<?php
require 'functions.php';

// Pastikan ada parameter id yang dikirim
if (!isset($_GET['id'])) {
    // Jika tidak ada id, kembalikan ke halaman aktivitas
    header("Location: aktivitas.php");
    exit;
}

// Ambil id dari URL
$id = $_GET['id'];

// Panggil fungsi hapus_aktivitas
if (hapus_aktivitas($id) > 0) {
    echo "
        <script>
            alert('Data aktivitas berhasil dihapus!');
            document.location.href = 'aktivitas.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data aktivitas gagal dihapus!');
            document.location.href = 'aktivitas.php';
        </script>
    ";
}
?>