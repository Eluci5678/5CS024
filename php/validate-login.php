<?php
declare(strict_types=1);

require_once __DIR__ . '/../security/bootstrap.php';

// DB connection (placeholder file is committed; real db.php should be ignored)
require_once __DIR__ . '/../credentials/db.php'; // or db-blank.php depending on your setup

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// CSRF verification (only works if your login form includes csrf_token hidden field)
csrf_verify($_POST['csrf_token'] ?? null);

// Read & validate inputs safely
$username = trim((string)($_POST['User'] ?? ''));
$password = (string)($_POST['Password'] ?? '');

if ($username === '' || $password === '') {
    // Generic error - don’t reveal which field was wrong
    header('Location: ../login.php?error=1');
    exit;
}

// Sprint 2: login rate limit setup
$maxAttempts = 5;
$lockoutTime = 300;
$attemptKey = 'login_' . strtolower($username);

if (!isset($_SESSION[$attemptKey])) {
    $_SESSION[$attemptKey] = [
        'count' => 0,
        'locked_until' => 0
    ];
}

// block login if too many failed attempts
if ($_SESSION[$attemptKey]['locked_until'] > time()) {
    header('Location: ../login.php?error=locked');
    exit;
}

// Fetch user by usernamee
$stmt = $mysqli->prepare("SELECT user_id, name, password_hash FROM users WHERE name = ? LIMIT 1");
if (!$stmt) {
    // Don’t leak DB errors to the user
    header('Location: ../login.php?error=1');
    exit;
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;

$stmt->close();

if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {

    // count failed login attempts
    $_SESSION[$attemptKey]['count']++;

    // lock login for a while after too many attempts
    if ($_SESSION[$attemptKey]['count'] >= $maxAttempts) {
        $_SESSION[$attemptKey]['locked_until'] = time() + $lockoutTime;
        header('Location: ../login.php?error=locked');
        exit;
    }

    header('Location: ../login.php?error=1');
    exit;
}

// Login success: set session and regenerate session ID
$_SESSION['user_id'] = (int)$user['user_id'];
$_SESSION['username'] = (string)$user['name'];
// reset login attempts after success
$_SESSION[$attemptKey]['count'] = 0;
$_SESSION[$attemptKey]['locked_until'] = 0;

// Sprint 2: session timeout tracking
$_SESSION['last_activity'] = time();
$_SESSION['session_expires'] = 30; // 30 seconds 

session_regenerate_id(true);

// Redirect to homepage/dashboard
header('Location: ../index.php');
exit;
