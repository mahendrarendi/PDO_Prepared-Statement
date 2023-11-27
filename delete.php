<?php
require_once 'db.php';

function deleteAccount($userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    return $stmt->rowCount();
}
