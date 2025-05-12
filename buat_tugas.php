<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tugas - E-Learning Class</title>
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
        .task-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .task-card.active {
            border-left-color: #3b82f6;
            background-color: #f8fafc;
        }
        .datetime-picker {
            position: relative;
        }
        .datetime-picker input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 0;
            padding: 1.5rem;
            opacity: 0;
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
                <a href="buat_kuis.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-question-circle w-5 mr-3"></i>
                    <span>Buat Kuis</span>
                </a>
                <a href="buat_tugas.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
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
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <h1 class="text-xl font-semibold text-gray-800">Buat Tugas</h1>
                <p class="text-sm text-gray-600">Buat tugas untuk siswa dengan instruksi yang jelas</p>
            </div>
            
            <!-- Task Creation Form -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Form Buat Tugas</h2>
                <form id="task-form" action="proses_buat_tugas.php" method="POST">
                    <div class="mb-6">
                        <label for="task-title" class="block text-sm font-semibold text-gray-600 mb-2">Judul Tugas</label>
                        <input type="text" id="task-title" name="task_title" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul tugas" required>
                    </div>
                    
                    <div class="mb-6">
                        <label for="task-description" class="block text-sm font-semibold text-gray-600 mb-2">Deskripsi Tugas</label>
                        <textarea id="task-description" name="task_description" rows="5" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan deskripsi detail tentang tugas ini" required></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="task-start" class="block text-sm font-semibold text-gray-600 mb-2">Waktu Mulai</label>
                            <div class="datetime-picker relative">
                                <input type="datetime-local" id="task-start" name="task_start" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label for="task-deadline" class="block text-sm font-semibold text-gray-600 mb-2">Batas Waktu</label>
                            <div class="datetime-picker relative">
                                <input type="datetime-local" id="task-deadline" name="task_deadline" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Kategori Tugas</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="task_category" value="Individu" class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                                <span>Individu</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="task_category" value="Kelompok" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <span>Kelompok</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="task_category" value="Proyek" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <span>Proyek</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="task_category" value="Lainnya" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <span>Lainnya</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="task-instruction" class="block text-sm font-semibold text-gray-600 mb-2">Instruksi Tugas</label>
                        <textarea id="task-instruction" name="task_instruction" rows="8" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis instruksi lengkap untuk tugas ini" required></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label for="task-attachment" class="block text-sm font-semibold text-gray-600 mb-2">Lampiran (Opsional)</label>
                        <div class="flex items-center">
                            <input type="file" id="task-attachment" name="task_attachment" class="hidden">
                            <button type="button" id="upload-btn" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300">
                                <i class="fas fa-paperclip mr-2"></i> Pilih File
                            </button>
                            <span id="file-name" class="ml-3 text-sm text-gray-500">Belum ada file dipilih</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Format file: PDF, DOCX, PPTX, XLSX (Maks. 10MB)</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="task-points" class="block text-sm font-semibold text-gray-600 mb-2">Nilai Maksimal</label>
                        <input type="number" id="task-points" name="task_points" min="1" max="100" value="100" class="w-20 p-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <input type="checkbox" id="allow-late" name="allow_late_submission" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <label for="allow-late" class="ml-2 text-sm text-gray-600">Izinkan pengumpulan terlambat</label>
                        </div>
                        <div class="flex space-x-3">
                            <button type="reset" class="bg-gray-200 text-gray-700 py-2 px-6 rounded-lg hover:bg-gray-300">Reset</button>
                            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700">Simpan Tugas</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Task Preview -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Pratinjau Tugas</h2>
                    <button id="update-preview" class="flex items-center text-sm bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">
                        <i class="fas fa-sync-alt mr-2"></i> Perbarui Pratinjau
                    </button>
                </div>
                
                <!-- Preview Container -->
                <div id="preview-container" class="hidden">
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <h3 id="preview-title" class="text-lg font-semibold text-blue-800">Judul Tugas</h3>
                        <div class="flex items-center text-sm text-blue-600 mt-1">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span id="preview-deadline">Batas waktu: -</span>
                        </div>
                        <div class="flex items-center text-sm text-blue-600 mt-1">
                            <i class="fas fa-users mr-2"></i>
                            <span id="preview-category">Kategori: -</span>
                        </div>
                        <div class="flex items-center text-sm text-blue-600 mt-1">
                            <i class="fas fa-star mr-2"></i>
                            <span id="preview-points">Nilai: -</span>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Deskripsi Tugas</h4>
                        <div id="preview-description" class="prose max-w-none text-gray-700">
                            Deskripsi tugas akan muncul di sini
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Instruksi Tugas</h4>
                        <div id="preview-instruction" class="prose max-w-none text-gray-700">
                            Instruksi tugas akan muncul di sini
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Lampiran</h4>
                        <div id="preview-attachment" class="text-gray-500">
                            Tidak ada lampiran
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-500 mt-1 mr-2"></i>
                            <div>
                                <p class="text-sm text-yellow-700">Tugas ini akan tersedia mulai <span id="preview-start" class="font-medium">-</span> dan batas pengumpulan pada <span id="preview-end" class="font-medium">-</span>.</p>
                                <p id="preview-late" class="text-sm text-yellow-700 mt-1 hidden">Pengumpulan terlambat diizinkan dengan pengurangan nilai.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Empty State -->
                <div id="empty-preview" class="text-center py-8">
                    <i class="fas fa-tasks text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Isi form di atas untuk melihat pratinjau tugas.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function loadTaskPreview() {
            try {
                const response = await fetch('get_tasks.php');
                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Update elemen pratinjau dengan data dari database
                document.getElementById('preview-title').textContent = data.title || '-';
                document.getElementById('preview-description').innerHTML = (data.description || '-').replace(/\n/g, '<br>');
                document.getElementById('preview-instruction').innerHTML = (data.instruction || '-').replace(/\n/g, '<br>');
                document.getElementById('preview-category').textContent = `Kategori: ${data.category || '-'}`;
                document.getElementById('preview-points').textContent = `Nilai: ${data.points || '-'}`;
                document.getElementById('preview-deadline').textContent = `Batas waktu: ${new Date(data.deadline).toLocaleString('id-ID') || '-'}`;
                document.getElementById('preview-start').textContent = new Date(data.start_time).toLocaleString('id-ID') || '-';
                document.getElementById('preview-end').textContent = new Date(data.deadline).toLocaleString('id-ID') || '-';

                if (data.attachment) {
                    document.getElementById('preview-attachment').innerHTML = `
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-paperclip text-gray-400 mr-3"></i>
                            <a href="${data.attachment}" target="_blank" class="text-gray-700 hover:underline">${data.attachment}</a>
                        </div>
                    `;
                } else {
                    document.getElementById('preview-attachment').textContent = 'Tidak ada lampiran';
                }

                if (data.allow_late_submission) {
                    document.getElementById('preview-late').classList.remove('hidden');
                } else {
                    document.getElementById('preview-late').classList.add('hidden');
                }

                // Tampilkan pratinjau
                document.getElementById('empty-preview').classList.add('hidden');
                document.getElementById('preview-container').classList.remove('hidden');

            } catch (error) {
                console.error('Gagal memuat data tugas:', error);
            }
        }

        // Panggil fungsi ini saat tombol "Perbarui Pratinjau" diklik
        document.getElementById('update-preview').addEventListener('click', loadTaskPreview);
    </script>
</body>
</html>