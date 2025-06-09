<?php
require 'function.php';

// Menambahkan session_start() di awal untuk manajemen sesi
session_start();

// Jika user sudah login, redirect ke admin panel
if (isset($_SESSION["login"])) {
    header("Location: ../admin_panel/index.php");
    exit;
}


if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // Cek username
    if (mysqli_num_rows($result) === 1) {

        // Cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Set session
            $_SESSION["login"] = true;

            header("Location: ../admin_panel/index.php");
            exit;
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(to right, #28a745, #218838);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #198754;
            color: white;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 1.5rem;
        }
        .btn-success {
            background-color: #198754;
            border: none;
            padding: 0.75rem;
            font-weight: bold;
        }
        .btn-success:hover {
            background-color: #157347;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
            border-color: #198754;
        }
        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card my-4">
                <div class="card-header text-center">
                    <h3 class="mb-0">Selamat Datang!</h3>
                    <p class="mb-0">Silakan login ke akun Anda</p>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> Username atau password salah!
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>