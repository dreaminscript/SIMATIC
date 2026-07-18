<?php
require_once '../auth.php';
cek_akses('admin');
require_once '../koneksi.php';

$id = intval($_GET['id'] ?? 0);

if (!$id) {
    header("Location: pengajuan.php");
    exit;
}

$error_msg = "";
$success_msg = "";

$query = mysqli_query($conn, "SELECT surat FROM cuti WHERE id_cuti = '$id'");

if (mysqli_num_rows($query) == 0) {
    $error_msg = "Data tidak ditemukan!";
} else {
    $data = mysqli_fetch_assoc($query);

    if (!empty($data['surat'])) {
        $file = "../assets/uploads/" . $data['surat'];
        if (file_exists($file)) {
            unlink($file);
        }
    }

    $hapus = mysqli_query($conn, "DELETE FROM cuti WHERE id_cuti='$id'");

    if ($hapus) {
        $success_msg = "Data pengajuan berhasil dihapus permanen.";
    } else {
        $error_msg = "Gagal menghapus data dari database.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Penghapusan...</title>
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
                title: 'Berhasil Dihapus!',
                text: '<?= $success_msg ?>',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location = 'pengajuan.php';
            });
        <?php elseif ($error_msg != ""): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $error_msg ?>',
                confirmButtonColor: '#0d6efd'
            }).then(() => {
                window.location = 'pengajuan.php';
            });
        <?php endif; ?>
    </script>
</body>

</html>