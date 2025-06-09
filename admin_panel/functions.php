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
// Fungsi untuk menghapus data aktivitas
function hapus_aktivitas($id)
{
    $conn = koneksi();
    // Ambil nama file foto sebelum menghapus data dari DB
    $aktivitas = query("SELECT foto FROM aktivitas WHERE id = $id");
    if ($aktivitas) {
        $foto = $aktivitas[0]['foto'];
        // Jika nama foto bukan default, hapus filenya dari folder img
        if ($foto != 'nophoto.jpg' && file_exists('img/' . $foto)) {
            unlink('img/' . $foto);
        }
    }
    
    mysqli_query($conn, "DELETE FROM aktivitas WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menghapus data organisasi
function hapus_organisasi($id)
{
    $conn = koneksi();
    mysqli_query($conn, "DELETE FROM organisasi WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Fungsi untuk mengubah data aktivitas
function ubah_aktivitas($data)
{
    $conn = koneksi();

    // Ambil data dari form
    $id = $data['id'];
    $organisasi_id = htmlspecialchars($data['organisasi_id']);
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    $detail = htmlspecialchars($data['detail']);
    $fotoLama = htmlspecialchars($data['fotoLama']);

    // Cek apakah user memilih gambar baru atau tidak
    if ($_FILES['foto']['error'] === 4) {
        // Jika tidak ada gambar baru diupload, gunakan nama foto lama
        $foto = $fotoLama;
    } else {
        // Jika ada gambar baru, panggil fungsi upload
        $foto = upload();
        // Jika upload gagal, hentikan proses
        if (!$foto) {
            return false;
        }
        // Hapus file foto lama jika bukan gambar default
        if ($fotoLama != 'nophoto.jpg' && file_exists('img/' . $fotoLama)) {
            unlink('img/' . $fotoLama);
        }
    }

    // Query update data
    $query = "UPDATE aktivitas SET
                organisasi_id = '$organisasi_id',
                nama_organisasi = '$nama_organisasi',
                email = '$email',
                alamat = '$alamat',
                detail = '$detail',
                foto = '$foto'
              WHERE id = $id
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Fungsi untuk mengubah data organisasi
function ubah_organisasi($data)
{
    $conn = koneksi();

    // Ambil data dari form
    $id = $data['id'];
    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $alamat = htmlspecialchars($data['alamat']);

    // Query update data
    $query = "UPDATE organisasi SET
                nama_organisasi = '$nama_organisasi',
                alamat = '$alamat'
              WHERE id = $id
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Fungsi untuk mencari data aktivitas
function cari_aktivitas($keyword)
{
    $conn = koneksi();

    $query = "SELECT * FROM aktivitas
              WHERE
                nama_organisasi LIKE '%$keyword%' OR
                detail LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%'
              ORDER BY id DESC
            ";
    
    return query($query);
}

// Fungsi untuk mencari data organisasi
function cari_organisasi($keyword)
{
    $keyword_escaped = mysqli_real_escape_string(koneksi(), $keyword);

    $query = "SELECT * FROM organisasi
              WHERE
                nama_organisasi LIKE '%$keyword_escaped%' OR
                alamat LIKE '%$keyword_escaped%'
              ORDER BY id DESC
            ";
    
    return query($query);
}
?>