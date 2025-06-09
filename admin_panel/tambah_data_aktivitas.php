<?php
require 'functions.php';
$title = 'Form Tambah Data Aktivitas';

// Ambil data organisasi untuk ditampilkan di dropdown
$organisasi_list = query("SELECT id, nama_organisasi FROM organisasi");

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    if (tambah_aktivitas($_POST) > 0) { // Memanggil fungsi yang sudah diperbaiki
        echo "<script>
            alert('Data aktivitas berhasil ditambahkan!');
            document.location.href = 'aktivitas.php';
          </script>";
    } else {
        echo "<script>
            alert('Data aktivitas gagal ditambahkan!');
          </script>";
    }
}
?>
<?php
session_start();

if (!isset($_SESSION['login'])) {
    // Jika belum login, tendang ke halaman login
    header("Location: ../auth/login.php");
    exit;
}

// Baru require functions.php setelah cek session
require 'functions.php';
// ... sisa kode asli dari masing-masing file ...
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Tambah Data Aktivitas</h1>
            <div class="card p-4">
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="organisasi_id" class="form-label">Pilih Organisasi Penyelenggara</label>
                        <select class="form-select" name="organisasi_id" id="organisasi_id" required>
                            <option value="" disabled selected>-- Pilih dari daftar --</option>
                            <?php foreach ($organisasi_list as $org) : ?>
                                <option value="<?= htmlspecialchars($org['id']); ?>"><?= htmlspecialchars($org['nama_organisasi']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Aktivitas / Judul</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Kontak</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Lokasi Aktivitas</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail Lengkap Aktivitas</label>
                        <textarea class="form-control" id="detail" name="detail" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Poster / Foto Aktivitas</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-success">Tambah Data Aktivitas</button>
                        <a href="aktivitas.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>