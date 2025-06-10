<?php
// 1. Selalu mulai sesi di awal
session_start();

// 2. Hapus semua variabel sesi
$_SESSION = [];

// 3. Hapus sesi dari server
session_unset();
session_destroy();

// 4. Arahkan kembali (redirect) pengguna ke halaman utama
header("Location: ../index.php");
exit;
?>
