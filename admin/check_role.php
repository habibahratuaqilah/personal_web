<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function checkRole($allowedRoles = [])
{
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'editor') {
            echo "<script>alert('Akses ditolak.'); window.location='data_artikel.php';</script>";
        } else {
            echo "<script>alert('Akses ditolak.'); window.location='../index.php';</script>";
        }
        exit;
    }
}
