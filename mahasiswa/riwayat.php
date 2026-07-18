<?php
require_once '../auth.php';
cek_akses('mahasiswa');
require_once '../koneksi.php';
$current_page = 'riwayat.php';

$username = $_SESSION['username'];
$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);
$id_user = $dataUser['id_user']; 

$query = mysqli_query($conn, "
    SELECT *
    FROM cuti
    WHERE id_user = '$id_user'
    ORDER BY tanggal_pengajuan DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; display: flex; min-height: 100vh; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; animation: fadeIn 0.5s ease-out; }
        .table-responsive { border-radius: 12px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) { .main-content { padding: 15px; } .action-btns { display: flex; flex-direction: column; gap: 5px; } }
    </style>
</head>
<body>

    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-primary fw-bold">Riwayat Pengajuan Cuti</h4>
            <a href="pengajuan.php" class="btn btn-primary fw-bold d-none d-md-inline-block">
                + Buat Pengajuan
            </a>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Tgl Pengajuan</th>
                            <th width="15%">Mulai Cuti</th>
                            <th width="15%">Selesai Cuti</th>
                            <th width="20%">Status</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if(mysqli_num_rows($query) > 0) {
                            while($row = mysqli_fetch_assoc($query)){
                                $status = $row['status'];
                                
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
                        <tr>
                            <td class="fw-semibold text-muted"><?= $no++; ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                            <td><span class="text-primary fw-semibold"><?= date('d M Y', strtotime($row['tanggal_mulai'])); ?></span></td>
                            <td><span class="text-danger fw-semibold"><?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></span></td>
                            <td>
                                <span class="badge <?= $badge ?> w-75 py-2 fs-6 text-capitalize"><?= htmlspecialchars($status); ?></span>
                            </td>
                            <td class="action-btns">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="detail.php?id=<?= $row['id_cuti']; ?>" class="btn btn-sm btn-outline-info fw-bold px-3">Detail</a>
                                    
                                    <?php if ($status == "Menunggu Dosen") { ?>
                                        <a href="hapus.php?id=<?= $row['id_cuti']; ?>" class="btn btn-sm btn-outline-danger fw-bold px-3" onclick="return confirm('Apakah Anda yakin ingin membatalkan dan menghapus pengajuan ini?');">Batalkan</a>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-outline-secondary fw-bold px-3" disabled title="Tidak dapat dibatalkan karena sedang/sudah diproses">Batalkan</button>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="6" class="py-5 text-muted fw-semibold">Belum ada riwayat pengajuan cuti yang Anda buat.</td>
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