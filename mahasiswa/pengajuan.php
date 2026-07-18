<?php
require_once '../auth.php';
cek_akses('mahasiswa');
require_once '../koneksi.php';
$current_page = 'pengajuan.php'; 

$username = $_SESSION['username'];
$user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$data = mysqli_fetch_assoc($user);

$hari_ini = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Cuti - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; display: flex; min-height: 100vh; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; animation: fadeIn 0.5s ease-out; }
        .form-card { background: #ffffff; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); padding: 30px; max-width: 800px; margin: 0 auto; }
        .form-label { font-weight: 600; color: #495057; }
        .form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid #ced4da; transition: all 0.3s ease; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15); border-color: #0d6efd; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) { .main-content { padding: 15px; } .form-card { padding: 20px; } }
    </style>
</head>
<body>

    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 800px; margin: 0 auto;">
            <h4 class="mb-0 text-primary fw-bold">Ajukan Cuti Akademik</h4>
        </div>

        <div class="form-card border-0">
            <form action="proses_pengajuan.php" method="POST" enctype="multipart/form-data" id="formPengajuan">
                
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($data['id_user']); ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" name="nama" class="form-control bg-light" value="<?= htmlspecialchars($username); ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="number" name="nim" class="form-control" placeholder="Masukkan NIM Anda" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Alasan Cuti <span class="text-danger">*</span></label>
                            <textarea name="alasan" class="form-control" rows="4" placeholder="Tuliskan alasan pengajuan cuti secara jelas..." required style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <!-- Tambahkan atribut min dengan tanggal hari ini dan beri ID -->
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" min="<?= $hari_ini; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <!-- Tambahkan atribut min dengan tanggal hari ini dan beri ID -->
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" min="<?= $hari_ini; ?>" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">Surat Pendukung <span class="text-muted fw-normal">(Opsional)</span></label>
                            <input type="file" name="surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text">Format yang didukung: PDF, JPG, JPEG, PNG.</div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2" id="btnSubmit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send me-2" viewBox="0 0 16 16">
                              <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                            </svg>
                            Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('formPengajuan').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
            btn.classList.add('disabled');
        });

        const tglMulai = document.getElementById('tanggal_mulai');
        const tglSelesai = document.getElementById('tanggal_selesai');

        tglMulai.addEventListener('change', function() {
            tglSelesai.min = this.value;
            
            if (tglSelesai.value < this.value) {
                tglSelesai.value = '';
            }
        });
    </script>
</body>
</html>