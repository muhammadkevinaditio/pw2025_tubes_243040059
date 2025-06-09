<?php
require 'functions.php';
$title = 'Data Aktivitas';

// Logika Pencarian
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    // Panggil fungsi pencarian baru
    $aktivitas_list = cari_aktivitas($keyword);
} else {
    // Jika tidak ada pencarian, tampilkan semua data
    $aktivitas_list = query("SELECT * FROM aktivitas ORDER BY id DESC");
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<style>
    .table-img { width: 100px; height: auto; object-fit: cover; border-radius: 5px; }
    .no-decoration { text-decoration: none; }
</style>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="no-decoration text-muted"><i class="bi bi-house-gear-fill"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-clipboard2-fill"></i> Aktivitas</li>
        </ol>
    </nav>
    <div class="mt-4">
        <h1 class="mb-3">Data List Aktivitas</h1>
        
        <div class="row">
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan judul atau detail..." name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" autofocus>
                        <button class="btn btn-success" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <a href="tambah_data_aktivitas.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Tambah Data Aktivitas</a>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Judul Aktivitas</th>
                        <th>Email Kontak</th>
                        <th>Lokasi</th>
                        <th>Foto</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($aktivitas_list)) : ?>
                        <tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>
                    <?php else : ?>
                        <?php $i = 1; foreach ($aktivitas_list as $akt) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($akt['nama_organisasi']); ?></td>
                                <td><?= htmlspecialchars($akt['email']); ?></td>
                                <td><?= htmlspecialchars($akt['alamat']); ?></td>
                                <td><img src="img/<?= htmlspecialchars($akt['foto']); ?>" alt="Foto" class="table-img"></td>
                                <td><?= htmlspecialchars($akt['detail']); ?></td>
                                <td>
                                    <a href="ubah_aktivitas.php?id=<?= $akt['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="hapus_aktivitas.php?id=<?= $akt['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
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