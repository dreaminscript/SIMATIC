<?php
require_once '../auth.php';
cek_akses('kaprodi');
require_once '../koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

$query = mysqli_query($conn, "UPDATE cuti SET status='Diproses TU' WHERE id_cuti='$id' AND status='Menunggu Kaprodi'");
$berhasil = mysqli_affected_rows($conn) > 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Memproses Persetujuan...</title>
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
        <?php if ($berhasil): ?>
            Swal.fire({
                icon: 'success',
                title: 'Disetujui!',
                text: 'Pengajuan cuti berhasil disetujui dan siap dicetak oleh TU.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location = 'dashboard.php';
            });
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal / Sudah Diproses!',
                text: 'Data mungkin sudah disetujui/ditolak sebelumnya.',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.location = 'dashboard.php';
            });
        <?php endif; ?>
    </script>
</body>

</html>