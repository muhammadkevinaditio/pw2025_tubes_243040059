<?php
require 'functions.php';
$title = 'Form Tambah Data Aktivitas';

// Ambil data organisasi untuk ditampilkan di dropdown
$organisasi_list = query("SELECT * FROM organisasi");

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Kirimkan data dan file ke fungsi tambah
    if (tambah($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'aktivitas.php';
          </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            document.location.href = 'tambah_data_aktivitas.php';
          </script>";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Tambah Data Aktivitas</h1>
            <div class="card p-4">
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="organisasi_id" class="form-label">Pilih Organisasi</label>
                        <select class="form-select" name="organisasi_id" id="organisasi_id" required>
                            <option value="" disabled selected>-- Pilih Organisasi --</option>
                            <?php foreach ($organisasi_list as $org) : ?>
                                <option value="<?= $org['id']; ?>"><?= $org['nama_organisasi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Organisasi (Konfirmasi)</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail Aktivitas</label>
                        <textarea class="form-control" id="detail" name="detail" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Aktivitas</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-success">Tambah Data</button>
                        <a href="aktivitas.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>