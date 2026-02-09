<?php
declare(strict_types=1);

// basic hardening files 
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Refferer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation()');

//content security policy (sprint 1)
header("Content-Security-Policy default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'");

// session cookie security
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'); 

session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => $https,          // true only when HTTPS
  'httponly' => true,
  'samesite' => 'Lax',
]);

if (session_status() !== PHP_SESSION_ACTIVE) { 
  session_start();

function csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function csrf_verify(?string $token): void {
  if (!$token || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    exit('Invalid CSRF token');
  }}}
