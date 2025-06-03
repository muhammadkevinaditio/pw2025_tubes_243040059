<!-- koneksi ke database -->
<?php
function koneksi()
{
    $conn = mysqli_connect('localhost', 'root', '', 'relawan_connect');
    return $conn;
}

