<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit;
}
include('check_role.php');
checkRole(['admin', 'editor']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-blue-900 text-white text-center py-6 shadow">
        <h1 class="text-3xl font-bold">// HALAMAN ADMIN //</h1>
    </header>
    <div class="flex max-w-7xl mx-auto mt-8 px-4">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold text-blue-700 mb-4 textcenter">MENU</h2>
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
        <main class="w-3/4 bg-white rounded shadow p-6 ml-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Daftar Artikel</h2>
                <a href="add_artikel.php"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700
transition">+ Tambah Artikel</a>
            </div>
            <table class="min-w-full table-auto border border-gray-300 text-sm">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-3 border">No</th>
                        <th class="p-3 border">Nama Artikel</th>
                        <th class="p-3 border">Isi Artikel</th>
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_artikel";
                    $query = mysqli_query($db, $sql);
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr class='even:bg-gray-50'>";
                        echo "<td class='border p-2 text-center'>" . $no++ . "</td>";
                        echo "<td class='border p-2'>" .
                            htmlspecialchars($data['nama_artikel']) . "</td>";
                        echo "<td class='border p-2'>" .
                            htmlspecialchars($data['isi_artikel']) . "</td>";
                        echo "<td class='border p-2 text-center space-x-2'>
<a
href='edit_artikel.php?id_artikel={$data['id_artikel']}' class='text-blue600 hover:underline'>Edit</a>
 <a
href='delete_artikel.php?id_artikel={$data['id_artikel']}'
onclick='return confirm(\"Yakin ingin menghapus?\")'
class='text-red-600 hover:underline'>Hapus</a>
</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?php echo date('Y'); ?> | Created by Habibah
    </footer>
</body>

</html>