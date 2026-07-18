<?php
require_once '../auth.php';
cek_akses('mahasiswa');
require_once '../koneksi.php';

$id_user = intval($_POST['user_id']); 
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$nim = mysqli_real_escape_string($conn, $_POST['nim']);
$alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
$tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
$tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);

$status = "Menunggu Dosen";
$namaFile = NULL;
$uploadSuccess = true;
$errorMessage = '';

if (isset($_FILES['surat']) && $_FILES['surat']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['surat']['name'];
    $tmp = $_FILES['surat']['tmp_name'];
    $folder = "../assets/uploads/"; 

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $cleanFileName = preg_replace('/[^a-zA-Z0-9.\-_]/', '_', $file);
    $namaFile = time() . "_" . $cleanFileName;

    if (!move_uploaded_file($tmp, $folder . $namaFile)) {
        $uploadSuccess = false;
        $errorMessage = "Gagal mengunggah file surat pendukung.";
    }
}

$querySuccess = false;

if ($uploadSuccess) {
    $suratValue = $namaFile ? "'" . $namaFile . "'" : "NULL";

    $query = "INSERT INTO cuti (id_user, nama, nim, alasan, tanggal_mulai, tanggal_selesai, surat, status, tanggal_pengajuan)
              VALUES ('$id_user', '$nama', '$nim', '$alasan', '$tanggal_mulai', '$tanggal_selesai', $suratValue, '$status', NOW())";

    if (mysqli_query($conn, $query)) {
        $querySuccess = true;
    } else {
        $errorMessage = "Terjadi kesalahan saat menyimpan data ke database: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Pengajuan...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }</style>
</head>
<body>
    <script>
        <?php if ($querySuccess): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Pengajuan cuti akademik Anda berhasil dikirim.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location = 'dashboard.php';
            });
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $errorMessage ?>',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Kembali'
            }).then(() => {
                window.history.back();
            });
        <?php endif; ?>
    </script>
</body>
</html>