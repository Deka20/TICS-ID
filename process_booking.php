<!-- 
//nama file     : process_booking.php
//deskripsi     : file ini untuk proses pemesanan
//dibuat oleh   : Zidan Masadita - NIM :3312401083
//tanggal       : 20 Desember 2024 - 29 Desember 2024 
-->


<?php
// process_booking.php
session_start();
include 'koneksibioskop.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['booked']) && isset($_POST['seats'])) {
        $filmId = intval($_POST['id']);
        $theater = htmlspecialchars($_POST['theater']);
        $tanggal = htmlspecialchars($_POST['tanggal']);
        $waktu = htmlspecialchars($_POST['waktu']);
        $seats = explode(',', htmlspecialchars($_POST['seats']));

        // Query untuk mendapatkan harga film
        $queryHarga = "SELECT harga FROM film WHERE id = ? LIMIT 1";
        $stmtHarga = $koneksi->prepare($queryHarga);
        $stmtHarga->bind_param("i", $filmId);
        $stmtHarga->execute();
        $resultHarga = $stmtHarga->get_result();
        
        if ($resultHarga->num_rows === 0) {
            die("Film tidak ditemukan.");
        }

        $harga = $resultHarga->fetch_assoc()['harga'];
        $totalAmount = count($seats) * $harga;
        $bookingId = 'TCS' . date('YmdHis') . rand(100, 999);  // Generate booking ID

        // Mulai transaksi
        $koneksi->begin_transaction();
        try {
            // Query untuk memasukkan kursi yang dipesan
            $queryInsertSeat = "INSERT INTO pemesanan_kursi (kursi, booking_id, status, harga) VALUES (?, ?, 1, ?)";
            $stmtInsertSeat = $koneksi->prepare($queryInsertSeat);

            // Loop untuk menyisipkan kursi satu per satu
            foreach ($seats as $seat) {
                $stmtInsertSeat->bind_param("ssi", $seat, $bookingId, $harga);
                $stmtInsertSeat->execute();
            }

            // Ambil data untuk pemesanan tiket
            $username = $_SESSION['username'];
            $totalSeats = count($seats);
            $createdAt = date('YmdHis');

            // Query untuk menyimpan data pemesanan tiket
            $queryBooking = "INSERT INTO tiket (username, booking_id, film_id, judul, tanggal, waktu, theater, total_seats, total_price, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtBooking = $koneksi->prepare($queryBooking);
            $stmtBooking->bind_param(
                "ssissssids",
                $username,
                $bookingId,
                $filmId,
                $_SESSION['selected_film']['judul'],
                $tanggal,
                $waktu,
                $theater,
                $totalSeats,
                $totalAmount,
                $createdAt
            );
            $stmtBooking->execute();

            // Commit transaksi
            $koneksi->commit();
            $_SESSION['last_booking_id'] = $bookingId;  // Simpan booking_id untuk digunakan di halaman lain
            header("Location: invoice.php");  // Redirect ke halaman booking history
            exit;
        } catch (Exception $e) {
            // Jika ada error, rollback transaksi
            $koneksi->rollback();
            die("Error: " . $e->getMessage());
        }
    }
}
?>
