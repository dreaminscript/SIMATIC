<?php
require_once '../auth.php';
cek_akses('kaprodi');
require_once '../koneksi.php';
$page = 'pengajuan';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM cuti WHERE id_cuti='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

$status = $data['status'];
if ($status == 'Menunggu Dosen') {
    $badge = 'bg-warning text-dark';
} elseif ($status == 'Menunggu Kaprodi' || $status == 'Diproses...') {
    $badge = 'bg-info text-dark';
} elseif ($status == 'Cuti Diterima' || $status == 'Dicetak' || $status == 'Selesai') {
    $badge = 'bg-success';
} elseif (strpos($status, 'Ditolak') !== false) {
    $badge = 'bg-danger';
} else {
    $badge = 'bg-primary';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SIMATIC</title>
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

        .detail-label {
            width: 30%;
            color: #6c757d;
            font-weight: 600;
        }

        .detail-value {
            font-weight: 500;
            color: #2b2f32;
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

            .detail-label {
                width: 40%;
            }

            .action-group {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-header bg-white border-bottom p-4">
                <h4 class="mb-0 text-primary fw-bold">Detail Pengajuan Cuti</h4>
            </div>

            <div class="card-body p-4">
                <table class="table table-borderless align-middle mb-0">
                    <tr>
                        <td class="detail-label pb-3">Nama Mahasiswa</td>
                        <td class="detail-value pb-3 fs-5"><?= htmlspecialchars($data['nama']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">NIM</td>
                        <td class="detail-value pb-3"><?= htmlspecialchars($data['nim']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">Alasan Cuti</td>
                        <td class="detail-value pb-3 text-break"><?= nl2br(htmlspecialchars($data['alasan'])); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">Tanggal Mulai</td>
                        <td class="detail-value pb-3"><?= date('d F Y', strtotime($data['tanggal_mulai'])); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">Tanggal Selesai</td>
                        <td class="detail-value pb-3"><?= date('d F Y', strtotime($data['tanggal_selesai'])); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">File Surat</td>
                        <td class="detail-value pb-3">
                            <?php if (!empty($data['surat'])): ?>
                                <a href="../assets/uploads/<?= htmlspecialchars($data['surat']); ?>" target="_blank" class="text-decoration-none fw-bold text-primary">Lihat Dokumen</a>
                            <?php else: ?>
                                <span class="text-muted fst-italic">Tidak ada lampiran</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label">Status Saat Ini</td>
                        <td class="detail-value">
                            <span class="badge <?= $badge ?> px-3 py-2 fs-6 text-capitalize"><?= htmlspecialchars($status); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer bg-light p-4 border-top d-flex justify-content-between align-items-center">
                <a href="dashboard.php" class="btn btn-secondary fw-bold px-4">Kembali</a>

                <?php if ($status == 'Menunggu Kaprodi'): ?>
                    <div class="d-flex gap-2 action-group">
                        <a href="setujui.php?id=<?= $data['id_cuti']; ?>" class="btn btn-success fw-bold px-4" onclick="return confirm('Setujui pengajuan ini?');">Setujui</a>
                        <a href="tolak.php?id=<?= $data['id_cuti']; ?>" class="btn btn-danger fw-bold px-4">Tolak</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>