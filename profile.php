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
    SELECT clubs.*
    FROM clubs
    INNER JOIN user_clubs
        ON clubs.club_id = user_clubs.club_id
    WHERE user_clubs.user_id = ?
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();

echo $twig->render('profile.twig', [
    'user' => $user,
    'clubs' => $result
]);