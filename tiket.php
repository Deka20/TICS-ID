<!-- 
//nama file    : tiket.php
//deskripsi    : file untuk menampilkan halaman daftar pemesanan tiket untuk di kelola admin 
//dibuat oleh  : Rafles Yuda Stevenses Nababan - NIM : 3312401062
//tanggal      : 24 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php';

// Cek jika sudah login
if (!isset($_SESSION['username_admin'])) {
  header('Location: login-admin.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pemesanan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="dashboard.css">
  <style>
    body {
      background-color: #eaeaea;
      font-family: "Poppins", sans-serif;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">TICS ID</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['username_admin'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link text-light" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle" style="font-size: 24px;"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li>
                  <h6 class="dropdown-header">Hello, <?php echo htmlspecialchars($_SESSION['username_admin']); ?></h6>
                </li>
                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link text-light btn btn-outline-light" href="login-admin.php">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Layout -->
  <div class="container-fluid mt-5">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 bg-dark sidebar d-flex flex-column pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active text-white" href="dashboard_bioskop.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <hr class="bg-secondary">
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="user.php"><i class="fas fa-user me-2"></i> Data Pengguna</a>
            <hr class="bg-secondary">
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="film.php"><i class="fas fa-video me-2"></i> Daftar Film</a>
            <hr class="bg-secondary">
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="tiket.php"><i class="fas fa-clock me-2"></i> Riwayat Pemesanan</a>
            <hr class="bg-secondary">
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="coming_soon.php"><i class="fas fa-video me-2"></i> Film Coming Soon</a>
            <hr class="bg-secondary">
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="carousel.php"><i class="fas fa-image me-2"></i> Edit Carousel</a>
            <hr class="bg-secondary">
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="kursi.php"><i class="fas fa-chair me-2"></i> Data Kursi</a>
            <hr class="bg-secondary">
          </li>
        </ul>
      </nav>

      <!-- Main Content -->
      <div class="col-md-10 p-5 pt-3">
        <h3><i class="fas fa-clock me-2"></i> Riwayat Pemesanan</h3>
        <hr>

        <!-- Table for Booking History -->
        <div class="table-responsive">
          <?php
          // Mengambil data dari database dengan JOIN dan GROUP_CONCAT untuk menggabungkan kursi
          $query = "
            SELECT t.booking_id, t.username, t.judul, t.tanggal, t.waktu, t.theater, t.total_seats, t.total_price, 
                   DATE_FORMAT(CONVERT_TZ(t.created_at, '+01:00', '+07:00'), '%d-%m-%Y %H:%i:%s') AS created_at_wib,
                   GROUP_CONCAT(pk.kursi ORDER BY pk.kursi ASC) AS kursi, 
                   COUNT(pk.kursi) AS total_kursi
            FROM tiket t
            JOIN pemesanan_kursi pk ON t.booking_id = pk.booking_id
            GROUP BY t.booking_id
          ";
          $result = mysqli_query($koneksi, $query);
          ?>
          <table class="table table-striped table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Booking ID</th>
                <th>Username</th>
                <th>Judul Film</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Theater</th>
                <th>Kursi</th>
                <th>Total Seats</th>
                <th>Total Price</th>
                <th>Waktu Pemesanan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($data = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $data['booking_id'] . "</td>";
                echo "<td>" . $data['username'] . "</td>";
                echo "<td>" . $data['judul'] . "</td>";
                echo "<td>" . $data['tanggal'] . "</td>";
                echo "<td>" . $data['waktu'] . "</td>";
                echo "<td>" . $data['theater'] . "</td>";
                echo "<td>" . $data['kursi'] . "</td>";
                echo "<td>" . $data['total_kursi'] . "</td>"; // Menampilkan jumlah kursi
                echo "<td>Rp" . number_format($data['total_price'], 0, ',', '.') . "</td>";
                echo "<td>" . $data['created_at_wib'] . "</td>"; // Menampilkan waktu dalam WIB dengan format dd-mm-yyyy hh:mm:ss
                echo "<td><a href='hapus_riwayat.php?id=" . $data['booking_id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>