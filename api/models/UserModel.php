<?php
function get_all_users() {
    return db()->query("SELECT id, name, email FROM users")->fetchAll(PDO::FETCH_ASSOC);
}

function get_user($id) {
    $stmt = db()->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function create_user($data) {
    $stmt = db()->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$data['name'], $data['email']]);
    return get_user(db()->lastInsertId());
}