<?php
$logFile = __DIR__ . '/ping.log';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$entry = sprintf("[%s] %s\n", date('c'), $ip);
file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
header('Content-Type: application/json');
echo json_encode(['status' => 'ok']);

