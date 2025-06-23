<?php
include "../koneksi.php";
session_start();
include "check_role.php";
checkRole(['admin']);

// Hapus kegiatan
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($db, "DELETE FROM tbl_kegiatan WHERE id = $id");
    header("Location: data_kegiatan.php");
    exit;
}

// Ambil data kegiatan
$data = mysqli_query($db, "SELECT * FROM tbl_kegiatan ORDER BY tanggal ASC");

// Proses tambah atau update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    if (isset($_POST['edit_id'])) {
        $id = intval($_POST['edit_id']);
        mysqli_query($db, "UPDATE tbl_kegiatan SET tanggal='$tanggal', deskripsi='$deskripsi', status='$status' WHERE id=$id")
            or die('Error update: ' . mysqli_error($db));
    } else {
        mysqli_query($db, "INSERT INTO tbl_kegiatan (tanggal, deskripsi, status) VALUES ('$tanggal', '$deskripsi', '$status')");
    }

    header("Location: data_kegiatan.php");
    exit;
}

// Jika sedang mengedit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($db, "SELECT * FROM tbl_kegiatan WHERE id = $id");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Jadwal Kegiatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

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
            <li><a href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');" class="block text-red-600 hover:underline font-medium">Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="w-3/4 bg-white rounded shadow p-6 ml-6 overflow-x-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Jadwal Kegiatan</h2>

        <!-- Form Tambah/Edit Kegiatan -->
        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <input type="date" name="tanggal" required value="<?= $edit_data['tanggal'] ?? '' ?>" class="border p-2 rounded">
            <input type="text" name="deskripsi" placeholder="Deskripsi kegiatan" required value="<?= $edit_data['deskripsi'] ?? '' ?>" class="border p-2 rounded">
            <select name="status" class="border p-2 rounded">
                <option <?= isset($edit_data) && $edit_data['status'] === 'Belum Dilaksanakan' ? 'selected' : '' ?>>Belum Dilaksanakan</option>
                <option <?= isset($edit_data) && $edit_data['status'] === 'Sedang Berlangsung' ? 'selected' : '' ?>>Sedang Berlangsung</option>
                <option <?= isset($edit_data) && $edit_data['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
            <?php if ($edit_data): ?>
                <input type="hidden" name="edit_id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>
            <button type="submit" class="col-span-1 md:col-span-3 bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                <?= $edit_data ? 'Update Kegiatan' : 'Tambah Kegiatan' ?>
            </button>
        </form>

        <!-- Daftar Kegiatan -->
        <ul class="space-y-3">
            <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <li class="border p-4 rounded shadow bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600"><?= date('d M Y', strtotime($row['tanggal'])) ?></p>
                            <p class="font-semibold"><?= htmlspecialchars($row['deskripsi']) ?></p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <span class="px-2 py-1 text-xs rounded 
                                <?= $row['status'] === 'Selesai' ? 'bg-green-200 text-green-800' :
                                    ($row['status'] === 'Sedang Berlangsung' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') ?>">
                                <?= $row['status'] ?>
                            </span>
                            <a href="?edit=<?= $row['id'] ?>" class="text-blue-600 text-sm hover:underline">Edit</a>
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus kegiatan ini?')" class="text-red-600 text-sm hover:underline">Hapus</a>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </main>
</div>

<!-- Footer -->
<footer class="bg-blue-800 text-white text-center py-4 mt-10">
    &copy; <?= date('Y'); ?> | Created by Habibah
</footer>

</body>
</html>
