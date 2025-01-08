<!-- 
//nama file     : invoice_history.php
//deskripsi     : file ini untuk menampilkan detail riwayat pemesanan pembeli di halaman booking history
//dibuat oleh   : Zidan Masadita Pramudia - NIM : 3312401083
//tanggal       : 20 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


$booking_id = $_GET['booking_id'];

// Query untuk mendapatkan detail booking
$query = "SELECT t.booking_id, t.judul, t.theater, t.tanggal, t.waktu, t.total_price, t.total_seats, t.created_at, t.username
          FROM tiket t
          WHERE t.booking_id = ?";
$stmt = $koneksi->prepare($query);

if (!$stmt) {
    die("Error preparing statement: " . $koneksi->error);
}

$stmt->bind_param("s", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Booking not found for booking ID: " . htmlspecialchars($booking_id));
}

$booking_details = $result->fetch_assoc(); // Mendapatkan booking details dari table tiket

// Query untuk mendapatkan kursi yang dipesan
$query_seats = "SELECT kursi FROM pemesanan_kursi WHERE booking_id = ?";
$stmt_seats = $koneksi->prepare($query_seats);
$stmt_seats->bind_param("s", $booking_id);
$stmt_seats->execute();
$result_seats = $stmt_seats->get_result();

$seats = [];
while ($row = $result_seats->fetch_assoc()) {
    $seats[] = $row['kursi']; // Tambahkan tiap kursi kedalam array seats
}

$stmt->close();
$stmt_seats->close();
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tics ID - Booking History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .booking-history {
            text-align: center;
            margin-top: 30px;
        }
        .booking-history h2 {
            font-weight: bold;
        }
        .booking-details {
            background-color: #888;
            color: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            text-align: left;
            width: 100%;
            max-width: 600px;
        }
        .booking-details div {
            padding: 10px 0;
            border-bottom: 1px solid white;
        }
        .booking-details div:last-child {
            border-bottom: none;
        }
        .btn-secondary {
            width: 100%;
        }
        .back-btn {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 10px 0;
            margin: 5px;
            border-radius: 60px;
        }
        .back-btn i {
            font-size: 28px;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="bioskop.php">TICS ID</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="bioskop.php">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bioskop.php#nowShowing">NOW SHOWING</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bioskop.php#comingSoon">COMING SOON</a>
        </li>
        <li class="nav-item">
          <form class="d-flex" action="search.php" method="GET">
            <input class="form-control me-2" type="search" name="query" placeholder="Search Movies" aria-label="Search" style="border-radius: 20px;">
            <button class="btn btn-outline-light" type="submit" style="border-radius: 50px;"><i class='bx bx-search-alt-2'></i></button>
          </form>
        </li>
      </ul>
      <ul class="navbar-nav ms-3">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link btn-outline-light" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle" style="font-size: 32px; color: white;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><h6 class="dropdown-header text-muted"><?php echo htmlspecialchars($_SESSION['username']); ?></h6></li>
        <li><a class="dropdown-item" href="profile.php"><i class="bx bxs-user-circle"></i> Profile</a></li>
        <li><a class="dropdown-item" href="booking_history.php"><i class="bx bx-history"></i> Booking History</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bx bx-log-out"></i> Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-outline-light" href="login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Booking History -->
<div class="container booking-history">
    <br>
    <br>
    <h2>Booking History</h2>
    <div class="booking-details col-md-6">
    <a href="booking_history.php" class="back-btn"><i class='bx bx-arrow-back'></i></a>
        <div class="text-center"><h2>TICS ID</h2></div>
        <div><strong>Kode Pesanan:</strong> <?php echo htmlspecialchars($booking_details['booking_id']); ?></div>
        <div><strong>Nama Pemesan:</strong> <?php echo htmlspecialchars($booking_details['username']); ?></div>
        <div><strong>Judul:</strong> <?php echo htmlspecialchars($booking_details['judul']); ?></div>
        <div><strong>Waktu:</strong> <?php echo htmlspecialchars($booking_details['waktu']); ?></div>
        <div><strong>Tanggal:</strong> <?php echo htmlspecialchars($booking_details['tanggal']); ?></div>
        <div><strong>Kursi:</strong> <?php echo implode(", ", $seats); ?></div>
        <div><strong>Theater:</strong> <?php echo htmlspecialchars($booking_details['theater']); ?></div>
        <div><strong>Total Harga:</strong> Rp <?php echo number_format($booking_details['total_price'], 0, ',', '.'); ?></div>
        <form action="invoice_pdf.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking_details['booking_id']); ?>">
            <button type="submit" class="btn btn-secondary mt-4">Export to PDF</button>
        </form>

    </div>
</div>

<!-- JavaScripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
