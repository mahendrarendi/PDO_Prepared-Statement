 <!-- update_view.php -->
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
                <form action="update_process.php" method="post">
                    <input type="hidden" name="userId" value="<?php echo $account['id']; ?>">
                    <div class="form-group">
                        <label for="newUsername">New Username:</label>
                        <input type="text" class="form-control" name="newUsername" value="<?php echo $account['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="newEmail">New Email:</label>
                        <input type="email" class="form-control" name="newEmail" value="<?php echo $account['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" name="newPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                </form>
                <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
