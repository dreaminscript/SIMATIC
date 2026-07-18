<?php
require_once '../auth.php';
cek_akses('mahasiswa');
require_once '../koneksi.php';
$page = 'dashboard';

$username = $_SESSION['username'];
$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);
$id_user = $dataUser['id_user'];

$q_total = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE id_user='$id_user'");
$total = mysqli_fetch_assoc($q_total)['total'] ?? 0;

$q_menunggu = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE id_user='$id_user' AND status='Menunggu Dosen'");
$menunggu = mysqli_fetch_assoc($q_menunggu)['total'] ?? 0;

$q_disetujui = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE id_user='$id_user' AND status IN ('Menunggu Kaprodi', 'Dicetak', 'Selesai')");
$disetujui = mysqli_fetch_assoc($q_disetujui)['total'] ?? 0;

$q_ditolak = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE id_user='$id_user' AND status IN ('Ditolak Dosen','Ditolak Kaprodi')");
$ditolak = mysqli_fetch_assoc($q_ditolak)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            animation: fadeIn 0.5s ease-out;
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
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card card-stat mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-1 text-primary fw-bold">Selamat Datang, <?= htmlspecialchars($username); ?> 👋</h4>
                <p class="text-muted mb-0">Sistem Informasi Penangguhan Akademik dan Cuti (SIMATIC). Pantau status pengajuan cuti Anda di sini.</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-primary fw-bold mb-1"><?= $total; ?></h2>
                    <span class="text-muted fw-semibold">Total Pengajuan</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-warning fw-bold mb-1"><?= $menunggu; ?></h2>
                    <span class="text-muted fw-semibold">Menunggu Dosen</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-success fw-bold mb-1"><?= $disetujui; ?></h2>
                    <span class="text-muted fw-semibold">Disetujui/Proses</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-danger fw-bold mb-1"><?= $ditolak; ?></h2>
                    <span class="text-muted fw-semibold">Ditolak</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>