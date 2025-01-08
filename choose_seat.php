<!-- 
//nama file : choose_seat.php
//deskripsi : file ini untuk fitur pemilihan kursi
//dibuat oleh : Zahra Ufairah - NIM : 3312401060, Jesica Kristina Manalu - NIM : 3312401069
//tanggal     : 08 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Mengambil detail film dari sesi
if (!isset($_SESSION['selected_film'])) {
    die("Error: No movie selected");
}

$movieDetails = $_SESSION['selected_film'];
$judul = $movieDetails['judul'];

// Check apakah form data tersedia di POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate that id exists in POST data
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("Error: Film ID not provided");
    }

    // Validasi data
    $filmId = intval($_POST['id']);
    $theater = htmlspecialchars($_POST['theater']);
    $tanggal = htmlspecialchars($_POST['jadwal']);
    $waktu = htmlspecialchars($_POST['waktu']);
    
    // Mengahmbil harga dari database film
    $queryHarga = "SELECT harga FROM film WHERE id = ? LIMIT 1";
    $stmtHarga = $koneksi->prepare($queryHarga);
    if (!$stmtHarga) {
        die("Error preparing statement: " . $koneksi->error);
    }
    
    $stmtHarga->bind_param("i", $filmId);
    $stmtHarga->execute();
    $resultHarga = $stmtHarga->get_result();
    
    if ($resultHarga->num_rows === 0) {
        die("Error: Film not found.");
    }
    
    $harga = $resultHarga->fetch_assoc()['harga'];
}

// Process booking kursi
if (isset($_POST['booked']) && isset($_POST['seats'])) {
    // Validasi dan proses pemmilihan kursi
    $kursi_terpilih = explode(',', htmlspecialchars($_POST['seats']));
    $totalAmount = count($kursi_terpilih) * $harga; // Menghitung total harga berdasarkan jumlah kursi yang dipilih

    // Generate booking_id dengan format
    $bookingId = 'TCS' . date('YmdHis') . rand(100, 999);

    //Memulai database transaksi untuk memastikan data tetap konsisten
    $koneksi->begin_transaction();
    try {
        // Masukkan sestiap pemilihan kursi ke tabel pemesanan_kursi
        $query_insert = "INSERT INTO pemesanan_kursi (kursi, status, harga, booking_id) VALUES (?, 1, ?, ?)";
        $stmtInsert = $koneksi->prepare($query_insert);
        if (!$stmtInsert) {
            throw new Exception("Error preparing seat booking query: " . $koneksi->error);
        }
        
        // Bind parameters dan memasukkan tiap kursi
        foreach ($kursi_terpilih as $kursi) {
            $stmtInsert->bind_param("sis", $kursi, $harga, $booking_id);
            $stmtInsert->execute();
        }

        // Mennyimpan Booking Details kedalam tabel tiket
        $username = $_SESSION['username'];
        $totalSeats = count($kursi_terpilih);
        $createdAt = date('YmdHis');

        $query_booking = "INSERT INTO tiket (username, booking_id, film_id, judul, tanggal, waktu, theater, total_seats, total_price, created_at) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtBooking = $koneksi->prepare($query_booking);
        if (!$stmtBooking) {
            throw new Exception("Error preparing booking query: " . $koneksi->error);
        }

        $stmtBooking->bind_param(
            "ssissssids", 
            $username, 
            $bookingId, 
            $filmId, 
            $judul, 
            $tanggal, 
            $waktu, 
            $theater, 
            $totalSeats, 
            $totalAmount, 
            $createdAt
        );
        $stmtBooking->execute();

        // Menyelesaikan transaksi
        $koneksi->commit();
        $_SESSION['last_booking_id'] = $booking_id;
        header("Location: booking_history.php");
        exit;

        // Mengarahkan booking history
        echo "<script>
            alert('Selamat 😉, Pesanan anda berhasil!');
            window.location.href = 'booking_history.php';
        </script>";
    } catch (Exception $e) {
        // Mengulang kembali transaksi jika terjadi kesalahan
        $koneksi->rollback();
        die("Error: " . $e->getMessage());
    }
}

// Mengambil kursi yang dipesan dari database
$query = "SELECT kursi FROM pemesanan_kursi WHERE status = 1";
$result = mysqli_query($koneksi, $query);
$kursi_terpesan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $kursi_terpesan[] = $row['kursi'];
}

