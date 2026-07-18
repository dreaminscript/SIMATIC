<?php
require_once '../auth.php';
cek_akses('admin');
require_once '../koneksi.php';
$page = 'pengajuan';

$q_setuju = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Disetujui'");
$t_setuju = mysqli_fetch_assoc($q_setuju)['total'] ?? 0;

$q_tolak = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status IN ('Ditolak Dosen', 'Ditolak Kaprodi')");
$t_tolak = mysqli_fetch_assoc($q_tolak)['total'] ?? 0;

$q_cetak = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status = 'Dicetak'");
$t_cetak = mysqli_fetch_assoc($q_cetak)['total'] ?? 0;

$query_data = "SELECT * FROM cuti ORDER BY tanggal_pengajuan DESC";
$result_data = mysqli_query($conn, $query_data);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengajuan - SIMATIC</title>
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
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        .table-responsive {
            border-radius: 12px;
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
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h4 class="mb-4 fw-bold text-dark">Data Pengajuan Cuti</h4>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-stat text-center p-4 h-100">
                    <h2 class="text-success fw-bold"><?= $t_setuju ?></h2>
                    <span class="text-muted fw-semibold">Disetujui</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat text-center p-4 h-100">
                    <h2 class="text-danger fw-bold"><?= $t_tolak ?></h2>
                    <span class="text-muted fw-semibold">Ditolak</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat text-center p-4 h-100">
                    <h2 class="text-secondary fw-bold"><?= $t_cetak ?></h2>
                    <span class="text-muted fw-semibold">Dicetak</span>
                </div>
            </div>
        </div>

        <div class="card card-stat p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%" class="text-start">Nama / NIM</th>
                            <th width="15%">Tgl Pengajuan</th>
                            <th width="15%">Periode Cuti</th>
                            <th width="20%" class="text-start">Alasan</th>
                            <th width="15%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result_data) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result_data)):
                                $status = $row['status'];

                                if ($status == 'Disetujui') {
                                    $badge_class = 'bg-success';
                                } elseif (strpos($status, 'Ditolak') !== false) {
                                    $badge_class = 'bg-danger';
                                } elseif ($status == 'Dicetak' || $status == 'Selesai') {
                                    $badge_class = 'bg-secondary';
                                } else {
                                    $badge_class = 'bg-warning text-dark';
                                }
                        ?>
                                <tr>
                                    <td class="text-muted fw-semibold"><?= $no++ ?></td>
                                    <td class="text-start">
                                        <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
                                        <span class="text-muted small"><?= htmlspecialchars($row['nim']) ?></span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                    <td>
                                        <span class="text-primary fw-semibold"><?= date('d M Y', strtotime($row['tanggal_mulai'])) ?></span> <br> s/d <br>
                                        <span class="text-danger fw-semibold"><?= date('d M Y', strtotime($row['tanggal_selesai'])) ?></span>
                                    </td>
                                    <td class="text-start text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($row['alasan']) ?>">
                                        <?= htmlspecialchars($row['alasan']) ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $badge_class ?> w-100 py-2 fs-6 text-capitalize">
                                            <?= htmlspecialchars($status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="hapus_pengajuan.php?id=<?= $row['id_cuti'] ?>" class="btn btn-sm btn-outline-danger fw-bold px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengajuan cuti ini secara permanen?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                            endwhile;
                        } else {
                            ?>
                            <tr>
                                <td colspan="7" class="py-5 text-muted text-center fw-semibold">Belum ada data pengajuan cuti saat ini.</td>
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