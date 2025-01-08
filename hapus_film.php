<!-- 
//nama file  : hapus_film.php
//deskripsi  : file ini untuk menghapus data film tayang sekarang dari data base
//dibuat oleh: Zahra Ufairah - NIM : 3312401060
//tanggal    : 12 Desember 2024 - 15 Desember 2024 
-->


<?php
// Menghubungkan dengan file koneksi database
include 'koneksibioskop.php';
$id =  $_GET['id'];
$result = mysqli_query($koneksi, "DELETE FROM film WHERE id='$id'");
header("Location:film.php");
