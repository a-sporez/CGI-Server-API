<?php
function db() {
    static $pdo;
    if ($pdo) return $pdo;

    $host = 'placeholder.mysql.server';
    $user = 'placeholderuser';
    $pass = "placeholderpass";
    $dbname = 'placeholderdbname';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        json_error(500, 'Database connection failed.');
    }
}