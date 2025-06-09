<?php
require 'function.php';

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
            alert('User baru berhasil ditambahkan! Silakan login.');
            document.location.href = 'login.php';
            </script>";
    } else {
        echo "<script>
            alert('Gagal mendaftar!');
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: linear-gradient(to right, #28a745, #218838); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 1rem; box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1); }
        .card-header { background-color: #198754; color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem; padding: 1.5rem; }
        .btn-success { background-color: #198754; border: none; padding: 0.75rem; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card my-4">
                <div class="card-header text-center">
                    <h3 class="mb-0">Registrasi Akun Baru</h3>
                </div>
                <div class="card-body p-4">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group"><span class="input-group-text"><i class="bi bi-person-fill"></i></span><input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username" required></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group"><span class="input-group-text"><i class="bi bi-lock-fill"></i></span><input type="password" class="form-control" name="password" id="password" placeholder="Buat password" required></div>
                        </div>
                        <div class="mb-4">
                            <label for="password2" class="form-label">Konfirmasi Password</label>
                            <div class="input-group"><span class="input-group-text"><i class="bi bi-lock-fill"></i></span><input type="password" class="form-control" name="password2" id="password2" placeholder="Ulangi password" required></div>
                        </div>
                        <div class="d-grid"><button type="submit" name="register" class="btn btn-success">Register</button></div>
                    </form>
                    <div class="text-center mt-3"><small>Sudah punya akun? <a href="login.php" class="text-success fw-bold">Login di sini</a></small></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>