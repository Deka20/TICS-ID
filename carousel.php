<!-- 
//nama file  : coming_soon.php
//deskripsi  : file untuk megelola film yang akan tayang
//dibuat oleh : Zahra Ufairah - NIM : 3312401060
//tanggal     : 13 Desember 2024 - 15 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php'; // Pastikan koneksi ke database

// Cek jika sudah login
if (!isset($_SESSION['username_admin'])) {
    header('Location: login-admin.php');
    exit();
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
    <title>ADMINISTRATOR</title>
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

            <!-- Konten Utama -->
            <div class="col-md-10 p-5 pt-3">
                <h3><i class="fas fa-image me-2"></i> Gambar Carousel</h3>

                <!-- Tombol Tambah Gambar Carousel -->
                <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#tambahCarouselModal">
                    <i class="fas fa-plus-circle me-2"></i>TAMBAH GAMBAR CAROUSEL
                </button>

                <!-- Modal Upload Gambar Carousel -->
                <div class="modal fade" id="tambahCarouselModal" tabindex="-1" aria-labelledby="tambahCarouselModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahCarouselModalLabel">Tambah Gambar Carousel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="upload_carousel.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="carousel_image" class="form-label">Pilih Gambar</label>
                                        <input type="file" class="form-control" id="carousel_image" name="carousel_image" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Gambar Carousel -->
                <h5>Daftar Gambar Carousel</h5>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM carousel_image");
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><img src="uploads/<?php echo $data['image_name']; ?>" style="width: 100px; height: auto; border-radius: 5px;"></td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editCarouselModal<?php echo $data['id']; ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <!-- Hapus Button -->
                                    <a href="delete_carousel.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Edit Gambar Carousel -->
                            <div class="modal fade" id="editCarouselModal<?php echo $data['id']; ?>" tabindex="-1" aria-labelledby="editCarouselModalLabel<?php echo $data['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCarouselModalLabel<?php echo $data['id']; ?>">Edit Gambar Carousel</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="update_carousel.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="carousel_image" class="form-label">Pilih Gambar</label>
                                                    <input type="file" class="form-control" id="carousel_image" name="carousel_image" accept="image/*">
                                                    <small>Biarkan kosong jika tidak ingin mengubah gambar</small>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
