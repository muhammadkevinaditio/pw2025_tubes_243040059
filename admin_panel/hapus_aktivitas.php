<?php
require 'functions.php';

// 1. Cek apakah ada parameter id yang dikirim melalui URL
if (!isset($_GET['id'])) {
    // Jika tidak ada, paksa kembali ke halaman utama aktivitas
    header("Location: aktivitas.php");
    exit;
}

// 2. Ambil id dari URL untuk menentukan data mana yang akan dihapus
$id = $_GET['id'];

// 3. Panggil fungsi hapus_aktivitas dan cek hasilnya
if (hapus_aktivitas($id) > 0) {
    // Jika berhasil (lebih dari 0 baris terpengaruh)
    echo "
        <script>
            alert('Data aktivitas berhasil dihapus!');
            document.location.href = 'aktivitas.php';
        </script>
    ";
} else {
    // Jika gagal
    echo "
        <script>
            alert('Data aktivitas gagal dihapus!');
            document.location.href = 'aktivitas.php';
        </script>
    ";
}
?>