// Menutup koneksi
$koneksi->close();
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .seat-container {
            flex: 3;
            text-align: center;
            background-color:rgb(170, 170, 166);
            padding: 10px;
            border-radius: 20px;
            border: solid 2px white;
        }
        .seats {
            display: grid;
            grid-template-columns: repeat(10, 50px);
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }
        .seat {
            width: 50px;
            height: 50px;
            background-color: #333;
            text-align: center;
            line-height: 50px;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        .seat.selected {
            background-color:rgb(57, 223, 79);
        }
        .seat.booked {
            background-color: red;
            cursor: not-allowed;
        }
        .booking-box {
            flex: 1;
            width: 250px;
            padding: 15px;
            background-color:rgb(170, 170, 166);
            border: 2px solid white;
            box-shadow: -2px 3px 10px -5px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: -2px 3px 10px -5px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: -2px 3px 10px -5px rgba(0, 0, 0, 0.75);
            text-align: left;
            margin-left: 30px;
            border-radius: 20px;
            color: white;
        }
        .booking-box h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .book-btn {
            margin-top: 20px;
            padding: 12px;
            background: orange;
            color: white;
            border: 1px solid white;
            cursor: pointer;
            font-size: 16px;
            width: 30%;
            border-radius: 5px;
        }
        .booking-box p {
            margin: 10px 0;
            font-size: 14px;
        }
        .screen {
            background-color: #333;
            color: white;
            width: 80%;
            height: 20px;
            margin: 0 auto;
            border-radius: 8px;
            line-height: 20px;
            font-size: 18px;
            margin-bottom: 20px;
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
          <a class="nav-link" href="#nowShowing">NOW SHOWING</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#comingSoon">COMING SOON</a>
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
<br>
<br>
    <div class="container">
        <div class="seat-container">
            <div class="screen">Screen</div>
            <form method="POST" action="process_booking.php">
                <div class="seats">
                    <?php for ($row = 'A'; $row <= 'F'; $row++): ?>
                        <?php for ($col = 1; $col <= 10; $col++): 
                            $nomor_kursi = $row . $col;
                            $kelas_kursi = in_array($nomor_kursi, $kursi_terpesan) ? 'booked' : '';
                        ?>
                            <div class="seat <?php echo $kelas_kursi; ?>" 
                                data-seat="<?php echo $nomor_kursi; ?>" 
                                onclick="toggleSeat(this, '<?php echo $nomor_kursi; ?>')">
                                <?php echo $nomor_kursi; ?>
                            </div>
                        <?php endfor; ?>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="seats" id="selected-seats">
                <input type="hidden" name="id" value="<?php echo $filmId; ?>">
                <input type="hidden" name="theater" value="<?php echo $theater; ?>">
                <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                <input type="hidden" name="waktu" value="<?php echo $waktu; ?>">
                <button type="submit" name="booked" class="book-btn">Book Now</button>
            </form>
        </div>

        <div class="booking-box">
            <h1>Booking Details</h1>
            <hr>
            <p><strong>Movie Title: </strong><?php echo $judul; ?></p>
            <hr>
            <p><strong>Theater: </strong><?php echo $theater; ?></p>
            <hr>
            <p><strong>Date: </strong><?php echo $tanggal; ?></p>
            <hr>
            <p><strong>Time: </strong><?php echo $waktu; ?></p>
            <hr>
            <p><strong>Seats Selected: </strong><span id="amount">0</span></p>
            <hr>
            <p><strong>Total Price: </strong><span id="total">Rp 0</span></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        let selectedSeats = [];
        let totalAmount = 0;
        const pricePerSeat = <?php echo $harga; ?>;

        // Fungsi javascript untuk membedakan tiap kursi yang sedang dipilih, sudah terpesan, atau tersedia
        function toggleSeat(element, seat) {
            if (element.classList.contains('booked')) {
                alert('Kursi ini sudah dipesan!');
                return;
            }

            element.classList.toggle('selected');
            const index = selectedSeats.indexOf(seat);

            if (index > -1) {
                selectedSeats.splice(index, 1);
                totalAmount -= pricePerSeat;
            } else {
                selectedSeats.push(seat);
                totalAmount += pricePerSeat;
            }

            document.getElementById('selected-seats').value = selectedSeats.join(',');
            document.getElementById('amount').innerText = selectedSeats.length;
            document.getElementById('total').innerText = `Rp ${totalAmount}`;
        }
    </script>

</body>
</html>
