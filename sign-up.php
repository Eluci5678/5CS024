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
    $warning_message = "Username is already taken";
}
if ($warning_code == 2){
    $warning_message = "Passwords do not match";
}
if ($warning_code == 3){
    $warning_message = "Email is already registered";
}

echo $twig->render('sign-up.twig', [
    'user' => $_SESSION['user_id'] ?? null,
    'warning' => $warning_message,
]);
