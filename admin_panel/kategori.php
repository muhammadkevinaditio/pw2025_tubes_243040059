<?php
// Pastikan tidak ada karakter apapun sebelum baris ini
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
$title = 'Data Kategori'; // PERUBAHAN: Judul halaman

// Logika Pencarian
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    // PERUBAHAN: Panggil fungsi pencarian baru
    $kategori_list = cari_kategori($keyword);
} else {
    // PERUBAHAN: Ambil data dari tabel 'kategori'
    $kategori_list = query("SELECT * FROM kategori ORDER BY id DESC");
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<style>
    .no-decoration { text-decoration: none; }
</style>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="no-decoration text-muted"><i class="bi bi-house-gear-fill"></i> Home</a></li>
            <!-- PERUBAHAN: Mengganti ikon dan teks breadcrumb -->
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-tags-fill"></i> Kategori</li>
        </ol>
    </nav>
    <div class="mt-4">
        <!-- PERUBAHAN: Judul utama halaman -->
        <h1 class="mb-3">Data List Kategori</h1>

        <div class="row">
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <!-- PERUBAHAN: Placeholder disesuaikan -->
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama kategori..." name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" autofocus>
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PERUBAHAN: Tombol dan link disesuaikan untuk kategori -->
        <a href="tambah_data_kategori.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Tambah Data Kategori</a>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <!-- PERUBAHAN: Header tabel disesuaikan -->
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PERUBAHAN: Menggunakan variabel $kategori_list -->
                    <?php if (empty($kategori_list)) : ?>
                        <!-- PERUBAHAN: Colspan menjadi 3 dan teks disesuaikan -->
                        <tr><td colspan="3" class="text-center">Data kategori tidak ditemukan.</td></tr>
                    <?php else : ?>
                        <!-- PERUBAHAN: Variabel loop dan array key disesuaikan -->
                        <?php $i = 1; foreach ($kategori_list as $kat) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($kat['nama_kategori']); ?></td>
                                <td>
                                    <!-- PERUBAHAN: Link ubah dan hapus disesuaikan -->
                                    <a href="ubah_kategori.php?id=<?= $kat['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="hapus_kategori.php?id=<?= $kat['id']; ?>" onclick="return confirm('Yakin ingin menghapus kategori ini? Semua aktivitas terkait akan kehilangan kategorinya.');" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>
