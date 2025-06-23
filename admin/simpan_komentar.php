<?php
include "../koneksi.php";
session_start();

$id_artikel = $_POST['id_artikel'];
$nama = mysqli_real_escape_string($db, $_POST['nama_pengunjung']);
$komentar = mysqli_real_escape_string($db, $_POST['isi_komentar']);

$sql = "INSERT INTO tbl_komentar (id_artikel, nama_pengunjung, isi_komentar) VALUES ('$id_artikel', '$nama', '$komentar')";
mysqli_query($db, $sql);

echo "<script>alert('Komentar berhasil dikirim! Menunggu persetujuan.'); window.history.back();</script>";
