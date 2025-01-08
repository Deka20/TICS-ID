<!-- 
//nama file    : user.php
//deskripsi    : file untuk menampilkan data pengguna
//dibuat oleh  : Grace Anastasya Simanungkalit - NIM : 3312401073
//tanggal      : 12 Desember 2024 - 15 Desember 2024 
-->

<?php
session_start();

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
  <title>Document</title>
  <link rel="stylesheet" href="dashboard.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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


      <!-- Tambah Data Pengguna -->
      <div class="col-md-10 p-5 pt-3">
        <h3><i class="fas fa-user me-2"></i> Daftar Pengguna</h3>
        <hr>
        <!--modal tambah data-->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabel">Tambah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
              </div>
              <div class="modal-body">
                <form action="tambah_user.php" method="POST">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                  </div>
                  <div class="mb-3">
                    <label for="no_hp" class="form-label">No.Handphone</label>
                    <input type="number" class="form-control" id="no_hp" name="no_hp" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editDataLabel">Edit Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="ubah_user.php" method="POST">
                  <input type="hidden" id="edit-email" name="email">
                  <div class="mb-3">
                    <label for="edit-username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="edit-username" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit-password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="edit-password" name="password" placeholder="Password Baru">
                  </div>
                  <div class="mb-3">
                    <label for="edit-nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="edit-nama_lengkap" name="nama_lengkap" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit-no_hp" class="form-label">No.Handphone</label>
                    <input type="number" class="form-control" id="edit-no_hp" name="no_hp" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">NO</th>
              <th scope="col">EMAIL</th>
              <th scope="col">USERNAME</th>
              <th scope="col">NAMA LENGKAP</th>
              <th scope="col">NO.HANDPHONE</th>
              <th scope="col">AKSI</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'koneksibioskop.php';
            $query = mysqli_query($koneksi, "SELECT * FROM user");
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['nama_lengkap']; ?></td>
                <td><?php echo $data['no_hp']; ?></td>
                <td>
                  <a href="hapus_user.php?email=<?php echo $data['email']; ?>" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt"></i>Delete</a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const editButtons = document.querySelectorAll('.edit-button');
          editButtons.forEach(button => {
            button.addEventListener('click', function() {
              const email = this.getAttribute('data-email');
              const username = this.getAttribute('data-username');
              const password = this.getAttribute('data-password');
              const nama_lengkap = this.getAttribute('data-nama_lengkap');
              const no_hp = this.getAttribute('data-no_hp');

              document.getElementById('edit-email').value = email;
              document.getElementById('edit-username').value = username;
              document.getElementById('edit-password').value = '';
              document.getElementById('edit-nama_lengkap').value = nama_lengkap;
              document.getElementById('edit-no_hp').value = no_hp;
            });
          });
        });
      </script>
</body>

</html>