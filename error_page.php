<!--
//nama file   : error_page.php
//deskripsi   : file ini sebagai notif eror 
//dibuat oleh : Zidan Masadita Pramudia - NIM : 3312401083
//tanggal     : 20 desember 2024 - 29 desember 2024
-->

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan - Booking ID Tidak Ditemukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eaeaea;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .error-container {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #f5c6cb;
            display: inline-block;
            width: 100%;
            max-width: 600px;
        }
        h1 {
            font-size: 2em;
        }
        p {
            font-size: 1.2em;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color:rgb(202, 132, 3);
        }
    </style>
</head>
<body>

    <div class="error-container">
        <h1>Booking ID Tidak Ditemukan</h1>
        <p>Maaf, kami tidak dapat menemukan ID booking Anda di sesi saat ini. Mungkin sesi Anda telah kedaluwarsa atau Anda belum melakukan pemesanan sebelumnya.</p>
        <p>Silakan kembali ke halaman utama atau coba lagi.</p>
        <button class="back-button" onclick="window.location.href='bioskop.php'">Kembali ke Halaman Utama</button>
    </div>

</body>
</html>
