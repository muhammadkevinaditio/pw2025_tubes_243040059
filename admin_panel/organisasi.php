<?php
require 'functions.php';
$title = 'Data Organisasi';

// Logika Pencarian
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    // Panggil fungsi pencarian baru
    $organisasi_list = cari_organisasi($keyword);
} else {
    // Jika tidak ada pencarian, tampilkan semua data
    $organisasi_list = query("SELECT * FROM organisasi ORDER BY id DESC");
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
require_once 'functions.php';
// ... sisa kode asli dari masing-masing file ...
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
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-arms-up"></i> Organisasi</li>
        </ol>
    </nav>
    <div class="mt-4">
        <h1 class="mb-3">Data List Organisasi</h1>

        <div class="row">
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau alamat..." name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" autofocus>
                        <button class="btn btn-success" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <a href="tambah_data_organisasi.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Tambah Data Organisasi</a>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Nama Organisasi</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($organisasi_list)) : ?>
                        <tr><td colspan="4" class="text-center">Data organisasi tidak ditemukan.</td></tr>
                    <?php else : ?>
                        <?php $i = 1; foreach ($organisasi_list as $org) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($org['nama_organisasi']); ?></td>
                                <td><?= htmlspecialchars($org['alamat']); ?></td>
                                <td>
                                    <a href="ubah_organisasi.php?id=<?= $org['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="hapus_organisasi.php?id=<?= $org['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
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