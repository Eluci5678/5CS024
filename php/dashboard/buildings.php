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
$initials = $_POST['building_initials'] ?? "";
$name = $_POST['building_name'] ?? "";
$campus = $_POST['campus_location'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($initials)) $missing[] = "Initials Missing";
    if (empty($name)) $missing[] = "Name Missing";
    if (empty($campus)) $missing[] = "Campus Missing";

    if (strlen($initials) > 10) $missing[] = "Initials too long";
    if (strlen($name) > 50) $missing[] = "Name too long";
    if (strlen($campus) > 50) $missing[] = "Campus too long";

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
    global $mysqli,$initials,$name,$campus;

    $stmt = $mysqli->prepare("
        INSERT INTO buildings (building_initials, building_name, campus_location)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("sss",$initials,$name,$campus);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$initials,$name,$campus;

    $stmt = $mysqli->prepare("
        UPDATE buildings
        SET building_initials=?, building_name=?, campus_location=?
        WHERE building_id=?
    ");

    $stmt->bind_param("sssi",$initials,$name,$campus,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM buildings
        WHERE building_id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}
?>