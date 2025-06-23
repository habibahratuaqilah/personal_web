<?php
include('../koneksi.php');
session_start();
include('check_role.php');
checkRole(['admin','editor']);

$nama_artikel = mysqli_real_escape_string($db, $_POST['nama_artikel']);
$isi_artikel = mysqli_real_escape_string($db, $_POST['isi_artikel']);
$kategori = mysqli_real_escape_string($db, $_POST['kategori']);

$sql = "INSERT INTO tbl_artikel (nama_artikel, isi_artikel, kategori) VALUES ('$nama_artikel', '$isi_artikel', '$kategori')";
$query = mysqli_query($db, $sql);

if ($query) {
    echo "<script>alert('Artikel berhasil ditambahkan.'); window.location='data_artikel.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan artikel.'); window.location='tambah_artikel.php';</script>";
}
?>
