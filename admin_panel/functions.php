<?php
session_start();

// Fungsi untuk koneksi ke database
function koneksi()
{
    $conn = mysqli_connect('localhost', 'root', '', 'relawan_connect');
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    return $conn;
}

// Fungsi untuk menjalankan query dan mengambil hasilnya
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

// Fungsi untuk menangani upload file gambar
function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek 1: Apakah ada gambar yang diupload?
    if ($error === 4) { // 4 artinya tidak ada file
        return 'nophoto.jpg'; // Kembalikan nama gambar default
    }

    // Cek 2: Validasi ekstensi file
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Error: File yang Anda upload bukan gambar (jpg, jpeg, png).');</script>";
        return false;
    }

    // Cek 3: Validasi ukuran file (misal: maks 2MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Error: Ukuran gambar terlalu besar (maks 2MB).');</script>";
        return false;
    }

    // Lolos pengecekan, generate nama file baru yang unik
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($tmpName, 'img/' . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        echo "<script>alert('Error: Gagal memindahkan file gambar.');</script>";
        return false;
    }
}

// Fungsi untuk menambah data aktivitas baru
function tambah_aktivitas($data)
{
    $conn = koneksi();

    $organisasi_id = htmlspecialchars($data['organisasi_id']);
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    $detail = htmlspecialchars($data['detail']);

    // Panggil fungsi upload
    $foto = upload();
    if (!$foto) {
        return false; // Jika upload gagal, hentikan proses
    }

    $query = "INSERT INTO aktivitas (nama_organisasi, email, alamat, foto, detail, organisasi_id)
              VALUES ('$nama_organisasi', '$email', '$alamat', '$foto', '$detail', '$organisasi_id')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menambah organisasi baru (setelah user ada)
function tambah_organisasi($data)
{
    $conn = koneksi();

    // Ambil data dari form
    $user_id = htmlspecialchars($data['user_id']);
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $alamat = htmlspecialchars($data['alamat']);

    // Cek apakah user_id valid
    if (empty($user_id)) {
        return false;
    }

    // Query insert data organisasi dengan user_id yang sudah dipilih
    $query = "INSERT INTO organisasi (user_id, nama_organisasi, alamat)
              VALUES 
                ('$user_id', '$nama_organisasi', '$alamat')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
