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
$room_code = $_POST['room_code'] ?? "";
$building_id = $_POST['building_id'] ?? null;
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($room_code)) $missing[] = "Room Code Missing";
    if (!is_numeric($building_id)) $missing[] = "Building Missing";

    if (strlen($room_code) > 10) $missing[] = "Room Code too long";

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
    global $mysqli,$room_code,$building_id;

    $stmt = $mysqli->prepare("
        INSERT INTO rooms (room_code, building_id)
        VALUES (?, ?)
    ");

    $stmt->bind_param("si",$room_code,$building_id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$room_code,$building_id;

    $stmt = $mysqli->prepare("
        UPDATE rooms
        SET room_code=?, building_id=?
        WHERE room_id=?
    ");

    $stmt->bind_param("sii",$room_code,$building_id,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM rooms
        WHERE room_id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}
?>