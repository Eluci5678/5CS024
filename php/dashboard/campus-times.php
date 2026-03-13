<?php
$user = include("../user.php");
include("../../credentials/db.php");

function redirect(){
    header("Location: ../../dashboard.php");
    exit;
}

if (!$user){
    redirect();
}

$stmt = $mysqli->prepare("
    SELECT role_id
    FROM user_roles
    WHERE user_id = ?
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$user_roles = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$admin = false;

foreach ($user_roles as $role){
    if ((int)$role['role_id'] === 1){
        $admin = true;
        break;
    }
}

if (!$admin){
    redirect();
}

$id = $_POST['id'] ?? null;
$campus = $_POST['campus_name'] ?? "";
$day = $_POST['day_of_week'] ?? "";
$opens = $_POST['opens_at'] ?? "";
$closes = $_POST['closes_at'] ?? "";
$note = $_POST['note'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($campus)) $missing[] = "Campus Missing";
    if (empty($day)) $missing[] = "Day Missing";
    if (empty($opens)) $missing[] = "Open Time Missing";
    if (empty($closes)) $missing[] = "Close Time Missing";

    if ($id !== null && !is_numeric($id))
        $missing[] = "Incorrect ID";
}

if (!empty($missing)){
    redirect();
}

if ($delete) deleteRow();
elseif ($id) updateRow();
else createRow();

function createRow(){
    global $mysqli,$campus,$day,$opens,$closes,$note;

    $stmt = $mysqli->prepare("
        INSERT INTO campus_opening_times
        (campus_name, day_of_week, opens_at, closes_at, note)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssss",$campus,$day,$opens,$closes,$note);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$campus,$day,$opens,$closes,$note;

    $stmt = $mysqli->prepare("
        UPDATE campus_opening_times
        SET campus_name=?, day_of_week=?, opens_at=?, closes_at=?, note=?
        WHERE id=?
    ");

    $stmt->bind_param("sssssi",$campus,$day,$opens,$closes,$note,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM campus_opening_times
        WHERE id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}
?>