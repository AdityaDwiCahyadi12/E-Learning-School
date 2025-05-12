<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kuis - E-Learning Class</title>
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
        .quiz-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .quiz-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .quiz-card.active {
            border-left-color: #3b82f6;
            background-color: #f8fafc;
        }
        .option-item {
            transition: all 0.2s ease;
        }
        .option-item:hover {
            background-color: #f1f5f9;
        }
        .option-item.correct {
            background-color: #d1fae5;
            border-color: #10b981;
        }
        .option-item.incorrect {
            background-color: #fee2e2;
            border-color: #ef4444;
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
                <p class="text-xs font-semibold text-gray-500 px-2 mb-2">MENU UTAMA</p>
                <a href="dashboard.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <p class="text-xs font-semibold text-gray-500 px-2 mb-2 mt-4">MANAJEMEN ANGGOTA</p>
                <a href="tambah_anggota.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-user-plus w-5 mr-3"></i>
                    <span>Tambah Anggota</span>
                </a>
                <p class="text-xs font-semibold text-gray-500 px-2 mb-2 mt-4">PEMBELAJARAN</p>
                <a href="forum_diskusi.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-comments w-5 mr-3"></i>
                    <span>Forum Diskusi</span>
                </a>
                <a href="tambah_materi.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-book-open w-5 mr-3"></i>
                    <span>Tambah Materi</span>
                </a>
                <a href="buat_kuis.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-question-circle w-5 mr-3"></i>
                    <span>Buat Kuis</span>
                </a>
                <a href="buat_tugas.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-tasks w-5 mr-3"></i>
                    <span>Buat Tugas</span>
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
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <h1 class="text-xl font-semibold text-gray-800">Buat Kuis Interaktif</h1>
                <p class="text-sm text-gray-600">Buat kuis menarik dengan berbagai jenis pertanyaan</p>
            </div>

            <!-- Quiz Creation Form -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Form Buat Kuis</h2>
                <form id="quiz-form" action="proses_buat_kuis.php" method="POST">
                    <div class="mb-6">
                        <label for="quiz-title" class="block text-sm font-semibold text-gray-600 mb-2">Judul Kuis</label>
                        <input type="text" id="quiz-title" name="quiz_title" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul kuis" required>
                    </div>

                    <!-- Duration and Time -->
                    <div class="mb-6">
                        <label for="duration" class="block text-sm font-semibold text-gray-600 mb-2">Durasi Kuis (menit)</label>
                        <input type="number" id="duration" name="duration" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan durasi dalam menit" required>
                    </div>
                    <div class="mb-6">
                        <label for="starttime" class="block text-sm font-semibold text-gray-600 mb-2">Waktu Mulai</label>
                        <input type="datetime-local" id="starttime" name="starttime" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label for="endtime" class="block text-sm font-semibold text-gray-600 mb-2">Waktu Selesai</label>
                        <input type="datetime-local" id="endtime" name="endtime" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Dynamic Questions -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-semibold text-gray-800">Pertanyaan Kuis</h3>
                            <button type="button" id="add-question" class="flex items-center text-sm bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                                <i class="fas fa-plus mr-2"></i> Tambah Pertanyaan
                            </button>
                        </div>
                        <div id="questions-container">
                            <!-- Questions will be dynamically added here -->
                        </div>
                    </div>

                    <div class="flex justify-center mt-4">
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            Buat Kuis
                        </button>
                    </div>
                </form>
            </div>

            <!-- List of Existing Quizzes -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Kuis</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-6 text-left">Judul Kuis</th>
                                <th class="py-3 px-6 text-left">Durasi (menit)</th>
                                <th class="py-3 px-6 text-left">Waktu Mulai</th>
                                <th class="py-3 px-6 text-left">Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <?php
                        // Include your PDO connection here
                        try {
                            $pdo = new PDO('mysql:host=localhost;dbname=smpm29', 'root', '');
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $e) {
                            die("Could not connect to the database: " . $e->getMessage());
                        }

                        // Now your query will work correctly
                        try {
                            $stmt = $pdo->query("SELECT * FROM quizzes ORDER BY id DESC");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                                echo "<td class='py-3 px-6 text-left'>" . htmlspecialchars($row['title']) . "</td>";
                                echo "<td class='py-3 px-6 text-left'>" . htmlspecialchars($row['duration_minutes']) . "</td>";
                                echo "<td class='py-3 px-6 text-left'>" . htmlspecialchars($row['start_time']) . "</td>";
                                echo "<td class='py-3 px-6 text-left'>" . htmlspecialchars($row['end_time']) . "</td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='4' class='text-center py-3'>Gagal memuat kuis: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-question').addEventListener('click', function() {
            const questionContainer = document.getElementById('questions-container');
            const questionId = `question-${Date.now()}`;
            const questionHTML = `
                <div class="mb-6" id="${questionId}">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Pertanyaan</label>
                    <input type="text" name="questions[${questionId}][question]" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan pertanyaan" required>

                    <label class="block text-sm font-semibold text-gray-600 mb-2 mt-4">Pilihan Jawaban</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="option-A-${questionId}" name="questions[${questionId}][correct_answer]" value="A" class="mr-2" required>
                            <input type="text" name="questions[${questionId}][options][]" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Pilihan A" required>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="option-B-${questionId}" name="questions[${questionId}][correct_answer]" value="B" class="mr-2">
                            <input type="text" name="questions[${questionId}][options][]" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Pilihan B" required>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="option-C-${questionId}" name="questions[${questionId}][correct_answer]" value="C" class="mr-2">
                            <input type="text" name="questions[${questionId}][options][]" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Pilihan C" required>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="option-D-${questionId}" name="questions[${questionId}][correct_answer]" value="D" class="mr-2">
                            <input type="text" name="questions[${questionId}][options][]" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Pilihan D" required>
                        </div>
                    </div>
                </div>
            `;
            questionContainer.insertAdjacentHTML('beforeend', questionHTML);
        });
        </script>
</body>
</html>