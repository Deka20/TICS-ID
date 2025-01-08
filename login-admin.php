<!-- 
//nama file : login-admin.php
//deskripsi : file ini untuk login admin
//dibuat oleh: Zidan Masadita Pramudia - NIM : 3312401083
//tanggal    : 23 November 2024 - 31 Desember 2024 
-->


<?php
session_start();

// Menyertakan file koneksi
include('koneksibioskop.php');
$query = mysqli_query($koneksi, "SELECT * FROM administrator");

// Cek apakah form login disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil nilai input dari form
    $username_admin = $_POST['username_admin'];
    $password = $_POST['password'];
    $query = "SELECT * FROM administrator WHERE username_admin='$username_admin' AND password='$password'";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username_admin'] = $username_admin;
        header('Location: dashboard_bioskop.php');
    } else {
        // Jika username_admin dan password tidak cocok
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-dark">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; border-radius: 30px;">
            <h1 class="text-center mb-4">Login</h1>

            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="username_admin" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username_admin" name="username_admin" style="border-radius: 20px;" required>
                    <i class="bx bxs-user" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px;"></i>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" style="border-radius: 20px;" required>
                    <i class="bx bxs-lock" style="position: absolute; right: 10%; transform: translateY(-160%); opacity: 50%; font-size: 18px;"></i>
                </div>
                <div class="d-grid gap-2 mb-2">
                    <button type="submit" class="btn btn-warning" style="border-radius: 20px;">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>