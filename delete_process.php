<?php
require_once 'delete.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir delete
    $userIdToDelete = $_POST['userIdToDelete'];

    // Panggil fungsi deleteAccount dari delete.php
    $rowCount = deleteAccount($userIdToDelete);

    if ($rowCount > 0) {
        // Hapus berhasil, redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Hapus gagal, mungkin tampilkan pesan error
        echo "Delete failed. Please try again.";
    }
} else {
    // Jika bukan metode POST, redirect kembali ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}
