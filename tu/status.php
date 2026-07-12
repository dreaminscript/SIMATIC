<?php
include "../koneksi.php";
include "sidebar.php";

$query = mysqli_query($conn, "SELECT * FROM cuti ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan Cuti</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="content">

    <h2>Status Pengajuan Cuti</h2>

    <table>

        <tr>
            <th width="80">ID</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
        </tr>

        <?php
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
        ?>

        <tr>

            <td><?= $row['id']; ?></td>

            <td><?= htmlspecialchars($row['nama']); ?></td>

            <td><?= htmlspecialchars($row['nim']); ?></td>

            <td><?= date('d M Y', strtotime($row['tanggal_mulai'])); ?></td>

            <td><?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></td>

            <td>

                <?php
                if ($row['status'] == "Menunggu") {
                    echo "<span class='status pending'>Menunggu</span>";
                } elseif ($row['status'] == "Disetujui Dosen") {
                    echo "<span class='status dosen'>Disetujui Dosen</span>";
                } elseif ($row['status'] == "Disetujui Kaprodi") {
                    echo "<span class='status kaprodi'>Disetujui Kaprodi</span>";
                } elseif ($row['status'] == "Ditolak Dosen") {
                    echo "<span class='status ditolak'>Ditolak Dosen</span>";
                } elseif ($row['status'] == "Ditolak Kaprodi") {
                    echo "<span class='status ditolak'>Ditolak Kaprodi</span>";
                } elseif ($row['status'] == "Selesai") {
                    echo "<span class='status selesai'>Selesai</span>";
                } else {
                    echo "<span class='status'>" . htmlspecialchars($row['status']) . "</span>";
                }
                ?>

            </td>

        </tr>

        <?php
            }
        } else {
        ?>

        <tr>
            <td colspan="6" style="text-align:center;">Belum ada data pengajuan cuti.</td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>