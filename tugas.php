<?php
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

// Koneksi database
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
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Ambil daftar tugas aktif
$tasks = [];
try {
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY deadline ASC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error mengambil data tugas: " . $e->getMessage());
}

// Handle pengumpulan tugas
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_task'])) {
    $taskId = $_POST['task_id'];
    $comment = $_POST['submission_comment'] ?? '';
    $filePath = '';

    if (isset($_FILES['submission_file']) && $_FILES['submission_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/tasks/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = $userId . '_' . basename($_FILES['submission_file']['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['submission_file']['tmp_name'], $filePath)) {
            $errorMessage = "Gagal mengupload file.";
        }
    } else {
        $errorMessage = "File tugas wajib diunggah.";
    }

    if (empty($errorMessage)) {
        $stmt = $pdo->prepare("
            INSERT INTO task_submissions (task_id, user_id, file_path, comment, submitted_at)
            VALUES (?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE
            file_path = VALUES(file_path),
            comment = VALUES(comment),
            submitted_at = NOW()
        ");
        $stmt->execute([$taskId, $userId, $filePath, $comment]);
        header("Location: tugas.php?submitted=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - E-Learning Class</title>
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
<body class="bg-gray-50">
    <div class="flex min-h-screen">
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

                <a href="materi.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-book-open w-5 mr-3"></i>
                    <span>Materi</span>
                </a>

                <a href="kuis.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-question-circle w-5 mr-3"></i>
                    <span>Kuis</span>
                </a>

                <!-- Set active class on Tugas -->
                <a href="tugas.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
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
        <main class="flex-1 ml-64 p-8 bg-gray-50 min-h-screen">
        <div class="bg-white rounded-md p-4 shadow-sm border border-gray-100 mb-6">
            <h2 class="text-base font-semibold text-gray-800">Daftar Tugas</h2>
            <p class="text-sm text-gray-600">Kumpulkan tugas yang telah diberikan oleh dosen</p>
        </div>

            <?php if (!empty($errorMessage)): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?= htmlspecialchars($errorMessage) ?></div>
            <?php elseif (isset($_GET['submitted'])): ?>
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">Tugas berhasil dikumpulkan!</div>
            <?php endif; ?>

            <?php if (empty($tasks)): ?>
                <p class="text-gray-600">Tidak ada tugas saat ini.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($tasks as $task): ?>
                        <div class="relative flex bg-white rounded-lg p-5 shadow border border-gray-200">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($task['title']) ?></h3>
                                <p class="text-sm text-gray-600 mb-1">Kategori: Umum</p>
                                <p class="text-gray-700 text-sm mb-3 whitespace-pre-line"><?= htmlspecialchars($task['description']) ?></p>

                                <form method="POST" enctype="multipart/form-data" class="space-y-2">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">

                                    <input type="file" name="submission_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>

                                    <textarea name="submission_comment" rows="2" placeholder="Komentar (opsional)" class="w-full mt-2 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400"></textarea>

                                    <button type="submit" name="submit_task" class="inline-block mt-2 text-sm text-blue-600 hover:underline font-medium">📤 Kumpulkan Tugas</button>
                                </form>
                            </div>

                            <!-- Tanggal -->
                            <div class="absolute top-4 right-4 text-sm text-gray-500">
                                <?= date('d M Y', strtotime($task['deadline'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
