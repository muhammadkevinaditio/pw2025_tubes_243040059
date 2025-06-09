<!-- koneksi functions -->
<?php
require 'functions.php';
$title = 'Data Aktivitas';
$aktivitas = query("SELECT * FROM aktivitas");
?>
<?php
session_start();

if (!isset($_SESSION['login'])) {
    // Jika belum login, tendang ke halaman login
    header("Location: ../auth/login.php");
    exit;
}

// Baru require functions.php setelah cek session
require_once 'functions.php';
// ... sisa kode asli dari masing-masing file ...
?>

<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once 'functions.php';
$title = 'Dashboard';
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5">
    <h1>Selamat Datang di Halaman Admin!</h1>
    <p>Halo, <?= htmlspecialchars($_SESSION['username']); ?>. Anda berhasil login.</p>
</div>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>relawan_connect</title>
</head>

<style>
    .square {
        border: solid;
    }

    .summary-aktivitas {
        background-color: #188639;
        border-radius: 15px;
    }

    .summary-organisasi {
        background-color: #af4d0c;
        border-radius: 15px;
    }

    .no-decoration:hover {
        text-decoration: none;
        color: salmon;
    }
</style>

<body>
    <!-- <h2>halo admin</h2> -->

    <!-- summary design -->
    <div class="container mt-5">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-house-gear-fill"></i>Home</li>
                </ol>
            </nav>
            <!-- summary-aktivitas -->
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-aktivitas p-3">
                    <div class="row">
                        <div class="col-6"></div>
                        <div><i class="bi bi-clipboard2" style="font-size: 6rem; color: #fff;"></i></div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">aktivitas</h3>
                            <p class="fs-5"></p>
                            <p><a href="aktivitas" class="text-white no-decoration">kelola aktivitas</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- summary-organisasi/user -->
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-organisasi p-3">
                    <div class="row">
                        <div class="col-6"></div>
                        <div><i class="bi bi-person-arms-up" style="font-size: 6rem; color: #fff;"></i></div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">organisasi</h3>
                            <p class="fs-5"></p>
                            <p><a href="aktivitas" class="text-white no-decoration">organisasi</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require('partials/footer.php'); ?>

</html>