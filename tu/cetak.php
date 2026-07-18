<?php
require_once '../auth.php';
cek_akses('tu');
require_once '../koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

$query = mysqli_query($conn, "SELECT * FROM cuti WHERE id_cuti='$id' AND status IN ('Diproses TU', 'Disetujui', 'Dicetak')");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan atau belum disetujui Kaprodi.'); window.location='dashboard.php';</script>";
    exit;
}

if ($row['status'] == 'Diproses TU') {
    mysqli_query($conn, "UPDATE cuti SET status='Disetujui' WHERE id_cuti='$id'");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Cuti - <?= htmlspecialchars($row['nim']); ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap');

        body {
            font-family: 'Times New Roman', Times, serif;
            padding: 40px;
            background-color: #f0f0f0;
        }

        .surat {
            max-width: 750px;
            margin: auto;
            background: white;
            border: 1px solid #ccc;
            padding: 50px 60px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .kop-surat h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .kop-surat p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .judul-surat {
            text-align: center;
            margin-bottom: 30px;
        }

        .judul-surat h2 {
            margin: 0;
            text-decoration: underline;
            font-size: 18px;
        }

        .judul-surat p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .isi-surat {
            line-height: 1.6;
            text-align: justify;
        }

        table.data {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table.data td {
            padding: 8px 4px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .ttd-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
        }

        .ttd {
            text-align: center;
            width: 250px;
        }

        .no-print {
            max-width: 750px;
            margin: 20px auto;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .btn-print {
            background-color: #0d6efd;
        }

        .btn-back {
            background-color: #6c757d;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .surat {
                border: none;
                box-shadow: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="surat">
        <div class="kop-surat">
            <h1>Universitas SIMATIC</h1>
            <p>Fakultas Teknologi Informasi - Program Studi Sistem Informasi</p>
            <p>Jl. Pendidikan No. 123, Kota Bandung, Jawa Barat</p>
        </div>

        <div class="judul-surat">
            <h2>SURAT KETERANGAN IZIN CUTI AKADEMIK</h2>
            <p>Nomor: <?= date('Y/m') ?>/CUTI/SIMATIC/<?= sprintf("%03d", $row['id_cuti']); ?></p>
        </div>

        <div class="isi-surat">
            <p>Yang bertanda tangan di bawah ini, Kepala Bagian Tata Usaha Fakultas Teknologi Informasi menerangkan bahwa mahasiswa:</p>

            <table class="data">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>: <?= htmlspecialchars($row['nama']); ?></td>
                </tr>
                <tr>
                    <td>Nomor Induk Mahasiswa</td>
                    <td>: <?= htmlspecialchars($row['nim']); ?></td>
                </tr>
                <tr>
                    <td>Alasan Cuti</td>
                    <td>: <?= htmlspecialchars($row['alasan']); ?></td>
                </tr>
                <tr>
                    <td>Masa Cuti Akademik</td>
                    <td>: <b><?= date('d F Y', strtotime($row['tanggal_mulai'])); ?></b> s.d <b><?= date('d F Y', strtotime($row['tanggal_selesai'])); ?></b></td>
                </tr>
                <tr>
                    <td>Status Persetujuan</td>
                    <td>: Telah Disetujui (Dosen Wali & Ketua Program Studi)</td>
                </tr>
            </table>

            <p>
                Telah secara resmi diberikan izin penangguhan kegiatan akademik (Cuti) untuk rentang waktu yang telah disebutkan di atas.
                Selama masa cuti, mahasiswa yang bersangkutan dibebaskan dari segala bentuk kegiatan perkuliahan dan administrasi akademik yang berjalan.
            </p>
            <p>
                Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.
            </p>
        </div>

        <div class="ttd-container">
            <div class="ttd">
                <p>Bandung, <?= date('d F Y'); ?><br>Kepala Bagian Tata Usaha</p>
                <br><br><br><br>
                <p style="text-decoration: underline; font-weight: bold; margin-bottom: 0;">Nama Lengkap Staf TU</p>
                <p style="margin-top: 5px;">NIP. 19801234 200501 1 001</p>
            </div>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">Cetak Surat (PDF)</button>
        <a href="dashboard.php" class="btn btn-back">Kembali ke Dashboard</a>
    </div>

</body>

</html>