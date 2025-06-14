<?php
session_start();

// Hapus semua variabel session
$_SESSION = [];

// Hancurkan session
session_destroy();


// Redirect ke halaman login
header("Location: ../../halaman_user/index.php");
exit;
?>