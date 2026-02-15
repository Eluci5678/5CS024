<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$route = $_POST['route_name'];
$schedule = $_POST['schedule'];

$missing = [];
if (empty($route)) $missing[] = "Route";
if (empty($schedule)) $missing[] = "Schedule";

if (strlen($route) > 100) $missing[] = "Route too long";
if (strlen($schedule) > 255) $missing[] = "Schedule too long";

if (!empty($missing)){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt = $mysqli->prepare("
    INSERT INTO transit_info (route_name, schedule)
    VALUES (?, ?)
");

if (!$stmt){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->bind_param("ss", $route, $schedule);

if (!$stmt->execute()){
    header("Location: ../../dashboard.php");
    exit;
}

$stmt->close();
$mysqli->close();

header("Location: ../../dashboard.php");
exit;
?>
