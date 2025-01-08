<!-- 
//nama file  : search.php
//deskripsi  : file ini untuk fitur pencarian film sesuai genre atau judul
//dibuat oleh : Rafles Yuda Stevenses Nababan - NIM: 3312401062
//tanggal     : 23 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bioskop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? $_GET['query'] : '';

if ($query != '') {
  // Mencari film now showing
  $sql_now_showing = "SELECT * FROM film WHERE judul LIKE ? OR genre LIKE ?";
  $stmt_now_showing = $conn->prepare($sql_now_showing);
  $search_term = "%$query%";
  $stmt_now_showing->bind_param("ss", $search_term, $search_term);
  $stmt_now_showing->execute();
  $result_now_showing = $stmt_now_showing->get_result();

  // Mencari film coming soon
  $sql_coming_soon = "SELECT * FROM coming_soon WHERE judul LIKE ? OR genre LIKE ?";
  $stmt_coming_soon = $conn->prepare($sql_coming_soon);
  $stmt_coming_soon->bind_param("ss", $search_term, $search_term);
  $stmt_coming_soon->execute();
  $result_coming_soon = $stmt_coming_soon->get_result();
} else {
  $result_now_showing = null;
  $result_coming_soon = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #f8f9fa;
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
<br>
  <div class="container mt-5">
    <h3>Search Results for "<?php echo htmlspecialchars($query); ?>"</h3>
    <!-- Section Sedang Tayang -->
    <h4 class="mt-5">Now Showing</h4>
    <div class="row">
      <?php if ($result_now_showing && $result_now_showing->num_rows > 0): ?>
        <?php while ($row = $result_now_showing->fetch_assoc()): ?>
          <div class="col-md-2">
            <div class="card mb-4">
              <img class="card-img-top" src="uploads/<?php echo $row['poster']; ?>" alt="Movie Poster">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                <a href="pilih.php?id=<?php echo $row['id']; ?>&poster=<?php echo urlencode($row['poster']); ?>&judul=<?php echo urlencode($row['judul']); ?>" class="btn btn-warning">Book Now</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No movies currently showing found.</p>
      <?php endif; ?>
    </div>

    <!-- Section Coming Soon -->
    <h4 class="mt-5">Coming Soon</h4>
    <div class="row">
      <?php if ($result_coming_soon && $result_coming_soon->num_rows > 0): ?>
        <?php while ($row = $result_coming_soon->fetch_assoc()): ?>
          <div class="col-md-2">
            <div class="card mb-4">
              <img class="card-img-top" src="uploads/<?php echo $row['poster']; ?>" alt="Movie Poster">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                <a href="#" class="btn btn-warning trailer-btn" data-bs-toggle="modal" data-bs-target="#trailerModal" data-video="<?php echo $row['trailer']; ?>">Trailer</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No upcoming movies found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Modal untuk Trailer -->
  <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="trailerModalLabel">Trailer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="ratio ratio-16x9">
            <iframe id="trailerVideo" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var trailerBtns = document.querySelectorAll('.trailer-btn');
    trailerBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        var videoSrc = this.getAttribute('data-video');
        if (videoSrc.includes('youtube.com/watch?v=')) {
          var videoID = videoSrc.split('v=')[1];
          videoSrc = 'https://www.youtube.com/embed/' + videoID;
        }
        var trailerVideo = document.getElementById('trailerVideo');
        trailerVideo.src = videoSrc;
      });
    });

    var trailerModal = document.getElementById('trailerModal');
    trailerModal.addEventListener('hidden.bs.modal', function() {
      var trailerVideo = document.getElementById('trailerVideo');
      trailerVideo.src = '';
    });
  </script>

</body>
</html>

<?php
$conn->close();
?>