<?php
require_once 'db.php';

function login($usernameOrEmail, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND password = ?");
    $stmt->execute([$usernameOrEmail, $usernameOrEmail, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}
