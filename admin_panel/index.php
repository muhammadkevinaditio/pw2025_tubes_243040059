<!-- koneksi functions -->
<?php
require 'functions.php';

$queryAktivitas = mysqli_query($conn, "SELECT * FROM kategori_aktivitas");
$jumlahAktivitas = mysqli_num_rows($queryAktivitas);
?>

<?php require('partials/header.php'); ?>
<?php require('partials/navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .square {
        border: solid;
    }

    .summary-aktivitas {
        background-color: #188639;
        border-radius: 15px;
    }

    .summary-organisasi{
        background-color: #af4d0c;
        border-radius: 15px;
    }
    .no-decoration:hover{
        text-decoration: none;
        color: salmon;
    }
</style>

<body>
    <h2>halo admin</h2>

    <!-- summary design -->
    <div class="container mt-5">
        <div class="row">
            <!-- summary-aktivitas -->
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-aktivitas p-3">
                <div class="row">
                    <div class="col-6"></div>
                    <div><i class="bi bi-clipboard2" style="font-size: 6rem; color: #fff;"></i></div>
                    <div class="col-6 text-white">
                        <h3 class="fs-2">aktivitas</h3>
                        <p class="fs-5">Total aktivitas:10</p>
                        <p><a href="aktivitas" class="text-white no-decoration">kelola aktivitas</a></p>
                    </div>
                </div>
                </div>
            </div>

            <!-- summary-organisasi/user -->
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-organisasi p-3">
                <div class="row">
                    <div class="col-6"></div>
                    <div><i class="bi bi-person-arms-up" style="font-size: 6rem; color: #fff;"></i></div>
                    <div class="col-6 text-white">
                        <h3 class="fs-2">organisasi</h3>
                        <p class="fs-5">Total organisasi:5</p>
                        <p><a href="aktivitas" class="text-white no-decoration">kelola aktivitas</a></p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</body>

</html>