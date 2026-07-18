<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    body {
        background-color: #f4f7f6;
        display: flex;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    .sidebar {
        background: linear-gradient(180deg, #212529 0%, #343a40 100%);
        width: 260px;
        display: flex;
        flex-direction: column;
        padding-top: 30px;
        transition: all 0.3s ease;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        z-index: 1030;
    }

    .sidebar .brand {
        color: white;
        text-align: center;
        padding-bottom: 20px;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
        margin-left: 20px;
        margin-right: 20px;
    }

    .sidebar .nav-item {
        margin: 5px 15px;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.7);
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(5px);
    }

    .sidebar .nav-link.active {
        background-color: white;
        color: #212529;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-item-logout {
        margin-top: auto;
        margin-bottom: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-logout {
        background-color: rgba(220, 53, 69, 0.1);
        color: #ffcccc !important;
        border-radius: 10px;
        padding: 12px 20px;
        text-align: left;
        font-weight: 600;
        border: 1px solid rgba(220, 53, 69, 0.3);
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #dc3545;
        color: white !important;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        transform: translateX(5px);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            flex-direction: column;
            padding-bottom: 75px;
        }

        .sidebar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 75px;
            flex-direction: row;
            padding: 0;
            background: #ffffff;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .sidebar .brand {
            display: none;
        }

        .sidebar .nav {
            flex-direction: row !important;
            width: 100%;
            justify-content: space-around;
            align-items: center;
            margin: 0;
            padding: 0 10px;
        }

        .sidebar .nav-item {
            margin: 0;
            flex: 1;
        }

        .sidebar .nav-item-logout {
            margin: 0;
            padding: 0;
            border: none;
        }

        .sidebar .nav-link,
        .btn-logout {
            flex-direction: column;
            padding: 8px 0;
            gap: 4px;
            font-size: 11px;
            border-radius: 12px;
            color: #6c757d !important;
            background: transparent !important;
            border: none;
            justify-content: center;
            text-align: center;
        }

        .sidebar .nav-link.active {
            color: #212529 !important;
            background-color: rgba(33, 37, 41, 0.1) !important;
            font-weight: 700;
            box-shadow: none;
        }

        .btn-logout {
            color: #dc3545 !important;
        }
    }
</style>

<div class="sidebar">
    <div class="brand">SIMATIC TU</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="status.php" class="nav-link <?= ($current_page == 'status.php') ? 'active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Status Cuti</span>
            </a>
        </li>
        <li class="nav-item nav-item-logout">
            <a href="../logout.php" class="btn-logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>