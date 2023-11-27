<?php
require_once 'db.php';

function getAccountById($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    return $account;
}

function updateAccount($userId, $newUsername, $newEmail, $newPassword) {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$newUsername, $newEmail, $newPassword, $userId]);

    return $stmt->rowCount();
}
