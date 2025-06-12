<?php
session_start();

// Cek 1: Apakah pengguna sudah login?
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php"); 
    exit;
}

// Cek 2: Apakah role pengguna adalah 'admin'?
if ($_SESSION['role'] !== 'admin') {
    die("Akses ditolak. Anda tidak memiliki hak untuk mengunjungi halaman ini. <a href='auth/logout.php'>Logout</a>");
    exit;
}

// Jika lolos kedua pemeriksaan, lanjutkan memuat halaman
require_once 'functions.php';
$title = 'Dashboard';

// PERUBAHAN: Query untuk menghitung jumlah data disesuaikan
$jumlah_aktivitas = count(query("SELECT * FROM aktivitas"));
$jumlah_kategori = count(query("SELECT * FROM kategori")); // Mengambil dari tabel 'kategori'
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<style>
    .summary-box {
        color: white;
        border-radius: 15px;
        padding: 20px;
        transition: transform 0.2s;
    }
    .summary-box:hover {
        transform: scale(1.05);
    }
    .summary-aktivitas { background-color: #198754; }
    /* PERUBAHAN: Warna untuk kategori diganti agar berbeda */
    .summary-kategori { background-color: #0d6efd; } 
    .summary-box .icon { font-size: 5rem; opacity: 0.8; }
    .summary-box-link { color: white; text-decoration: none; }
    .summary-box-link:hover { color: #e9ecef; }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Selamat Datang, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>!</h1>
    
    <div class="row">
        <!-- Kartu Aktivitas (Tidak Berubah) -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="summary-box summary-aktivitas">
                <div class="row">
                    <div class="col-8">
                        <h3>Aktivitas</h3>
                        <h2 class="fs-1 fw-bold"><?= $jumlah_aktivitas; ?></h2>
                        <a href="aktivitas.php" class="summary-box-link">Kelola Aktivitas &rarr;</a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end">
                        <i class="bi bi-clipboard2-fill icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- PERUBAHAN: Kartu Organisasi diubah menjadi Kategori -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="summary-box summary-kategori">
                <div class="row">
                    <div class="col-8">
                        <h3>Kategori</h3>
                        <h2 class="fs-1 fw-bold"><?= $jumlah_kategori; ?></h2>
                        <a href="kategori.php" class="summary-box-link">Kelola Kategori &rarr;</a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end">
                        <i class="bi bi-tags-fill icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>
