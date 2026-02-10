<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$stmt = $mysqli->prepare("SELECT * FROM clubs");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();

echo $twig->render('clubs.twig', [
    'data' => $result
]);
?>
