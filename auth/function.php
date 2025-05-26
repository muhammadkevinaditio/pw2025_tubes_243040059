<?php
// koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'relawan_connect');

function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // mengecek username apakah sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username yang dipilih sudah terdaftar!')   
            </script>";

        return false;
    }


    //mengecek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }

    //mengenkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //menambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username,password) VALUES('$username', '$password')");
    return mysqli_affected_rows($conn);
}
