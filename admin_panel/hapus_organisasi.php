<?php
require 'functions.php';

// 1. Cek apakah ada parameter id yang dikirim melalui URL
if (!isset($_GET['id'])) {
    // Jika tidak ada, paksa kembali ke halaman utama organisasi
    header("Location: organisasi.php");
    exit;
}

// 2. Ambil id dari URL
$id = $_GET['id'];

// 3. Panggil fungsi hapus_organisasi dan cek hasilnya
if (hapus_organisasi($id) > 0) {
    // Jika berhasil
    echo "
        <script>
            alert('Data organisasi berhasil dihapus!');
            document.location.href = 'organisasi.php';
        </script>
    ";
} else {
    // Jika gagal
    echo "
        <script>
            alert('Data organisasi gagal dihapus!');
            document.location.href = 'organisasi.php';
        </script>
    ";
}
?>