<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$id = $_POST['id'] ?? null;
$name = $_POST['club_name'] ?? "";
$desc = $_POST['description'] ?? "";
$owner = $_POST['owner_id'] ?? "";
$schedule = $_POST['schedule'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($name)) $missing[] = "Name Missing";
    if (empty($desc)) $missing[] = "Description Missing";
    if (empty($owner)) $missing[] = "Owner ID Missing";
    if (empty($schedule)) $missing[] = "Schedule Missing";
    if (!is_numeric($owner)) $missing[] = "Invalid Owner ID";
    if (strlen($name) > 150) $missing[] = "Name too long (150 Characters)";

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
    global $mysqli,$name,$desc,$owner,$schedule;

    $stmt = $mysqli->prepare("
        INSERT INTO clubs (club_name, description, owner_id, schedule)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssis",$name,$desc,$owner,$schedule);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$name,$desc,$owner,$schedule;

    $stmt = $mysqli->prepare("
        UPDATE clubs
        SET club_name=?, description=?, owner_id=?, schedule=?
        WHERE club_id=?
    ");

    $stmt->bind_param("ssisi",$name,$desc,$owner,$schedule,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM clubs
        WHERE club_id=?
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
