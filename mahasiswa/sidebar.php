<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">

    <div class="logo">
        <h2>SIMATIC</h2>
    </div>

    <ul>


        <li class="<?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">

            <?php if ($current_page == 'dashboard.php') { ?>

                <span>Dashboard</span>

            <?php } else { ?>

                <a href="dashboard.php">Dashboard</a>

            <?php } ?>

        </li>


        <li class="<?= ($current_page == 'pengajuan.php') ? 'active' : ''; ?>">

            <?php if ($current_page == 'pengajuan.php') { ?>

                <span>Ajukan Cuti</span>

            <?php } else { ?>

                <a href="pengajuan.php">Ajukan Cuti</a>

            <?php } ?>

        </li>


        <li class="<?= ($current_page == 'riwayat.php') ? 'active' : ''; ?>">

            <?php if ($current_page == 'riwayat.php') { ?>

                <span>Riwayat Pengajuan</span>

            <?php } else { ?>

                <a href="riwayat.php">Riwayat Pengajuan</a>

            <?php } ?>

        </li>

        <li class="logout">
            <a href="../logout.php">Logout</a>
        </li>

    </ul>

</div>