<?php
include "../koneksi.php";
session_start();

$id_artikel = $_GET['id'];
$query = mysqli_query($db, "SELECT * FROM tbl_artikel WHERE id_artikel='$id_artikel'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['nama_artikel']) ?> | Detail Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-8 shadow-lg">
        <div class="text-center">
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($data['nama_artikel']) ?></h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto bg-white p-8 mt-10 rounded-lg shadow">
        <p class="text-sm text-gray-500 mb-4">Kategori: <span class="font-medium"><?= htmlspecialchars($data['kategori']) ?></span></p>

        <article class="prose max-w-none text-lg text-gray-800 mb-10">
            <?= nl2br(htmlspecialchars($data['isi_artikel'])) ?>
        </article>

        <!-- Komentar Tampil -->
        <div class="border-t pt-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Komentar</h2>

            <?php
            $komen = mysqli_query($db, "SELECT * FROM tbl_komentar WHERE id_artikel='$id_artikel' AND status='diterima' ORDER BY created_at DESC");
            $adaKomentar = false;
            while ($k = mysqli_fetch_array($komen)) {
                $adaKomentar = true;
                echo "<div class='mb-6 p-4 bg-gray-50 border rounded'>";
                echo "<p class='font-semibold text-blue-800'>" . htmlspecialchars($k['nama_pengunjung']) . "</p>";
                echo "<p class='text-gray-700 mt-1'>" . nl2br(htmlspecialchars($k['isi_komentar'])) . "</p>";
                echo "<p class='text-sm text-gray-400 mt-2'>" . $k['created_at'] . "</p>";
                echo "</div>";
            }
            if (!$adaKomentar) {
                echo "<p class='text-gray-500 italic'>Belum ada komentar.</p>";
            }
            ?>
        </div>

        <!-- Form Komentar -->
        <div class="mt-10 border-t pt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Tinggalkan Komentar</h2>
            <form action="simpan_komentar.php" method="post" class="space-y-4">
                <input type="hidden" name="id_artikel" value="<?= $data['id_artikel'] ?>">
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="nama_pengunjung">Nama Anda:</label>
                    <input type="text" name="nama_pengunjung" id="nama_pengunjung" required class="w-full p-3 border rounded focus:outline-none focus:ring focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="isi_komentar">Komentar:</label>
                    <textarea name="isi_komentar" id="isi_komentar" rows="4" required class="w-full p-3 border rounded focus:outline-none focus:ring focus:ring-blue-300"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded transition">Kirim Komentar</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-16">
        &copy; <?= date('Y'); ?> | Created by Habibah
    </footer>
</body>

</html>
