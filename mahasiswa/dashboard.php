<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user
$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

    <div class="welcome">

        <h2>
            Selamat Datang,
            <?= htmlspecialchars($username); ?> 👋
        </h2>

        <p>
            Selamat datang di Sistem Informasi Penangguhan Akademik dan Cuti (SIMATIC).
            Silakan melakukan pengajuan cuti atau melihat riwayat pengajuan melalui menu di samping.
        </p>

    </div>

    <?php

    // Total = semua pengajuan milik user, apapun statusnya
    $total = mysqli_num_rows(mysqli_query($conn,
        "SELECT * FROM cuti WHERE user_id='".$dataUser['id']."'"
    ));

    // Menunggu = belum disentuh sama sekali (masih di tahap dosen)
    $menunggu = mysqli_num_rows(mysqli_query($conn,
        "SELECT * FROM cuti
        WHERE user_id='".$dataUser['id']."'
        AND status='Menunggu'"
    ));

    // Disetujui = sudah ada progress persetujuan (dosen/kaprodi/selesai)
    $disetujui = mysqli_num_rows(mysqli_query($conn,
        "SELECT * FROM cuti
        WHERE user_id='".$dataUser['id']."'
        AND status IN ('Disetujui Dosen','Disetujui Kaprodi','Selesai')"
    ));

    // Ditolak = ditolak di tahap manapun
    $ditolak = mysqli_num_rows(mysqli_query($conn,
        "SELECT * FROM cuti
        WHERE user_id='".$dataUser['id']."'
        AND status IN ('Ditolak Dosen','Ditolak Kaprodi')"
    ));

    ?>

    <div class="cards">

        <div class="card-item">
            <h3><?= $total; ?></h3>
            <p>Total Pengajuan</p>
        </div>

        <div class="card-item">
            <h3><?= $menunggu; ?></h3>
            <p>Menunggu</p>
        </div>

        <div class="card-item">
            <h3><?= $disetujui; ?></h3>
            <p>Disetujui</p>
        </div>

        <div class="card-item">
            <h3><?= $ditolak; ?></h3>
            <p>Ditolak</p>
        </div>

    </div>

</div>

</body>
</html>