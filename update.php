<?php
session_start();
require_once 'db.php';

// Fungsi untuk mengupdate data akun
function updateAccount($userId, $newUsername, $newEmail, $newPassword) {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$newUsername, $newEmail, $newPassword, $userId]);

    return $stmt->rowCount();
}

// Fungsi untuk menampilkan data akun berdasarkan ID
function getAccountById($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    return $account;
}

// Halaman tampilan update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses update
    $userId = $_POST['userId'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

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
    // Halaman tampilan update
    if (isset($_GET['userIdToUpdate'])) {
        $userIdToUpdate = $_GET['userIdToUpdate'];
        $accountToUpdate = getAccountById($userIdToUpdate);
    } else {
        // Jika tidak ada ID yang diberikan, redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Update Account</h2>
                <form action="update.php" method="post">
                    <input type="hidden" name="userId" value="<?php echo $accountToUpdate['id']; ?>">
                    <div class="form-group">
                        <label for="newUsername">New Username:</label>
                        <input type="text" class="form-control" name="newUsername" value="<?php echo $accountToUpdate['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="newEmail">New Email:</label>
                        <input type="email" class="form-control" name="newEmail" value="<?php echo $accountToUpdate['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" name="newPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
