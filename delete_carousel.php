<!-- 
//nama file    : delete_carousel.php
//deskripsi    : file ini untuk menghapus poster film yang dijadikan carousel
//dibuat oleh  : Zahra Ufairah - NIM :3312401060
//tanggal      : 07 November 2024 - 29 Desember 2024 
-->


<?php
include 'koneksibioskop.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama gambar untuk menghapus file
    $query = mysqli_query($koneksi, "SELECT * FROM carousel_image WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    $imageName = $data['image_name'];

    // Hapus gambar dari folder
    unlink("uploads/" . $imageName);

    // Hapus data dari database
    mysqli_query($koneksi, "DELETE FROM carousel_image WHERE id = $id");

    // Mengarahkan ke halaman sebelumnya
    header("Location: carousel.php");
    exit();
}
?>
