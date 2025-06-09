<?php
require 'functions.php';
$title = 'Form Tambah Data Organisasi';

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    
    // Kita akan buat fungsi baru bernama 'tambah_organisasi' nanti di functions.php
    if (tambah_organisasi($_POST) > 0) {
        echo "<script>
            alert('Data organisasi berhasil ditambahkan!');
            document.location.href = 'organisasi.php';
          </script>";
    } else {
        echo "<script>
            alert('Data organisasi gagal ditambahkan!');
            document.location.href = 'tambah_data_organisasi.php';
          </script>";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Tambah Data Organisasi</h1>
            <div class="card p-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Organisasi</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Organisasi</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required></textarea>
                    </div>
                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-success">Tambah Data</button>
                        <a href="organisasi.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>