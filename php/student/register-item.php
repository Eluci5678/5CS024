<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../login.php");
    exit;
}

$type = $_GET['type'] ?? null;
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if (!$type || !$action || !is_numeric($id)) {
    header("Location: index.php");
    exit;
}

switch ($type) {
    case 'club':
        if ($action === 'join') {
            joinClub($id);
        } elseif ($action === 'leave') {
            leaveClub($id);
        }
        break;

    default:
        exit;
}

function joinClub($id){
    global $mysqli, $user;

    $stmt = $mysqli->prepare("
        INSERT INTO user_clubs (user_id, club_id)
        VALUES (?,?)
    ");
    $stmt->bind_param("ii", $user['id'], $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../clubs.php");
    exit;
}

function leaveClub($id){
    global $mysqli, $user;

    $stmt = $mysqli->prepare("
        DELETE FROM user_clubs
        WHERE user_id = ? AND club_id = ?
    ");
    $stmt->bind_param("ii", $user['id'], $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../clubs.php");
    exit;
}