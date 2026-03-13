<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    echo json_encode([]);
    exit;
}

$search = $_GET['search'] ?? "";

$stmt = $mysqli->prepare("
    SELECT role_id, club_id
    FROM user_roles
    WHERE user_id = ?
");

$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$user_roles = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$permissions = [
    'admin' => false,
    'clubs' => []
];

foreach ($user_roles as $role){

    if ((int)$role['role_id'] === 1){
        $permissions['admin'] = true;
    }

    if ((int)$role['role_id'] === 2 || (int)$role['role_id'] === 3){
        if ($role['club_id']){
            $permissions['clubs'][] = (int)$role['club_id'];
        }
    }
}

if ($permissions['admin']){

    $stmt = $mysqli->prepare("
        SELECT club_id, club_name, description
        FROM clubs
        WHERE club_name LIKE CONCAT('%', ?, '%')
        LIMIT 20
    ");

    $stmt->bind_param("s",$search);

}else{

    if (empty($permissions['clubs'])){
        echo json_encode([]);
        exit;
    }

    $stmt = $mysqli->prepare("
        SELECT club_id, club_name, description
        FROM clubs
        WHERE club_name LIKE CONCAT('%', ?, '%')
        AND club_id IN (SELECT club_id FROM user_roles WHERE user_id = ? AND role_id IN (2,3))
        LIMIT 20
    ");

    $stmt->bind_param("si", $search, $user['id']);
}

$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_all(MYSQLI_ASSOC));