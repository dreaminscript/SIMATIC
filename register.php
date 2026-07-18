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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - SIMATIC</title>
    <link rel="stylesheet" href="assets/css/style.css">
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

        <form action="" method="POST" id="registerForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="konfirmasi_password">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('konfirmasi_password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>

            <button type="submit" name="register" class="btn btn-red" id="registerBtn">Daftar</button>
        </form>

        <div class="footer-text">
            Sudah punya akun? <a href="login.php" style="color: #d32f2f;">Silakan login</a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const passInput = document.getElementById(inputId);
            
            const iconEye = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
            
            const iconEyeOff = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;

            if (passInput.type === 'password') {
                passInput.type = 'text';
                btn.innerHTML = iconEyeOff;
                btn.classList.add('active');
            } else {
                passInput.type = 'password';
                btn.innerHTML = iconEye;
                btn.classList.remove('active');
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            btn.innerHTML = 'Memproses...';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'not-allowed';
        });
    </script>
</body>
</html>