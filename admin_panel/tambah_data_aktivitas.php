<?php
require 'functions.php';
$title = 'Form Tambah Data Aktivitas';

// Ambil daftar organisasi untuk ditampilkan di dropdown
$organisasi_list = query("SELECT id, nama_organisasi FROM organisasi ORDER BY nama_organisasi ASC");


// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {

    // Cek apakah data berhasil ditambahkan atau tidak
    if (tambah_aktivitas($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'aktivitas.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'tambah_data_aktivitas.php';
            </script>
        ";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Form Tambah Data Aktivitas</h1>
            <form action="" method="post" enctype="multipart/form-data">
                
                <!-- PERUBAHAN: Input Nama Organisasi diganti jadi Dropdown -->
                <div class="mb-3">
                    <label for="organisasi_id" class="form-label">Pilih Organisasi</label>
                    <select class="form-select" name="organisasi_id" id="organisasi_id" required>
                        <option value="">-- Pilih Organisasi Penyelenggara --</option>
                        <?php foreach ($organisasi_list as $org) : ?>
                            <option value="<?= $org['id']; ?>"><?= htmlspecialchars($org['nama_organisasi']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_aktivitas" class="form-label">Nama Aktivitas</label>
                    <input type="text" class="form-control" id="nama_aktivitas" name="nama_aktivitas" required autofocus>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Kontak</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Aktivitas</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea class="form-control" id="detail" name="detail" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Aktivitas</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                </div>
                <div class="my-4 d-grid gap-4">
                    <button type="submit" name="submit" class="btn btn-success">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>
