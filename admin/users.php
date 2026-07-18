<?php
require_once '../auth.php';
cek_akses('admin');
require_once '../koneksi.php';
$page = 'users';

if (isset($_POST['update_role'])) {
    $id_user = $_POST['id_user'];
    $role_baru = $_POST['role_baru'];

    $query_update = "UPDATE users SET role = '$role_baru' WHERE id_user = '$id_user'";

    if (mysqli_query($conn, $query_update)) {
        $pesan_sukses = "Role user berhasil diperbarui!";
    } else {
        $pesan_error = "Gagal memperbarui role: " . mysqli_error($conn);
    }
}

$keyword = "";
if (isset($_GET['cari_btn'])) {
    $keyword = $_GET['keyword'];
    $query = "SELECT * FROM users WHERE username LIKE '%$keyword%' OR role LIKE '%$keyword%' ORDER BY id_user ASC";
} else {
    $query = "SELECT * FROM users ORDER BY id_user ASC";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data User - SIMATIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .select-role {
            border-radius: 20px;
            cursor: pointer;
            text-align: center;
            font-weight: bold;
            border: none;
            padding: 5px 15px;
            appearance: auto;
        }

        .select-role:focus {
            box-shadow: none;
            outline: 2px solid #fff;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h4 class="mb-4 fw-bold">Data User</h4>

        <?php if (isset($pesan_sukses)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $pesan_sukses ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($pesan_error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $pesan_error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card card-stat p-4 mb-4">
            <form action="" method="GET" class="row g-2 align-items-center">
                <div class="col-md-8">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari Username / Role" value="<?= htmlspecialchars($keyword) ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" name="cari_btn" class="btn btn-primary w-100">Cari</button>
                </div>
                <div class="col-md-2">
                    <a href="users.php" class="btn btn-danger w-100">Reset</a>
                </div>
            </form>
        </div>

        <div class="card card-stat p-0 overflow-hidden">
            <table class="table table-hover mb-0 text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">ID</th>
                        <th width="50%" class="text-start">Username / Nama</th>
                        <th width="40%">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                            $bg_class = ($row['role'] == 'admin') ? 'bg-primary text-white' : 'bg-success text-white';
                    ?>
                            <tr>
                                <td><?= sprintf("%02d", $no++) ?></td>
                                <td class="text-start fw-bold"><?= htmlspecialchars(!empty($row['nama']) ? $row['nama'] : $row['username']) ?></td>
                                <td>
                                    <form action="" method="POST" style="margin: 0;">
                                        <input type="hidden" name="id_user" value="<?= $row['id_user'] ?>">
                                        <input type="hidden" name="update_role" value="1">

                                        <select name="role_baru" class="form-select form-select-sm select-role w-50 mx-auto <?= $bg_class ?>" onchange="this.form.submit()">
                                            <option value="admin" <?= ($row['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                            <option value="mahasiswa" <?= ($row['role'] == 'mahasiswa') ? 'selected' : '' ?>>Mahasiswa</option>
                                            <option value="dosen" <?= ($row['role'] == 'dosen') ? 'selected' : '' ?>>Dosen</option>
                                            <option value="kaprodi" <?= ($row['role'] == 'kaprodi') ? 'selected' : '' ?>>Ketua Prodi</option>
                                            <option value="tu" <?= ($row['role'] == 'tu') ? 'selected' : '' ?>>Tata Usaha</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="3" class="py-4 text-muted">Data tidak ditemukan.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>
</body>

</html>