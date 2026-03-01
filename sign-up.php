<?php
require_once __DIR__ . '/security/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';
include("php/user.php");
include("credentials/db.php");
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('csrf_token', csrf_token());

$error_map = [
    1 => "Username is already taken",
    2 => "Passwords do not match",
    3 => "Email is already registered",
    4 => "Invalid username",
    5 => "Invalid email address",
    6 => "Password must be at least 8 characters",
    7 => "Registration failed. Please try again.",
];

$warning_code = (int)($_GET['error'] ?? 0);
$warning_message = $error_map[$warning_code] ?? "";

echo $twig->render('sign-up.twig', [
    'user' => $user,
    'warning' => $warning_message,
]);
