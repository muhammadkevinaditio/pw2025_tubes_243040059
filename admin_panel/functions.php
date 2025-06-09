<?php
// koneksi ke database
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

function upload()
{
    // Ambil data dari $_FILES
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if ($error === 4) { // 4 artinya tidak ada file yang diupload
        // Jika user tidak upload gambar, kita gunakan gambar default
        return 'nophoto.jpg';
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda upload bukan gambar!');</script>";
        return false;
    }

    // Cek jika ukurannya terlalu besar (misal: maks 2MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    // Generate nama gambar baru agar unik
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}


// function tambah aktivitas
function tambah($data)
{
    $conn = koneksi();

    // Ambil data dari tiap elemen dalam form
    $organisasi_id = htmlspecialchars($data['organisasi_id']); // <-- DATA BARU
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    $detail = htmlspecialchars($data['detail']);

    // Upload gambar
    $foto = upload();
    if (!$foto) {
        return false; // Jika upload gagal, hentikan fungsi
    }
    
    // Query insert data - SESUAIKAN DENGAN URUTAN KOLOM ANDA
    $query = "INSERT INTO aktivitas (nama_organisasi, email, alamat, foto, detail, organisasi_id)
              VALUES 
                ('$nama_organisasi', '$email', '$alamat', '$foto', '$detail', '$organisasi_id')";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    return mysqli_affected_rows($conn);
}

//funtion hapus
function hapus($id)
{
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM aktivitas WHERE id = $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}


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

    // === BAGIAN MENAMBAHKAN ORGANISASI ===
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $alamat = htmlspecialchars($data['alamat']);
    
    // Query insert data organisasi dengan user_id yang sudah didapat
    $query = "INSERT INTO organisasi (nama_organisasi, alamat, user_id)
              VALUES 
                ('$nama_organisasi', '$alamat', '$new_user_id')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
