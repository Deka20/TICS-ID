<!-- 
//nama file    : ubah_coming_soon.php
//deskripsi    : file untuk mengedit data film coming soon
//dibuat oleh  : Jesica Kristina Manalu - NIM : 3312401069
//tanggal      : 14 Desember 2024 - 29 Desember 2024 
-->

<?php
// Pastikan koneksi database tersedia
include 'koneksibioskop.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$genre = $_POST['genre'];
$trailer = $_POST['trailer'];

// Cek apakah file baru diunggah untuk poster
if (isset($_FILES['poster']['name']) && $_FILES['poster']['name']) {
    $poster = $_FILES['poster']['name'];
    $targetposter = "uploads/" . basename($poster);

    // Upload file baru
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetposter)) {
        // Hapus poster lama jika ada
        $queryposter = mysqli_query($koneksi, "SELECT poster FROM coming_soon WHERE id = '$id'");
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
    $queryposter = mysqli_query($koneksi, "SELECT poster FROM coming_soon WHERE id = '$id'");
    $poster = mysqli_fetch_assoc($queryposter)['poster'];
}

// Perbarui data di database
$queryUpdate = "UPDATE coming_soon SET judul = '$judul', genre = '$genre', trailer = '$trailer', poster = '$poster' WHERE id = '$id'";

if (mysqli_query($koneksi, $queryUpdate)) {
    header("Location: coming_soon.php?status=success"); // Redirect ke halaman utama dengan status berhasil
} else {
    echo "Gagal memperbarui data: " . mysqli_error($koneksi);
}
?>
