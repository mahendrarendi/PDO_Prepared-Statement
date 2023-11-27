<?php
session_start();
require_once 'db.php'; // File yang berisi koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login_view.php');
    exit();
}

// Jika sudah login, ambil informasi pengguna dari sesi
$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fungsi untuk menampilkan data akun
function displayAccounts() {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $accounts;
}

// Fungsi untuk mencari data akun berdasarkan keyword
function searchAccount($keyword) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ?");
    $stmt->execute(["%$keyword%", "%$keyword%"]);
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $accounts;
}

// Fungsi untuk mengupdate data akun
function updateAccount($userId, $newUsername, $newEmail, $newPassword) {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$newUsername, $newEmail, $newPassword, $userId]);

    return $stmt->rowCount();
}

// Handle pencarian
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $accounts = searchAccount($keyword);
} else {
    // Tampilkan semua data akun jika tidak ada pencarian
    $accounts = displayAccounts();
}

// Handle update data akun
if (isset($_POST['update'])) {
    $userId = $_POST['userId'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    $rowCount = updateAccount($userId, $newUsername, $newEmail, $newPassword);

    if ($rowCount > 0) {
        // Update berhasil, refresh halaman untuk menampilkan perubahan
        header('Location: dashboard.php');
        exit();
    } else {
        // Update gagal, mungkin tampilkan pesan error
        echo "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Welcome, <?php echo $username; ?>!</h2>
                <p>This is your dashboard.</p>

                <!-- Form Pencarian -->
                <form action="dashboard.php" method="post" class="form-inline">
                    <div class="form-group">
                        <!-- <label for="keyword" class="mr-2">Search:</label> -->
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Enter keyword..." required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="search">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <!-- Tampilkan Data Akun -->
                <h3>Account List</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($accounts as $account) {
                            echo "<tr>";
                            echo "<td>{$account['id']}</td>";
                            echo "<td>{$account['username']}</td>";
                            echo "<td>{$account['email']}</td>";
                            echo "<td>";

                            // Tambahkan link untuk update dan delete dengan ikon
                            echo "<a href='update_view.php?userIdToUpdate={$account['id']}' class='btn btn-warning btn-sm mr-2'><i class='fa fa-edit'></i> Update</a>";
                            echo "<a href='delete_view.php?userIdToDelete={$account['id']}' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i> Delete</a>";
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
