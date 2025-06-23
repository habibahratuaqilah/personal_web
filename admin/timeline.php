<?php
include "koneksi.php";
session_start();

$data = mysqli_query($db, "SELECT * FROM tbl_kegiatan ORDER BY tanggal ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Timeline Kegiatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<header class="bg-blue-900 text-white text-center p-6 text-2xl font-bold">
    Timeline Kegiatan
</header>

<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-xl font-bold mb-6 text-blue-700">Jadwal Kegiatan</h2>
    <ul class="space-y-4">
        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <li class="border-l-4 pl-4 <?= $row['status'] === 'Selesai' ? 'border-green-500' : ($row['status'] === 'Sedang Berlangsung' ? 'border-yellow-500' : 'border-red-500') ?>">
                <p class="text-gray-600 text-sm"><?= date('d M Y', strtotime($row['tanggal'])) ?></p>
                <p class="font-semibold"><?= htmlspecialchars($row['deskripsi']) ?></p>
                <span class="text-xs px-2 py-1 rounded inline-block mt-1 <?= $row['status'] === 'Selesai' ? 'bg-green-200 text-green-800' : ($row['status'] === 'Sedang Berlangsung' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') ?>">
                    <?= $row['status'] ?>
                </span>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
</body>
</html>
