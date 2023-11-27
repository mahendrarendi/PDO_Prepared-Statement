<?php
require_once 'db.php';

function displayAccounts() {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $accounts;
}
