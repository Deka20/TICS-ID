<!-- 
//nama file    : hapus_riwayat.php
//deskripsi    : file ini untuk menghapus riwayat pemesanan pengguna
//dibuat oleh  : Rafles Yuda Stevenses - NIM : 3312401062
//tanggal      :  24 Desember 2024 - 29 Desember 2024 
-->


<?php
// Menghubungkan dengan file koneksi database
include 'koneksibioskop.php';

// Memeriksa apakah ada parameter 'id' di URL
if (isset($_GET['id'])) {
    // Mendapatkan booking_id dari URL
    $booking_id = $_GET['id'];

    // Query untuk menghapus tiket berdasarkan booking_id
    $query_delete = "DELETE FROM tiket WHERE booking_id = '$booking_id'";

    // Menjalankan query
    $result = mysqli_query($koneksi, $query_delete);

    // Mengecek apakah query berhasil dijalankan
    if ($result) {
        // Jika berhasil, tampilkan pesan dan redirect ke halaman tiket.php
        echo "<script>
                alert('Tiket berhasil dihapus!');
                window.location.href = 'tiket.php';
              </script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>
                alert('Gagal menghapus tiket. Silakan coba lagi.');
                window.location.href = 'tiket.php';
              </script>";
    }
} else {
    // Jika 'id' tidak ada di URL, tampilkan pesan error
    echo "<script>
            alert('Booking ID tidak ditemukan!');
            window.location.href = 'tiket.php';
          </script>";
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
