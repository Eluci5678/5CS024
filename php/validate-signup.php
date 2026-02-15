<?php
require_once __DIR__ . '/../security/bootstrap.php';
include("../credentials/db.php");

$username = trim($_POST['User'] ?? '');
$email = trim($_POST['Email'] ?? '');
$password = $_POST['Password'] ?? '';
$confirmPassword = $_POST['ConfirmPassword'] ?? '';

// Optional (recommended) if your signup form is POSTing csrf_token:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify($_POST['csrf_token'] ?? null);
}

if ($username === '' || strlen($username) > 50) {
    header("Location: ../sign-up.php?error=4");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../sign-up.php?error=5");
    exit;
}

if (strlen($password) < 8) {
    header("Location: ../sign-up.php?error=6");
    exit;
}

if ($password !== $confirmPassword) {
    header("Location: ../sign-up.php?error=2");
    exit;
}

// Check username exists
$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->fetch_assoc()) {
    header("Location: ../sign-up.php?error=1");
    exit;
}

// Check email exists
$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->fetch_assoc()) {
    header("Location: ../sign-up.php?error=3");
    exit;
}

// Hash password here: 
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $passwordHash);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;

    session_regenerate_id(true);

    header("Location: ../index.php");
    exit;
}

header("Location: ../sign-up.php?error=7");
exit;
