<?php
require_once '../auth.php';
cek_akses('dosen');
require_once '../koneksi.php';

$id = intval($_GET['id'] ?? 0);

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$query = mysqli_query($conn, "UPDATE cuti SET status='Menunggu Kaprodi' WHERE id_cuti='$id' AND status='Menunggu Dosen'");

$berhasil = mysqli_affected_rows($conn) > 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Memproses Persetujuan...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { background-color: #f4f7f6; }</style>
</head>
<body>
    <script>
        <?php if ($berhasil): ?>
            Swal.fire({
                icon: 'success',
                title: 'Disetujui!',
                text: 'Pengajuan cuti telah diteruskan ke Kaprodi.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => { window.location = 'dashboard.php'; });
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal / Sudah Diproses!',
                text: 'Data mungkin sudah disetujui sebelumnya.',
                confirmButtonColor: '#d33'
            }).then(() => { window.location = 'dashboard.php'; });
        <?php endif; ?>
    </script>
</body>
</html>