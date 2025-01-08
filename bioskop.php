<!-- 
 //nama file     : bioskop.php
//deskripsi     : file ini untuk menampilkan halaman utama pengguna
//dibuat oleh   : Zidan Masadita Pramudia - NIM : 3312401083, Jesica Kristina Manalu - NIM : 3312401069
//tanggal       : 07 November 2024 - 29 Desember 2024 
-->

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TICS ID</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Genre
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="search.php?query=Action">Action</a></li>
            <li><a class="dropdown-item" href="search.php?query=Adventure">Adventure</a></li>
            <li><a class="dropdown-item" href="search.php?query=Sci-fi">Sci-fi</a></li>
            <li><a class="dropdown-item" href="search.php?query=Horror">Horror</a></li>
            <li><a class="dropdown-item" href="search.php?query=Drama">Drama</a></li>
          </ul>
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




  <?php
// Include file koneksi ke database
include 'koneksibioskop.php';

// Ambil data gambar dari database
$query = "SELECT * FROM carousel_image";
$result = mysqli_query($koneksi, $query);
$carousel_images = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- Carousel -->
<div class="col-md-12 p-0">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php 
            // Cek apakah ada gambar di database
            if (count($carousel_images) > 0) {
                $isActive = true; // Set gambar pertama sebagai active
                foreach ($carousel_images as $image) {
                    // Path gambar di folder 'uploads'
                    $imagePath = "uploads/" . $image['image_name']; 
            ?>
                <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
                    <img src="<?php echo $imagePath; ?>" class="d-block w-100 img-fluid" alt="Carousel Image" style="height: 400px; width: 1200px;">
                </div>
            <?php
                    $isActive = false; // Setelah gambar pertama, set sisanya bukan active
                }
            } else {
                echo "<p>No images found.</p>";
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</div>

<!-- Film Sedang Tayang Section -->
<?php
include 'koneksibioskop.php';

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query untuk mengambil data film yang sedang tayang
$query = mysqli_query($koneksi, "SELECT * FROM film WHERE jadwal >= CURDATE() ORDER BY jadwal ASC");
if (!$query) {
    die("Query failed: " . mysqli_error($koneksi));
}
?>

<h4 class="text-center fw-bold my-4" id="nowShowing">Now Showing</h4>
<div id="nowShowingCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $counter = 0; // Menghitung jumlah film yang ditampilkan
        $hasMovies = mysqli_num_rows($query) > 0; // Memastikan ada data film

        if ($hasMovies) {
            $active = true; // Menandakan item pertama sebagai aktif
            while ($data = mysqli_fetch_assoc($query)) {
                $poster = 'uploads/' . htmlspecialchars($data['poster'], ENT_QUOTES, 'UTF-8');
                $judul = htmlspecialchars($data['judul'], ENT_QUOTES, 'UTF-8');
                $genre = htmlspecialchars($data['genre'], ENT_QUOTES, 'UTF-8');

                // Logika untuk membagi film ke dalam grup carousel
                if ($counter % 5 == 0) {
                    if ($counter > 0) {
                        echo '</div></div>'; // Menutup grup sebelumnya
                    }
                    echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                    echo '<div class="d-flex justify-content-center flex-wrap">';
                    $active = false; // Hanya grup pertama yang aktif
                }
        ?>
                <div class="m-2" style="width: 220px;">
                    <div class="card">
                        <img src="<?php echo $poster; ?>" class="card-img-top img-fluid" alt="<?php echo $judul; ?>" />
                        <div class="card-body bg-light">
                            <h5 class="card-title"><?php echo $judul; ?></h5>
                            <p class="card-text"><?php echo $genre; ?></p>
                            <a href="pilih.php?id=<?php echo $data['id']; ?>&poster=<?php echo urlencode($data['poster']); ?>&judul=<?php echo urlencode($data['judul']); ?>" class="btn btn-warning">Book Now</a>
                        </div>
                    </div>
                </div>
        <?php
                $counter++;
            }
            echo '</div></div>'; // Menutup grup terakhir
        } else {
            // Tampilkan pesan jika tidak ada film yang sedang tayang
            echo '<div class="text-center p-4">No movies are currently showing.</div>';
        }
        ?>
    </div>

    <?php if ($hasMovies && $counter > 5): ?>
      <!-- Navigasi carousel -->
      <button class="carousel-control-prev" type="button" data-bs-target="#nowShowingCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#nowShowingCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    <?php endif; ?>
  </div>

  <?php
  // Menutup koneksi ke database setelah selesai
  mysqli_close($koneksi);
  ?>


  <!-- Tambahkan modal -->
  <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="trailerModalLabel">Trailer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Video YouTube -->
          <div class="ratio ratio-16x9">
            <iframe id="trailerVideo" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Film Coming Soon Section -->
<?php
include 'koneksibioskop.php';

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query untuk mengambil data film yang akan datang
$query = mysqli_query($koneksi, "SELECT * FROM coming_soon");
if (!$query) {
    die("Query failed: " . mysqli_error($koneksi));
}
?>

<h4 class="text-center fw-bold my-4" id="comingSoon">Coming Soon</h4>
<div id="comingSoonCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $counter = 0; // Menghitung jumlah film yang ditampilkan
        $hasMovies = mysqli_num_rows($query) > 0; // Memastikan ada data film

        if ($hasMovies) {
          $active = true; // Menandakan item pertama sebagai aktif
          while ($data = mysqli_fetch_assoc($query)) {
              $poster = 'uploads/' . htmlspecialchars($data['poster'], ENT_QUOTES, 'UTF-8');
              $judul = htmlspecialchars($data['judul'], ENT_QUOTES, 'UTF-8');
              $genre = htmlspecialchars($data['genre'], ENT_QUOTES, 'UTF-8');
                $trailerLink = htmlspecialchars($data['trailer'], ENT_QUOTES, 'UTF-8'); // Mengambil link trailer dari database

                // Logika untuk membagi film ke dalam grup carousel
                if ($counter % 5 == 0) {
                    if ($counter > 0) {
                        echo '</div></div>'; // Menutup grup sebelumnya
                    }
                    echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                    echo '<div class="d-flex justify-content-center flex-wrap">';
                    $active = false; // Hanya grup pertama yang aktif
                }
        ?>
                <div class="m-2" style="width: 220px;">
                    <div class="card">
                        <img src="<?php echo $poster; ?>" alt="<?php echo $judul; ?>" class="card-img-top img-fluid" />
                        <div class="card-body bg-light">
                            <h5 class="card-title"><?php echo $judul; ?></h5>
                            <p class="card-text"><?php echo $genre; ?></p>
                            <!-- Tombol Trailer yang memanggil modal dan menyisipkan link video -->
                            <a href="#" class="btn btn-warning trailer-btn" data-bs-toggle="modal" data-bs-target="#trailerModal" data-video="<?php echo $trailerLink; ?>">Trailer</a>
                        </div>
                    </div>
                </div>
        <?php
                $counter++;
            }
            echo '</div></div>'; // Menutup grup terakhir
        } else {
            // Tampilkan pesan jika tidak ada film yang akan datang
            echo '<div class="text-center p-4">No upcoming movies.</div>';
        }
        ?>
    </div>

    <?php if ($hasMovies && $counter > 5): ?>
        <!-- Navigasi carousel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#comingSoonCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#comingSoonCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    <?php endif; ?>
</div>

<?php
// Menutup koneksi ke database setelah selesai
mysqli_close($koneksi);
?>


  <script>
    // Script untuk mengupdate iframe video di modal
    // Script untuk mengupdate iframe video di modal
    var trailerBtns = document.querySelectorAll('.trailer-btn');
    trailerBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        var videoSrc = this.getAttribute('data-video');

        // Pastikan URL menggunakan format embed
        if (videoSrc.includes('youtube.com/watch?v=')) {
          var videoID = videoSrc.split('v=')[1];
          videoSrc = 'https://www.youtube.com/embed/' + videoID;
        }

        var trailerVideo = document.getElementById('trailerVideo');
        trailerVideo.src = videoSrc; // Mengubah src iframe dengan video link
      });
    });

    // Script untuk menutup modal dan menghapus src dari iframe (untuk menghentikan video)
    var trailerModal = document.getElementById('trailerModal');
    trailerModal.addEventListener('hidden.bs.modal', function() {
      var trailerVideo = document.getElementById('trailerVideo');
      trailerVideo.src = ''; // Menghapus src saat modal ditutup
    });
  </script>




  <!-- Footer -->
  <footer class="bg-dark text-white mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h4></h4>
          <br>
          <p class="justify-content-center">2024 All Rights Reserved.</p>
        </div>
        <div class="col-md-6">
          <br>
          <i class="bx bxl-instagram-alt" style="font-size: 26px;"><a href="https://www.instagram.com/" style="text-decoration: none; color: white; font-family: Poppins, sans-serif; margin-left: 5px;">Instagram</a></i> <i class='bx bxl-facebook' style="font-size: 26px; margin-left: 15px;"><a href="https://www.facebook.com/KOMPAScom" style="text-decoration: none; color: white; font-family: Poppins, sans-serif; margin-left: 2px;">Facebook</a></i>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {

      // Trailer Button Click Event
      const trailerButtons = document.querySelectorAll('.trailer-btn');
      const trailerVideo = document.getElementById('trailerVideo');
      const trailerModal = document.getElementById('trailerModal');

      if (trailerButtons.length > 0 && trailerVideo && trailerModal) {
        trailerButtons.forEach(button => {
          button.addEventListener('click', function() {
            const videoUrl = this.getAttribute('data-video');
            if (videoUrl) {
              trailerVideo.src = videoUrl;
            }
          });
        });

        // Bersihkan URL video saat modal ditutup
        trailerModal.addEventListener('hidden.bs.modal', function() {
          trailerVideo.src = '';
        });
      }
    });
  </script>
</body>

</html>