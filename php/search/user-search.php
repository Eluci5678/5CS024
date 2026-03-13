<?php
include("../../credentials/db.php");

$user = $_GET['search'] ?? "";

$stmt = $mysqli->prepare("
    SELECT user_id, name, email
    FROM users
    WHERE name LIKE CONCAT('%', ?, '%')
    LIMIT 20
");

$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();

echo json_encode($result->fetch_all(MYSQLI_ASSOC));