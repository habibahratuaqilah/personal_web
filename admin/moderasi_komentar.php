<?php
include('../koneksi.php');
session_start();
include('check_role.php');
checkRole(['admin']);

$id = $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'terima') {
    mysqli_query($db, "UPDATE tbl_komentar SET status='diterima' WHERE id_komentar='$id'");
} elseif ($aksi == 'tolak') {
    mysqli_query($db, "UPDATE tbl_komentar SET status='ditolak' WHERE id_komentar='$id'");
} elseif ($aksi == 'hapus') {
    mysqli_query($db, "DELETE FROM tbl_komentar WHERE id_komentar='$id'");
}

header('Location: data_komentar.php');
