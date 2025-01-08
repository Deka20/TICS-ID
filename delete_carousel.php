<!-- 
//nama file    : delete_carousel.php
//deskripsi    : file ini untuk menghapus poster film yang dijadikan carousel
//dibuat oleh  : Zahra Ufairah - NIM :3312401060
//tanggal      : 07 November 2024 - 29 Desember 2024 

Mulai
    Sertakan koneksi ke database ('koneksibioskop.php')

    // Cek jika ada ID yang dikirim melalui GET
    Jika ada 'id' dalam GET:
        Simpan 'id' dari GET

        // Ambil data gambar berdasarkan ID dari database
        Jalankan query untuk mengambil data gambar berdasarkan ID
        Ambil nama gambar dari hasil query

        // Hapus gambar dari folder
        Hapus file gambar menggunakan unlink() berdasarkan nama gambar

        // Hapus data gambar dari database
        Jalankan query untuk menghapus data gambar dari tabel carousel_image berdasarkan ID

        // Arahkan pengguna kembali ke halaman carousel.php
        Arahkan ke halaman carousel.php
        Keluar dari skrip
Selesai
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
