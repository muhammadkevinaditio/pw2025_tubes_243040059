<?php
require '../admin_panel/functions.php';

$title = "Cari Aktivitas";
$aktivitas = []; 
$keyword = '';

if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
    $keyword = $_GET['keyword'];
    $aktivitas = cari_aktivitas($keyword); 
}

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

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <form action="search.php" method="get" class="d-flex shadow-sm">
                <input type="text" class="form-control form-control-lg" name="keyword" placeholder="Ketik nama aktivitas, lokasi, atau topik..." value="<?= htmlspecialchars($keyword); ?>" autofocus>
                <button class="btn btn-success btn-lg" type="submit" style="white-space: nowrap;"><i class="bi bi-search"></i> Cari</button>
            </form>
        </div>
    </div>

    <!-- Container untuk hasil pencarian -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        
        <?php if (!empty($aktivitas)) : ?>
            <!-- JIKA AKTIVITAS DITEMUKAN -->
            <?php foreach ($aktivitas as $a) : ?>
            <div class="col">
                <div class="card h-100 card-activity">
                    <img src="../img/<?= htmlspecialchars($a['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($a['nama_aktivitas']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($a['nama_aktivitas']); ?></h5>
                        <div class="mb-2">
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                                <i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($a['alamat']); ?>
                            </span>
                        </div>
                        <p class="card-text text-muted small">
                            <?php
                                // Potong deskripsi agar tidak terlalu panjang
                                echo htmlspecialchars(mb_strimwidth($a['detail'], 0, 100, "..."));
                            ?>
                        </p>
                        <div class="mt-auto">
                           <a href="detail_aktivitas.php?id=<?= $a['id']; ?>" class="btn btn-outline-success w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        <?php elseif (isset($_GET['keyword'])) : ?>
            <!-- JIKA KEYWORD DIISI TAPI TIDAK ADA HASIL -->
            <div class="col-lg-8">
                <div class="info-message text-center">
                    <h4 class="text-muted">Oops!</h4>
                    <p class="mb-0">Aktivitas dengan kata kunci "<strong><?= htmlspecialchars($keyword); ?></strong>" tidak dapat kami temukan.</p>
                    <p><a href="search.php" class="text-success">Coba lagi</a> dengan kata kunci lain.</p>
                </div>
            </div>

        <?php else : ?>
            <!-- TAMPILAN AWAL SEBELUM PENCARIAN -->
             <div class="col-lg-8">
                <div class="info-message text-center">
                    <h4 class="text-muted">Mulai Mencari</h4>
                    <p>Silakan masukkan kata kunci pada kolom pencarian di atas untuk menemukan aktivitas yang Anda inginkan.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require 'partials/footer.php'; ?>
