<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$title = $_POST['title'];
$desc = $_POST['events_description'];
$type = $_POST['event_type'];
$club = $_POST['associated_club'];
$start = $_POST['start_time'];
$end = $_POST['end_time'];
$expire = $_POST['expiration_date'];
$creator = $_POST['created_by'];

$missing = [];
if (empty($title)) $missing[] = "Title";
if (empty($desc)) $missing[] = "Description";
if (empty($type)) $missing[] = "Type";
if (empty($club)) $missing[] = "Club";
if (empty($start)) $missing[] = "Start";
if (empty($end)) $missing[] = "End";
if (empty($expire)) $missing[] = "Expire";
if (empty($creator)) $missing[] = "Creator";

if (!is_numeric($club)) $missing[] = "Club invalid";
if (!is_numeric($creator)) $missing[] = "Creator invalid";
if (strlen($title) > 50) $missing[] = "Title too long";

if (!empty($missing)){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt = $mysqli->prepare("
    INSERT INTO events
    (title, events_description, event_type, associated_club,
     start_time, end_time, expiration_date, created_by)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->bind_param(
    "sssisssi",
    $title,
    $desc,
    $type,
    $club,
    $start,
    $end,
    $expire,
    $creator
);

if (!$stmt->execute()){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->close();
$mysqli->close();

header("Location: ../../dashboard.php");
exit;
?>