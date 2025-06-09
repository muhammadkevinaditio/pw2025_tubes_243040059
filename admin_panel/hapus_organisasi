<?php
require 'functions.php';

// Pastikan ada parameter id yang dikirim
if (!isset($_GET['id'])) {
    // Jika tidak ada id, kembalikan ke halaman organisasi
    header("Location: organisasi.php");
    exit;
}

// Ambil id dari URL
$id = $_GET['id'];

// Panggil fungsi hapus_organisasi
if (hapus_organisasi($id) > 0) {
    echo "
        <script>
            alert('Data organisasi berhasil dihapus!');
            document.location.href = 'organisasi.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data organisasi gagal dihapus!');
            document.location.href = 'organisasi.php';
        </script>
    ";
}
?>