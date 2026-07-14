<?php
require_once '../auth.php';
cek_akses('admin');
require_once '../koneksi.php';
$page = 'dashboard';

$q_user = mysqli_query($conn, "SELECT COUNT(id) AS total FROM users");
$t_user = mysqli_fetch_assoc($q_user)['total'];

$q_cuti = mysqli_query($conn, "SELECT COUNT(id) AS total FROM cuti");
$t_cuti = mysqli_fetch_assoc($q_cuti)['total'];

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card card-stat mb-4">
            <div class="card-body p-4">
                <h4 class="mb-1 text-primary">Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h4>
                <p class="text-muted mb-0">Selamat datang di halaman panel admin SIMATIC.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-stat text-center p-3 h-100">
                    <h2 class="text-primary fw-bold"><?= $t_user ?></h2>
                    <span class="text-muted">Total User</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat text-center p-3 h-100">
                    <h2 class="text-primary fw-bold"><?= $t_cuti ?></h2>
                    <span class="text-muted">Total Pengajuan</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-stat text-center p-3 h-100">
                    <h2 class="text-success fw-bold">3</h2>
                    <span class="text-muted small">Dosen<br>Disetujui</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-stat text-center p-3 h-100">
                    <h2 class="text-success fw-bold">2</h2>
                    <span class="text-muted small">Kaprodi<br>Disetujui</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-stat text-center p-3 h-100">
                    <h2 class="text-secondary fw-bold">0</h2>
                    <span class="text-muted small">TU<br>Dicetak</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card card-stat text-center p-4">
                    <h1 class="text-success fw-bold">1</h1>
                    <span class="text-muted fs-5">Disetujui</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-stat text-center p-4">
                    <h1 class="text-danger fw-bold">1</h1>
                    <span class="text-muted fs-5">Ditolak</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>