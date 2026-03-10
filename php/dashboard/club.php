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
    SELECT role_id, club_id
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
    'owned' => [],
    'co_owned' => []
];

foreach ($user_roles as $role){
    switch ((int)$role['role_id']){
        case 1:
            $permissions['admin'] = true;
            break;
        case 2:
            if ($role['club_id']) $permissions['owned'][] = (int)$role['club_id'];
            break;
        case 3:
            if ($role['club_id']) $permissions['co_owned'][] = (int)$role['club_id'];
            break;
    }
}

function canAccessClub($club_id){
    global $permissions;

    if ($permissions['admin']) return true;

    return in_array($club_id,$permissions['owned']) || in_array($club_id,$permissions['co_owned']);
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
}else{
    if (empty($name)) $missing[] = "Name Missing";
    if (empty($desc)) $missing[] = "Description Missing";
    if (empty($owner)) $missing[] = "Owner ID Missing";
    if (empty($schedule)) $missing[] = "Schedule Missing";
    if (!is_numeric($owner)) $missing[] = "Invalid Owner ID";
    if (strlen($name) > 150) $missing[] = "Name too long (150 Characters)";
    if ($id !== null && !is_numeric($id)) $missing[] = "Incorrect ID";
}

if (!empty($missing)){
    redirect();
}

if ($id){
    if (!canAccessClub((int)$id)){
        redirect();
    }
}

if (!$id && !$permissions['admin']){
    if (!in_array((int)$owner,$permissions['owned'])){
        redirect();
    }
}

if ($delete){
    deleteRow();
}elseif ($id){
    updateRow();
}else{
    createRow();
}

function createRow(){
    global $mysqli,$name,$desc,$owner,$schedule;

    $stmt = $mysqli->prepare("
        INSERT INTO clubs (club_name, description, schedule)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("sss",$name,$desc,$schedule);
    $stmt->execute();

    $club_id = $mysqli->insert_id;
    $stmt->close();

    $stmt = $mysqli->prepare("
        INSERT INTO user_roles (user_id, role_id, club_id)
        VALUES (?, 2, ?)
    ");
    $stmt->bind_param("ii",$owner,$club_id);
    $stmt->execute();
    $stmt->close();

    redirect();
}

function updateRow(){
    global $mysqli,$id,$name,$desc,$owner,$schedule;

    $stmt = $mysqli->prepare("
        UPDATE clubs
        SET club_name=?, description=?, schedule=?
        WHERE club_id=?
    ");
    $stmt->bind_param("sssi",$name,$desc,$schedule,$id);
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("
        DELETE FROM user_roles
        WHERE club_id=? AND role_id=2
    ");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("
        INSERT INTO user_roles (user_id, role_id, club_id)
        VALUES (?,2,?)
    ");
    $stmt->bind_param("ii",$owner,$id);
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
?>