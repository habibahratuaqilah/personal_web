<?php
include "koneksi.php";
session_start();
$ip = $_SERVER['REMOTE_ADDR'];
$tanggal = date('Y-m-d');

// Cek apakah sudah tercatat
$cek = mysqli_query($db, "SELECT * FROM tbl_pengunjung WHERE ip_address='$ip' AND tanggal='$tanggal'");
if (mysqli_num_rows($cek) == 0) {
    mysqli_query($db, "INSERT INTO tbl_pengunjung (ip_address, tanggal) VALUES ('$ip', '$tanggal')");
}

// Proses form kirim pesan
$pesan_terkirim = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($db, $_POST['nama']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $isi_pesan = mysqli_real_escape_string($db, $_POST['isi_pesan']);

    if ($nama && $email && $isi_pesan) {
        mysqli_query($db, "INSERT INTO tbl_pesan (nama, email, isi_pesan) VALUES ('$nama', '$email', '$isi_pesan')");
        $pesan_terkirim = "Pesan berhasil dikirim!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Personal Web | Kontak</title>
    <link rel="stylesheet" href="./src/output.css">
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <!-- Header -->
    <header class="bg-blue-900 text-white text-center p-6 text-2xl font-bold">
        Personal Web | Habibah
    </header>

    <!-- Navigation -->
    <nav class="bg-blue-700 text-white py-3">
        <ul class="flex justify-center space-x-10 font-medium text-lg">
            <li><a href="index.php" class="hover:underline">Artikel</a></li>
            <li><a href="gallery.php" class="hover:underline">Gallery</a></li>
            <li><a href="about.php" class="hover:underline">About</a></li>
            <li><a href="kontak.php" class="hover:underline">Kontak</a></li>
            <?php if (isset($_SESSION['username'])) : ?>
                <li class="hover:underline">👤 <?= htmlspecialchars($_SESSION['username']) ?></li>
                <li><a href="admin/logout.php" class="hover:underline text-red-300">Logout</a></li>
            <?php else : ?>
                <li><a href="admin/login.php" class="hover:underline">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-3xl mx-auto p-8 mt-10 bg-white rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-blue-800 text-center border-b pb-4">📬 Buku Tamu / Form Kontak</h2>

        <?php if ($pesan_terkirim): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded border border-green-300 text-center font-medium">
                <?= $pesan_terkirim ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama Anda"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required />
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Alamat Email</label>
                <input type="email" name="email" placeholder="contoh@email.com"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required />
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Isi Pesan</label>
                <textarea name="isi_pesan" rows="6" placeholder="Tulis pesan atau kesan Anda di sini..."
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"
                    required></textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition duration-200">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </main>


    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?= date('Y'); ?> | Created by Habibah
    </footer>
</body>

</html>