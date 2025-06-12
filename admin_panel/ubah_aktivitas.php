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
$title = 'Form Ubah Data Aktivitas';

// Ambil id dari URL
$id = $_GET['id'];
if (!isset($id)) {
    header("Location: aktivitas.php");
    exit;
}

// Query data aktivitas berdasarkan id
$aktivitas = query("SELECT * FROM aktivitas WHERE id = $id")[0];

// PERUBAHAN: Ambil data kategori untuk dropdown
$kategori_list = query("SELECT * FROM kategori");

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Panggil fungsi ubah_aktivitas yang sudah diperbarui
    if (ubah_aktivitas($_POST) > 0) {
        echo "<script>
                alert('Data aktivitas berhasil diubah!');
                document.location.href = 'aktivitas.php';
              </script>";
    } else {
        echo "<script>
                alert('Tidak ada data yang diubah atau terjadi kesalahan!');
                document.location.href = 'aktivitas.php';
              </script>";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Ubah Data Aktivitas</h1>
            <div class="card p-4 shadow-sm">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $aktivitas['id']; ?>">
                    <input type="hidden" name="fotoLama" value="<?= $aktivitas['foto']; ?>">

                    <!-- PERUBAHAN: Dropdown untuk memilih Kategori -->
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Pilih Kategori</label>
                        <select class="form-select" name="kategori_id" id="kategori_id" required>
                            <?php foreach ($kategori_list as $kat) : ?>
                                <option value="<?= $kat['id']; ?>" <?= ($kat['id'] == $aktivitas['kategori_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($kat['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_aktivitas" class="form-label">Nama Aktivitas</label>
                        <input type="text" class="form-control" id="nama_aktivitas" name="nama_aktivitas" required value="<?= htmlspecialchars($aktivitas['nama_aktivitas']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Kontak</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($aktivitas['email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Aktivitas</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required value="<?= htmlspecialchars($aktivitas['alamat']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail</label>
                        <textarea class="form-control" id="detail" name="detail" rows="4" required><?= htmlspecialchars($aktivitas['detail']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Ganti Foto (Maks: 2MB)</label>
                        <br>
                        <img src="../img/<?= htmlspecialchars($aktivitas['foto']); ?>" width="120" class="mb-2 img-thumbnail">
                        <input type="file" class="form-control" id="foto" name="foto">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="aktivitas.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="submit" class="btn btn-primary">Ubah Data Aktivitas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>
