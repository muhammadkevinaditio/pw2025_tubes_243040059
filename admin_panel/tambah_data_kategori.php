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

require_once 'functions.php';
$title = 'Form Tambah Data Kategori';

// Logika untuk memproses form
if (isset($_POST['submit'])) {
    // PERUBAHAN: Panggil fungsi tambah_kategori
    if (tambah_kategori($_POST) > 0) {
        echo "<script>
                alert('Data kategori baru berhasil ditambahkan!');
                document.location.href = 'kategori.php';
              </script>";
    } else {
        echo "<script>
                alert('Data kategori gagal ditambahkan!');
              </script>";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- PERUBAHAN: Judul dan breadcrumb disesuaikan -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-muted text-decoration-none"><i class="bi bi-house-gear-fill"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="kategori.php" class="text-muted text-decoration-none"><i class="bi bi-tags-fill"></i> Kategori</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
                </ol>
            </nav>
            <h1 class="mb-3">Form Tambah Data Kategori</h1>
            
            <div class="card p-4 shadow-sm">
                <!-- PERUBAHAN: Form disederhanakan total -->
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required autofocus placeholder="Contoh: Project">
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="kategori.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="submit" class="btn btn-success">Tambah Kategori</button>
                    </div>
                </form>
            </div>
        </d