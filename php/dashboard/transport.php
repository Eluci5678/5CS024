<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$id = $_POST['id'] ?? null;
$route = $_POST['route_name'] ?? "";
$schedule = $_POST['schedule'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($route)) $missing[] = "Route Missing";
    if (empty($schedule)) $missing[] = "Schedule Missing";

    if (strlen($route) > 100) $missing[] = "Route too long (100 Characters)";
    if (strlen($schedule) > 255) $missing[] = "Schedule too long (255 Characters)";

    if ($id !== null && !is_numeric($id))
        $missing[] = "Incorrect ID";
}

if (!empty($missing)){
    header("Location: ../../dashboard.php");
    exit;
}

if ($delete) deleteRow();
elseif ($id) updateRow();
else createRow();

function createRow(){
    global $mysqli,$route,$schedule;

    $stmt = $mysqli->prepare("
        INSERT INTO transit_info (route_name, schedule)
        VALUES (?, ?)
    ");

    $stmt->bind_param("ss",$route,$schedule);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$route,$schedule;

    $stmt = $mysqli->prepare("
        UPDATE transit_info
        SET route_name=?, schedule=?
        WHERE transit_id=?
    ");

    $stmt->bind_param("ssi",$route,$schedule,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM transit_info
        WHERE transit_id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function redirect(){
    header("Location: ../../dashboard.php");
    exit;
}
?>
