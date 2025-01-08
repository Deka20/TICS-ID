<!-- 
//nama file    : ubah_bioskop.php
//deskripsi    : file untuk mengubah data film yang akan tayang sekarang
//dibuat oleh  : Grace Anastasya Simanungkalit - NIM : 3312401073
//tanggal      : 12 Desember 2024 - 15 Desember 2024 
-->

<?php
// Pastikan koneksi database tersedia
include 'koneksibioskop.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$jadwal = $_POST['jadwal'];
$genre = $_POST['genre'];
$harga = $_POST['harga'];
$theater = $_POST['theater'];
$waktu_tayang = $_POST['waktu_tayang'];
$trailer = $_POST['trailer'];

// Cek apakah file baru diunggah untuk poster
if (isset($_FILES['poster']['name']) && $_FILES['poster']['name']) {
    $poster = $_FILES['poster']['name'];
    $targetposter = "uploads/" . basename($poster);

    // Upload file baru
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetposter)) {
        // Hapus poster lama jika ada
        $queryposter = mysqli_query($koneksi, "SELECT poster FROM film WHERE id = '$id'");
        $oldposter = mysqli_fetch_assoc($queryposter)['poster'];

        if ($oldposter && file_exists("uploads/" . $oldposter)) {
            unlink("uploads/" . $oldposter);
        }
    } else {
        echo "Gagal mengunggah poster.";
        exit;
    }
} else {
    // Jika tidak ada file baru, tetap gunakan poster lama
    $queryposter = mysqli_query($koneksi, "SELECT poster FROM film WHERE id = '$id'");
    $poster = mysqli_fetch_assoc($queryposter)['poster'];
}

// Perbarui data di database
$queryUpdate = "UPDATE film SET judul = '$judul', jadwal = '$jadwal', genre = '$genre', harga = '$harga', theater = '$theater', waktu_tayang = '$waktu_tayang', poster = '$poster', trailer = '$trailer' WHERE id = '$id'";

if (mysqli_query($koneksi, $queryUpdate)) {
    header("Location: film.php?status=success"); // Redirect ke halaman utama dengan status berhasil
} else {
    echo "Gagal memperbarui data: " . mysqli_error($koneksi);
}
?>
