<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$id = (int)($_GET['id'] ?? 0);

if ($user) {
    $stmt = $mysqli->prepare("
        SELECT events.*, user_events.user_id AS joined
        FROM events
        LEFT JOIN user_events
            ON events.event_id = user_events.event_id
            AND user_events.user_id = ?
        WHERE events.event_id  = ?
    ");
    $stmt->bind_param("ii", $user['id'], $id);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM events WHERE events.event_id = ?");
    $stmt->bind_param("i", $id);
}
$stmt->execute();
$event = $stmt->get_result();

echo $twig->render('event-info.twig', [
    'user' => $user,
    'event' => $event
]);
?>