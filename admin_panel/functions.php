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


// function tambah
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