<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$campus = $_POST['campus_name'];
$day = $_POST['day_of_week'];
$open = $_POST['opens_at'];
$close = $_POST['closes_at'];
$note = $_POST['note'];
$src = $_POST['source_ref'];

$missing = [];
if (empty($campus)) $missing[] = "Campus";
if (empty($day)) $missing[] = "Day";
if (empty($open)) $missing[] = "Open";
if (empty($close)) $missing[] = "Close";

if (strlen($campus) > 80) $missing[] = "Campus too long";

if (!empty($missing)){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt = $mysqli->prepare("
    INSERT INTO gym_opening_times
    (campus_name, day_of_week, opens_at, closes_at, note, source_ref)
    VALUES (?, ?, ?, ?, ?, ?)
");

if (!$stmt){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->bind_param("ssssss", $campus, $day, $open, $close, $note, $src);

if (!$stmt->execute()){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->close();
$mysqli->close();

header("Location: ../../dashboard.php");
exit;
?>
