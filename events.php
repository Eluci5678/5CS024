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
        SELECT events.*, user_events.user_id AS joined
        FROM events
        LEFT JOIN user_events
            ON events.event_id = user_events.event_id
            AND user_events.user_id = ?
    ");
    $stmt->bind_param("i", $user['id']);
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
