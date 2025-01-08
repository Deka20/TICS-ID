<!-- 
//nama file    : ubah_user.php
//deskripsi    : file untuk mengedit data pengguna dari dashboard admin
//dibuat oleh  : Jesica Kristina Manalu - NIM : 3312401069
//tanggal      : 14 Desember 2024 - 29 Desember 2024 
-->


<?php
// Pastikan koneksi database tersedia
include 'koneksibioskop.php';

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$nama_lengkap = $_POST['nama_lengkap'];
$no_hp = $_POST['no_hp'];

// Cek apakah password diubah
if (!empty($password)) {
    // Jika password diisi, hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    // Update dengan password baru yang sudah di-hash
    $result = mysqli_query($koneksi, "UPDATE user SET username='$username', password='$password_hash', nama_lengkap='$nama_lengkap' , no_hp='$no_hp' WHERE email='$email'");
} else {
    // Jika password kosong, update tanpa mengganti password
    $result = mysqli_query($koneksi, "UPDATE user SET username='$username', nama_lengkap='$nama_lengkap' , no_hp='$no_hp' WHERE email='$email'");
}

// Mengarahkan kembali ke halaman user.php
header("Location: user.php");
