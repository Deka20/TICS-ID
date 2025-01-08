<!-- 
//nama file  : export_pdf.php
//deskripsi  : file untuk menampilkan film yang nanti akan tayangg
//dibuat oleh : Zidan Masadita Pramudia - NIM : 3312401083, Rafles Yuda Stevenses Nababan - NIM : 3312401062
//tanggal     : 20 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
require('fpdf/fpdf.php');
include 'koneksibioskop.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah last_booking_id tersedia di sesi
if (!isset($_SESSION['last_booking_id'])) {
    die("Error: No booking found.");
}

$booking_id = $_SESSION['last_booking_id'];

// Query untuk mendapatkan detail booking
$query = "SELECT t.booking_id, t.judul, t.theater, t.tanggal, t.waktu, t.total_price, k.kursi AS seat_number, t.username
          FROM tiket t
          JOIN pemesanan_kursi k ON t.booking_id = k.booking_id
          WHERE t.booking_id = ?";

$stmt = $koneksi->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $koneksi->error);
}

$stmt->bind_param("s", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Booking not found.");
}

$booking_details = [];
while ($row = $result->fetch_assoc()) {
    // Jika data booking belum ada, masukkan detail booking ke dalam array
    if (empty($booking_details)) {
        $booking_details['booking_id'] = $row['booking_id'];
        $booking_details['judul'] = $row['judul'];
        $booking_details['theater'] = $row['theater'];
        $booking_details['tanggal'] = $row['tanggal'];
        $booking_details['waktu'] = $row['waktu'];
        $booking_details['total_price'] = $row['total_price'];
        $booking_details['seats'] = [];
        $booking_details['username'] = $row['username'];
    }
    // Masukkan kursi yang dipesan ke dalam array 'seats'
    $booking_details['seats'][] = $row['seat_number'];
}

// Definisikan kelas PDF menggunakan FPDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10, 'TICS ID - Booking Details', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Buat objek PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Kode Pemesanan
$pdf->Cell(0, 10, 'Kode Pesanan: ' . $booking_details['booking_id'], 0, 1);

// Tanggal Pemesanan
$pdf->Cell(0, 10, 'Tanggal: ' . $booking_details['tanggal'], 0, 1);

// Detail Pemesan
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Detail Pemesan:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nama Pemesan: ' . $booking_details['username'], 0, 1);

// Detail Pemesanan
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Detail Pemesanan:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Judul: ' . $booking_details['judul'], 0, 1);
$pdf->Cell(0, 10, 'Theater: ' . $booking_details['theater'], 0, 1);
$pdf->Cell(0, 10, 'Waktu: ' . $booking_details['waktu'], 0, 1);
$pdf->Cell(0, 10, 'Kursi: ' . implode(', ', $booking_details['seats']), 0, 1);

// Total Harga
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Total Bayar:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Total Harga: Rp ' . number_format($booking_details['total_price'], 0, ',', '.'), 0, 1);

// Output PDF ke browser
$pdfOutput = 'booking_details.pdf';
$pdf->Output('F', $pdfOutput); // Simpan file sementara di server

// Pratinjau PDF di browser
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=$pdfOutput");
readfile($pdfOutput);

// Hapus file sementara setelah di-output
unlink($pdfOutput);
?>
