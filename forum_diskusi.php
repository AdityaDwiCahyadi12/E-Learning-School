<?php
// Mulai session
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

// Membuat koneksi PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Ambil data user
$userId = $_SESSION['user']['id'] ?? null;
$userData = [];

if ($userId) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error mengambil data user: " . $e->getMessage());
    }
}

// Ambil semua diskusi terbaru
$stmt = $pdo->query("SELECT d.id, u.full_name, u.role, d.title, d.content, d.created_at FROM discussions d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");
$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil semua balasan untuk diskusi
$repliesStmt = $pdo->query("SELECT r.id, r.discussion_id, u.full_name, r.content, r.created_at FROM replies r JOIN users u ON r.user_id = u.id ORDER BY r.created_at ASC");
$replies = $repliesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forum Diskusi - E-Learning Class</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover {
            background-color: #f1f5f9;
            border-left: 3px solid #3b82f6;
        }
        .sidebar-item.active {
            background-color: #e0e7ff;
            color: #3b82f6;
            font-weight: 500;
            border-left: 3px solid #3b82f6;
        }
        .materi-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .materi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .bab-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .bab-content.show {
            max-height: 1000px;
        }
    </style>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-white shadow-lg fixed left-0 sidebar">
            <div class="flex items-center justify-center p-4 border-b">
                <span class="text-xl font-bold text-gray-800">E-Learning Class</span>
            </div>
            <div class="p-4">
                <div class="flex items-center mb-6 p-3 bg-gray-100 rounded-lg">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($userData['full_name'] ?? 'User') ?>&background=3b82f6&color=fff" alt="Profil" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-medium text-gray-800"><?= htmlspecialchars($userData['full_name'] ?? 'User') ?></p>
                        <p class="text-xs text-gray-500"><?= htmlspecialchars($userData['role'] ?? 'Role') ?></p>
                    </div>
                </div>
                
                <p class="text-xs font-semibold text-gray-500 px-2 mb-2">MENU UTAMA</p>
                <a href="dashboard.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-home w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <p class="text-xs font-semibold text-gray-500 px-2 mb-2 mt-4">PROFIL</p>
                <a href="profil_saya.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-user w-5 mr-3"></i>
                    <span>Profil Saya</span>
                </a>

                <p class="text-xs font-semibold text-gray-500 px-2 mb-2 mt-4">PEMBELAJARAN</p>
                <a href="forum_diskusi.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-comments w-5 mr-3"></i>
                    <span>Forum Diskusi</span>
                </a>
                <a href="materi.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-book-open w-5 mr-3"></i>
                    <span>Materi</span>
                </a>
                <a href="kuis.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-question-circle w-5 mr-3"></i>
                    <span>Kuis</span>
                </a>
                <a href="tugas.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-tasks w-5 mr-3"></i>
                    <span>Tugas</span>
                </a>

                <div class="border-t mt-4 pt-2">
                    <a href="keluar.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64 w-full p-6">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">Forum Diskusi Kelas</h1>
                        <p class="text-sm text-gray-600">Diskusikan materi pembelajaran dengan teman sekelas dan guru</p>
                    </div>
                    <button id="btnNewDiscussion" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i> Diskusi Baru
                    </button>
                </div>
            </div>

            <!-- Form Diskusi Baru -->
            <div class="forum-card bg-white rounded-lg shadow-sm p-6 mb-6 hidden" id="newDiscussionForm">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-edit mr-2 text-blue-500"></i> Buat Diskusi Baru
                </h2>
                <form action="proses_buat_diskusi_siswa.php" method="POST">
                    <div class="mb-4">
                        <label for="judul" class="block text-sm font-semibold text-gray-600 mb-1">Judul Diskusi</label>
                        <input type="text" id="judul" name="judul" class="w-full p-3 border border-gray-300 rounded-lg input-field" placeholder="Masukkan judul diskusi" required />
                    </div>
                    <div class="mb-4">
                        <label for="konten" class="block text-sm font-semibold text-gray-600 mb-1">Isi Diskusi</label>
                        <textarea id="konten" name="konten" rows="4" class="w-full p-3 border border-gray-300 rounded-lg input-field" placeholder="Tulis isi diskusi Anda secara detail" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelDiscussion" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg">
                            Posting Diskusi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Daftar Diskusi -->
            <div class="space-y-6">
                <?php foreach ($discussions as $discussion): ?>
                    <div class="forum-card bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-comments text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($discussion['title']) ?></h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Oleh: <?= htmlspecialchars($discussion['full_name']) ?> (<?= htmlspecialchars($discussion['role']) ?>) • 
                                            <span class="text-xs text-gray-500"><?= date('d M Y, H:i', strtotime($discussion['created_at'])) ?></span>
                                        </p>
                                    </div>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                                <p class="text-gray-700 mt-3"><?= nl2br(htmlspecialchars($discussion['content'])) ?></p>

                                <!-- Reply Form -->
                                <div class="mt-6">
                                    <form action="proses_balas_diskusi.php" method="POST">
                                        <input type="hidden" name="diskusi_id" value="<?= $discussion['id'] ?>" />
                                        <input type="hidden" name="user_id" value="<?= $userId ?>" />
                                        <div class="mb-4">
                                            <textarea name="konten" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Tulis balasan Anda..." required></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg">
                                                Kirim Balasan
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Tampilkan balasan -->
                                <div class="mt-4">
                                    <?php foreach ($replies as $reply): ?>
                                        <?php if ($reply['discussion_id'] == $discussion['id']): ?>
                                            <div class="reply-card mb-4">
                                                <p class="font-semibold"><?= htmlspecialchars($reply['full_name']) ?></p>
                                                <p class="text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($reply['created_at'])) ?></p>
                                                <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan form diskusi baru
        document.getElementById('btnNewDiscussion').addEventListener('click', function() {
            document.getElementById('newDiscussionForm').classList.toggle('hidden');
        });

        // Fungsi untuk membatalkan form diskusi baru
        document.getElementById('cancelDiscussion').addEventListener('click', function() {
            document.getElementById('newDiscussionForm').classList.add('hidden');
        });
    </script>
</body>
</html>
