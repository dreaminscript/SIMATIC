<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD - SIMATIC</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f6f9; }
        .wrapper { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .menu-box { background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .logout-btn { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="wrapper">
    <h1>Selamat Datang, <?= $_SESSION['username']; ?>!</h1>

    <?php if ($role == 'mahasiswa') : ?>
        <div class="menu-box">
            <h3>Selamat Datang, <?= $_SESSION['username']; ?>!</h3>
            <ul>
                <li></li><a href="#">Dashboard</a></li>
                <li><a href="#">Ajukan Cuti</a></li>
                <li><a href="#">Riwayat Lengkap</a></li>
            </ul>
        </div>

    <?php elseif ($role == 'dosen') : ?>
        <div class="menu-box" style="background-color: #e8f5e9;">
            <h3>Selamat Datang, <?= $_SESSION['username']; ?>!</h3>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Daftar Cuti Mahasiswa</a></li>
            </ul>
        </div>

    <?php elseif ($role == 'kaprodi') : ?>
        <div class="menu-box" style="background-color: #fff3e0;">
            <h3>Selamat Datang, <?= $_SESSION['username']; ?>!</h3>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Persetujuan Cuti</a></li>
            </ul>
        </div>

    <?php elseif ($role == 'tu') : ?>
        <div class="menu-box" style="background-color: #f3e5f5;">
            <h3>Selamat Datang, <?= $_SESSION['username']; ?>!</h3>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Status Pengajuan Cuti</a></li>
            </ul>
        </div>

    <?php elseif ($role == 'admin') : ?>
        <div class="menu-box" style="background-color: #ffebee;">
            <h3>Selamat Datang, <?= $_SESSION['username']; ?>!</h3>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Data Pengajuan Cuti</a></li>
                <li><a href="#">Data Pengguna</a></li>
            </ul>
        </div>
    
    <?php endif; ?>

    <br><br>
    <a href="logout.php" class="logout-btn">Keluar dari Aplikasi</a>
</div>

</body>
</html>