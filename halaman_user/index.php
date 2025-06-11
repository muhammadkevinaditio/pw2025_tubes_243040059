<?php
// memanggil header
require 'partials/header.php';

// memanggil navbar
require 'partials/navbar.php';
?>
<body>

    <!-- Bagian Hero -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Ambil Peran Jadi Relawan</h1>
            <p class="lead mb-4">Ubah niat baik jadi aksi baik hari ini</p>
            <a href="search.php" class="btn btn-main">Cari Aktivitas</a>
        </div>
    </header>

    <!-- Daftar Aktivitas -->
    <main id="daftar-aktivitas" class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Aktivitas Terbaru</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php foreach ($aktivitas as $a) : ?>
            <div class="col">
                <div class="card h-100 card-activity">
                    <img src="../admin_panel/img/<?= htmlspecialchars($a['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($a['nama_aktivitas']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($a['nama_aktivitas']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($a['email']); ?></h6>
                        <p class="card-text">
                            <small class="text-muted"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($a['alamat']); ?></small>
                        </p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($aktivitas)) : ?>
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada aktivitas yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3">
        <div class="container">
            <p>&copy; 2025 RelawanConnect. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
