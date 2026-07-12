<?php
session_start();
include 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong!";
    } else {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                
                header("Location: dashboard.php");
                exit;
            }
        }
        $error = "Username atau Password salah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LOGIN - SIMATIC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="title">SIMATIC</div>
        <div class="subtitle">Sistem Informasi Penangguhan Akademik dan Cuti</div>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn btn-blue">Login</button>
        </form>

        <div class="footer-text">
            Belum punya akun? <a href="register.php" style="color: #0022ff;">Daftar sekarang</a>
        </div>
    </div>

</body>
</html>