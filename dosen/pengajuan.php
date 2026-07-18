<?php
require_once '../auth.php';
cek_akses('dosen');
require_once '../koneksi.php';
$page = 'pengajuan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; display: flex; min-height: 100vh; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-content { flex-grow: 1; padding: 20px; overflow-y: auto; animation: fadeIn 0.5s ease-out; }
        .table-responsive { border-radius: 10px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) { .main-content { padding: 15px; } .d-flex.gap-2 { flex-direction: column; } }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-0 text-primary fw-bold">Daftar Pengajuan Cuti</h4>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">NIM</th>
                            <th width="20%" class="text-start">Nama Mahasiswa</th>
                            <th width="20%" class="text-start">Alasan</th>
                            <th width="10%">Mulai</th>
                            <th width="10%">Selesai</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $data = mysqli_query($conn, "SELECT * FROM cuti ORDER BY tanggal_pengajuan DESC");

                        if (mysqli_num_rows($data) > 0) {
                            while ($d = mysqli_fetch_assoc($data)) {
                                $status = $d['status'];
                                
                                if ($status == 'Menunggu Dosen') { $badge = 'bg-warning text-dark'; }
                                elseif (strpos($status, 'Ditolak') !== false) { $badge = 'bg-danger'; }
                                elseif ($status == 'Menunggu Kaprodi' || $status == 'Diproses...') { $badge = 'bg-info text-dark'; }
                                else { $badge = 'bg-success'; }
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($d['nim']); ?></td>
                                    <td class="text-start fw-bold"><?= htmlspecialchars($d['nama']); ?></td>
                                    <td class="text-start text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($d['alasan']); ?>">
                                        <?= htmlspecialchars($d['alasan']); ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($d['tanggal_mulai'])); ?></td>
                                    <td><?= date('d M Y', strtotime($d['tanggal_selesai'])); ?></td>
                                    <td>
                                        <span class="badge <?= $badge ?> w-100 py-2 fs-6 text-capitalize"><?= htmlspecialchars($status); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="detail.php?id=<?= $d['id_cuti']; ?>" class="btn btn-sm btn-info text-white fw-bold px-3">Detail</a>
                                            
                                            <?php if ($status == 'Menunggu Dosen'): ?>
                                                <a href="setujui.php?id=<?= $d['id_cuti']; ?>" class="btn btn-sm btn-success fw-bold px-3" onclick="return confirm('Setujui pengajuan ini dan teruskan ke Kaprodi?');">Setujui</a>
                                                <a href="tolak.php?id=<?= $d['id_cuti']; ?>" class="btn btn-sm btn-danger fw-bold px-3">Tolak</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8" class="py-5 text-muted fw-semibold">Belum ada data pengajuan cuti.</td>
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