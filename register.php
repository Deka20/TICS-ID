<!-- 
//nama file : register.php
//deskripsi : file ini untuk regis pengguna
//dibuat oleh: Zidan Masadita Pramudia - NIM : 3312401083
//tanggal    : 19 Desember 2024 - 31 Desember 2024 
-->


<?php
session_start();

// Menyertakan file koneksi
include('koneksibioskop.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | TICS ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    </style>
</head>

<body style="background-color: gray;">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; border-radius: 30px; background-color: #333; border: solid white 2px;">
            <h1 class="text-center mb-4 text-light">Register</h1>

            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            ?>

            <form method="POST" action="tambah_user.php">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label text-light">Full Name</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" style="border-radius: 20px; background: transparent; color: white;" required>
                    <i class="bx bxs-user" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px; color: white;"></i>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label text-light">Username</label>
                    <input type="text" class="form-control" id="username" name="username" style="border-radius: 20px; background: transparent; color: white;" required>
                    <i class="bx bxs-user" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px; color: white;"></i>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-light">Email</label>
                    <input type="text" class="form-control" id="email" name="email" style="border-radius: 20px; background: transparent; color: white;" required>
                    <i class="bx bxl-gmail" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px; color: white;"></i>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label text-light">Phone Number</label>
                    <input type="number" class="form-control" id="no_hp" name="no_hp" style="border-radius: 20px; background: transparent; color: white;" required>
                    <i class="bx bxs-phone" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px; color: white;"></i>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label text-light">Password</label>
                    <input type="password" class="form-control" id="password" name="password" style="border-radius: 20px; background: transparent; color: white;" required>
                    <i class="bx bxs-lock" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px; color: white;"></i>
                </div>
                <div class="d-grid gap-2 mb-2">
                    <button type="submit" class="btn btn-light" style="border-radius: 20px; border: solid 2px; height: 40px;"><b>Register</b></button>
                </div>
                <div class="mb-2">
                    <p class="text-light">Already have an account? <a href="login.php" style="color: white;">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>