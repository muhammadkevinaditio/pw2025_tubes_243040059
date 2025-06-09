<?php
require 'functions.php';
$title = 'Data Organisasi';
// Mengambil data dari tabel organisasi
$organisasi_list = query("SELECT * FROM organisasi ORDER BY id DESC");
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<style>
    /* Anda bisa menambahkan style khusus jika diperlukan */
    .no-decoration {
        text-decoration: none;
    }
</style>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="no-decoration text-muted"><i class="bi bi-house-gear-fill"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-arms-up"></i> Organisasi</li>
        </ol>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-3">Data List Organisasi</h1>
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
                                <tr>
                                    <td colspan="4" class="text-center">Data organisasi tidak ditemukan.</td>
                                </tr>
                            <?php else : ?>
                                <?php $i = 1;
                                foreach ($organisasi_list as $org) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $org['nama_organisasi']; ?></td>
                                        <td><?= $org['alamat']; ?></td>
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
    </div>
</div>

<?php require('partials/footer.php'); ?>