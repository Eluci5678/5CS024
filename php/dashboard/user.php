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
    SELECT 1
    FROM user_roles
    WHERE user_id = ? AND role_id = 1
    LIMIT 1
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows === 0){
    redirect();
}

$id = $_POST['id'] ?? null;
$username = $_POST['username'] ?? "";
$email = $_POST['email'] ?? "";
$password = $_POST['password'] ?? "";
$delete = isset($_POST['delete']);

if ($delete){
    if (!is_numeric($id)) exit;
    deleteRow();
    exit;
}

if ($id){
    if (!is_numeric($id)) exit;

    if ($username !== "" || $email !== ""){
        updateUser($id, $username, $email);
    }

    if ($password !== "") {
        updatePassword($id, $password);
    }

    redirect();
}

if ($username !== "" && $email !== "" && $password !== ""){
    createUser($username, $email, $password);
    exit;
}

function createUser($username,$email,$password){
    global $mysqli;

    if ($username === '' || strlen($username) > 50) redirect();
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) redirect();
    if (strlen($password) < 8) redirect();

    if (!isUserUnique($username,$email)) redirect();

    $passwordHash = password_hash($password,PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("
        INSERT INTO users (name,email,password_hash)
        VALUES (?,?,?)
    ");
    $stmt->bind_param("sss",$username,$email,$passwordHash);
    $stmt->execute();
    $stmt->close();

    redirect();
}

function updateUser($id, $username, $email){
    global $mysqli;

    $stmt = $mysqli->prepare("
        SELECT user_id
        FROM users
        WHERE (name=? OR email=?) AND user_id<>?
    ");
    $stmt->bind_param("ssi", $username, $email, $id);
    $stmt->execute();
    $exists = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($exists) redirect();

    $stmt = $mysqli->prepare("
        UPDATE users
        SET name=?, email=?
        WHERE user_id=?
    ");
    $stmt->bind_param("ssi", $username, $email, $id);
    $stmt->execute();
    $stmt->close();
}

function updatePassword($id, $password){
    global $mysqli;

    if (strlen($password) < 8) redirect();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("UPDATE users SET password_hash=? WHERE user_id=?");
    $stmt->bind_param("si", $passwordHash, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM users
        WHERE user_id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function isUserUnique($username,$email){
    global $mysqli;

    $stmt = $mysqli->prepare("
        SELECT user_id
        FROM users
        WHERE name=? OR email=?
        LIMIT 1
    ");
    $stmt->bind_param("ss",$username,$email);
    $stmt->execute();

    $exists = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return !$exists;
}

exit;
?>