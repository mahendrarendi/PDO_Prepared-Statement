<?php
session_start();
require_once 'db.php';

// Fungsi untuk login
function login($usernameOrEmail, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND password = ?");
    $stmt->execute([$usernameOrEmail, $usernameOrEmail, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengecek apakah pengguna sudah login
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Halaman tampilan login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses login
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    if (login($usernameOrEmail, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        // Gagal login, mungkin tampilkan pesan error
        echo "Login failed. Please try again.";
    }
} elseif (isUserLoggedIn()) {
    // Pengguna sudah login, redirect ke dashboard
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="usernameOrEmail">Username or Email:</label>
                        <input type="text" class="form-control" name="usernameOrEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <br>
                    <!-- Tautan ke halaman registrasi -->
                    <p>don't have an account yet? <a href="register.php">register Here</a></p>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
