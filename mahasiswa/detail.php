<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: riwayat.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user yang login
$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);

$id = intval($_GET['id']);

// Cek data DAN pastikan pengajuan ini memang milik user yang login
$query = mysqli_query($conn, "
    SELECT *
    FROM cuti
    WHERE id = '$id'
    AND user_id = '".$dataUser['id']."'
");

if (mysqli_num_rows($query) == 0) {

    echo "<script>
            alert('Data tidak ditemukan atau bukan milik Anda.');
            window.location='riwayat.php';
          </script>";

    exit;
}

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

<?php include "sidebar.php"; ?>

<div class="content">

    <h2>Detail Pengajuan Cuti</h2>

    <div class="detail-card">

        <table class="detail-table">

            <tr>
                <td width="220"><b>Nama Mahasiswa</b></td>
                <td><?= htmlspecialchars($data['nama']); ?></td>
            </tr>

            <tr>
                <td><b>NIM</b></td>
                <td><?= htmlspecialchars($data['nim']); ?></td>
            </tr>

            <tr>
                <td><b>Alasan</b></td>
                <td><?= nl2br(htmlspecialchars($data['alasan'])); ?></td>
            </tr>

            <tr>
                <td><b>Tanggal Mulai</b></td>
                <td><?= $data['tanggal_mulai']; ?></td>
            </tr>

            <tr>
                <td><b>Tanggal Selesai</b></td>
                <td><?= $data['tanggal_selesai']; ?></td>
            </tr>

            <tr>
                <td><b>Surat Pendukung</b></td>
                <td>

                    <?php if($data['surat']){ ?>

                        <a
                            href="../uploads/<?= $data['surat']; ?>"
                            target="_blank"
                            class="btn-detail">

                            Lihat Surat

                        </a>

                    <?php } else { ?>

                        Tidak ada file.

                    <?php } ?>

                </td>
            </tr>

            <tr>

                <td><b>Status</b></td>

                <td>

                    <?php

                    if($data['status']=="Menunggu"){
                        echo "<span class='badge warning'>Menunggu</span>";
                    }

                    elseif($data['status']=="Disetujui Dosen"){
                        echo "<span class='badge info'>Disetujui Dosen</span>";
                    }

                    elseif($data['status']=="Disetujui Kaprodi"){
                        echo "<span class='badge success'>Disetujui Kaprodi</span>";
                    }

                    elseif($data['status']=="Ditolak Dosen" || $data['status']=="Ditolak Kaprodi" || $data['status']=="Ditolak"){
                        echo "<span class='badge danger'>".htmlspecialchars($data['status'])."</span>";
                    }

                    elseif($data['status']=="Selesai"){
                        echo "<span class='badge primary'>Selesai</span>";
                    }

                    else{
                        echo "<span class='badge primary'>".htmlspecialchars($data['status'])."</span>";
                    }

                    ?>

                </td>

            </tr>

            <tr>
                <td><b>Catatan</b></td>

                <td>

                    <?=
                    empty($data['catatan'])
                    ? "-"
                    : htmlspecialchars($data['catatan']);
                    ?>

                </td>

            </tr>

        </table>

        <br>

        <a
            href="riwayat.php"
            class="btn-kembali">

            ← Kembali

        </a>

    </div>

</div>

</body>

</html>