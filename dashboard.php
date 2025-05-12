<?php
// Mulai session
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

try {
    // Buat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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

    // Query untuk materials (tanpa kondisi status)
    $stmtMaterials = $pdo->query("SELECT COUNT(*) AS total FROM materials");
    $totalMateri = $stmtMaterials->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Query jumlah quizzes aktif (yang sedang berlangsung)
    $currentDateTime = date('Y-m-d H:i:s');
    $stmtQuizzes = $pdo->query("SELECT COUNT(*) AS total FROM quizzes WHERE start_time <= '$currentDateTime' AND end_time >= '$currentDateTime'");
    $totalKuis = $stmtQuizzes->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Query jumlah tasks aktif (belum melewati deadline)
    $currentDate = date('Y-m-d H:i:s');
    $stmtTasks = $pdo->query("SELECT COUNT(*) AS total FROM tasks WHERE deadline >= '$currentDate'");
    $totalTugas = $stmtTasks->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Query jumlah discussions baru (misal: dalam 7 hari terakhir)
    $recentDate = date('Y-m-d H:i:s', strtotime('-7 days'));
    $stmtDiscussions = $pdo->query("SELECT COUNT(*) AS total FROM discussions WHERE created_at >= '$recentDate'");
    $totalDiskusi = $stmtDiscussions->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

} catch (PDOException $e) {
    die("Terjadi kesalahan pada database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Learning Class - Dashboard User</title>
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
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .quick-access-card {
            transition: all 0.3s ease;
        }
        .quick-access-card:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
                <a href="#" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
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
                <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
                <p class="text-sm text-gray-600">Selamat datang, <?= htmlspecialchars($userData['full_name'] ?? 'User') ?></p>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Materi Baru</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalMateri ?></h3>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <i class="fas fa-book-open text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-xs mt-3">
                        <i class="fas fa-arrow-up"></i> 2 belum dibaca
                    </p>
                </div>
                
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kuis Aktif</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalKuis ?></h3>
                        </div>
                        <div class="bg-green-100 p-2 rounded-lg">
                            <i class="fas fa-question-circle text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-amber-500 text-xs mt-3">
                        <i class="fas fa-clock"></i> 1 kuis berakhir soon
                    </p>
                </div>
                
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-amber-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tugas Aktif</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalTugas ?></h3>
                        </div>
                        <div class="bg-amber-100 p-2 rounded-lg">
                            <i class="fas fa-tasks text-amber-600"></i>
                        </div>
                    </div>
                    <p class="text-red-500 text-xs mt-3">
                        <i class="fas fa-exclamation-triangle"></i> 1 deadline besok
                    </p>
                </div>
                
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Diskusi Baru</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalDiskusi ?></h3>
                        </div>
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <i class="fas fa-comments text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-blue-500 text-xs mt-3">
                        <i class="fas fa-reply"></i> 2 menunggu respons Anda
                    </p>
                </div>
            </div>
            
            <!-- Quick Access -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="materi.php" class="quick-access-card bg-white rounded-lg shadow-sm p-6 hover:bg-blue-50 cursor-pointer border border-transparent hover:border-blue-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-book-open text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Materi</h3>
                            <p class="text-sm text-gray-500">Akses materi pembelajaran</p>
                        </div>
                    </div>
                </a>
                
                <a href="kuis.php" class="quick-access-card bg-white rounded-lg shadow-sm p-6 hover:bg-green-50 cursor-pointer border border-transparent hover:border-green-200">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-question-circle text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Kuis</h3>
                            <p class="text-sm text-gray-500">Kerjakan kuis yang tersedia</p>
                        </div>
                    </div>
                </a>
                
                <a href="tugas.php" class="quick-access-card bg-white rounded-lg shadow-sm p-6 hover:bg-purple-50 cursor-pointer border border-transparent hover:border-purple-200">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-tasks text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Tugas</h3>
                            <p class="text-sm text-gray-500">Lihat dan kumpulkan tugas</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Aktivitas Terkini</h2>
                    <a href="#" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg">
                        <div class="bg-green-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Anda mengumpulkan tugas</h3>
                            <p class="text-sm text-gray-500">Tugas Matematika - Aljabar Linear</p>
                            <p class="text-xs text-gray-400 mt-1">Hari ini, 10:30</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg">
                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-book text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Materi baru tersedia</h3>
                            <p class="text-sm text-gray-500">Pemrograman Web - Bab 5: JavaScript</p>
                            <p class="text-xs text-gray-400 mt-1">Kemarin, 15:45</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg">
                        <div class="bg-amber-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-question-circle text-amber-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Kuis baru tersedia</h3>
                            <p class="text-sm text-gray-500">Kuis Bahasa Inggris - Grammar</p>
                            <p class="text-xs text-gray-400 mt-1">2 hari lalu</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg">
                        <div class="bg-purple-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-comment-dots text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Diskusi baru di forum</h3>
                            <p class="text-sm text-gray-500">"Pertanyaan tentang tugas minggu ini"</p>
                            <p class="text-xs text-gray-400 mt-1">3 hari lalu</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Deadline Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Deadline Mendatang</h2>
                    <a href="tugas.php" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                        <div>
                            <h3 class="font-medium text-gray-800">Tugas Matematika</h3>
                            <p class="text-sm text-gray-500">Besok, 23:59</p>
                        </div>
                        <a href="#" class="text-red-600 hover:text-red-800 text-sm font-medium">Kerjakan</a>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg border-l-4 border-amber-500">
                        <div>
                            <h3 class="font-medium text-gray-800">Kuis Bahasa Inggris</h3>
                            <p class="text-sm text-gray-500">2 hari lagi</p>
                        </div>
                        <a href="#" class="text-amber-600 hover:text-amber-800 text-sm font-medium">Mulai</a>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                        <div>
                            <h3 class="font-medium text-gray-800">Proyek Akhir</h3>
                            <p class="text-sm text-gray-500">7 hari lagi</p>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>