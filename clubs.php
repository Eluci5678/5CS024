<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

if ($user) {
    $stmt = $mysqli->prepare("
        SELECT clubs.*, user_clubs.user_id AS joined
        FROM clubs
        LEFT JOIN user_clubs
            ON clubs.club_id = user_clubs.club_id
            AND user_clubs.user_id = ?
    ");
    $stmt->bind_param("i", $user['id']);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM clubs");
}

$stmt->execute();
$result = $stmt->get_result();

echo $twig->render('clubs.twig', [
    'user' => $user,
    'data' => $result
]);
?>