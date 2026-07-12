<?php
include "../koneksi.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

mysqli_query($conn, "UPDATE cuti SET status='Disetujui Kaprodi' WHERE id='$id'");

header("Location: dashboard.php");
exit;
?>