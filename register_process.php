<?php
require_once 'register.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir register
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Panggil fungsi register dari register.php
    $rowCount = register($username, $email, $password);

    if ($rowCount > 0) {
        // Registrasi berhasil, mungkin tampilkan pesan sukses atau redirect ke halaman login
        header('Location: login_view.php');
        exit();
    } else {
        // Registrasi gagal, mungkin tampilkan pesan error
        echo "Registration failed. Please try again.";
    }
} else {
    // Jika bukan metode POST, redirect kembali ke halaman register
    header('Location: register_view.php');
    exit();
}
