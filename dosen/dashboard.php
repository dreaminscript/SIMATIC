<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php
include "../koneksi.php";
include "sidebar.php";
?>

<div class="content">

    <h2>Selamat Datang, Dosen!</h2>

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
            <th width="70">ID</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Status</th>
            <th width="260">Aksi</th>
        </tr>

        <?php

        $data = mysqli_query($conn, "SELECT * FROM cuti ORDER BY id DESC");

        while($d = mysqli_fetch_assoc($data)){
        ?>

        <tr>

            <td><?= $d['id']; ?></td>

            <td><?= $d['nama']; ?></td>

            <td><?= $d['nim']; ?></td>

            <td><?= $d['status']; ?></td>

            <td>

                <a href="detail.php?id=<?= $d['id']; ?>" class="btn lihat">Lihat</a>

                <a href="setujui.php?id=<?= $d['id']; ?>" class="btn setuju">Disetujui</a>

                <a href="tolak.php?id=<?= $d['id']; ?>" class="btn tolak">Ditolak</a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>