<?php
require 'functions.php';
$title = 'Form Tambah Data Organisasi';

if (isset($_POST['submit'])) {
    if (tambah_organisasi($_POST) > 0) {
        echo "<script>
            alert('Data organisasi dan user baru berhasil ditambahkan!');
            document.location.href = 'organisasi.php';
          </script>";
    } else {
        // Pesan error lebih spesifik bisa ditambahkan di sini jika perlu
        echo "<script>
            alert('Data organisasi gagal ditambahkan! Pastikan username belum terdaftar.');
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
            <p>Lengkapi profil organisasi beserta informasi login yang akan digunakan.</p>
            <div class="card p-4">
                <form action="" method="post">
                    <h5 class="mb-3">Profil Organisasi</h5>
                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Organisasi</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Organisasi</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Akun Login untuk Organisasi</h5>
                     <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                     <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                     <div class="mb-3">
                        <label for="password2" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password2" name="password2" required>
                    </div>

                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-success">Tambah Data & Buat Akun</button>
                        <a href="organisasi.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>