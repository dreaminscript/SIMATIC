<?php
include "../koneksi.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

// Update status menjadi Disetujui Dosen
$query = mysqli_query($conn, "UPDATE cuti SET status='Disetujui Dosen' WHERE id='$id'");

if ($query) {
    echo "<script>
        alert('Pengajuan berhasil disetujui!');
        window.location='dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menyetujui pengajuan. Silakan coba lagi.');
        window.location='dashboard.php';
    </script>";
}
?>