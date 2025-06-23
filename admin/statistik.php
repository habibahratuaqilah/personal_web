<?php
include "../koneksi.php";
session_start();
include "check_role.php";
checkRole(['admin']);

// Ambil data 7 hari terakhir
$data = mysqli_query($db, "
    SELECT tanggal, COUNT(*) AS jumlah 
    FROM tbl_pengunjung 
    GROUP BY tanggal 
    ORDER BY tanggal DESC 
    LIMIT 7
");

$tanggal = [];
$jumlah = [];

while ($row = mysqli_fetch_assoc($data)) {
    $tanggal[] = $row['tanggal'];
    $jumlah[] = $row['jumlah'];
}
$tanggal = array_reverse($tanggal);
$jumlah = array_reverse($jumlah);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Statistik</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Statistik Pengunjung (7 Hari Terakhir)</h2>
            <canvas id="pengunjungChart" height="100"></canvas>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?= date('Y'); ?> | Created by Habibah
    </footer>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('pengunjungChart').getContext('2d');
        const pengunjungChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($tanggal) ?>,
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: <?= json_encode($jumlah) ?>,
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>