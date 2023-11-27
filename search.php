<?php
require_once 'db.php';

function searchAccount($keyword) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ?");
    $stmt->execute(["%$keyword%", "%$keyword%"]);
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $accounts;
}
