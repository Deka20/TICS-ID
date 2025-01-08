<!-- 
//nama file    : koneksibioskop.php
//deskripsi    : file ini berisi koneksi ke database 
//dibuat oleh  : Zidan Masadita Pramudia - NIM : 3312401083
//tanggal      : 13  November 2024 
-->


<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "bioskop"; // Nama Database

// Melakukan koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Memeriksa koneksi
if (!$koneksi) {
    die("Gagal koneksi: " . mysqli_connect_error());
}
