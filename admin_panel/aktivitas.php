<!-- koneksi functions -->
<?php
require 'functions.php';
$title = 'Data Aktivitas';
$aktivitas = query("SELECT * FROM aktivitas");
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kategori</title>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" class="no-decoration text-muted"><i class="bi bi-house-gear-fill"></i>home
                </li></a>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-clipboard2-fill"></i>Aktivitas</li>
            </ol>
        </nav>
        <div class="container mt-5">
            <!-- table data aktivitas -->
            <div class="row">
                <div class="col-8-md">
                    <h1 class="mb-3">Data list aktivitas</h1>
                    <a href="tambah_data_aktivitas.php" class="btn btn-success mb-3">Tambah Data aktivitas</a>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>#</th>
                            <th>Nama aktivitas</th>
                            <th>Nama organisasi</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>detail</th>
                            <th>Aksi</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
</body>
<?php require('partials/footer.php'); ?>

</html>