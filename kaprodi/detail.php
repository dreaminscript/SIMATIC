<?php
include "../koneksi.php";
include "sidebar.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM cuti WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengajuan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="content">

    <h2>Detail Pengajuan Cuti</h2>

    <table class="detail-table">

        <tr>
            <th>Nama</th>
            <td><?= $data['nama']; ?></td>
        </tr>

        <tr>
            <th>NIM</th>
            <td><?= $data['nim']; ?></td>
        </tr>

        <tr>
            <th>Alasan</th>
            <td><?= $data['alasan']; ?></td>
        </tr>

        <tr>
            <th>Tanggal Mulai</th>
            <td><?= $data['tanggal_mulai']; ?></td>
        </tr>

        <tr>
            <th>Tanggal Selesai</th>
            <td><?= $data['tanggal_selesai']; ?></td>
        </tr>

        <tr>
            <th>Surat</th>
            <td><?= $data['surat']; ?></td>
        </tr>

        <tr>
            <th>Status</th>
            <td><?= $data['status']; ?></td>
        </tr>

    </table>

    <br>

   <a href="dashboard.php" class="btn lihat">
    Kembali
</a>

</div>

</body>
</html>