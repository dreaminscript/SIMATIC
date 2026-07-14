<?php
session_start();

function cek_akses($role_diperlukan) {
    if (!isset($_SESSION['login']) || !isset($_SESSION['username']) || !isset($_SESSION['role'])) {
        header("Location: ../login.php"); 
        exit();
    }

    if ($_SESSION['role'] !== $role_diperlukan) {
        header("Location: ../404.php");
        exit();
    }
}
?>