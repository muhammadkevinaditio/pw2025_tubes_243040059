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

// Fungsi untuk menangani upload file gambar (Tidak ada perubahan di sini)
function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        return 'nophoto.jpg';
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Error: File yang Anda upload bukan gambar (jpg, jpeg, png).');</script>";
        return false;
    }

    if ($ukuranFile > 2000000) {
        echo "<script>alert('Error: Ukuran gambar terlalu besar (maks 2MB).');</script>";
        return false;
    }

    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    if (move_uploaded_file($tmpName, '../img/'. $namaFileBaru)) {
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

    // PERUBAHAN: Mengambil kategori_id, bukan organisasi_id
    $kategori_id = htmlspecialchars($data['kategori_id']); 
    $id_user = 6; // Nanti bisa diganti dengan ID dari session
    $nama_aktivitas = htmlspecialchars($data['nama_aktivitas']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    $detail = htmlspecialchars($data['detail']);

    $foto = upload();
    if (!$foto) {
        return false;
    }

    // PERUBAHAN: Query INSERT disesuaikan dengan kolom baru
    $query = "INSERT INTO aktivitas (nama_aktivitas, email, alamat, foto, detail, kategori_id, id_user)
              VALUES ('$nama_aktivitas', '$email', '$alamat', '$foto', '$detail', $kategori_id, $id_user)";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menambah kategori baru
function tambah_kategori($data)
{
    $conn = koneksi();

    // PERUBAHAN: Hanya mengambil nama_kategori
    $nama_kategori = htmlspecialchars($data['nama_kategori']);

    // PERUBAHAN: Query INSERT disesuaikan untuk tabel 'kategori'
    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menghapus data aktivitas (Tidak ada perubahan)
function hapus_aktivitas($id)
{
    $conn = koneksi();
    $aktivitas = query("SELECT foto FROM aktivitas WHERE id = $id");
    if ($aktivitas) {
        $foto = $aktivitas[0]['foto'];
        if ($foto != 'nophoto.jpg' && file_exists('../img/' . $foto)) {
            unlink('../img/' . $foto);
        }
    }

    mysqli_query($conn, "DELETE FROM aktivitas WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Fungsi untuk menghapus data kategori
function hapus_kategori($id)
{
    $conn = koneksi();
    // PERUBAHAN: Menghapus dari tabel 'kategori'
    mysqli_query($conn, "DELETE FROM kategori WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Fungsi untuk mengubah data aktivitas
function ubah_aktivitas($data)
{
    $conn = koneksi();

    $id = $data['id'];
    // PERUBAHAN: Mengambil kategori_id
    $kategori_id = htmlspecialchars($data['kategori_id']);
    $id_user = 6;
    $nama_aktivitas = htmlspecialchars($data['nama_aktivitas']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    $detail = htmlspecialchars($data['detail']);
    $fotoLama = htmlspecialchars($data['fotoLama']);

    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
        if (!$foto) {
            return false;
        }
        if ($fotoLama != 'nophoto.jpg' && file_exists('../img/' . $fotoLama)) {
            unlink('../img/' . $fotoLama);
        }
    }

    // PERUBAHAN: Query UPDATE disesuaikan
    $query = "UPDATE aktivitas SET
                kategori_id = '$kategori_id',
                id_user = '$id_user',
                nama_aktivitas = '$nama_aktivitas',
                email = '$email',
                alamat = '$alamat',
                detail = '$detail',
                foto = '$foto'
              WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk mengubah data kategori
function ubah_kategori($data)
{
    $conn = koneksi();

    $id = $data['id'];
    // PERUBAHAN: Mengambil nama_kategori
    $nama_kategori = htmlspecialchars($data['nama_kategori']);

    // PERUBAHAN: Query UPDATE disesuaikan untuk tabel 'kategori'
    $query = "UPDATE kategori SET
                nama_kategori = '$nama_kategori'
              WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Fungsi untuk mencari data aktivitas (Tidak ada perubahan)
function cari_aktivitas($keyword)
{
    $conn = koneksi();
    $query = "SELECT * FROM aktivitas
              WHERE
                nama_aktivitas LIKE '%$keyword%' OR
                detail LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%'
              ORDER BY id DESC";
    return query($query);
}

// Fungsi untuk mencari data kategori
function cari_kategori($keyword)
{
    // PERUBAHAN: Fungsi ini diganti dari cari_organisasi
    $keyword_escaped = mysqli_real_escape_string(koneksi(), $keyword);

    // PERUBAHAN: Query disesuaikan untuk tabel 'kategori'
    $query = "SELECT * FROM kategori
              WHERE
                nama_kategori LIKE '%$keyword_escaped%'
              ORDER BY id DESC";
    return query($query);
}

?>
