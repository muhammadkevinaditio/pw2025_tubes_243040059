<?php
require 'functions.php';
$title = 'Data Aktivitas';
$aktivitas = query("SELECT * FROM aktivitas ORDER BY id DESC");
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<style>
    .no-decoration {
        text-decoration: none;
    }
    .table-img {
        width: 100px;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="no-decoration text-muted"><i class="bi bi-house-gear-fill"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-clipboard2-fill"></i> Aktivitas</li>
        </ol>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-3">Data List Aktivitas</h1>
                <a href="tambah_data_aktivitas.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Tambah Data Aktivitas</a>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-success"> <tr>
                                <th>#</th>
                                <th>Nama Organisasi</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Foto</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($aktivitas)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center">Data aktivitas tidak ditemukan.</td>
                                </tr>
                            <?php else : ?>
                                <?php $i = 1;
                                foreach ($aktivitas as $akt) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $akt['nama_organisasi']; ?></td>
                                        <td><?= $akt['email']; ?></td>
                                        <td><?= $akt['alamat']; ?></td>
                                        <td>
                                            <img src="img/<?= $akt['foto']; ?>" alt="Foto Aktivitas" class="table-img">
                                        </td>
                                        <td><?= $akt['detail']; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <a href="hapus.php?id=<?= $akt['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
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