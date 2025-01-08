<!-- 
//nama file  : coming_soon.php
//deskripsi  : file untuk menampilkan film yang nanti akan tayangg
//dibuat oleh : Jesica Kristina Manalu - NIM : 3312401069
//tanggal     : 14 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();

// Cek jika sudah login
if (!isset($_SESSION['username_admin'])) {
    header('Location: login-admin.php');
    exit();
}
?>

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
                <h3><i class="fas fa-video me-2"></i> Daftar Film</h3>
                <hr>

                <!-- Tombol Tambah Film -->
                <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                    <i class="fas fa-plus-circle me-2"></i>TAMBAH DATA FILM
                </button>

                <!-- Modal Tambah Data -->
                <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahDataLabel">Tambah Data Film</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="tambah_coming_soon.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="id" class="form-label">ID Film</label>
                                        <input type="text" class="form-control" id="id" name="id" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Film</label>
                                        <input type="text" class="form-control" id="judul" name="judul" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="genre" class="form-label">Genre</label>
                                        <input type="text" class="form-control" id="genre" name="genre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="trailer" class="form-label">Trailer</label>
                                        <input type="text" class="form-control" id="trailer" name="trailer" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="poster" class="form-label">Poster Film</label>
                                        <input type="file" class="form-control" id="poster" name="poster" accept="image/*" required>
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
                                <h5 class="modal-title" id="editDataLabel">Edit Data Film</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="ubah_coming_soon.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="edit-id" name="id">
                                    <div class="mb-3">
                                        <label for="edit-judul" class="form-label">Judul Film</label>
                                        <input type="text" class="form-control" id="edit-judul" name="judul" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-genre" class="form-label">Genre</label>
                                        <input type="text" class="form-control" id="edit-genre" name="genre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-trailer" class="form-label">Trailer</label>
                                        <input type="text" class="form-control" id="edit-trailer" name="trailer" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-poster" class="form-label">Poster Film</label>
                                        <input type="file" class="form-control" id="edit-poster" name="poster">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Film -->
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">ID</th>
                            <th scope="col">JUDUL FILM</th>
                            <th scope="col">GENRE</th>
                            <th scope="col">POSTER</th>
                            <th scope="col">TRAILER</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'koneksibioskop.php';
                        $query = mysqli_query($koneksi, "SELECT * FROM coming_soon");
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['judul']; ?></td>
                                <td><?php echo $data['genre']; ?></td>
                                <td>
                                    <img src="uploads/<?= $data['poster']; ?>" alt="Poster Film" style="width: 100px; height: auto; border-radius: 5px;" />
                                </td>
                                <td><?php echo $data['trailer']; ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm me-1 edit-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editDataModal"
                                        data-id="<?php echo $data['id']; ?>"
                                        data-judul="<?php echo $data['judul']; ?>"
                                        data-genre="<?php echo $data['genre']; ?>"
                                        data-trailer="<?php echo $data['trailer']; ?>"
                                        data-poster="<?php echo $data['poster']; ?>"
                                        >
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <a href="hapus_coming_soon.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm mt-2">
                                        <i class="fas fa-trash-alt"></i> Delete
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

        <!-- Script untuk mengisi data edit modal -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editButtons = document.querySelectorAll('.edit-button');
                const posterPreview = document.getElementById('poster-preview');

                // Mengisi data ke modal edit
                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const judul = this.getAttribute('data-judul');
                        const genre = this.getAttribute('data-genre');
                        const jadwal = this.getAttribute('data-jadwal');
                        const harga = this.getAttribute('data-harga');
                        const waktu_tayang = this.getAttribute('data-waktu_tayang');
                        const poster = this.getAttribute('data-poster');

                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-judul').value = judul;
                        document.getElementById('edit-genre').value = genre;
                        document.getElementById('edit-jadwal').value = jadwal;
                        document.getElementById('edit-harga').value = harga;
                        document.getElementById('edit-waktu_tayang').value = waktu_tayang;

                        // Tampilkan poster di preview
                        posterPreview.src = poster;
                        posterPreview.style.display = "block";
                    });
                });

                // Preview saat file diunggah
                const editPosterInput = document.getElementById('edit-poster');
                editPosterInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            posterPreview.src = e.target.result;
                            posterPreview.style.display = "block";
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>

</body>

</html>