<!-- koneksi ke database -->
<?php
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


// function tambah
function tambah($data)
{
    session_start();
    $conn = koneksi();

    $nama_organisasi = htmlspecialchars($data['nama_organisasi']);
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);
    
    
    $query = "INSERT INTO aktivitas 
              VALUES 
                (null,'$nama_organisasi', '$email', '$alamat')";

    // return mysqli_affected_rows($conn);
    mysqli_query($conn, $query) or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);



//funtion hapus
  function hapus($id)
{
  $conn = koneksi();

  mysqli_query($conn, "DELETE FROM aktivitas WHERE id = $id") or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);
}
}
