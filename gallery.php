<?php include "koneksi.php";
session_start();
$ip = $_SERVER['REMOTE_ADDR'];
$tanggal = date('Y-m-d');

// Cek apakah sudah tercatat
$cek = mysqli_query($db, "SELECT * FROM tbl_pengunjung WHERE ip_address='$ip' AND tanggal='$tanggal'");
if (mysqli_num_rows($cek) == 0) {
    mysqli_query($db, "INSERT INTO tbl_pengunjung (ip_address, tanggal) VALUES ('$ip', '$tanggal')");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gallery | Personal Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <!-- Header -->
    <header class="bg-blue-900 text-white text-center p-6 text-2xl font-bold">
        Gallery | Habibah
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
    <!-- Gallery Grid -->
    <main class="max-w-6xl mx-auto p-6">
        <h2 class="text-xl font-bold mb-6 text-center">Galeri Foto</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php
            $sql = "SELECT * FROM tbl_gallery ORDER BY id_gallery DESC";
            $query = mysqli_query($db, $sql);
            while ($data = mysqli_fetch_array($query)) {
                echo "<div class='bg-white border rounded shadow overflow-hidden'>";
                echo "<img src='images/{$data['foto']}' class='w-full aspect-[2/3] object-cover' alt='Gambar'>";
                echo "<div class='p-4'>";
                echo "<h3 class='text-lg font-semibold text-blue-700'>" .
                    htmlspecialchars($data['judul']) . "</h3>";
                echo "</div></div>";
            }
            ?>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?php echo date('Y'); ?> | Created by Habibah
    </footer>
</body>

</html>