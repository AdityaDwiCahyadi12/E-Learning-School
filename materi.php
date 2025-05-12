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
    // Set the PDO error mode to exception
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

// Ambil semua materi terbaru
$sql = "SELECT * FROM materials ORDER BY created_at DESC LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran - E-Learning Class</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <a href="forum_diskusi.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-comments w-5 mr-3"></i>
                    <span>Forum Diskusi</span>
                </a>
                <a href="materi.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
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
                        <h1 class="text-xl font-semibold text-gray-800">Materi Pembelajaran</h1>
                        <p class="text-sm text-gray-600">Pelajari materi pembelajaran yang telah disediakan oleh guru</p>
                    </div>
                    <div class="flex space-x-2">
                        <div class="relative">
                            <input type="text" placeholder="Cari materi..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded-lg text-sm font-medium flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Materi List -->
            <div class="space-y-6">
                <?php if (count($materials) > 0): ?>
                    <?php foreach($materials as $row): ?>
                        <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition-shadow">
                            <div class="flex">
                                <div class="bg-blue-100 p-3 rounded-full h-12 w-12 flex items-center justify-center mr-4">
                                    <?php
                                    // Tampilkan icon berdasarkan ekstensi file
                                    $ext = pathinfo($row['file_path'], PATHINFO_EXTENSION);
                                    if (in_array(strtolower($ext), ['pdf'])) {
                                        echo '<i class="fas fa-file-pdf text-blue-600"></i>';
                                    } elseif (in_array(strtolower($ext), ['doc', 'docx'])) {
                                        echo '<i class="fas fa-file-word text-blue-600"></i>';
                                    } elseif (in_array(strtolower($ext), ['ppt', 'pptx'])) {
                                        echo '<i class="fas fa-file-powerpoint text-blue-600"></i>';
                                    } else {
                                        echo '<i class="fas fa-file-alt text-blue-600"></i>';
                                    }
                                    ?>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($row['title']); ?></h3>
                                        <span class="text-xs text-gray-500"><?php echo date('d M Y', strtotime($row['created_at'])); ?></span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Kategori: <?php echo htmlspecialchars($row['category'] ?? 'Umum'); ?></p>
                                    <p class="text-gray-700 mt-2 text-sm"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                                    <?php if (!empty($row['file_path'])): ?>
                                        <div class="mt-3 flex items-center text-sm text-blue-600">
                                            <i class="fas fa-download mr-2"></i>
                                            <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="hover:underline" target="_blank">Download File</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">Tidak ada materi yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleBab(id) {
            const content = document.getElementById(id);
            content.classList.toggle('show');
        }
    </script>
</body>
</html>