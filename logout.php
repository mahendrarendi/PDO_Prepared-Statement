<?php
// logout.php
session_start();
session_destroy();

// Redirect ke halaman login_view.php setelah logout
header('Location: login_view.php');
exit();
?>
