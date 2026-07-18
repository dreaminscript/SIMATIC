<?php
require_once '../auth.php';
cek_akses('tu');
require_once '../koneksi.php';
$page = 'dashboard';

$q_total = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti");
$total = mysqli_fetch_assoc($q_total)['total'] ?? 0;

$q_menunggu = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status IN ('Menunggu Dosen', 'Menunggu Kaprodi')");
$menunggu = mysqli_fetch_assoc($q_menunggu)['total'] ?? 0;

$q_diproses = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status IN ('Diproses TU', 'Dicetak', 'Disetujui')");
$diproses = mysqli_fetch_assoc($q_diproses)['total'] ?? 0;

$query = mysqli_query($conn, "SELECT * FROM cuti WHERE status='Diproses TU' ORDER BY tanggal_pengajuan ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tata Usaha - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            animation: fadeIn 0.5s ease-out;
        }

        .card-stat {
            transition: all 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
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
        <div class="card card-stat mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-1 text-dark fw-bold">Selamat Datang, Bagian Tata Usaha 👋</h4>
                <p class="text-muted mb-0">Kelola dan cetak surat keterangan cuti akademik mahasiswa di sini.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-primary fw-bold mb-1"><?= $total; ?></h2>
                    <span class="text-muted fw-semibold">Total Pengajuan Masuk</span>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-warning fw-bold mb-1"><?= $menunggu; ?></h2>
                    <span class="text-muted fw-semibold">Menunggu Dosen/Kaprodi</span>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-success fw-bold mb-1"><?= $diproses; ?></h2>
                    <span class="text-muted fw-semibold">Siap Cetak / Selesai</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white p-3 border-bottom">
                <h5 class="mb-0 fw-bold text-dark">Antrean Siap Cetak Surat</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="35%" class="text-start">Nama / NIM</th>
                            <th width="25%">Tanggal Pengajuan</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td class="fw-semibold">#<?= htmlspecialchars($row['id_cuti']); ?></td>
                                    <td class="text-start">
                                        <strong><?= htmlspecialchars($row['nama']); ?></strong><br>
                                        <span class="text-muted small"><?= htmlspecialchars($row['nim']); ?></span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                                    <td>
                                        <a href="cetak.php?id=<?= $row['id_cuti']; ?>" class="btn btn-sm btn-primary fw-bold px-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-1" viewBox="0 0 16 16" style="vertical-align: text-bottom;">
                                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                            </svg>
                                            Cetak Surat
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" class="py-5 text-muted fw-semibold">Belum ada pengajuan yang siap dicetak.</td>
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