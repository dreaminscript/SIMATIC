<?php
require_once '../auth.php';
cek_akses('dosen');
require_once '../koneksi.php';
$page = 'dashboard';

$q_jumlah = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti");
$jumlah = mysqli_fetch_assoc($q_jumlah)['total'] ?? 0;

$q_menunggu = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status='Menunggu Dosen'");
$menunggu = mysqli_fetch_assoc($q_menunggu)['total'] ?? 0;

$q_diproses = mysqli_query($conn, "SELECT COUNT(id_cuti) AS total FROM cuti WHERE status!='Menunggu Dosen'");
$diproses = mysqli_fetch_assoc($q_diproses)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; display: flex; min-height: 100vh; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-content { flex-grow: 1; padding: 20px; overflow-y: auto; animation: fadeIn 0.5s ease-out; }
        .card-stat { transition: all 0.3s ease; cursor: pointer; }
        .card-stat:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important; }
        .table-responsive { border-radius: 10px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) { .main-content { padding: 15px; } .d-flex.gap-2 { flex-direction: column; } }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card card-stat mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-1 text-primary fw-bold">Selamat Datang, <?= htmlspecialchars($_SESSION['username'] ?? 'Dosen') ?> 👋</h4>
                <p class="text-muted mb-0">Kelola persetujuan pengajuan cuti mahasiswa di sini.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-primary fw-bold mb-1"><?= $jumlah; ?></h2>
                    <span class="text-muted fw-semibold">Total Pengajuan</span>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-warning fw-bold mb-1"><?= $menunggu; ?></h2>
                    <span class="text-muted fw-semibold">Menunggu Persetujuan</span>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card card-stat text-center p-4 border-0 shadow-sm h-100">
                    <h2 class="text-success fw-bold mb-1"><?= $diproses; ?></h2>
                    <span class="text-muted fw-semibold">Sudah Diproses</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%" class="text-start">Nama / NIM</th>
                            <th width="20%">Status</th>
                            <th width="40%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = mysqli_query($conn, "SELECT * FROM cuti ORDER BY tanggal_pengajuan DESC");
                        if(mysqli_num_rows($data) > 0) {
                            while($d = mysqli_fetch_assoc($data)){
                                $status = $d['status'];
                                
                                if ($status == 'Menunggu Dosen') { $badge = 'bg-warning text-dark'; }
                                elseif (strpos($status, 'Ditolak') !== false) { $badge = 'bg-danger'; }
                                elseif ($status == 'Menunggu Kaprodi' || $status == 'Diproses...') { $badge = 'bg-info text-dark'; }
                                else { $badge = 'bg-success'; }
                        ?>
                        <tr>
                            <td class="text-muted fw-semibold">#<?= htmlspecialchars($d['id_cuti']); ?></td>
                            <td class="text-start">
                                <strong><?= htmlspecialchars($d['nama']); ?></strong><br>
                                <span class="text-muted small"><?= htmlspecialchars($d['nim']); ?></span>
                            </td>
                            <td>
                                <span class="badge <?= $badge ?> w-75 py-2 fs-6 text-capitalize"><?= htmlspecialchars($status); ?></span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="detail.php?id=<?= $d['id_cuti']; ?>" class="btn btn-sm btn-info text-white fw-bold px-3">Detail</a>
                                    
                                    <?php if ($status == 'Menunggu Dosen'): ?>
                                        <a href="setujui.php?id=<?= $d['id_cuti']; ?>" class="btn btn-sm btn-success fw-bold px-3" onclick="return confirm('Setujui pengajuan ini dan teruskan ke Kaprodi?');">Setujui</a>
                                        <a href="tolak.php?id=<?= $d['id_cuti']; ?>" class="btn btn-sm btn-danger fw-bold px-3">Tolak</a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary fw-bold px-3" disabled>Selesai Diproses</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                        ?>
                        <tr>
                            <td colspan="4" class="py-4 text-muted">Belum ada data pengajuan cuti.</td>
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