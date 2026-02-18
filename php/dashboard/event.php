<?php
$user = include("../user.php");
include("../../credentials/db.php");

if (!$user){
    header("Location: ../../dashboard.php");
    exit;
}

$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? "";
$desc = $_POST['events_description'] ?? "";
$type = $_POST['event_type'] ?? "";
$club = $_POST['associated_club'] ?? "";
$start = $_POST['start_time'] ?? "";
$end = $_POST['end_time'] ?? "";
$expire = $_POST['expiration_date'] ?? "";
$creator = $_POST['created_by'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($title)) $missing[] = "Title Missing";
    if (empty($desc)) $missing[] = "Description Missing";
    if (empty($type)) $missing[] = "Type Missing";
    if (empty($club)) $missing[] = "Club ID Missing";
    if (empty($start)) $missing[] = "Start Time Missing";
    if (empty($end)) $missing[] = "End Time Missing";
    if (empty($expire)) $missing[] = "Expiration Date Missing";
    if (empty($creator)) $missing[] = "Creator ID Missing";
    if (!is_numeric($club)) $missing[] = "Incorrect Club ID";
    if (!is_numeric($creator)) $missing[] = "Incorrect Creator ID";
    if (strlen($title) > 50) $missing[] = "Title too long (50 Characters)";

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
    global $mysqli,$title,$desc,$type,$club,$start,$end,$expire,$creator;

    $stmt = $mysqli->prepare("
        INSERT INTO events
        (title, events_description, event_type, associated_club, start_time, end_time, expiration_date, created_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssisssi",$title,$desc,$type,$club,$start,$end,$expire,$creator);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$title,$desc,$type,$club,$start,$end,$expire,$creator;

    $stmt = $mysqli->prepare("
        UPDATE events
        SET title=?, events_description=?, event_type=?, associated_club=?, start_time=?, end_time=?, expiration_date=?, created_by=?
        WHERE event_id=?
    ");

    $stmt->bind_param("sssisssii",$title,$desc,$type,$club,$start,$end,$expire,$creator,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM events
        WHERE event_id=?
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
