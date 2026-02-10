<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$stmt = $mysqli->prepare("
    SELECT
        users.user_id,
        users.name,
        SUM(attendance_records.attendance_status) AS attendance_score
    FROM users
    LEFT JOIN attendance_records
        ON attendance_records.user_id = users.user_id
    GROUP BY
        users.user_id,
        users.name
    ORDER BY
        attendance_score DESC
");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

$rank = 1;
foreach ($users as &$user) {
    $user['rank'] = $rank++;
}

echo $twig->render('leaderboard.twig', [
    'users' => $users
]);
?>
