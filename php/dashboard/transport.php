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

$permissions = [
    'admin' => false,
    'transport' => false
];

foreach ($user_roles as $role){
    switch ((int)$role['role_id']){
        case 1:
            $permissions['admin'] = true;
            break;
        case 5:
            $permissions['transport'] = true;
            break;
    }
}

if (!$permissions['admin'] && !$permissions['transport']){
    redirect();
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
    redirect();
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
?>