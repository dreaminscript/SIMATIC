<?php
require_once '../auth.php';
cek_akses('admin');
require_once '../koneksi.php';
$page = 'dashboard';

$q_user = mysqli_query($conn, "SELECT COUNT(id_user) AS total FROM users");
$t_user = mysqli_fetch_assoc($q_user)['total'] ?? 0;

$q_cuti = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti");
$t_cuti = mysqli_fetch_assoc($q_cuti)['total'] ?? 0;

$q_dosen = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Disetujui Dosen'");
$t_dosen = mysqli_fetch_assoc($q_dosen)['total'] ?? 0;

$q_kaprodi = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Disetujui Kaprodi'");
$t_kaprodi = mysqli_fetch_assoc($q_kaprodi)['total'] ?? 0;

$q_tu = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Dicetak'");
$t_tu = mysqli_fetch_assoc($q_tu)['total'] ?? 0;

$q_setuju = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Disetujui'");
$t_setuju = mysqli_fetch_assoc($q_setuju)['total'] ?? 0;

$q_tolak = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Ditolak'");
$t_tolak = mysqli_fetch_assoc($q_tolak)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            animation: fadeIn 0.5s ease-out;
            padding: 20px;
        }
        
        .card-stat {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            .card-body h4 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card card-stat mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-1 text-primary fw-bold">Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h4>
                <p class="text-muted mb-0">Selamat datang di halaman panel admin SIMATIC.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card card-stat text-center p-3 h-100 border-0 shadow-sm">
                    <h2 class="text-primary fw-bold mb-1"><?= $t_user ?></h2>
                    <span class="text-muted small fw-semibold">Total User</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-stat text-center p-3 h-100 border-0 shadow-sm">
                    <h2 class="text-primary fw-bold mb-1"><?= $t_cuti ?></h2>
                    <span class="text-muted small fw-semibold">Total Pengajuan</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="card card-stat text-center p-3 h-100 border-0 shadow-sm">
                    <h2 class="text-success fw-bold mb-1"><?= $t_dosen ?></h2>
                    <span class="text-muted small fw-semibold">Dosen<br>Disetujui</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="card card-stat text-center p-3 h-100 border-0 shadow-sm">
                    <h2 class="text-success fw-bold mb-1"><?= $t_kaprodi ?></h2>
                    <span class="text-muted small fw-semibold">Kaprodi<br>Disetujui</span>
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="card card-stat text-center p-3 h-100 border-0 shadow-sm">
                    <h2 class="text-secondary fw-bold mb-1"><?= $t_tu ?></h2>
                    <span class="text-muted small fw-semibold">TU<br>Dicetak</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="card card-stat text-center p-4 border-0 shadow-sm">
                    <h1 class="text-success fw-bold display-4"><?= $t_setuju ?></h1>
                    <span class="text-muted fs-5 fw-semibold">Disetujui</span>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card card-stat text-center p-4 border-0 shadow-sm">
                    <h1 class="text-danger fw-bold display-4"><?= $t_tolak ?></h1>
                    <span class="text-muted fs-5 fw-semibold">Ditolak</span>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>