<?php
require 'functions.php';
$title = 'Form tambah data aktivitas';

if (isset($_POST['submit'])) {
    if (tambah($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'tambah_data_aktivitas.php';
          </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            document.location.href = 'aktivitas.php';
          </script>";
    }
}
?>

<?php require('partials/header.php'); ?>

<?php require('partials/navbar.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-3">Form Tambah Data Aktivitas</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- <div class="mb-3">
                    <label for="nama" class="form-label">Nama aktivitas</label>
                    <input type="text" class="form-control" id="nama" name="nama aktivitas" required autofocus>
                </div> -->
                <div class="mb-3">
                    <label for="nim" class="form-label">Nama organisasi</label>
                    <input type="text" class="form-control" id="nama organisasi" name="nama organisasi" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <!-- <div class="mb-3">
                    <label for="gambar" class="form-label">Foto</label>
                    <input type="text" class="form-control" id="foto" name="foto" value="nophoto.jpg" readonly>
                </div> -->
                <!-- <div class="mb-3">
                    <label for="jurusan" class="form-label">Detail</label>
                    <input type="text" class="form-control" id="detail" name="detail" required>
                </div> -->
                <div class="my-4 d-grid gap-4">
                    <button type="submit" name="submit" class="btn btn-success">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>