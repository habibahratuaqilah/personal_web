<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit;
}
include('check_role.php');
checkRole(['admin']);
$id = $_GET['id_gallery'];
$sql = "SELECT * FROM tbl_gallery WHERE id_gallery = '$id'";
$query = mysqli_query($db, $sql);
$data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Gambar Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-blue-900 text-white text-center py-6 shadow">
        <h1 class="text-3xl font-bold">Edit Gambar Gallery</h1>
    </header>
    <div class="flex max-w-7xl mx-auto mt-8 px-4">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold text-blue-700 mb-4 textcenter">MENU</h2>
            <ul class="space-y-2 text-gray-700">
                <li><a href="beranda_admin.php" class="block hover:text-blue600">Beranda</a></li>
                <li><a href="data_artikel.php" class="block hover:text-blue600">Kelola Artikel</a></li>
                <li><a href="data_gallery.php" class="block font-semibold text-blue800">Kelola Gallery</a></li>
                <li><a href="about.php" class="block hover:text-blue600">About</a></li>
                <li>
                    <a href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');"
                        class="block text-red-600 hover:underline fontmedium">Logout</a>
                </li>
            </ul>
        </aside>
        <!-- Main Content -->
        <main class="w-3/4 bg-white rounded shadow p-6 ml-6">
            <form action="proses_edit_gallery.php" method="post"
                enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="id_gallery" value="<?php echo
                                                                $data['id_gallery']; ?>">
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700
mb-1">Judul Gambar</label>
                    <input type="text" id="judul" name="judul" required
                        value="<?php echo htmlspecialchars($data['judul']); ?>"
                        class="w-full p-2 border rounded focus:outline-none focus:ring
focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar
                        Saat Ini</label>
                    <img src="../images/<?php echo $data['foto']; ?>" class="h-40
rounded shadow mb-3" alt="Foto Lama">
                </div>
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700
mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file" id="foto" name="foto" accept="image/*"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2
file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="submit"
                        class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue800 transition">Simpan Perubahan</button>
                    <a href="data_gallery.php"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bggray-400 transition">Batal</a>
                </div>
            </form>
        </main>
    </div>
    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?php echo date('Y'); ?> | Created by Habibah
    </footer>
</body>

</html>