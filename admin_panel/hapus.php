<?php
require 'functions.php';
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Cek apakah id valid
  if (hapus($id) > 0) {
    echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'aktivitas.php';
          </script>";
  } else {
    echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = 'aktivitas.php';
          </script>";
  }
} else {
  echo "<script>
          document.location.href = 'aktivitas.php';
        </script>";
}