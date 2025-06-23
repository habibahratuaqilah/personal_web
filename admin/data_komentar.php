<?php
include('../koneksi.php');
session_start();
include('check_role.php');
checkRole(['admin']);

$komentar = mysqli_query($db, "SELECT k.*, a.nama_artikel FROM tbl_komentar k 
                               JOIN tbl_artikel a ON k.id_artikel = a.id_artikel 
                               ORDER BY k.created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Moderasi Komentar</title>
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
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 bg-white rounded shadow p-6 ml-6 overflow-x-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Moderasi Komentar</h2>
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Artikel</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Komentar</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $no = 1;
                    while ($k = mysqli_fetch_array($komentar)) : ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2"><?= $no++ ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($k['nama_artikel']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($k['nama_pengunjung']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($k['isi_komentar']) ?></td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded 
                                <?= $k['status'] === 'diterima' ? 'bg-green-100 text-green-700' : ($k['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                                    <?= ucfirst($k['status']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <?php if ($k['status'] != 'diterima') : ?>
                                    <a href="moderasi_komentar.php?id=<?= $k['id_komentar'] ?>&aksi=terima" class="text-green-600 hover:underline">Terima</a>
                                <?php endif; ?>

                                <?php if ($k['status'] != 'ditolak') : ?>
                                    <a href="moderasi_komentar.php?id=<?= $k['id_komentar'] ?>&aksi=tolak" class="text-yellow-600 hover:underline">Tolak</a>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?= date('Y'); ?> | Created by Habibah
    </footer>
</body>

</html>