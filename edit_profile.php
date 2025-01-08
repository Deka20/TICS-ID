<!-- 
//Nama file : edit_profile.php
//deskripsi : file ini untuk mengedit profil pengguna
//dibuat oleh : Rafles Yuda Stevenses Nababan - NIM : 3312401062
//tanggal     : 19 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php';

// Jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
$data = mysqli_fetch_assoc($query);

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);

    // Cek apakah username sudah ada
    $check_username_query = "SELECT * FROM user WHERE username = '$username' AND email != '$email'";
    $check_username_result = mysqli_query($koneksi, $check_username_query);

    if (mysqli_num_rows($check_username_result) > 0) {
        // Jika username sudah ada, tampilkan pesan error
        echo "<script>
                alert('Username sudah digunakan, silakan pilih username lain.');
                window.location.href = 'profile.php'; // Redirect kembali ke halaman edit profil
              </script>";
    } else {
        // Ambil password baru dari form
        $password = $_POST['password'];

        // Cek apakah password baru diberikan
        if (!empty($password)) {
            // Hash password baru menggunakan PASSWORD_DEFAULT
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update query untuk mengubah password dan data lainnya
            $update_query = "UPDATE user SET username = '$username', password = '$hashed_password', nama_lengkap = '$nama_lengkap' WHERE email = '$email'";
        } else {
            // Jika tidak ada password baru, hanya update username dan nama lengkap
            $update_query = "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap' WHERE email = '$email'";
        }

        // Jalankan query untuk update
        $result = mysqli_query($koneksi, $update_query);

        if ($result) {
            // Jika update berhasil, tampilkan pesan sukses
            echo "<script>
                    alert('Profil berhasil diperbarui!');
                    window.location.href = 'profile.php'; // Redirect ke halaman profil
                  </script>";
        } else {
            // Jika update gagal, tampilkan pesan error
            echo "<script>
                    alert('Terjadi kesalahan. Profil gagal diperbarui.');
                    window.location.href = 'profile.php'; // Redirect kembali ke halaman profil
                  </script>";
        }
    }
}
