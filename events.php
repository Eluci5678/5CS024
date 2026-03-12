<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

include("php/cleanup.php");

if ($user) {
    $stmt = $mysqli->prepare("
        SELECT 
            events.*, 
            user_events.user_id AS joined,
            user_clubs.user_id AS in_club
        FROM events
        LEFT JOIN user_events
            ON events.event_id = user_events.event_id
            AND user_events.user_id = ?
        LEFT JOIN user_clubs
            ON events.associated_club = user_clubs.club_id
            AND user_clubs.user_id = ?
        ORDER BY in_club DESC, start_time ASC
    ");
    $stmt->bind_param("ii", $user['id'], $user['id']);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM events");
}

$stmt->execute();
$result = $stmt->get_result();

echo $twig->render('events.twig', [
    'user' => $user,
    'data' => $result
]);
?>
