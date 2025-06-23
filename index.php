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

$keyword = isset($_GET['cari']) ? trim($_GET['cari']) : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Personal Web | Home</title>
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
            <?php
            if (isset($_SESSION['username'])) {
                echo '<li class="hover:underline">👤 ' . htmlspecialchars($_SESSION['username']) . '</li>';
                echo '<li><a href="admin/logout.php" class="hover:underline text-red-300">Logout</a></li>';
            } else {
                echo '<li><a href="admin/login.php" class="hover:underline">Login</a></li>';
            }
            ?>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Artikel Utama -->
        <section class="md:col-span-2 bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">Artikel Terbaru</h2>
            <div class="space-y-4">
                <?php
                $where = $keyword ? "WHERE nama_artikel LIKE '%$keyword%' OR isi_artikel LIKE '%$keyword%'" : '';
                $sql = "SELECT * FROM tbl_artikel $where ORDER BY id_artikel DESC";
                $query = mysqli_query($db, $sql);
                if (mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<div class='border-b pb-4'>";
                        echo "<h3 class='text-lg font-semibold text-blue-700'>
                        <a href='admin/detail_artikel.php?id=" . $data['id_artikel'] . "' class='hover:underline'>" .
                            htmlspecialchars($data['nama_artikel']) . "</a>
                      </h3>";
                        echo "<p>" . substr(strip_tags($data['isi_artikel']), 0, 100) . "...</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-gray-500 italic'>Artikel tidak ditemukan.</p>";
                }
                ?>
            </div>
        </section>

        <!-- Sidebar -->
        <aside class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Daftar Artikel</h2>
            <ul class="space-y-2 list-disc list-inside text-gray-700">
                <?php
                $sql = "SELECT * FROM tbl_artikel ORDER BY id_artikel DESC";
                $query = mysqli_query($db, $sql);
                while ($data = mysqli_fetch_array($query)) {
                    echo "<li>" . htmlspecialchars($data['nama_artikel']) . "</li>";
                }
                ?>
            </ul>
        </aside>

        <!-- Form Pencarian -->
        <div class="md:col-span-3">
            <form method="GET" class="flex gap-2 mt-4">
                <input type="text" name="cari" placeholder="Cari artikel..." value="<?= htmlspecialchars($keyword) ?>"
                    class="w-full p-2 border rounded" />
                <button type="submit" class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700">Cari</button>
            </form>
        </div>
    </main>

    <!-- Chatbot Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <!-- Tombol Buka Chatbot -->
        <button onclick="openChatbotModal()" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 z-50">
            💬
        </button>
    </div>

    <!-- Chatbot Modal -->
    <div id="chatbotModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white w-[90%] md:w-[700px] max-h-[80vh] rounded-xl shadow-xl flex flex-col overflow-hidden">

            <!-- Header -->
            <div class="bg-blue-700 text-white p-4 flex justify-between items-center">
                <h2 class="font-semibold text-lg">Tanya Admin</h2>
                <button onclick="closeChatbotModal()" class="text-white text-2xl leading-none hover:text-gray-200">&times;</button>
            </div>

            <!-- Chat Area -->
            <div id="chatContent" class="p-4 space-y-3 overflow-y-auto flex-1 text-sm bg-gray-50">
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg w-fit shadow">Hai! Ada yang bisa saya bantu?</div>
            </div>

            <!-- Input -->
            <form onsubmit="sendMessage(event)" class="flex border-t bg-white p-3 gap-2">
                <input id="userInput" type="text" placeholder="Tulis pertanyaan..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 text-sm" required>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 text-sm rounded-md hover:bg-blue-700 transition">Kirim</button>
            </form>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?= date('Y'); ?> | Created by Habibah
    </footer>

    <script>
        function openChatbotModal() {
            document.getElementById('chatbotModal').classList.remove('hidden');
        }

        function closeChatbotModal() {
            document.getElementById('chatbotModal').classList.add('hidden');
        }

        function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('userInput');
            const chatContent = document.getElementById('chatContent');
            const userMessage = input.value.trim();

            if (!userMessage) return;

            chatContent.innerHTML += `
      <div class="flex justify-end">
        <div class="bg-blue-500 text-dark px-4 py-2 rounded-lg max-w-[100%] shadow">${userMessage}</div>
      </div>
    `;
            input.value = '';
            chatContent.scrollTop = chatContent.scrollHeight;

            setTimeout(() => {
                let reply = "Maaf, saya belum mengerti. Coba pertanyaan lain ya.";

                const faq = {
                    "jadwal": "Lihat jadwal kegiatan di menu 'Jadwal Kegiatan'.",
                    "admin": "Hubungi admin lewat menu kontak di atas.",
                    "login": "Klik tombol Login di kanan atas halaman.",
                };

                const lowerMsg = userMessage.toLowerCase();
                for (let key in faq) {
                    if (lowerMsg.includes(key)) {
                        reply = faq[key];
                        break;
                    }
                }

                chatContent.innerHTML += `
        <div class="flex justify-start">
          <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg max-w-[80%] shadow">${reply}</div>
        </div>
      `;
                chatContent.scrollTop = chatContent.scrollHeight;
            }, 500);
        }
    </script>

</body>

</html>