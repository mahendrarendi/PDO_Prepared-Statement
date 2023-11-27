<?php
session_start();
require_once 'db.php';

// Fungsi untuk menghapus data akun
function deleteAccount($userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

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

// Halaman tampilan delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses delete
    $userId = $_POST['userId'];

    $rowCount = deleteAccount($userId);

    if ($rowCount > 0) {
        // Delete berhasil, redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Delete gagal, mungkin tampilkan pesan error
        echo "Delete failed. Please try again.";
    }
} else {
    // Halaman tampilan delete
    if (isset($_GET['userIdToDelete'])) {
        $userIdToDelete = $_GET['userIdToDelete'];
        $accountToDelete = getAccountById($userIdToDelete);
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
    <title>Delete Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Delete Account</h2>
                <p>Are you sure you want to delete the account for <?php echo $accountToDelete['username']; ?>?</p>
                <form action="delete.php" method="post">
                    <input type="hidden" name="userId" value="<?php echo $accountToDelete['id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
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
