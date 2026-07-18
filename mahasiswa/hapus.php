<?php
require_once '../auth.php';
cek_akses('mahasiswa');
require_once '../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: riwayat.php");
    exit;
}

$username = $_SESSION['username'];

$user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$dataUser = mysqli_fetch_assoc($user);
$id_user = $dataUser['id_user'];

$id = intval($_GET['id']);
$error_msg = "";
$success_msg = "";

$query = mysqli_query($conn, "
    SELECT *
    FROM cuti
    WHERE id_cuti = '$id'
    AND id_user = '$id_user'
");

if (mysqli_num_rows($query) == 0) {
    $error_msg = "Data tidak ditemukan atau bukan milik Anda!";
} else {
    $data = mysqli_fetch_assoc($query);

    if ($data['status'] != "Menunggu Dosen") {
        $error_msg = "Pengajuan yang sudah diproses tidak dapat dibatalkan.";
    } else {
        if (!empty($data['surat'])) {
            $file = "../assets/uploads/" . $data['surat'];
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $hapus = mysqli_query($conn, "DELETE FROM cuti WHERE id_cuti='$id'");

        if ($hapus) {
            $success_msg = "Pengajuan cuti berhasil dibatalkan dan dihapus.";
        } else {
            $error_msg = "Gagal menghapus data dari database.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Pembatalan...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>
    <script>
        <?php if ($success_msg != ""): ?>
            Swal.fire({
                icon: 'success',
                title: 'Dibatalkan!',
                text: '<?= $success_msg ?>',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location = 'riwayat.php';
            });
        <?php elseif ($error_msg != ""): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $error_msg ?>',
                confirmButtonColor: '#0d6efd'
            }).then(() => {
                window.location = 'riwayat.php';
            });
        <?php endif; ?>
    </script>
</body>

</html>