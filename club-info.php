<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$id = (int)($_GET['id'] ?? 0);

$stmt = $mysqli->prepare("SELECT * FROM clubs WHERE club_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$club = $stmt->get_result();

$stmt = $mysqli->prepare("SELECT * FROM events WHERE associated_club = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$club_events = $stmt->get_result();

echo $twig->render('club-info.twig', [
    'user' => $user,
    'club' => $club,
    'club_events' => $club_events
]);
?>