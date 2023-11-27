<?php
require_once 'login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir login
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    // Panggil fungsi login dari login.php
    $user = login($usernameOrEmail, $password);

    if ($user) {
        // Login berhasil, lakukan sesuatu seperti menyimpan data sesi
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect ke halaman setelah login
        header('Location: dashboard.php');
        exit();
    } else {
        // Login gagal, mungkin tampilkan pesan error atau redirect kembali ke halaman login
        echo "Login failed. Please check your credentials.";
    }
} else {
    // Jika bukan metode POST, redirect kembali ke halaman login
    header('Location: login_view.php');
    exit();
}
