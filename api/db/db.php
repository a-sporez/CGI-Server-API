<?php
function db() {
    static $pdo;
    if ($pdo) return $pdo;

    $path = __DIR__ . 'database.sqlite';

    try {
        $pdo = new PDO("sqlite:$path");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'SQLite connection failed.']);
        exit;
    }
}