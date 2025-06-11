<?php
// Mulai sesi di baris paling atas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hubungkan ke file functions.php Anda
// Sesuaikan path jika letak filenya berbeda
require '../admin_panel/functions.php';

// --- LOGIKA KEAMANAN ---
// Cek apakah pengguna sudah login. Jika tidak, redirect ke halaman login.
// Sesuaikan 'login_user' dengan nama session yang Anda gunakan
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

// --- LOGIKA PROSES FORM ---
// Cek apakah tombol 'submit' sudah ditekan
if (isset($_POST["submit"])) {

    // Panggil fungsi untuk menambah data dari functions.php
    // Anggap nama fungsinya adalah tambahAktivitas()
    // Fungsi ini akan menangani validasi, upload gambar, dan insert ke database
    if (tambah_aktivitas($_POST) > 0) {
        // Jika berhasil, tampilkan pesan sukses dengan JavaScript dan redirect
        echo "
            <script>
                alert('Data aktivitas baru berhasil ditambahkan!');
                document.location.href = '../halaman_user/index.php';
            </script>
        ";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "
            <script>
                alert('Gagal menambahkan data aktivitas baru!');
                document.location.href = 'tambah_lowongan.php';
            </script>
        ";
    }
}

// Ambil path ke header Anda. Sesuaikan jika perlu.
require('partials/header.php');
require('partials/navbar.php');
?>

<!-- KONTEN FORMULIR -->
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">Formulir Tambah Aktivitas Baru</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
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
                    <label for="foto" class="form-label">Foto Aktivitas maks:2mb</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                </div>

                        <!-- Tombol Submit dan Kembali -->
                        <div class="d-flex justify-content-between">
                            <a href="../halaman_user/index.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" name="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Aktivitas
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR KONTEN FORMULIR -->

<?php
// Ambil path ke footer Anda. Sesuaikan jika perlu.
require 'partials/footer.php';
?>
