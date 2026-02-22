<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$warning_code = isset($_GET['error']) ? (int)$_GET['error'] : 0;
$warning_message = "";

if ($warning_code == 1){
    $warning_message = "Incorrect username or password";
}

echo $twig->render('login.twig', [
    'user' => $user,
    'warning' => $warning_message,
]);
