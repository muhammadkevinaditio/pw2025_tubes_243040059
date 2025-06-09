<?php
// Mulai session dan cek status login
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once 'functions.php';
$title = 'Dashboard';

// Query untuk menghitung jumlah data
$jumlah_aktivitas = count(query("SELECT * FROM aktivitas"));
$jumlah_organisasi = count(query("SELECT * FROM organisasi"));
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
    .summary-organisasi { background-color: #fd7e14; }
    .summary-box .icon { font-size: 5rem; opacity: 0.8; }
    .summary-box-link { color: white; text-decoration: none; }
    .summary-box-link:hover { color: #e9ecef; }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Selamat Datang, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>!</h1>
    
    <div class="row">
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

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="summary-box summary-organisasi">
                <div class="row">
                    <div class="col-8">
                        <h3>Organisasi</h3>
                        <h2 class="fs-1 fw-bold"><?= $jumlah_organisasi; ?></h2>
                        <a href="organisasi.php" class="summary-box-link">Kelola Organisasi &rarr;</a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end">
                        <i class="bi bi-person-arms-up icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>