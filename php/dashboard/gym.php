<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$id = $_POST['id'] ?? null;
$campus = $_POST['campus_name'] ?? "";
$day = $_POST['day_of_week'] ?? "";
$open = $_POST['opens_at'] ?? "";
$close = $_POST['closes_at'] ?? "";
$note = $_POST['note'] ?? "";
$src = $_POST['source_ref'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($campus)) $missing[] = "Campus Missing";
    if (empty($day)) $missing[] = "Day Missing";
    if (empty($open)) $missing[] = "Opening Time Missing";
    if (empty($close)) $missing[] = "Closing Time Missing";
    if (strlen($campus) > 80) $missing[] = "Campus too long (80 Characters)";

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
    global $mysqli,$campus,$day,$open,$close,$note,$src;

    $stmt = $mysqli->prepare("
        INSERT INTO gym_opening_times
        (campus_name, day_of_week, opens_at, closes_at, note, source_ref)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssssss",$campus,$day,$open,$close,$note,$src);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$campus,$day,$open,$close,$note,$src;

    $stmt = $mysqli->prepare("
        UPDATE gym_opening_times
        SET campus_name=?, day_of_week=?, opens_at=?, closes_at=?, note=?, source_ref=?
        WHERE id=?
    ");

    $stmt->bind_param("ssssssi",$campus,$day,$open,$close,$note,$src,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM gym_opening_times
        WHERE id=?
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
