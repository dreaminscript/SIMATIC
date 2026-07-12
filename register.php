<?php
include 'koneksi.php';

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if (empty($username) || empty($password) || empty($konfirmasi_password)) {
        $error = "Semua harus diisi!";
    } 
    
    elseif ($password !== $konfirmasi_password) {
        $error = "Password tidak cocok!";
    } else {
        $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek_user) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$password_hashed')";
            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil! Silakan login";
            } else {
                $error = "Pendaftaran gagal, silahkan coba lagi";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>REGISTER - SIMATIC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        <div class="title">SIMATIC</div>
        <div class="subtitle">Daftarkan akun Anda!</div>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="alert alert-success"><?= $success; ?></div>
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

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" placeholder="Ulangi password" required>
            </div>

            <button type="submit" name="register" class="btn btn-red">Daftar</button>
        </form>

        <div class="footer-text">
            Sudah punya akun? <a href="login.php" style="color: #d32f2f;">Silakan login</a>
        </div>
    </div>

</body>
</html>