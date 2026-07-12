<?php
include "../koneksi.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

// Ambil data pengajuan, pastikan statusnya memang sudah Disetujui Kaprodi
$query = mysqli_query($conn, "SELECT * FROM cuti WHERE id='$id' AND status='Disetujui Kaprodi'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    die("Data tidak ditemukan atau belum disetujui Kaprodi.");
}

// Update status jadi Selesai setelah surat dicetak
mysqli_query($conn, "UPDATE cuti SET status='Selesai' WHERE id='$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Cuti</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        .surat { max-width: 700px; margin: auto; border: 1px solid #333; padding: 30px; }
        .surat h2 { text-align: center; }
        table.data { width: 100%; margin-top: 20px; border-collapse: collapse; }
        table.data td { padding: 6px 4px; }
        .ttd { margin-top: 60px; text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="surat">

    <h2>SURAT KETERANGAN CUTI</h2>

    <table class="data">
        <tr><td width="150">Nama</td><td>: <?= htmlspecialchars($row['nama']); ?></td></tr>
        <tr><td>NIM</td><td>: <?= htmlspecialchars($row['nim']); ?></td></tr>
        <tr><td>Alasan</td><td>: <?= htmlspecialchars($row['alasan']); ?></td></tr>
        <tr><td>Tanggal Mulai</td><td>: <?= date('d M Y', strtotime($row['tanggal_mulai'])); ?></td></tr>
        <tr><td>Tanggal Selesai</td><td>: <?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></td></tr>
        <tr><td>Status</td><td>: Disetujui (Dosen &amp; Kaprodi)</td></tr>
    </table>

    <p style="margin-top:20px;">
        Surat ini menyatakan bahwa mahasiswa yang bersangkutan telah disetujui untuk mengambil cuti
        sesuai dengan rentang tanggal di atas.
    </p>

    <div class="ttd">
        <p>Bandung, <?= date('d M Y'); ?></p>
        <br><br><br>
        <p>Tata Usaha</p>
    </div>

</div>

<div class="no-print" style="max-width:700px;margin:20px auto;text-align:center;">
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</div>

</body>
</html>