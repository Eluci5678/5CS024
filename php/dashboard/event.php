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

    return in_array($club_id,$permissions['owned']) ||
           in_array($club_id,$permissions['co_owned']);
}

$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? "";
$desc = $_POST['events_description'] ?? "";
$type = $_POST['event_type'] ?? "";
$club = $_POST['associated_club'] ?? "";
$start = $_POST['start_time'] ?? "";
$end = $_POST['end_time'] ?? "";
$creator = $_POST['created_by'] ?? "";
$delete = isset($_POST['delete']);

$missing = [];

if ($delete){
    if (!is_numeric($id)) $missing[] = "Incorrect ID";
}else{
    if (empty($title)) $missing[] = "Title Missing";
    if (empty($desc)) $missing[] = "Description Missing";
    if (empty($type)) $missing[] = "Type Missing";
    if (empty($club)) $missing[] = "Club ID Missing";
    if (empty($start)) $missing[] = "Start Time Missing";
    if (empty($end)) $missing[] = "End Time Missing";
    if (empty($creator)) $missing[] = "Creator ID Missing";
    if (!is_numeric($club)) $missing[] = "Incorrect Club ID";
    if (!is_numeric($creator)) $missing[] = "Incorrect Creator ID";
    if (strlen($title) > 50) $missing[] = "Title too long (50 Characters)";
    if ($id !== null && !is_numeric($id)) $missing[] = "Incorrect ID";

    $start_dt = new DateTime($start);
    $end_dt = new DateTime($end);
    $now = new DateTime();
    if ($start_dt < $now){$missing[] = "Start time cannot be in the past";}
    if ($end_dt <= $start_dt){$missing[] = "End time must be after start time";}
}

if (!empty($missing)){
    redirect();
}

if ($delete || $id){
    $stmt = $mysqli->prepare("
        SELECT associated_club
        FROM events
        WHERE event_id = ?
    ");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    if (!$event || !canAccessClub((int)$event['associated_club'])){
        redirect();
    }
}

if (!$id){
    if (!canAccessClub((int)$club)){
        redirect();
    }
}

if ($delete) deleteRow();
elseif ($id) updateRow();
else createRow();

function createRow(){
    global $mysqli,$title,$desc,$type,$club,$start,$end,$creator;

    $stmt = $mysqli->prepare("
        INSERT INTO events
        (title, events_description, event_type, associated_club, start_time, end_time, created_by)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssissi",$title,$desc,$type,$club,$start,$end,$creator);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function updateRow(){
    global $mysqli,$id,$title,$desc,$type,$club,$start,$end,$creator;

    $stmt = $mysqli->prepare("
        UPDATE events
        SET title=?, events_description=?, event_type=?, associated_club=?, start_time=?, end_time=?, created_by=?
        WHERE event_id=?
    ");

    $stmt->bind_param("sssissii",$title,$desc,$type,$club,$start,$end,$creator,$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}

function deleteRow(){
    global $mysqli,$id;

    $stmt = $mysqli->prepare("
        DELETE FROM events
        WHERE event_id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    redirect();
}
?>