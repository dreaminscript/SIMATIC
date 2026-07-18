<?php
require_once '../auth.php';
cek_akses('kaprodi');
require_once '../koneksi.php';
$page = 'pengajuan';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

// Keamanan Tambahan
$cek = mysqli_query($conn, "SELECT status FROM cuti WHERE id_cuti='$id'");
$data_cek = mysqli_fetch_assoc($cek);

if ($data_cek['status'] != 'Menunggu Kaprodi') {
    echo "<script>alert('Pengajuan ini tidak dapat ditolak (bukan Menunggu Kaprodi).'); window.location='dashboard.php';</script>";
    exit;
}

$swal_script = '';

if (isset($_POST['submit_tolak'])) {
    $id_post = mysqli_real_escape_string($conn, $_POST['id']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    $query = mysqli_query($conn, "UPDATE cuti SET status='Ditolak Kaprodi', catatan='$catatan' WHERE id_cuti='$id_post' AND status='Menunggu Kaprodi'");

    if ($query) {
        $swal_script = "
            Swal.fire({
                icon: 'success',
                title: 'Ditolak!',
                text: 'Alasan penolakan berhasil dikirim.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location = 'dashboard.php';
            });
        ";
    } else {
        $swal_script = "
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan alasan. Silakan coba lagi.',
                confirmButtonColor: '#d33'
            });
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tolak Pengajuan - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f7f6;
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            animation: fadeIn 0.5s ease-out;
        }

        textarea {
            resize: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            .action-btns {
                flex-direction: column-reverse;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 700px; margin-top: 20px;">
            <div class="card-header bg-white border-bottom p-4">
                <h4 class="mb-0 text-danger fw-bold">Alasan Penolakan Pengajuan Cuti</h4>
            </div>

            <div class="card-body p-4">
                <form action="" method="POST" id="formTolak">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">

                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold text-muted">Berikan catatan atau alasan mengapa pengajuan ini ditolak:</label>
                        <textarea
                            name="catatan"
                            id="catatan"
                            class="form-control bg-light"
                            rows="6"
                            placeholder="Ketik alasan penolakan di sini..."
                            required></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 action-btns">
                        <a href="detail.php?id=<?= htmlspecialchars($id); ?>" class="btn btn-secondary fw-bold px-4">Kembali</a>
                        <button type="submit" name="submit_tolak" class="btn btn-danger fw-bold px-4" id="btnSubmit">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('formTolak').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = 'Memproses...';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'not-allowed';
        });

        <?php if (!empty($swal_script)): ?>
            <?= $swal_script ?>
        <?php endif; ?>
    </script>
</body>

</html>