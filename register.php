<?php
require_once 'db.php';

function register($username, $email, $password) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    return $stmt->rowCount();
}
