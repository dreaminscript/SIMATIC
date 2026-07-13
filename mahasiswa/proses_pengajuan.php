<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = intval($_POST['user_id']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$nim = mysqli_real_escape_string($conn, $_POST['nim']);
$alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
$tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
$tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);

$status = "Menunggu";
$catatan = NULL;

$namaFile = NULL;

if (isset($_FILES['surat']) && $_FILES['surat']['error'] === UPLOAD_ERR_OK) {

    $file = $_FILES['surat']['name'];
    $tmp = $_FILES['surat']['tmp_name'];

    $folder = "../uploads/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $namaFile = time() . "_" . $file;

    if (!move_uploaded_file($tmp, $folder . $namaFile)) {

        echo "<script>
                alert('Upload surat gagal!');
                history.back();
              </script>";
        exit;

    }

}

$suratValue = $namaFile ? "'".$namaFile."'" : "NULL";

mysqli_query($conn, "
    INSERT INTO cuti
    (
        user_id,
        nama,
        nim,
        alasan,
        tanggal_mulai,
        tanggal_selesai,
        surat,
        status,
        catatan,
        created_at
    )
    VALUES
    (
        '$user_id',
        '$nama',
        '$nim',
        '$alasan',
        '$tanggal_mulai',
        '$tanggal_selesai',
        $suratValue,
        '$status',
        NULL,
        NOW()
    )
");

echo "<script>
        alert('Pengajuan berhasil dikirim.');
        window.location='dashboard.php';
      </script>";
?>