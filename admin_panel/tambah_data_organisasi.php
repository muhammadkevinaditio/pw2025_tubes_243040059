<?php
require 'functions.php';
$title = 'Form Tambah Data Organisasi';

if (isset($_POST['submit'])) {
    if (tambah_organisasi($_POST) > 0) { // Memanggil fungsi yang sudah diperbaiki
        echo "<script>
            alert('Data organisasi dan user baru berhasil ditambahkan!');
            document.location.href = 'organisasi.php';
          </script>";
    } else {
        echo "<script>
            alert('Data organisasi GAGAL ditambahkan!');
          </script>";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Tambah Organisasi Baru</h1>
            <p class="text-muted">Menambahkan organisasi baru akan sekaligus membuat akun login untuk organisasi tersebut.</p>
            <div class="card p-4">
                <form action="" method="post">
                    
                    <h5 class="border-bottom pb-2 mb-3">1. Profil Organisasi</h5>
                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Resmi Organisasi</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap Organisasi</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>

                    <h5 class="border-bottom pb-2 mb-3 mt-4">2. Akun Login</h5>
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
                        <button type="submit" name="submit" class="btn btn-success">Simpan Organisasi & Buat Akun</button>
                        <a href="organisasi.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>