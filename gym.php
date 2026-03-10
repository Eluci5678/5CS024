<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$stmt = $mysqli->prepare("SELECT * FROM gym_opening_times");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$gymTimes = $stmt->get_result();

$stmt = $mysqli->prepare("SELECT * FROM exercise_classes");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$gymClasses = $stmt->get_result();

echo $twig->render('gym.twig', [
    'user' => $user,
    'gym_times' => $gymTimes,
    'gym_classes' => $gymClasses
]);
?>
