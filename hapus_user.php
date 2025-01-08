<!-- 
//nama file     : hapus_user.php
//deskripsi     : file ini untuk mengahpus data pengguna dari database
//dibuat oleh   : Grace Anastasya Simanungkalit - NIM : 3312401073
//tanggal       : 12 Desember 2024 - 15 Desember 2024 
-->


<?php
// Menghubungkan dengan file koneksi database
include 'koneksibioskop.php';
$email =  $_GET['email'];
$result = mysqli_query($koneksi, "DELETE FROM user WHERE email='$email'");
header("Location:user.php");
