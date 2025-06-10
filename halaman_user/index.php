<?php
session_start();

// Naik satu level untuk menemukan folder admin_panel
require '../admin_panel/functions.php';
$aktivitas = query("SELECT * FROM aktivitas ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relawan Connect - Cari Aktivitas Sosial</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?q=80&w=2070&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 8rem 0;
            text-align: center;
        }
        .hero-section h1 {
            font-weight: 700;
            font-size: 3.5rem;
        }
        .card-activity {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .card-activity:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .navbar-brand {
            font-weight: 700;
        }
        .btn-main {
            background-color: #198754;
            border-color: #198754;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            transition: background-color 0.2s;
        }
        .btn-main:hover {
            background-color: #157347;
            border-color: #157347;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">RelawanConnect</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                     <?php if (isset($_SESSION['login'])) : ?>
                        <!-- JIKA SUDAH LOGIN -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, <?= htmlspecialchars($_SESSION['username']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <!-- JIKA BELUM LOGIN -->
                        <li class="nav-item">
                            <a class="nav-link" href="../auth/login.php">Masuk / Buat Akun</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bagian Hero -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Ambil Peran Jadi Relawan</h1>
            <p class="lead mb-4">Ubah niat baik jadi aksi baik hari ini</p>
            <a href="#daftar-aktivitas" class="btn btn-main">Cari Aktivitas</a>
        </div>
    </header>

    <!-- Daftar Aktivitas -->
    <main id="daftar-aktivitas" class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Aktivitas Terbaru</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php foreach ($aktivitas as $a) : ?>
            <div class="col">
                <div class="card h-100 card-activity">
                    <img src="../img/<?= htmlspecialchars($a['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($a['nama_aktivitas']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($a['nama_aktivitas']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($a['nama_organisasi']); ?></h6>
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
