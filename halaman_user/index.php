<?php
// Pastikan sesi dimulai jika diperlukan untuk navbar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../admin_panel/functions.php';
$title = "Selamat Datang di RelawanConnect";

// Query SQL untuk mengambil data aktivitas DAN nama kategorinya
$aktivitas_list = query("
    SELECT 
        aktivitas.*, 
        kategori.nama_kategori 
    FROM 
        aktivitas
    JOIN 
        kategori ON aktivitas.kategori_id = kategori.id
    ORDER BY 
        aktivitas.id DESC
    LIMIT 6
");

// Query kategori sudah dihapus dari sini

require 'partials/header.php';
require 'partials/navbar.php';
?>
<body>

    <!-- Bagian Hero -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">RelawanConnect</h1>
            <p class="lead mb-4">Ubah niat baik jadi aksi baik hari ini</p>
            <a href="search.php" class="btn btn-main">Cari Semua Aktivitas</a>
        </div>
    </header>

    <main class="container mt-5 mb-5">
        
        <!-- Bagian Filter Kategori sudah dipindahkan ke search.php -->

        <!-- Daftar Aktivitas -->
        <section id="daftar-aktivitas">
            <h2 class="text-center mb-4">Aktivitas Terbaru</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                
                <?php if (empty($aktivitas_list)) : ?>
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada aktivitas yang tersedia saat ini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($aktivitas_list as $a) : ?>
                    <div class="col">
                        <div class="card h-100 card-activity shadow-sm">
                            <img src="../img/<?= htmlspecialchars($a['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($a['nama_aktivitas']); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="text-success fw-bold mb-1"><?= htmlspecialchars($a['nama_kategori']); ?></p>           
                                <h5 class="card-title"><?= htmlspecialchars($a['nama_aktivitas']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($a['email']); ?></h6>
                                <p class="card-text">
                                    <small class="text-muted"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($a['alamat']); ?></small>
                                </p>
                            </div>
                            <div class="card-footer bg-white border-top-0 pb-3">
                                 <a href="detail_aktivitas.php?id=<?= $a['id']; ?>" class="btn btn-outline-success w-100">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> RelawanConnect. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
