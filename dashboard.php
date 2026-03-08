<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

if (!$user) {
    header("Location: login.php");
    exit;
}

$stmt = $mysqli->prepare("
    SELECT ur.role_id, ur.club_id
    FROM user_roles ur
    WHERE ur.user_id = ?
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$user_roles = $result->fetch_all(MYSQLI_ASSOC);

$permissions = [
    'admin' => false,
    'transport' => false,
    'gym' => false,
    'owned' => [],
    'co-owned' => []
];

foreach ($user_roles as $role) {
    switch ((int)$role['role_id']) {
        case 1:
            $permissions['admin'] = true;
            break;
        case 2:
            if ($role['club_id']) {
                $permissions['owned'][] = $role['club_id'];
            }
            break;
        case 3:
            if ($role['club_id']) {
                $permissions['co-owned'][] = $role['club_id'];
            }
            break;
        case 4:
            $permissions['gym'] = true;
            break;
        case 5:
            $permissions['transport'] = true;
            break;
    }
}

function fetchData($mysqli, $query) {
    $stmt = $mysqli->prepare($query);
    if (!$stmt) { die("Prepare failed: " . $mysqli->error); }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$user_data = fetchData($mysqli, "
    SELECT 
        u.*,
        GROUP_CONCAT(ur.role_id) as roles
    FROM users u
    LEFT JOIN user_roles ur ON ur.user_id = u.user_id
    GROUP BY u.user_id
");
$transit_data = fetchData($mysqli, "SELECT * FROM transit_info");
$gym_data = fetchData($mysqli, "SELECT * FROM gym_opening_times");
$club_data = fetchData($mysqli, "SELECT * FROM clubs");
$event_data = fetchData($mysqli, "SELECT * FROM events");
$club_roles = fetchData($mysqli, "SELECT user_id, club_id FROM user_roles WHERE role_id = 3");
$club_members = fetchData($mysqli, "SELECT club_id, user_id FROM user_clubs");

if (!$permissions['admin']) {
    $club_data = array_filter($club_data, function($club) use ($permissions) {
        return in_array($club['club_id'], $permissions['owned']) || in_array($club['club_id'], $permissions['co-owned']);
    });

    $event_data = array_filter($event_data, function($event) use ($permissions) {
        return in_array($event['associated_club'], $permissions['owned']) || in_array($event['associated_club'], $permissions['co-owned']);
    });

    if (!$permissions['gym']) { $gym_data = []; }
    if (!$permissions['transport']) { $transit_data = []; }

    if (!$permissions['admin'] && empty($permissions['owned'])) {
    $user_data = [];
    }
}

echo $twig->render('dashboard.twig', [
    'user' => $user,
    'user_data' => $user_data,
    'transit_data' => $transit_data,
    'gym_data' => $gym_data,
    'club_data' => $club_data,
    'event_data' => $event_data,
    'club_roles' => $club_roles,
    'club_members' => $club_members,
    'permissions' => $permissions
]);
?>
