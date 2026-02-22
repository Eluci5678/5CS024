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

if (!$user) {
    header("Location: login.php");
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM users");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_all(MYSQLI_ASSOC);

$stmt = $mysqli->prepare("SELECT * FROM transit_info");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();
$transit_data = $result->fetch_all(MYSQLI_ASSOC);

$stmt = $mysqli->prepare("SELECT * FROM gym_opening_times");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();
$gym_data = $result->fetch_all(MYSQLI_ASSOC);

$stmt = $mysqli->prepare("SELECT * FROM clubs");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();
$club_data = $result->fetch_all(MYSQLI_ASSOC);

$stmt = $mysqli->prepare("SELECT * FROM events");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();
$event_data = $result->fetch_all(MYSQLI_ASSOC);

echo $twig->render('dashboard.twig', [
    'user' => $_SESSION['user_id'] ?? null,
    'user_data' => $user_data,
    'transit_data' => $transit_data,
    'gym_data' => $gym_data,
    'club_data' => $club_data,
    'event_data' => $event_data
]);
?>
