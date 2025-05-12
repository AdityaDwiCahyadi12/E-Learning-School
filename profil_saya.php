<?php
// Mulai session
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

// Buat koneksi database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
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

// Format tanggal bergabung
$joinDate = $userData['created_at'] ? date('d F Y', strtotime($userData['created_at'])) : 'Tidak diketahui';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Class - Profil Saya</title>
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
        .profile-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
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
                <a href="profil_saya.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
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
            
            <!-- Profile Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="profile-card bg-white rounded-lg shadow-sm p-6">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($userData['full_name'] ?? 'User') ?>&background=3b82f6&color=fff&size=128" 
                                 alt="Profil" 
                                 class="w-32 h-32 rounded-full border-4 border-white shadow-md">
                            <button class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($userData['full_name'] ?? 'User') ?></h2>
                        <p class="text-gray-500 mb-2"><?= htmlspecialchars($userData['role'] ?? 'Role') ?></p>
                        <div class="flex space-x-2">
                            <button class="bg-blue-100 text-blue-600 p-2 rounded-full hover:bg-blue-200">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="bg-blue-100 text-blue-400 p-2 rounded-full hover:bg-blue-200">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="bg-pink-100 text-pink-600 p-2 rounded-full hover:bg-pink-200">
                                <i class="fab fa-instagram"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-gray-500">Bergabung sejak</span>
                            <span class="text-sm text-gray-800"><?= $joinDate ?></span>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-gray-500">Terakhir login</span>
                            <span class="text-sm text-gray-800">Hari ini, <?= date('H:i') ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Status</span>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Aktif</span>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Profile Form -->
                <div class="lg:col-span-2">
                    <form id="profileForm" method="POST" action="update_profile.php">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" 
                                           name="full_name"
                                           value="<?= htmlspecialchars($userData['full_name'] ?? '') ?>" 
                                           class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <input type="text" 
                                           name="username"
                                           value="<?= htmlspecialchars($userData['username'] ?? '') ?>" 
                                           class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" 
                                       name="email"
                                       value="<?= htmlspecialchars($userData['email'] ?? '') ?>" 
                                       class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                    </form>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h3>
                    <form id="passwordForm" method="POST" action="update_password.php">
                        <input type="hidden" name="user_id" value="<?= $userId ?>">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" required
                                    class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="new_password" required
                                    class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" name="confirm_password" required
                                    class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
