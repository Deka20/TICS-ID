<!-- 
//nama file   : update_carousel.php
//deskripsi   : file untuk mengedit 
//dibuat oleh : Zahra Ufairah - NIM : 3312401060
//tanggal     : 13 Desember 2024 - 15 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php'; // Pastikan koneksi ke database

// Cek jika sudah login
if (!isset($_SESSION['username_admin'])) {
    header('Location: login-admin.php');
    exit();
}

// Periksa apakah ada data yang dikirimkan
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Ambil data gambar lama untuk dihapus dari folder jika gambar baru diunggah
    $query = mysqli_query($koneksi, "SELECT * FROM carousel_image WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    $old_image_name = $data['image_name'];

    // Jika ada gambar baru yang diupload
    if (isset($_FILES['carousel_image']) && $_FILES['carousel_image']['error'] == 0) {
        // Tentukan lokasi folder penyimpanan
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["carousel_image"]["name"]);
        $image_name = basename($_FILES["carousel_image"]["name"]);

        // Periksa apakah file adalah gambar
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["carousel_image"]["tmp_name"]);
        if ($check !== false) {
            // Pindahkan file gambar ke folder "uploads"
            if (move_uploaded_file($_FILES["carousel_image"]["tmp_name"], $target_file)) {
                // Hapus gambar lama dari folder
                unlink("uploads/" . $old_image_name);

                // Update gambar di database
                $update_query = "UPDATE carousel_image SET image_name = '$image_name' WHERE id = $id";
                if (mysqli_query($koneksi, $update_query)) {
                    // Redirect ke halaman sebelumnya dengan pesan sukses
                    $_SESSION['success_message'] = "Gambar carousel berhasil diperbarui!";
                    header("Location: carousel.php");
                    exit();
                } else {
                    // Jika query update gagal
                    $_SESSION['error_message'] = "Terjadi kesalahan saat memperbarui gambar!";
                    header("Location: carousel.php");
                    exit();
                }
            } else {
                // Jika gagal mengunggah file
                $_SESSION['error_message'] = "Gagal mengunggah gambar!";
                header("Location: carousel.php");
                exit();
            }
        } else {
            // Jika file bukan gambar
            $_SESSION['error_message'] = "File yang diunggah bukan gambar!";
            header("Location: carousel.php");
            exit();
        }
    } else {
        // Jika tidak ada gambar baru yang diupload, hanya update informasi lainnya
        $_SESSION['error_message'] = "Tidak ada gambar yang diunggah.";
        header("Location: carousel.php");
        exit();
    }
} else {
    // Jika tidak ada id yang dikirim
    $_SESSION['error_message'] = "ID gambar tidak ditemukan!";
    header("Location: carousel.php");
    exit();
}
?>
