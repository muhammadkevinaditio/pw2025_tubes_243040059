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

// Fungsi untuk menambah organisasi baru (sekaligus mendaftarkan user baru)
function tambah_organisasi($data)
{
    $conn = koneksi();

    // 1. Proses Registrasi User
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Username dan password tidak boleh kosong!');</script>";
        return false;
    }

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username yang dipilih sudah terdaftar!');</script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        return false;
    }

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user (username, password) VALUES('$username', '$password_hashed')");
    
    $new_user_id = 0;
    if (mysqli_affected_rows($conn) > 0) {
        $new_user_id = mysqli_insert_id($conn);
    } else {
        return false; // Gagal membuat user, hentikan proses
    }

    // 2. Proses Penambahan Organisasi
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $alamat = htmlspecialchars($data['alamat']);
    
    $query = "INSERT INTO organisasi (nama_organisasi, alamat, user_id)
              VALUES ('$nama_organisasi', '$alamat', '$new_user_id')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menghapus data aktivitas
function hapus_aktivitas($id)
{
    $conn = koneksi();
    mysqli_query($conn, "DELETE FROM aktivitas WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menghapus data organisasi (dan user terkait)
function hapus_organisasi($id)
{
    $conn = koneksi();
    // Opsional: Cari dulu user_id sebelum menghapus organisasi
    // $org = query("SELECT user_id FROM organisasi WHERE id = $id")[0];
    // $user_id = $org['user_id'];
    
    // Hapus organisasi
    mysqli_query($conn, "DELETE FROM organisasi WHERE id = $id");
    
    // Opsional: Hapus juga user yang terhubung
    // if($user_id) {
    //    mysqli_query($conn, "DELETE FROM user WHERE id = $user_id");
    // }
    
    return mysqli_affected_rows($conn);
}

?>