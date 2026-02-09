<?php
require_once __DIR__ . '/vendor/autoload.php';
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

// Make CSRF token available to all Twig templates
$twig->addGlobal('csrf_token', csrf_token());

echo $twig->render('gym.twig', [
]);
?>
