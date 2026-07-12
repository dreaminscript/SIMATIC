<?php
include "../koneksi.php";
include "sidebar.php";

$query = mysqli_query($conn, "SELECT * FROM cuti WHERE status='Disetujui Dosen' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kaprodi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="content">

<h2>Selamat Datang, Kaprodi!</h2>

 <?php
    $jumlah = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cuti"));
    $menunggu = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cuti WHERE status='Menunggu'"));
    $diproses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cuti WHERE status!='Menunggu'"));
    ?>

    <div class="cards">

        <div class="card-item">
            <h3><?= $jumlah; ?></h3>
            <p>Total Pengajuan</p>
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
    <th>ID</th>
    <th>Nama</th>
    <th>NIM</th>
    <th>Status</th>
    <th width="260">Aksi</th>
</tr>

<?php
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= htmlspecialchars($row['nama']); ?></td>
    <td><?= htmlspecialchars($row['nim']); ?></td>
    <td><?= htmlspecialchars($row['status']); ?></td>
    <td>
        <a href="detail.php?id=<?= $row['id']; ?>" class="btn lihat">Lihat</a>
        <a href="setujui.php?id=<?= $row['id']; ?>" class="btn setuju">Disetujui</a>
        <a href="tolak.php?id=<?= $row['id']; ?>" class="btn tolak">Ditolak</a>
    </td>
</tr>

<?php
    }
} else {
?>

<tr>
    <td colspan="5" style="text-align:center;">Belum ada pengajuan yang menunggu persetujuan Kaprodi.</td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>