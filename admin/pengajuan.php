<?php
require_once '../auth.php';
cek_akses('admin');
require_once '../koneksi.php';
$page = 'pengajuan';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengajuan - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h4 class="mb-4 fw-bold">Data Pengajuan</h4>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-stat text-center p-4">
                    <h2 class="text-success fw-bold">1</h2>
                    <span class="text-muted">Disetujui</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat text-center p-4">
                    <h2 class="text-danger fw-bold">1</h2>
                    <span class="text-muted">Ditolak</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat text-center p-4">
                    <h2 class="text-secondary fw-bold">0</h2>
                    <span class="text-muted">Dicetak</span>
                </div>
            </div>
        </div>

        <div class="card card-stat p-3">
            <p class="text-muted text-center my-3">Tabel detail pengajuan cuti akan tampil di sini.</p>
        </div>
    </div>

</body>

</html>