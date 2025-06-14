<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../admin_panel/functions.php';

// --- Validasi & Pengambilan Data ---
// 1. Ambil ID dari URL dan pastikan itu adalah angka
$id = $_GET['id'] ?? 0;
if (!is_numeric($id) || $id <= 0) {
    // Jika ID tidak valid, kembalikan ke halaman utama atau tampilkan error
    header("Location: index.php");
    exit;
}

// 2. Query data aktivitas spesifik berdasarkan ID, GABUNGKAN dengan kategori
$conn = koneksi();
$id_safe = mysqli_real_escape_string($conn, $id);
$aktivitas = query("
    SELECT 
        aktivitas.*, 
        kategori.nama_kategori 
    FROM 
        aktivitas
    JOIN 
        kategori ON aktivitas.kategori_id = kategori.id
    WHERE 
        aktivitas.id = $id_safe
")[0]; // Ambil baris pertama

// 3. Jika data tidak ditemukan, arahkan kembali
if (!$aktivitas) {
    echo "Aktivitas tidak ditemukan.";
    exit; // atau header("Location: index.php");
}

$title = htmlspecialchars($aktivitas['nama_aktivitas']); // Judul halaman

require 'partials/header.php';
require 'partials/navbar.php';
?>

<main class="container my-5">
    <div class="row">
        <!-- Kolom Kiri: Gambar Aktivitas -->
        <div class="col-lg-7 mb-4">
            <img src="../img/<?= htmlspecialchars($aktivitas['foto']); ?>" class="img-fluid rounded shadow-sm w-100" alt="Poster <?= htmlspecialchars($aktivitas['nama_aktivitas']); ?>">
        </div>

        <!-- Kolom Kanan: Detail Aktivitas -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Badge Kategori -->
                    <span class="badge bg-success mb-3 fs-6"><?= htmlspecialchars($aktivitas['nama_kategori']); ?></span>
                    
                    <!-- Judul Aktivitas -->
                    <h1 class="card-title display-6 fw-bold"><?= htmlspecialchars($aktivitas['nama_aktivitas']); ?></h1>
                    
                    <hr>

                    <!-- Info Kontak & Lokasi -->
                    <p class="card-text text-muted">
                        <i class="bi bi-envelope-fill me-2"></i><?= htmlspecialchars($aktivitas['email']); ?>
                    </p>
                    <p class="card-text text-muted mb-4">
                        <i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($aktivitas['alamat']); ?>
                    </p>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                         <a href="search.php" class="btn btn-outline-secondary">Cari Aktivitas Lain</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Deskripsi Lengkap -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="mb-3">Deskripsi Aktivitas</h3>
                    <!-- Tampilkan detail dengan format paragraf -->
                    <p style="white-space: pre-wrap;"><?= htmlspecialchars($aktivitas['detail']); ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require 'partials/footer.php'; ?>
