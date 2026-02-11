<?php
session_start();
include("../credentials/db.php");

$username = $_POST['User'];
$email = $_POST['Email'];
$password = $_POST['Password'];
$confirmPassword = $_POST['ConfirmPassword'];

if ($password !== $confirmPassword) {
    header("Location: ../sign-up.php?error=2");
    exit;
}

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->fetch_assoc()) {
    header("Location: ../sign-up.php?error=1");
    exit;
}

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->fetch_assoc()) {
    header("Location: ../sign-up.php?error=3");
    exit;
}

$stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);
if ($stmt->execute()) {
    $user_id = $stmt->insert_id;

    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;

    header("Location: ../index.php");
    exit;
}