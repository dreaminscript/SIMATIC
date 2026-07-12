<?php
include "../koneksi.php";
include "sidebar.php";

// Kaprodi hanya melihat pengajuan yang sudah disetujui Dosen
$query = mysqli_query($conn, "SELECT * FROM cuti WHERE status='Disetujui Dosen' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="content">

    <h2>Daftar Pengajuan Cuti</h2>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Alasan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th width="250">Aksi</th>
            </tr>
        </thead>

        <tbody>

            <?php
            $no = 1;

            if (mysqli_num_rows($query) > 0) {
                while ($d = mysqli_fetch_assoc($query)) {
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($d['nim']); ?></td>
                <td><?= htmlspecialchars($d['nama']); ?></td>
                <td><?= htmlspecialchars($d['alasan']); ?></td>
                <td><?= date('d M Y', strtotime($d['tanggal_mulai'])); ?></td>
                <td><?= date('d M Y', strtotime($d['tanggal_selesai'])); ?></td>
                <td><?= htmlspecialchars($d['status']); ?></td>

                <td>
                    <a href="detail.php?id=<?= $d['id']; ?>" class="btn lihat">Lihat</a>
                    <a href="setujui.php?id=<?= $d['id']; ?>" class="btn setuju">Setujui</a>
                    <a href="tolak.php?id=<?= $d['id']; ?>" class="btn tolak">Tolak</a>
                </td>
            </tr>

            <?php
                }
            } else {
            ?>

            <tr>
                <td colspan="8" style="text-align:center;">Belum ada pengajuan yang menunggu persetujuan Kaprodi.</td>
            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>