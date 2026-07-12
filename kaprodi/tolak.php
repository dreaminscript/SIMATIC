<?php
include "../koneksi.php";

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tolak Pengajuan</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>

        .card{
            background:#fff;
            padding:30px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
        }

        textarea{
            width:100%;
            height:180px;
            resize:none;
            padding:15px;
            border:1px solid #ccc;
            border-radius:10px;
            margin-top:15px;
            font-size:16px;
        }

        .aksi{
            margin-top:20px;
            text-align:right;
        }

    </style>

</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">

<div class="card">

<h2>Alasan Pengajuan Cuti Ditolak</h2>

<form action="" method="POST">

    <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">

    <textarea
    name="catatan"
    placeholder="Masukkan alasan penolakan..."
    required></textarea>

    <div class="aksi">

        <a href="detail.php?id=<?= htmlspecialchars($id); ?>" class="btn lihat">
            Kembali
        </a>

        <button
        type="submit"
        class="btn tolak">
            Kirim
        </button>

    </div>

</form>

<?php

if (isset($_POST['catatan'])) {

    $id_post = $_POST['id'];
    $catatan = $_POST['catatan'];

    $query = mysqli_query($conn, "UPDATE cuti SET status='Ditolak Kaprodi', catatan='$catatan' WHERE id='$id_post'");

    if ($query) {
        echo "<script>
            alert('Alasan berhasil dikirim!');
            window.location='dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan alasan penolakan. Silakan coba lagi.');
        </script>";
    }

}

?>

</div>

</div>

</body>
</html>