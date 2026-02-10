<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$stmt = $mysqli->prepare("SELECT * FROM transit_info");
if (!$stmt) {die("Prepare failed: " . $mysqli->error);}
$stmt->execute();
$result = $stmt->get_result();

echo $twig->render('transport.twig', [
    'data' => $result
]);
?>