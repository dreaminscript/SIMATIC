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

// Cek apakah data milik user yang login
$query = mysqli_query($conn, "
    SELECT *
    FROM cuti
    WHERE id = '$id'
    AND user_id = '".$dataUser['id']."'
");

if (mysqli_num_rows($query) == 0) {

    echo "<script>
            alert('Data tidak ditemukan!');
            window.location='riwayat.php';
          </script>";

    exit;
}

$data = mysqli_fetch_assoc($query);

// Hanya boleh dihapus jika status masih Menunggu
if ($data['status'] != "Menunggu") {

    echo "<script>
            alert('Pengajuan yang sudah diproses tidak dapat dihapus.');
            window.location='riwayat.php';
          </script>";

    exit;
}

// Hapus file surat jika ada
if (!empty($data['surat'])) {

    $file = "../uploads/" . $data['surat'];

    if (file_exists($file)) {
        unlink($file);
    }
}

// Hapus data dari database
mysqli_query($conn, "DELETE FROM cuti WHERE id='$id'");

echo "<script>
        alert('Pengajuan berhasil dihapus.');
        window.location='riwayat.php';
      </script>";
?>