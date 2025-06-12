<?php
session_start();

// Cek 1: Apakah pengguna sudah login?
if (!isset($_SESSION['login'])) {
    // Jika belum, arahkan ke halaman login
    header("Location: ../auth/login.php"); 
    exit;
}

// Memuat file functions dan menentukan judul halaman
require_once '../admin_panel/functions.php';
$title = 'Tambah Aktivitas Baru';

// PERUBAHAN: Ambil daftar kategori untuk ditampilkan di dropdown
$kategori_list = query("SELECT * FROM kategori ORDER BY nama_kategori ASC");

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Panggil fungsi tambah_aktivitas yang sudah sesuai dengan sistem kategori
    if (tambah_aktivitas($_POST) > 0) {
        echo "
            <script>
                alert('Aktivitas baru berhasil diajukan dan akan ditinjau oleh admin!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal mengajukan aktivitas baru!');
            </script>
        ";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Formulir Tambah Aktivitas</h1>
            <div class="card p-4 shadow-sm">
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <!-- PERUBAHAN: Dropdown untuk memilih Kategori -->
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Pilih Kategori</label>
                        <select class="form-select" name="kategori_id" id="kategori_id" required>
                            <option value="" disabled selected>-- Pilih Kategori Aktivitas --</option>
                            <?php foreach ($kategori_list as $kat) : ?>
                                <option value="<?= $kat['id']; ?>"><?= htmlspecialchars($kat['nama_kategori']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_aktivitas" class="form-label">Nama Aktivitas</label>
                        <input type="text" class="form-control" id="nama_aktivitas" name="nama_aktivitas" required autofocus placeholder="Contoh: Penanaman 1000 Pohon Mangrove">
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Kontak Penyelenggara</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: kontak@pedulihutan.org">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Lokasi Aktivitas</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required placeholder="Contoh: Pantai Marunda, Jakarta Utara">
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail Aktivitas</label>
                        <textarea class="form-control" id="detail" name="detail" rows="4" required placeholder="Jelaskan secara singkat tentang kegiatan yang akan dilakukan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Poster Aktivitas (Maks: 2MB)</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="submit" class="btn btn-success">Ajukan Aktivitas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>
