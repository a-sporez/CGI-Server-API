<?php

function get_all_messages() {
    return db()->query("SELECT * FROM messages ORDER BY created_at DESK")->fetchAll(PDO::FETCH_ASSOC);
}

function get_message($id) {
    $stmt = db()->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function create_message($data) {
    $stmt = db()->prepare("INSERT INTO messages (author, content) VALUES (?, ?)");
    $stmt->execute([$data['author'], $data['content']]);
    return get_message(db()->lastInsertId());
}

function update_message($id, $data) {
    $stmt = db()->prepare("UPDATE messages SET author = ?, content =? WHERE id = ?");
    $stmt->execute([$data['author'], $data['content'], $id]);
    return get_message($id);
}

function delete_message($id) {
    $stmt = db()->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    return ['deleted' => $id];
}