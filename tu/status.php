<?php
require_once '../auth.php';
cek_akses('tu');
require_once '../koneksi.php';
$page = 'status';

$query = mysqli_query($conn, "SELECT * FROM cuti ORDER BY tanggal_pengajuan DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan Cuti - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            animation: fadeIn 0.5s ease-out;
        }

        .table-responsive {
            border-radius: 10px;
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
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-0 text-dark fw-bold">Semua Riwayat Pengajuan Cuti</h4>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%" class="text-start">Nama Mahasiswa</th>
                            <th width="15%">NIM</th>
                            <th width="15%">Mulai Cuti</th>
                            <th width="15%">Selesai Cuti</th>
                            <th width="15%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                $status = $row['status'];

                                if ($status == 'Menunggu Dosen' || $status == 'Menunggu Kaprodi') {
                                    $badge = 'bg-warning text-dark';
                                } elseif (strpos($status, 'Ditolak') !== false) {
                                    $badge = 'bg-danger';
                                } elseif ($status == 'Diproses TU' || $status == 'Disetujui' || $status == 'Dicetak') {
                                    $badge = 'bg-success';
                                } else {
                                    $badge = 'bg-info text-dark';
                                }
                        ?>
                                <tr>
                                    <td class="text-muted fw-semibold">#<?= htmlspecialchars($row['id_cuti']); ?></td>
                                    <td class="text-start fw-bold"><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['nim']); ?></td>
                                    <td><?= date('d M Y', strtotime($row['tanggal_mulai'])); ?></td>
                                    <td><?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></td>
                                    <td>
                                        <span class="badge <?= $badge ?> w-100 py-2 fs-6 text-capitalize"><?= htmlspecialchars($status != '' ? $status : 'Error/Kosong'); ?></span>
                                    </td>
                                    <td>
                                        <?php if ($status == 'Diproses TU' || $status == 'Disetujui' || $status == 'Dicetak'): ?>
                                            <a href="cetak.php?id=<?= $row['id_cuti']; ?>" class="btn btn-sm btn-outline-primary fw-bold px-3">Cetak Surat</a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">Belum Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7" class="py-5 text-muted fw-semibold">Belum ada data pengajuan cuti.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>