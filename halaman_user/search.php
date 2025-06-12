<?php
require '../admin_panel/functions.php';
$title = 'Cari Aktivitas';

$keyword = $_GET['keyword'] ?? '';
$kategori_filter = $_GET['kategori'] ?? '';

// Ambil semua kategori untuk tombol filter
$kategori_list = query("SELECT * FROM kategori ORDER BY nama_kategori ASC");

// --- LOGIKA PENCARIAN & FILTER ---
$conn = koneksi();
$base_query = "
    SELECT 
        aktivitas.*, 
        kategori.nama_kategori 
    FROM 
        aktivitas
    JOIN 
        kategori ON aktivitas.kategori_id = kategori.id
";

if (!empty($kategori_filter)) {
    // Filter berdasarkan kategori
    $kategori_filter_safe = mysqli_real_escape_string($conn, $kategori_filter);
    $base_query .= " WHERE kategori.nama_kategori = '$kategori_filter_safe'";
} elseif (!empty($keyword)) {
    // Cari berdasarkan keyword
    $keyword_safe = mysqli_real_escape_string($conn, $keyword);
    $base_query .= " WHERE (aktivitas.nama_aktivitas LIKE '%$keyword_safe%' OR aktivitas.detail LIKE '%$keyword_safe%' OR aktivitas.alamat LIKE '%$keyword_safe%')";
}

$base_query .= " ORDER BY aktivitas.id DESC";
$aktivitas_list = query($base_query);
// --- AKHIR LOGIKA ---

require 'partials/header.php';
require 'partials/navbar.php'; 
?>

<main class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h1 class="display-5 fw-bold">Cari Aktivitas Apapun</h1>
            <p class="lead text-muted mb-4">Temukan kegiatan kerelawanan yang sesuai dengan minat Anda di seluruh Indonesia.</p>
        </div>
    </div>

    <!-- Kolom Pencarian -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <form action="search.php" method="get" class="d-flex shadow-sm">
                <input type="text" class="form-control form-control-lg" name="keyword" placeholder="Ketik nama aktivitas, lokasi, atau topik..." value="<?= htmlspecialchars($keyword); ?>" autofocus>
                <button class="btn btn-success btn-lg" type="submit" style="white-space: nowrap;"><i class="bi bi-search"></i> Cari</button>
            </form>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="text-center mb-5">
        <div class="btn-group shadow-sm" role="group" aria-label="Filter Kategori">
            <a href="search.php" class="btn <?= (empty($kategori_filter) && empty($keyword)) ? 'btn-success' : 'btn-outline-success'; ?>">Semua</a>
            <?php foreach($kategori_list as $kat) : ?>
                <a href="?kategori=<?= urlencode($kat['nama_kategori']); ?>" class="btn <?= ($kategori_filter === $kat['nama_kategori']) ? 'btn-success' : 'btn-outline-success'; ?>"><?= htmlspecialchars($kat['nama_kategori']); ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Container untuk hasil pencarian -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        
        <?php if (!empty($aktivitas_list)) : ?>
            <?php foreach ($aktivitas_list as $a) : ?>
            <div class="col">
                <div class="card h-100 card-activity">
                    <img src="../img/<?= htmlspecialchars($a['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($a['nama_aktivitas']); ?>">
                    <div class="card-body d-flex flex-column">
                        <p class="text-success fw-bold mb-1"><?= htmlspecialchars($a['nama_kategori']); ?></p>
                        <h5 class="card-title"><?= htmlspecialchars($a['nama_aktivitas']); ?></h5>
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars(mb_strimwidth($a['detail'], 0, 100, "...")); ?>
                        </p>
                        <div class="mt-auto">
                           <a href="detail_aktivitas.php?id=<?= $a['id']; ?>" class="btn btn-outline-success w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        <?php else : ?>
            <div class="col-lg-8">
                <div class="info-message text-center">
                    <h4 class="text-muted">Oops!</h4>
                     <?php if(!empty($keyword)): ?>
                        <p>Aktivitas dengan kata kunci "<strong><?= htmlspecialchars($keyword); ?></strong>" tidak dapat kami temukan.</p>
                    <?php elseif(!empty($kategori_filter)): ?>
                        <p>Tidak ada aktivitas dalam kategori "<strong><?= htmlspecialchars($kategori_filter); ?></strong>" saat ini.</p>
                    <?php else: ?>
                         <p>Belum ada aktivitas yang tersedia.</p>
                    <?php endif; ?>
                    <p><a href="search.php" class="text-success">Lihat semua aktivitas</a></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require 'partials/footer.php'; ?>
