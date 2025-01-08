<!-- 
//nama file    : profile.php
//deskripsi    : file untuk menampilkan profile pengguna
//dibuat oleh  : Rafles Yuda Stevenses - NIM : 3312401062
//tanggal      : 19 Desember 2024 - 29 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php';

// Jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

$email = $_SESSION['email'];
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {
      background-color: #eaeaea;
      color: white;
    }

.card {
  border: 2px solid white;
  box-shadow: -2px 3px 10px -5px rgba(0, 0, 0, 0.75);
  -webkit-box-shadow: -2px 3px 10px -5px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: -2px 3px 10px -5px rgba(0, 0, 0, 0.75);
}

    .card-header {
      background-color: gray;
      color: white;
    }

    .card-body {
      background-color: gray;
      border-radius: 5px;
    }

    table {
      width: 50%;
    }

    table td {
      padding: 9px;
    }

    table b {
      color: white;
    }

    .btn-custom {
      background-color: #f39c12;
      color: white;
      border: none;
    }

    .btn-custom:hover {
      background-color: #ffc107;
      color: #fff;
    }

    .btn-back {
      position: absolute;
      top: 20px;
      left: 20px;
      background-color: #f39c12;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
    }

    .btn-back:hover {
      background-color: #ffc107;
      color: white;
    }
  </style>
</head>

<body>

  <!-- Tombol Back -->
  <a href="bioskop.php" class="btn-back">
    <i class='bx bx-arrow-back'></i>
  </a>

  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center">
            <h4>Profil Pengguna</h4>
          </div>
          <div class="card-body">
            <table>
              <tr>
                <td><b>Email</b></td>
                <td>: </td>
                <td><?php echo $data['email']; ?></td>
              </tr>
              <tr>
                <td><b>Username</b></td>
                <td>: </td>
                <td><?php echo $data['username']; ?></td>
              </tr>
              <tr>
                <td><b>Nama Lengkap</b></td>
                <td>: </td>
                <td><?php echo $data['nama_lengkap']; ?></td>
              </tr>
              <tr>
                <td><b>No.Handphone</b></td>
                <td>: </td>
                <td><?php echo $data['no_hp']; ?></td>
              </tr>
            </table>
            <br>
            <br>
            <br>
            <!-- Tombol Edit Profil -->
            <div class="text-center mt-4">
              <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#editProfileModal"><b>Edit Profil</b></button>
            </div>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Profil -->
  <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="editProfileModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="post" action="edit_profile.php">
    <div class="mb-3">
        <label for="username" class="form-label text-dark">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label text-dark">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru (opsional)">
    </div>

    <div class="mb-3">
        <label for="nama_lengkap" class="form-label text-dark">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" required>
    </div>

    <div class="d-grid gap-2 mb-2">
        <button type="submit" class="btn btn-warning">Update Profil</button>
    </div>
</form>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>