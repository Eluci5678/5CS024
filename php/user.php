<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = null;

if (isset($_SESSION['user_id'])) {
    $user = [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['username']
    ];
}

return $user;
