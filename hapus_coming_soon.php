<!-- 
//nama file     : hapus_coming_soon.php
//deskripsi     : file ini untuk menghapus data film coming soon pada database
//dibuat oleh   : Jesica Kristina Manalu - NIM : 3312401069
//tanggal       : 14 Desember 2024 - 29 Desember 2024 
-->


<?php
// Menghubungkan dengan file koneksi database
include 'koneksibioskop.php';
$id =  $_GET['id'];
$result = mysqli_query($koneksi, "DELETE FROM coming_soon WHERE id='$id'");
header("Location:coming_soon.php");
