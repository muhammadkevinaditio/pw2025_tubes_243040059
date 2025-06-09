<?php
session_start();

// Hapus semua variabel session
$_SESSION = [];

// Hancurkan session
session_destroy();

// Hapus cookie jika ada (opsional, untuk fitur "Remember Me")
// setcookie('id', '', time() - 3600);
// setcookie('key', '', time() - 3600);

// Redirect ke halaman login
header("Location: login.php");
exit;
?>