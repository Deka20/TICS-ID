<!-- 
//nama file    : upload_caraousel.php
//deskripsi    : file untuk menambah poster carousel
//dibuat oleh  : Zahra Ufairah - NIM : 3312401060
//tanggal      : 14 Desember 2024 - 15 Desember 2024 
-->

<?php
session_start();
include 'koneksibioskop.php'; // Pastikan koneksi ke database

if (!isset($_SESSION['username_admin'])) {
    header("Location: login-admin.php");
    exit;
}

// Cek jika gambar sudah di-upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['carousel_image'])) {
    $errors = [];
    $file_name = $_FILES['carousel_image']['name'];
    $file_size = $_FILES['carousel_image']['size'];
    $file_tmp = $_FILES['carousel_image']['tmp_name'];
    $file_type = $_FILES['carousel_image']['type'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validasi ekstensi file
    $extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($file_ext, $extensions)) {
        $errors[] = "Format file tidak diizinkan. Gunakan jpg, jpeg, png, atau gif.";
    }

    // Validasi ukuran file (maksimal 5MB)
    if ($file_size > 5242880) {
        $errors[] = "Ukuran file terlalu besar. Maksimal 5MB.";
    }

    if (empty($errors)) {
        // Membuat nama file yang unik
        $upload_dir = 'uploads/';
        $file_new_name = uniqid() . '.' . $file_ext;

        // Memindahkan file ke folder uploads
        if (move_uploaded_file($file_tmp, $upload_dir . $file_new_name)) {
            // Menyimpan nama file di database
            $query = "INSERT INTO carousel_image (image_name) VALUES ('$file_new_name')";
            if (mysqli_query($koneksi, $query)) {
                header('Location: carousel.php');
                exit();
            } else {
                echo "Gagal menyimpan data gambar di database.";
            }
        } else {
            echo "Gagal mengupload gambar.";
        }
    } else {
        echo implode("<br>", $errors);
    }
}
?>
