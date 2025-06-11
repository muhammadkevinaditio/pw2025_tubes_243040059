<?php
require 'functions.php';
$title = 'Form Ubah Data Aktivitas';

// Ambil id dari URL
$id = $_GET['id'];

// Query data aktivitas berdasarkan id
$aktivitas = query("SELECT * FROM aktivitas WHERE id = $id")[0];

// Ambil data organisasi untuk dropdown
$organisasi_list = query("SELECT id, nama_organisasi FROM organisasi");

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Panggil fungsi ubah_aktivitas
    if (ubah_aktivitas($_POST) > 0) {
        echo "<script>
            alert('Data aktivitas berhasil diubah!');
            document.location.href = 'aktivitas.php';
          </script>";
    } else {
        echo "<script>
            alert('Data aktivitas gagal diubah!');
            document.location.href = 'aktivitas.php';
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
            <h1 class="mb-3">Form Ubah Data Aktivitas</h1>
            <div class="card p-4">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $aktivitas['id']; ?>">
                    <input type="hidden" name="fotoLama" value="<?= $aktivitas['foto']; ?>">

                    <div class="mb-3">
                        <label for="organisasi_id" class="form-label">Pilih Organisasi Penyelenggara</label>
                        <select class="form-select" name="organisasi_id" id="organisasi_id" required>
                            <?php foreach ($organisasi_list as $org) : ?>
                                <option value="<?= htmlspecialchars($org['id']); ?>" <?= ($org['id'] == $aktivitas['organisasi_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($org['nama_organisasi']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Judul Aktivitas</label>
                        <input type="text" class="form-control" id="nama_aktivitas" name="nama_aktivitas" required value="<?= htmlspecialchars($aktivitas['nama_aktivitas']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Kontak Aktivitas</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($aktivitas['email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Lokasi Aktivitas</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required value="<?= htmlspecialchars($aktivitas['alamat']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail Lengkap Aktivitas</label>
                        <textarea class="form-control" id="detail" name="detail" rows="4" required><?= htmlspecialchars($aktivitas['detail']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Poster / Foto Aktivitas</label>
                        <br>
                        <img src="img/<?= htmlspecialchars($aktivitas['foto']); ?>" width="120" class="mb-2">
                        <input type="file" class="form-control" id="foto" name="foto">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>
                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">Ubah Data</button>
                        <a href="aktivitas.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>