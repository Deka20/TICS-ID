<!-- 
//nama file : login.php
//deskripsi : file ini untuk login pengguna
//dibuat oleh: Zidan Masadita Pramudia - NIM : 3312401083
//tanggal    : 23 November 2024 - 31 Desember 2024 
-->


<?php
session_start();
include 'koneksibioskop.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menghindari SQL Injection
    $username = mysqli_real_escape_string($koneksi, $username);

    // Query untuk mencari pengguna berdasarkan username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    // Cek apakah data ditemukan
    if ($row) {
        // Verifikasi password menggunakan password_verify()
        if (password_verify($password, $row['password'])) {
            // Jika password cocok, simpan session
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email']; // Menyimpan email ke session

            // Redirect ke halaman profil atau halaman lain setelah login berhasil
            header("Location: bioskop.php");
            exit();
        } else {
            // Jika password salah
            $error = "Username atau password salah.";
        }
    } else {
        // Jika username tidak ditemukan
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TICS ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .custom-alert {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body style="background-color: gray;">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; border-radius: 30px; background-color: #333; border: solid white 2px;">
            <h1 class="text-center mb-4 text-light">Login</h1>

            <?php
            // Menampilkan pesan error jika ada
            if (isset($error)) {
                echo "<div class='alert alert-danger custom-alert'>$error</div>";
            }
            ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="username" class="form-label text-light">Username</label>
                    <input type="text" class="form-control" id="username" name="username" style="border-radius: 20px;" required>
                    <i class="bx bxs-user" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px;"></i>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-light">Password</label>
                    <input type="password" class="form-control" id="password" name="password" style="border-radius: 20px;" required>
                    <i class="bx bxs-lock"  style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px;"></i>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="form-check" style="margin-bottom: 0;">
        <input type="checkbox" id="remember" name="remember" class="form-check-input">
        <label for="remember" class="form-check-label text-light">Remember me</label>
    </div>
    <div>
        <a href="login-admin.php" style="color: white; text-decoration: none;">Admin? Login </a>
    </div>
</div>

                <div class="d-grid gap-2 mb-2">
                    <button type="submit" class="btn btn-light" style="border-radius: 20px; border: solid 2px;"><b>Login</b></button>
                </div>
                <div class="mb-2 text-light">
                    <p>Don't have an account? <a href="register.php" style="color: white;">Register</a></p>
                </div>
            </form>
        </div>
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>