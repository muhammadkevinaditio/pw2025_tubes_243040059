<?php
// Fungsi untuk koneksi ke database
function koneksi()
{
    $conn = mysqli_connect('localhost', 'root', '', 'relawan_connect');
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    return $conn;
}

// Fungsi untuk registrasi user baru
function register($data)
{
    $conn = koneksi();

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek apakah username sudah ada
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username yang dipilih sudah terdaftar!');</script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        return false;
    }

    // Enkripsi password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    $query = "INSERT INTO user (username, password) VALUES('$username', '$password_hashed')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
?>