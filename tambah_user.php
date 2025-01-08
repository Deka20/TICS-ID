<!-- 
//nama file    : tambah_user.php
//deskripsi    : file untuk memproses tambah data pengguna yang telah melakukan registrasi
//dibuat oleh  : Grace Anastasya Simanungkalit - NIM : 3312401073
//tanggal      : 13 Desember 2024 - 29 Desember 2024 

MULAI
    // Sertakan file koneksi database
    MASUKKAN 'koneksibioskop.php'

    // Ambil data dari form
    email <- AmbilDariPOST('email')
    username <- AmbilDariPOST('username')
    password <- AmbilDariPOST('password')
    nama_lengkap <- AmbilDariPOST('nama_lengkap')
    no_hp <- AmbilDariPOST('no_hp')

    // Hash password sebelum disimpan ke database
    hashed_password <- HashPassword(password)

    // Cek apakah email sudah terdaftar
    queryEmail <- "SELECT * FROM user WHERE email = 'email'"
    hasilEmail <- EksekusiQuery(queryEmail)

    JIKA hasilEmail TIDAK KOSONG MAKA
        // Tampilkan pesan error dan kembali ke halaman sebelumnya
        TAMPILKAN_ALERT("Data dengan Email 'email' sudah terdaftar!")
        KEMBALI_HALAMAN_SEBELUMNYA()
        KELUAR_PROGRAM()
    AKHIR JIKA

    // Cek apakah username sudah terdaftar
    queryUsername <- "SELECT * FROM user WHERE username = 'username'"
    hasilUsername <- EksekusiQuery(queryUsername)

    JIKA hasilUsername TIDAK KOSONG MAKA
        // Tampilkan pesan error dan kembali ke halaman sebelumnya
        TAMPILKAN_ALERT("Data dengan Username 'username' sudah terdaftar!")
        KEMBALI_HALAMAN_SEBELUMNYA()
        KELUAR_PROGRAM()
    AKHIR JIKA

    // Simpan data ke dalam database
    queryInsert <- "INSERT INTO user (email, username, password, nama_lengkap, no_hp)
                    VALUES ('email', 'username', 'hashed_password', 'nama_lengkap', 'no_hp')"
    hasilInsert <- EksekusiQuery(queryInsert)

    JIKA hasilInsert BERHASIL MAKA
        // Tampilkan pesan sukses dan arahkan ke halaman login
        TAMPILKAN_ALERT("Data berhasil disimpan")
        ARAHKAN_HALAMAN("login.php")
    LAINNYA
        // Tampilkan pesan gagal dan arahkan ke halaman registrasi
        TAMPILKAN_ALERT("Gagal menyimpan data")
        ARAHKAN_HALAMAN("register.php")
    AKHIR JIKA
SELESAI
-->


<?php
include 'koneksibioskop.php';


// Ambil data dari form
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$nama_lengkap = $_POST['nama_lengkap'];
$no_hp = $_POST['no_hp'];

// Hash password sebelum disimpan ke database
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$checkIdQuery = "SELECT * FROM user WHERE email ='$email'";
$result = mysqli_query($koneksi, $checkIdQuery);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Data dengan Email $email sudah terdaftar!'); window.history.back();</script>";
    exit;
}

$checkIdQuery = "SELECT * FROM user WHERE username ='$username'";
$result = mysqli_query($koneksi, $checkIdQuery);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Data dengan Username $username sudah terdaftar!'); window.history.back();</script>";
    exit;
}

// Menyimpan data ke dalam database dengan password yang telah di-hash
$input = mysqli_query($koneksi, "INSERT INTO user (email, username, password, nama_lengkap, no_hp) VALUES('$email', '$username', '$hashed_password', '$nama_lengkap', '$no_hp')") or die(mysqli_error($koneksi));

if ($input) {
    echo "<script>
            alert('Data berhasil disimpan');
            window.location.href = 'login.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menyimpan data');
            window.location.href = 'register.php';
          </script>";
}
?>
