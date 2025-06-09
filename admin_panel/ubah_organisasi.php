<?php
require 'functions.php';
$title = 'Form Ubah Data Organisasi';

// Ambil id dari URL
$id = $_GET['id'];
if (!$id) {
    header("Location: organisasi.php");
    exit;
}

// Query data organisasi berdasarkan id
$organisasi = query("SELECT * FROM organisasi WHERE id = $id")[0];

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Panggil fungsi ubah_organisasi
    if (ubah_organisasi($_POST) > 0) {
        echo "<script>
            alert('Data organisasi berhasil diubah!');
            document.location.href = 'organisasi.php';
          </script>";
    } else {
        echo "<script>
            alert('Data organisasi gagal diubah!');
            document.location.href = 'organisasi.php';
          </script>";
    }
}
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Form Ubah Data Organisasi</h1>
            <div class="card p-4">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $organisasi['id']; ?>">

                    <div class="mb-3">
                        <label for="nama_organisasi" class="form-label">Nama Resmi Organisasi</label>
                        <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required value="<?= htmlspecialchars($organisasi['nama_organisasi']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap Organisasi</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required><?= htmlspecialchars($organisasi['alamat']); ?></textarea>
                    </div>
                    <div class="my-4 d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">Ubah Data</button>
                        <a href="organisasi.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>