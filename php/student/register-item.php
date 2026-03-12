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
            joinTarget($id, "user_clubs", "club_id", "clubs");
        } elseif ($action === 'leave') {
            leaveTarget($id, "user_clubs", "club_id", "clubs");
        }
        break;
    case 'event':
        if ($action === 'join') {
            if (!isUserInClub($id)) {
                header("Location: ../../events.php");
                exit;
            }
            joinTarget($id, "user_events", "event_id", "events");
        } elseif ($action === 'leave') {
            leaveTarget($id, "user_events", "event_id", "events");
        }
        break;
    default:
        exit;
}

function joinTarget($id, $table, $column, $redirect){
    global $mysqli, $user;

    $stmt = $mysqli->prepare("
        INSERT INTO $table (user_id, $column)
        VALUES (?,?)
    ");
    $stmt->bind_param("ii", $user['id'], $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../$redirect.php");
    exit;
}

function leaveTarget($id, $table, $column, $redirect){
    global $mysqli, $user;

    $stmt = $mysqli->prepare("
        DELETE FROM $table
        WHERE user_id = ? AND $column = ?
    ");
    $stmt->bind_param("ii", $user['id'], $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../$redirect.php");
    exit;
}

function isUserInClub($event_id){
    global $mysqli, $user;

    $stmt = $mysqli->prepare("SELECT associated_club FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    if (!$event) return false;

    $club_id = $event['associated_club'];

    $stmt = $mysqli->prepare("SELECT 1 FROM user_clubs WHERE user_id = ? AND club_id = ? LIMIT 1");
    $stmt->bind_param("ii", $user['id'], $club_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->fetch_assoc();
    $stmt->close();

    return (bool)$exists;
}

?>