<!-- koneksi ke database -->
<?php
function koneksi()
{
    $conn = mysqli_connect('localhost', 'root', '', 'relawan_connect');
    return $conn;
}


function query($query)
{
    $conn = koneksi();
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// function tambah
// function tambah($data)
// {
//     $conn = koneksi();

//     $nama_aktivitas = htmlspecialchars($data['nama_aktivitas']);
//     $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
//     $email = htmlspecialchars($data['email']);
//     $alamat = htmlspecialchars($data['alamat']);
//     $foto = htmlspecialchars($data['foto']);
//     $detail = htmlspecialchars_decode($data['detail']);

//     $query = "INSERT INTO aktivitas
//               VALUES
//             (null,null,null, '$nama_aktivitas', '$nama_organisasi', '$email', '$alamat', '$foto' , '$detail')";


//     mysqli_query($conn, $query) or die(mysqli_error($conn));

//     return mysqli_affected_rows($conn);
// }
function tambah($data)
{
    session_start();
    $conn = koneksi();

    // $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    // if (!$id_user) {
    //     die("User belum login, tidak bisa menambahkan data.");
    // }

    $nama_aktivitas = htmlspecialchars($data['nama_aktivitas']);
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    $foto = htmlspecialchars($data['foto']); // atau ambil dari $_FILES jika upload
    $detail = htmlspecialchars_decode($data['detail']);

    $query = "INSERT INTO aktivitas 
              (nama_aktivitas, nama_organisasi, email, alamat, foto, detail)
              VALUES 
              ('$nama_aktivitas', '$nama_organisasi', '$email', '$alamat', '$foto', '$detail')";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    return mysqli_affected_rows($conn);
}
