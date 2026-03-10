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
    'gym' => false
];

foreach ($user_roles as $role){
    switch ((int)$role['role_id']){
        case 1:
            $permissions['admin'] = true;
            break;
        case 4:
            $permissions['gym'] = true;
            break;
    }
}

if (!$permissions['admin'] && !$permissions['gym']){
    redirect();
}

$id = $_POST['id'] ?? null;
$class_date = $_POST['class_date'] ?? "";
$day = $_POST['day_of_week'] ?? "";
$class_name = $_POST['class_name'] ?? "";
$start = $_POST['start_time'] ?? "";
$end = $_POST['end_time'] ?? "";
$campus = $_POST['campus_name'] ?? "";
$location = $_POST['location'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}
else{
    if (empty($class_date)) $missing[] = "Date Missing";
    if (empty($day)) $missing[] = "Day Missing";
    if (empty($class_name)) $missing[] = "Class Name Missing";
    if (empty($start)) $missing[] = "Start Time Missing";
    if (empty($end)) $missing[] = "End Time Missing";
    if (empty($campus)) $missing[] = "Campus Missing";

    if (strlen($class_name) > 120) $missing[] = "Class name too long (120)";
    if (strlen($campus) > 80) $missing[] = "Campus too long (80)";
    if (strlen($location) > 160) $missing[] = "Location too long (160)";

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
    global $mysqli,$class_date,$day,$class_name,$start,$end,$campus,$location;

    $stmt = $mysqli->prepare("
        INSERT INTO exercise_classes
        (class_date, day_of_week, class_name, start_time, end_time, campus_name, location)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssss",
        $class_date,
        $day,
        $class_name,
        $start,
        $end,
        $campus,
        $location
    );

    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$class_date,$day,$class_name,$start,$end,$campus,$location;

    $stmt = $mysqli->prepare("
        UPDATE exercise_classes
        SET class_date=?, day_of_week=?, class_name=?, start_time=?, end_time=?, campus_name=?, location=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssssi",
        $class_date,
        $day,
        $class_name,
        $start,
        $end,
        $campus,
        $location,
        $id
    );

    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM exercise_classes
        WHERE id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}
?>