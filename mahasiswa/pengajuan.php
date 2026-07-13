<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];

$user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$data = mysqli_fetch_assoc($user);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Cuti</title>

     <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <?php include "sidebar.php"; ?>

    <div class="content">

        <h2>Ajukan Cuti Akademik</h2>

        <div class="form-card">

            <form action="proses_pengajuan.php" method="POST" enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="user_id"
                    value="<?= $data['id']; ?>"
                >

                <div class="form-group">
                    <label>Nama Mahasiswa</label>

                    <input
                        type="text"
                        name="nama"
                        value="<?= htmlspecialchars($username); ?>"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label>NIM</label>

                    <input
                        type="text"
                        name="nim"
                        placeholder="Masukkan NIM"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Alasan Cuti</label>

                    <textarea
                        name="alasan"
                        rows="5"
                        placeholder="Tuliskan alasan pengajuan cuti..."
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai</label>

                    <input
                        type="date"
                        name="tanggal_mulai"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Tanggal Selesai</label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Surat Pendukung (opsional)</label>

                    <input
                        type="file"
                        name="surat"
                        accept=".pdf,.jpg,.jpeg,.png"
                    >
                </div>


                <button
                    type="submit"
                    class="btn-submit"
                >
                    Kirim Pengajuan
                </button>

            </form>

        </div>

    </div>

</body>

</html>