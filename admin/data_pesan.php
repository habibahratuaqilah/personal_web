<?php
include "../koneksi.php";
session_start();
include "check_role.php";
checkRole(['admin']);

$pesan = mysqli_query($db, "SELECT * FROM tbl_pesan ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Data Pesan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-blue-900 text-white text-center py-6 shadow">
        <h1 class="text-3xl font-bold">Dashboard Admin</h1>
    </header>

    <div class="flex max-w-7xl mx-auto mt-8 px-4">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold text-blue-700 mb-4 text-center">MENU</h2>
            <ul class="space-y-2 text-gray-700">
            <ul class="space-y-2 text-gray-700">
                <li><a href="beranda_admin.php" class="block hover:text-blue-600">Beranda</a></li>
                <li><a href="data_artikel.php" class="block hover:text-blue-600">Kelola Artikel</a></li>
                <li><a href="data_gallery.php" class="block hover:text-blue-600">Kelola Gallery</a></li>
                <li><a href="about.php" class="block hover:text-blue-600">About</a></li>
                <li><a href="data_komentar.php" class="block hover:text-blue-600">Moderasi Komentar</a></li>
                <li><a href="statistik.php" class="block hover:text-blue-600">Statistik Pengunjung</a></li>
                <li><a href="data_pesan.php" class="block hover:text-blue-600">Buku Tamu</a></li>
                <li><a href="data_kegiatan.php" class="block font-semibold text-blue-800">Jadwal Kegiatan</a></li>
                <li>
                    <a href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');"
                        class="block text-red-600 hover:underline font-medium">Logout</a>
                </li>
            </ul>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 bg-white rounded shadow p-6 ml-6 overflow-x-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">📨 Data Pesan Pengunjung</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 text-sm">
                    <thead class="bg-gray-100 text-gray-700 text-left">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Isi Pesan</th>
                            <th class="px-4 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-800">
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($pesan)): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2"><?= $no++ ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['email']) ?></td>
                            <td class="px-4 py-2 whitespace-pre-line"><?= nl2br(htmlspecialchars($row['isi_pesan'])) ?></td>
                            <td class="px-4 py-2"><?= $row['created_at'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?= date('Y'); ?> | Created by Habibah
    </footer>

</body>

</html>
