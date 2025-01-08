<!-- 
//nama file     : kursi.php
//deskripsi     : file ini untuk menampilkan halaman  daftar pemesanan kursi untuk admin
//dibuat oleh   : Zahra Ufairah - NIM : 3312401060
//tanggal       : 12 Desember 2024 - 31 Desember 2024 
-->

<?php
session_start();
include 'koneksibioskop.php'; // Koneksi ke database

// Memastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username_admin'])) {
    header("Location: login-admin.php"); // Mengarahkan ke halaman login jika bukan admin
    exit();
}

// Fungsi untuk mengubah status dan kursi
if (isset($_POST['edit_status'])) {
    $kursi = $_POST['kursi'];
    $new_kursi = $_POST['new_kursi'];
    $status_baru = $_POST['status'] == 'booked' ? 1 : 0; // Mengubah status menjadi 0 jika status 'Tersedia', atau 1 jika status 'Terpesan'

    // Update status dan nomor kursi di database
    $query_update = "UPDATE pemesanan_kursi SET kursi = '$new_kursi', status = '$status_baru' WHERE kursi = '$kursi'";
    $result = mysqli_query($koneksi, $query_update);

    if ($result) {
        echo "<script>alert('Status dan nomor kursi berhasil diubah.'); window.location.href = 'kursi.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah status dan nomor kursi.'); window.location.href = 'kursi.php';</script>";
    }
}

// Fungsi untuk menghapus kursi
if (isset($_GET['hapus'])) {
    $kursi = $_GET['hapus'];

    // Query untuk menghapus data kursi
    $query_hapus = "DELETE FROM pemesanan_kursi WHERE kursi = '$kursi'";
    $result_hapus = mysqli_query($koneksi, $query_hapus);

    if ($result_hapus) {
        echo "<script>alert('Kursi berhasil dihapus.'); window.location.href = 'kursi.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kursi.'); window.location.href = 'kursi.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <title>ADMINISTRATOR - Daftar Kursi</title>
</head>
<style>
    body {
      background-color: #eaeaea;
      font-family: "Poppins", sans-serif;
    }
</style>
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
            <div class="col-md-10 mt-3">
                <h3 class="mb-3"><i class="fas fa-chair me-2"></i> Daftar Pemesanan Kursi</h3>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 1%;">No</th>
                            <th style="width: 5%;">Nomor Kursi</th>
                            <th style="width: 5%;">Harga</th>
                            <th style="width: 5%;">Status</th>
                            <th style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk menampilkan data pemesanan kursi
                        $query = mysqli_query($koneksi, "SELECT * FROM pemesanan_kursi");
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($query)) {
                            $status = $data['status'] == 1 ? 'booked' : 'available'; // Convert status integer to string
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>Kursi <?php echo $data['kursi']; ?></td>
                            <td>Rp<?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $status == 'booked' ? 'Terpesan' : 'Tersedia'; ?></td>
                            <td>
                                <!-- Tombol untuk mengubah status kursi menjadi Edit dengan warna hijau -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editStatusModal" data-kursi="<?php echo $data['kursi']; ?>" data-status="<?php echo $status; ?>" data-harga="<?php echo $data['harga']; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <!-- Tombol untuk menghapus kursi -->
                                <a href="?hapus=<?php echo $data['kursi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kursi ini?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit Status -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Edit Status dan Nomor Kursi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="kursi" id="kursi">
                        <div class="mb-3">
                            <label for="new_kursi" class="form-label">Nomor Kursi Baru</label>
                            <input type="text" class="form-control" id="new_kursi" name="new_kursi" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Pilih Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="available">Tersedia</option>
                                <option value="booked">Terpesan</option>
                            </select>
                        </div>
                        <button type="submit" name="edit_status" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript untuk mengisi modal dengan data kursi dan status
        var editStatusModal = document.getElementById('editStatusModal');
        editStatusModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var kursi = button.getAttribute('data-kursi');
            var status = button.getAttribute('data-status');
            var harga = button.getAttribute('data-harga');

            var modalKursi = editStatusModal.querySelector('#kursi');
            var modalNewKursi = editStatusModal.querySelector('#new_kursi');
            var modalStatus = editStatusModal.querySelector('#status');

            modalKursi.value = kursi;
            modalNewKursi.value = kursi;  // Isi sebelumnya dengan nilai kursi saat ini
            modalStatus.value = status;
        });
    </script>
</body>
</html>
