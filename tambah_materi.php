<?php
// Koneksi database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'smpm29';

$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Query untuk mengambil materi terbaru
$sql = "SELECT * FROM materials ORDER BY created_at DESC LIMIT 10";
$result = $mysqli->query($sql);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi - E-Learning Class</title>
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
        .file-upload {
            border: 2px dashed #cbd5e0;
            transition: all 0.3s ease;
        }
        .file-upload:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
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
                <a href="tambah_materi.php" class="sidebar-item active flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
                    <i class="fas fa-book-open w-5 mr-3"></i>
                    <span>Tambah Materi</span>
                </a>
                <a href="buat_kuis.php" class="sidebar-item flex items-center px-3 py-2 text-gray-700 rounded-lg mb-1">
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
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <h1 class="text-xl font-semibold text-gray-800">Tambah Materi Pembelajaran</h1>
                <p class="text-sm text-gray-600">Unggah materi pembelajaran dalam bentuk teks atau file</p>
            </div>
            
            <!-- Create New Material -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Form Tambah Materi</h2>
                <form action="proses_tambah_materi.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="judul" class="block text-sm font-semibold text-gray-600">Judul Materi</label>
                        <input type="text" id="judul" name="judul" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Masukkan judul materi" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="kategori" class="block text-sm font-semibold text-gray-600">Kategori Materi</label>
                        <select id="kategori" name="kategori" class="w-full p-3 border border-gray-300 rounded-lg" required>
                            <option value="">Pilih kategori</option>
                            <option value="Matematika">Matematika</option>
                            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Pemrograman">Pemrograman</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="konten" class="block text-sm font-semibold text-gray-600">Deskripsi Materi</label>
                        <textarea id="konten" name="konten" rows="4" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Tulis deskripsi materi Anda" required></textarea>
                    </div>
                    
                    <!-- File Upload Section -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Lampiran Materi (PDF/DOC/PPT)</label>
                        <div class="file-upload rounded-lg p-8 text-center">
                            <input type="file" id="file_materi" name="file_materi" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <div id="file-upload-content" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Klik untuk mengunggah file atau drag & drop</p>
                                <p class="text-xs text-gray-400 mt-1">Format yang didukung: PDF, DOC, PPT (Maks. 10MB)</p>
                            </div>
                            <div id="file-info" class="hidden mt-4 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt text-blue-500 mr-3"></i>
                                        <div>
                                            <p id="file-name" class="text-sm font-medium text-gray-700"></p>
                                            <p id="file-size" class="text-xs text-gray-500"></p>
                                        </div>
                                    </div>
                                    <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="reset" class="bg-gray-200 text-gray-700 py-2 px-6 rounded-lg hover:bg-gray-300">Reset</button>
                        <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700">Simpan Materi</button>
                    </div>
                </form>
            </div>
            
            <!-- Recent Materials -->
            <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Materi Terbaru</h2>

            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
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
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-500">Belum ada materi.</p>
            <?php endif; ?>
        </div>
        <?php $mysqli->close(); ?>
        </div>
    </div>

    <script>
        // File upload handling
        document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file_materi');
        const fileUploadContent = document.getElementById('file-upload-content');
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const removeFileBtn = document.getElementById('remove-file');

        fileUploadContent.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileType = file.type;
                const validTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                ];

                if (!validTypes.includes(fileType)) {
                    alert('Format file tidak didukung. Harap unggah file PDF, DOC, atau PPT.');
                    fileInput.value = ''; // reset input
                    return;
                }

                if (file.size > 10 * 1024 * 1024) { // 10MB limit
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    fileInput.value = ''; // reset input
                    return;
                }

                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileUploadContent.classList.add('hidden');
                fileInfo.classList.remove('hidden');
            }
        });

        removeFileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            fileInput.value = '';
            fileUploadContent.classList.remove('hidden');
            fileInfo.classList.add('hidden');
        });

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Drag and drop functionality
        const fileUpload = document.querySelector('.file-upload');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUpload.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUpload.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUpload.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            fileUpload.classList.add('border-blue-500', 'bg-blue-50');
        }

        function unhighlight() {
            fileUpload.classList.remove('border-blue-500', 'bg-blue-50');
        }

        fileUpload.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });
    </script>
</body>
</html>