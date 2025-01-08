<!-- 
//nama file : logout.php
//deskripsi : file ini untuk logout pengguna dan juga admin
//dibuat oleh: Zidan Masadita Pramudia - NIM : 3312401083
//tanggal    : 23 Desember 2024 - 29 Desember 2024 
-->

<?php
session_start();
session_unset();
session_destroy();
header("Location: bioskop.php");
exit();
?>
?>
