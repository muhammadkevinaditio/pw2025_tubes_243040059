<?php

$title = "Cari Aktivitas"; // Set judul halaman
$aktivitas = []; // Inisialisasi variabel agar tidak error
$keyword = '';

// Panggil header.php, sudah termasuk functions.php di dalamnya
require 'partials/header.php';

// Logika Pencarian
if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
    // Jika ada keyword pencarian, panggil fungsi cari
    $keyword = $_GET['keyword'];
    // PASTIKAN fungsi cari_aktivitas() di functions.php sudah diperbaiki
    $aktivitas = cari_aktivitas($keyword); 
}
// Jika tidak ada keyword, halaman akan menampilkan form dan pesan default saja.
?>

<?php require 'partials/navbar.php'; // Panggil Navbar ?>

<main class="container mt-5 mb-5 flex-grow-1">

    <h2 class="text-center mb-4">Cari Aktivitas Apapun</h2>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <form action="search.php" method="get" class="d-flex">
                <input type="text" class="form-control form-control-lg me-2" name="keyword" placeholder="Cari berdasarkan nama, lokasi..." value="<?= htmlspecialchars($keyword); ?>" autofocus>
                <button class="btn btn-success btn-lg" type="submit">Cari</button>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
        <?php if (!empty($aktivitas)) : ?>
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
                         <a href="../detail.php?id=<?= $a['id']; ?>" class="btn btn-outline-success w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php elseif (isset($_GET['keyword'])) : ?>
            <div class="col-12">
                <p class="text-center text-muted">Aktivitas dengan kata kunci "<?= htmlspecialchars($keyword); ?>" tidak ditemukan.</p>
            </div>
        <?php else : ?>
             <div class="col-12">
                <p class="text-center text-muted">Silakan masukkan kata kunci untuk memulai pencarian.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require 'partials/footer.php'; ?>