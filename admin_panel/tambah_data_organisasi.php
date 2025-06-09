<?php
require 'functions.php'; // Menggunakan functions.php dari admin_panel
$title = 'Form Tambah Data Organisasi';

// Query untuk mengambil user yang BELUM memiliki relasi di tabel organisasi
$unlinked_users = query("SELECT * FROM user WHERE id NOT IN (SELECT user_id FROM organisasi WHERE user_id IS NOT NULL)");

if (isset($_POST['submit'])) {
    if (tambah_organisasi($_POST) > 0) {
        echo "<script>
            alert('Data organisasi berhasil ditambahkan!');
            document.location.href = 'organisasi.php';
          </script>";
    } else {
        echo "<script>
            alert('Data organisasi gagal ditambahkan!');
          </script>";
    }
}
?>
<?php
session_start();

// Cek 1: Apakah pengguna sudah login?
if (!isset($_SESSION['login'])) {
    // Jika belum, tendang ke halaman login
    header("Location: ../auth/login.php"); // Sesuaikan path jika direktori auth ada di dalam admin_panel
    exit;
}

// Cek 2: Apakah role pengguna adalah 'admin'?
if ($_SESSION['role'] !== 'admin') {
    // Jika bukan admin, hentikan akses dan beri pesan
    die("Akses ditolak. Anda tidak memiliki hak untuk mengunjungi halaman ini. <a href='../auth/logout.php'>Logout</a>");
    exit;
}

// Jika lolos kedua pemeriksaan, lanjutkan memuat halaman
require_once 'functions.php';

// ... sisa kode asli dari masing-masing file dimulai dari sini ...
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Tambah Data Organisasi</h1>
            <p class="text-muted">Pastikan Anda sudah mendaftarkan user untuk organisasi ini melalui halaman registrasi.</p>
            <div class="card p-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Akun User</label>
                        <select class="form-select" name="user_id" id="user_id" required>
                            <option value="" disabled selected>-- Pilih user yang belum terhubung --</option>
                            <?php foreach ($unlinked_users as $user) : ?>
                                <option value="<?= htmlspecialchars($user['id']); ?>"><?= htmlspecialchars($user['username']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($unlinked_users)) : ?>
                            <div class="form-text text-danger">Semua user sudah terhubung dengan organisasi. Buat user baru terlebih dahulu.</div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Resmi Organisasi</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap Organisasi</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required></textarea>
                    </div>
                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-success" <?= empty($unlinked_users) ? 'disabled' : '' ?>>Tambah Data Organisasi</button>
                        <a href="organisasi.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>