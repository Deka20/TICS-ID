<!-- 
//nama file    : tambah_coming_soon.php
//deskripsi    : file untuk menambah data film coming soon ke database
//dibuat oleh  : Jesica Kristina Manalu - NIM : 3312401069
//tanggal      : 14 Desember 2024 - 29 Desember 2024 
-->


<?php
include('koneksibioskop.php');

// Ambil data dari form
$id = $_POST['id'];
$judul = $_POST['judul'];
$genre = $_POST['genre'];
$trailer = $_POST['trailer'];
$waktu_tayang = $_POST['waktu_tayang'];
$harga = $_POST['harga'];

// Validasi input untuk memastikan data tidak kosong
if (empty($id) || empty($judul) || empty($genre) || empty($trailer)) {
    echo "Semua field harus diisi!";
    exit();
}

$checkIdQuery = "SELECT * FROM coming_soon WHERE id ='$id'";
$result = mysqli_query($koneksi, $checkIdQuery);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Data dengan ID coming_soon $id sudah ada!'); window.history.back();</script>";
    exit;
}


// Validasi dan upload file gambar (poster)
$poster = $_FILES['poster']['name'];
$ukuran_poster = $_FILES['poster']['size'];
$tmp_poster = $_FILES['poster']['tmp_name'];
$ekstensi_poster_diperbolehkan = array('jpg', 'jpeg', 'png');
$x_poster = explode('.', $poster);
$ekstensi_poster = strtolower(end($x_poster));
$path_poster = "uploads/" . $poster;


if (in_array($ekstensi_poster, $ekstensi_poster_diperbolehkan) && $ukuran_poster <= 20000000) {
    if (move_uploaded_file($tmp_poster, $path_poster)) {
        // Simpan data ke database
        $query = "INSERT INTO coming_soon (id, judul, genre, trailer, poster) VALUES ('$id', '$judul', '$genre', '$trailer', '$poster')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='coming_soon.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data ke database!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah file!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('File gambar tidak valid atau ukurannya terlalu besar!'); window.history.back();</script>";
}
?>
