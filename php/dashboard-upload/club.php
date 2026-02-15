<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$name = $_POST['club_name'];
$desc = $_POST['description'];
$owner = $_POST['owner_id'];
$schedule = $_POST['schedule'];

$missing = [];
if (empty($name)) $missing[] = "Name";
if (empty($desc)) $missing[] = "Description";
if (empty($owner)) $missing[] = "Owner";
if (empty($schedule)) $missing[] = "Schedule";

if (!is_numeric($owner)) $missing[] = "Owner invalid";
if (strlen($name) > 150) $missing[] = "Name too long";

if (!empty($missing)){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt = $mysqli->prepare("
    INSERT INTO clubs (club_name, description, owner_id, schedule)
    VALUES (?, ?, ?, ?)
");

if (!$stmt){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->bind_param("ssis", $name, $desc, $owner, $schedule);

if (!$stmt->execute()){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->close();
$mysqli->close();

header("Location: ../../dashboard.php");
exit;
?>
