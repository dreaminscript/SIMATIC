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
                $_SESSION['id_user'] = $row['id_user']; 

                switch ($row['role']) {
                    case 'admin':
                        header("Location: admin/dashboard.php");
                        break;
                    case 'mahasiswa':
                        header("Location: mahasiswa/dashboard.php");
                        break;
                    case 'dosen':
                        header("Location: dosen/dashboard.php");
                        break;
                    case 'kaprodi':
                        header("Location: kaprodi/dashboard.php");
                        break;
                    case 'tu':
                        header("Location: tu/dashboard.php");
                        break;
                    default:
                        $error = "Role tidak dikenali, hubungi admin.";
                        break;
                }
                exit;
            }
        }
        $error = "Username atau Password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - SIMATIC</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="card">
        <div class="title">SIMATIC</div>
        <div class="subtitle">Sistem Informasi Penangguhan Akademik dan Cuti</div>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST" id="loginForm">
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

            <button type="submit" name="login" class="btn btn-blue" id="loginBtn">Login</button>
        </form>

        <div class="footer-text">
            Belum punya akun? <a href="register.php" style="color: #0022ff;">Daftar sekarang</a>
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

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = 'Memproses...';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'not-allowed';
        });
    </script>
</body>
</html>