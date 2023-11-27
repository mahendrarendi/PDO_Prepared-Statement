<?php
require_once 'update.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir update
    $userId = $_POST['userId'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    // Panggil fungsi updateAccount dari update.php
    $rowCount = updateAccount($userId, $newUsername, $newEmail, $newPassword);

    if ($rowCount > 0) {
        // Update berhasil, redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Update gagal, mungkin tampilkan pesan error
        echo "Update failed. Please try again.";
    }
} else {
    // Jika bukan metode POST, redirect kembali ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}
