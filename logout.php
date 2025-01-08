<!-- 
//nama file : logout.php
//deskripsi : file ini untuk logout pengguna dan juga admin
//dibuat oleh: Zidan Masadita Pramudia - NIM : 3312401083
//tanggal    : 23 Desember 2024 - 29 Desember 2024 

MULAI
    // Mulai sesi
    MULAI_SESSION()

    // Hapus semua variabel sesi
    HAPUS_SEMUA_SESSION()

    // Hancurkan sesi
    HANCURKAN_SESSION()

    // Arahkan pengguna ke halaman bioskop
    ARAHKAN_HALAMAN("bioskop.php")

    // Akhiri program
    KELUAR_PROGRAM()
SELESAI
-->

<?php
session_start();
session_unset();
session_destroy();
header("Location: bioskop.php");
exit();
?>
?>
