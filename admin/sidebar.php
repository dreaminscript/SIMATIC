<style>
    body {
        background-color: #f4f7f6;
        display: flex;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
        background-color: #0d6efd;
        /* Warna biru */
        width: 250px;
        display: flex;
        flex-direction: column;
        padding-top: 20px;
    }

    .sidebar .brand {
        color: white;
        text-align: center;
        padding-bottom: 20px;
        font-size: 1.5rem;
        font-weight: bold;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        border-radius: 0;
        padding: 15px 20px;
        font-weight: 500;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #0a58ca;
        color: white;
    }

    .sidebar .nav-item-logout {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 10px;
    }

    .btn-logout {
        background-color: #dc3545;
        color: white !important;
        border-radius: 0;
        padding: 15px 20px;
        text-align: center;
        font-weight: bold;
        border: none;
        width: 100%;
        display: block;
        text-decoration: none;
    }

    .btn-logout:hover {
        background-color: #bb2d3b;
        color: white !important;
    }

    .main-content {
        flex-grow: 1;
        padding: 30px;
        overflow-y: auto;
    }

    .card-stat {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="sidebar">
    <div class="brand">SIMATIC</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= ($page == 'dashboard') ? 'active' : '' ?>">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="pengajuan.php" class="nav-link <?= ($page == 'pengajuan') ? 'active' : '' ?>">Data Pengajuan</a>
        </li>
        <li class="nav-item">
            <a href="users.php" class="nav-link <?= ($page == 'users') ? 'active' : '' ?>">Data User</a>
        </li>

        <li class="nav-item nav-item-logout">
            <a href="../logout.php" class="btn-logout">Logout</a>
        </li>
    </ul>
</div>