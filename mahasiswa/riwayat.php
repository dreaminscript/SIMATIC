<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];

$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);

$query = mysqli_query($conn, "
    SELECT *
    FROM cuti
    WHERE user_id = '".$dataUser['id']."'
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Riwayat Pengajuan</title>

     <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

    <h2>Riwayat Pengajuan Cuti</h2>

    <div class="table-card">

        <table>

            <thead>

                <tr>

                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            <?php

            $no = 1;

            while($row = mysqli_fetch_assoc($query)){

            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td><?= date('d-m-Y', strtotime($row['created_at'])); ?></td>

                <td><?= $row['tanggal_mulai']; ?></td>

                <td><?= $row['tanggal_selesai']; ?></td>

                <td>

                <?php

                if($row['status']=="Menunggu"){
                    echo "<span class='badge warning'>Menunggu</span>";
                }

                elseif($row['status']=="Disetujui Dosen"){
                    echo "<span class='badge info'>Disetujui Dosen</span>";
                }

                elseif($row['status']=="Disetujui Kaprodi"){
                    echo "<span class='badge success'>Disetujui Kaprodi</span>";
                }

                elseif($row['status']=="Ditolak"){
                    echo "<span class='badge danger'>Ditolak</span>";
                }

                else{
                    echo "<span class='badge primary'>".$row['status']."</span>";
                }

                ?>

                </td>

                <td>

                    <a
                            href="detail.php?id=<?= $row['id']; ?>"
                            class="btn-detail">

                            Detail

                        </a>

                        <?php if ($row['status'] == "Menunggu") { ?>

                            <a
                                href="hapus.php?id=<?= $row['id']; ?>"
                                class="btn-hapus"
                                onclick="return confirm('Yakin ingin menghapus pengajuan ini?')">

                                Hapus

                            </a>

                        <?php } ?>


                </td>

            </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>