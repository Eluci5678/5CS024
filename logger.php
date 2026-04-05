<?php

function log_event($message) {
    $file = __DIR__ . '/../logs/security.log';
    $time = date('Y-m-d H:i:s');

    file_put_contents($file, "[$time] $message\n", FILE_APPEND);
}
