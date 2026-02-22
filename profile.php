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
$clubs = $stmt->get_result();

$stmt = $mysqli->prepare("
    SELECT events.*
    FROM events
    INNER JOIN user_events
        ON events.event_id = user_events.event_id
    WHERE user_events.user_id = ?
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$events = $stmt->get_result();

echo $twig->render('profile.twig', [
    'user' => $user,
    'clubs' => $clubs,
    'events' => $events
]);