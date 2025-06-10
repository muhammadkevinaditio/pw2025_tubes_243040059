<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("Location: ../halaman_user/index.php");
exit;
?>
