<?php
require_once __DIR__ . '/security/bootstrap.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$stmt = $mysqli->prepare("SELECT * FROM events");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();

echo $twig->render('events.twig', [
    'user' => $_SESSION['user_id'] ?? null,
    'data' => $result
]);
?>
