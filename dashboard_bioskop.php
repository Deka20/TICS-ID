<!-- 
// Nama file : dashboard_bioskop.php
//Deskripsi  : fungsi ini mengelola fungsi yang berhubungan dengan aktivitas admin
//dibuat oleh : Grace A Simanungkalit - NIM: 3312401073
//tanggal     : 12 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username_admin'])) {
  header('Location: login-admin.php');
  exit();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="dashboard.css">
  <title>Dashboard</title>
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

      <!-- Content -->
      <main class="col-md-10 ms-sm-auto px-md-4">
        <h3 class="mt-4"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</h3>
        <hr>
        <div class="row">
          <!-- Card: Data Pengguna -->
          <div class="col-md-4">
            <a href="user.php" class="text-decoration-none text-white">
              <div class="card bg-dark mb-3">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-user me-2"></i>Data Pengguna</h5>
                </div>
              </div>
            </a>
          </div>
          <!-- Card: Film -->
          <div class="col-md-4">
            <a href="film.php" class="text-decoration-none text-dark">
              <div class="card bg-warning mb-3">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-video me-2"></i>Film</h5>
                </div>
              </div>
            </a>
          </div>
          <!-- Riwayat Pemesanan -->
          <div class="col-md-4">
            <a href="tiket.php" class="text-decoration-none text-white">
              <div class="card bg-dark mb-3">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-clock me-2"></i>Riwayat Pemesanan</h5>
                </div>
              </div>
            </a>
          </div>
          <!-- Coming Soon -->
          <div class="col-md-4">
            <a href="coming_soon.php" class="text-decoration-none text-dark">
              <div class="card bg-warning mb-3">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-video me-2"></i>Coming Soon</h5>
                </div>
              </div>
            </a>
          </div>
          <!-- Edit Carousel-->
          <div class="col-md-4">
            <a href="carousel.php" class="text-decoration-none text-white">
              <div class="card bg-dark mb-3">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-image me-2"></i>Carousel</h5>
                </div>
              </div>
            </a>
          </div>
          <!-- Data Kursi-->
          <div class="col-md-4">
            <a href="kursi.php" class="text-decoration-none text-dark">
              <div class="card bg-warning mb-3">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-chair me-2"></i>Data Kursi</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>