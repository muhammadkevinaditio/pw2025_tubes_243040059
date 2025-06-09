<?php
// koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'relawan_connect');

function register($data)
{
    $conn = koneksi();

    // === BAGIAN REGISTRASI USER ===
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek apakah username sudah ada
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username yang dipilih sudah terdaftar!');
            </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }

    // Enkripsi password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username, password) VALUES('$username', '$password_hashed')");
    
    // Cek apakah user berhasil ditambahkan dan dapatkan ID-nya
    if(mysqli_affected_rows($conn) > 0) {
        $new_user_id = mysqli_insert_id($conn); // Mengambil ID dari user yang baru saja dibuat
    } else {
        return false; // Gagal membuat user
    }

    //mengenkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //menambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username,password) VALUES('$username', '$password')");
    return mysqli_affected_rows($conn);
}
