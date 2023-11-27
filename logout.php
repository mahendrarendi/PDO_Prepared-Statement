<?php
// logout.php
session_start();
session_destroy();

// Redirect ke halaman login.php setelah logout
header('Location: login.php');
exit();
?>
