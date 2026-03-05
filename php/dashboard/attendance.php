<?php
$user = include("../user.php");
include("../../credentials/db.php");

function redirect() {
    header("Location: ../../dashboard.php");
    exit();
}

if (!$user) redirect();

$stmt = $mysqli->prepare("
    SELECT 1
    FROM user_roles
    WHERE user_id = ? AND role_id = 1
    LIMIT 1
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect();
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    redirect();
}

$handle = fopen($_FILES['csv_file']['tmp_name'], "r");
if (!$handle) redirect();

$header = fgetcsv($handle);
if ($header !== ['user_id','source_type','source_id','week','attendance_status']) {
    fclose($handle);
    redirect();
}

$stmt = $mysqli->prepare("
    INSERT INTO attendance_records
    (user_id, source_type, source_id, week, attendance_status)
    VALUES (?,?,?,?,?)
");
if (!$stmt) {
    fclose($handle);
    redirect();
}

while (($row = fgetcsv($handle)) !== false) {
    if (count($row) !== 5) redirect();
    $user_id = (int)$row[0];
    $source = $row[1];
    $source_id = (int)$row[2];
    $dt = DateTime::createFromFormat('d-m-Y H:i', $row[3]);
    if (!$dt) redirect();
    $week = $dt->format('Y-m-d H:i:s');
    $status = (int)$row[4];

    $stmt->bind_param("isisi", $user_id, $source, $source_id, $week, $status);
    if (!$stmt->execute()) redirect();
}

$stmt->close();
fclose($handle);

redirect();