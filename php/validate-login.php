<?php
session_start();
include("../credentials/db.php");

$username = $_POST['User'];
$password = $_POST['Password'];

$stmt = $mysqli->prepare("SELECT user_id, name, password_hash FROM users WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ../login.php?error=1");
    exit;
}

if ($password === $user['password_hash']) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['name'];

    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../login.php?error=1");
    exit;
}
?>
