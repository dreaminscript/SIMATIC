<?php
require_once '../auth.php';
cek_akses('mahasiswa');
require_once '../koneksi.php';
$current_page = 'riwayat.php';

if (!isset($_GET['id'])) {
    header("Location: riwayat.php");
    exit;
}

$username = $_SESSION['username'];
$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);
$id_user = $dataUser['id_user'];

$id = intval($_GET['id']);

$query = mysqli_query($conn, "
    SELECT *
    FROM cuti
    WHERE id_cuti = '$id'
    AND id_user = '$id_user'
");

if (mysqli_num_rows($query) == 0) {
    echo "<!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Data Tidak Ditemukan</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>body { background-color: #f4f7f6; }</style>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak!',
                text: 'Data tidak ditemukan atau bukan milik Anda.',
                confirmButtonColor: '#0d6efd'
            }).then(() => {
                window.location = 'riwayat.php';
            });
        </script>
    </body>
    </html>";
    exit;
}

$data = mysqli_fetch_assoc($query);
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
            padding: 30px;
            overflow-y: auto;
            animation: fadeIn 0.5s ease-out;
        }

        .detail-label {
            width: 35%;
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
                width: 45%;
            }
        }
    </style>
</head>

<body>

    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary fw-bold">Detail Pengajuan Cuti</h4>
                <span class="badge <?= $badge ?> px-3 py-2 fs-6 text-capitalize"><?= htmlspecialchars($status); ?></span>
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
                        <td class="detail-value pb-3">
                            <span class="text-primary fw-semibold"><?= date('d F Y', strtotime($data['tanggal_mulai'])); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">Tanggal Selesai</td>
                        <td class="detail-value pb-3">
                            <span class="text-danger fw-semibold"><?= date('d F Y', strtotime($data['tanggal_selesai'])); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-label pb-3">Surat Pendukung</td>
                        <td class="detail-value pb-3">
                            <?php if (!empty($data['surat'])): ?>
                                <a href="../assets/uploads/<?= htmlspecialchars($data['surat']); ?>" target="_blank" class="text-decoration-none fw-bold text-primary d-inline-flex align-items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    Lihat Dokumen
                                </a>
                            <?php else: ?>
                                <span class="text-muted fst-italic">Tidak melampirkan file</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <?php if (!empty($data['catatan'])): ?>
                        <tr>
                            <td class="detail-label pt-3 border-top">Catatan Penolakan</td>
                            <td class="detail-value pt-3 border-top">
                                <div class="alert alert-danger mb-0">
                                    <?= nl2br(htmlspecialchars($data['catatan'])); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="card-footer bg-light p-4 border-top">
                <a href="riwayat.php" class="btn btn-secondary fw-bold px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16" style="vertical-align: text-bottom;">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>