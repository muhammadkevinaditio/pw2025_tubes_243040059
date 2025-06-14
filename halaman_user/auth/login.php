<?php
session_start();

// Jika sudah login, langsung arahkan ke halaman yang sesuai dengan rolenya
if (isset($_SESSION["login"])) {
    if ($_SESSION['role'] == 'admin') {
        // jika admin login akan 
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php");
    }
    exit;
}

// direct ke funtions
require_once '../../admin_panel/functions.php'; 

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $conn = koneksi();

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Login berhasil, set semua session yang dibutuhkan
            $_SESSION["login"] = true;
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];

            // === LOGIKA PENGALIHAN BERDASARKAN ROLE ===
            if ($row["role"] == 'admin') {
                // PERBAIKAN PATH: Naik 1 level ke index.php di admin_panel
                header("Location: ../../admin_panel/index.php");
                exit;
            } else {
                // PERBAIKAN PATH: Naik 2 level ke halaman_user
                header("Location: ../index.php");
                exit;
            }
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
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
                        <h3 class="mb-0">Selamat Datang!</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger" role="alert">
                                Username atau password salah!
                            </div>
                        <?php endif; ?>
                        
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-success">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <small>Belum punya akun? <a href="register.php" class="text-success fw-bold">Daftar di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>