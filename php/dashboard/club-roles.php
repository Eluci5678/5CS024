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
$is_admin = $stmt->get_result()->num_rows > 0;
$stmt->close();
$stmt = $mysqli->prepare("
    SELECT 1
    FROM clubs
    WHERE club_id = ? AND owner_id = ?
    LIMIT 1
");
$stmt->bind_param("ii", $club_id, $user['id']);
$stmt->execute();
$is_owner = $stmt->get_result()->num_rows > 0;
$stmt->close();

if (!$is_admin && !$is_owner){
    redirect();
}

$club_id = $_POST['club_id'] ?? null;
$coowners = $_POST['coowners'] ?? [];

if (!is_numeric($club_id)){
    redirect();
}

updateClubRoles($club_id, $coowners);
redirect();


function updateClubRoles($club_id, $coowners){
    global $mysqli;

    $role_id = 3;

    $stmt = $mysqli->prepare("
        DELETE FROM user_roles
        WHERE club_id = ? AND role_id = ?
    ");
    $stmt->bind_param("ii", $club_id, $role_id);
    $stmt->execute();
    $stmt->close();

    if (!$coowners) return;

    $stmt = $mysqli->prepare("
        INSERT INTO user_roles (user_id, role_id, club_id)
        VALUES (?, ?, ?)
    ");

    foreach ($coowners as $user_id){
        if (!is_numeric($user_id)) continue;

        $stmt->bind_param("iii", $user_id, $role_id, $club_id);
        $stmt->execute();
    }

    $stmt->close();
}

exit;
?>