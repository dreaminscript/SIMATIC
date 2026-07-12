<?php
include "../koneksi.php";
include "sidebar.php";

// Statistik kartu
$total       = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cuti"));
$menunggu    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cuti WHERE status IN ('Menunggu','Disetujui Dosen')"));
$diproses    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cuti WHERE status IN ('Disetujui Kaprodi','Selesai')"));

// Data yang siap dicetak surat: HARUS sudah disetujui Dosen DAN Kaprodi
$query = mysqli_query($conn, "SELECT * FROM cuti WHERE status='Disetujui Kaprodi' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tata Usaha</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="content">

    <h2>Selamat Datang, Tata Usaha</h2>

    <div class="cards">

        <div class="card-item">
            <h3><?= $total; ?></h3>
            <p>Pengajuan Masuk</p>
        </div>

        <div class="card-item">
            <h3><?= $menunggu; ?></h3>
            <p>Menunggu Persetujuan</p>
        </div>

        <div class="card-item">
            <h3><?= $diproses; ?></h3>
            <p>Sudah Diproses</p>
        </div>

    </div>

    <table>

        <tr>
            <th width="80">ID</th>
            <th>Daftar Pengajuan Cuti</th>
            <th width="180">Aksi</th>
        </tr>

        <?php
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td>
                <a href="cetak.php?id=<?= $row['id']; ?>" class="btn setuju">
                    Cetak
                </a>
            </td>
        </tr>

        <?php
            }
        } else {
        ?>

        <tr>
            <td colspan="3" style="text-align:center;">Belum ada pengajuan yang siap dicetak.</td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>