<?php
include('../koneksi.php');
session_start();

$username = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);

// Cek di database
$sql = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";
$query = mysqli_query($db, $sql);
$data = mysqli_fetch_assoc($query);

if ($data) {
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    // Arahkan berdasarkan role
    if ($data['role'] == 'admin') {
        header('Location: beranda_admin.php');
    } elseif ($data['role'] == 'editor') {
        header('Location: data_artikel.php');
    } elseif ($data['role'] == 'viewer') {
        header('Location: ../index.php'); 
    } else {
        echo "<script>alert('Role tidak dikenali.'); window.location='login.php';</script>";
    }
} else {
    echo "<script>alert('Login gagal! Username atau password salah.'); window.location='login.php';</script>";
}
