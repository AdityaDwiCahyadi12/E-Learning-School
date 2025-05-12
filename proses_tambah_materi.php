<?php
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $judul = $_POST['judul'] ?? '';
        $kategori = $_POST['kategori'] ?? '';
        $konten = $_POST['konten'] ?? '';

        // Upload file
        $file_path = null;
        if (isset($_FILES['file_materi']) && $_FILES['file_materi']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/materi/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            $file_tmp = $_FILES['file_materi']['tmp_name'];
            $file_name = time() . '_' . basename($_FILES['file_materi']['name']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($file_tmp, $target_file)) {
                $file_path = $target_file;
            } else {
                die("Gagal mengupload file.");
            }
        }

        // Simpan ke database
        $course_id = null; // atau ambil dari form jika ada

        $sql = "INSERT INTO materials (course_id, title, content, file_path, created_by, created_at) 
                VALUES (:course_id, :title, :content, :file_path, :created_by, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':course_id' => $course_id,
            ':title' => $judul,
            ':content' => $konten,
            ':file_path' => $file_path,
            ':created_by' => 1 // sesuaikan user id
        ]);

        header("Location: tambah_materi.php?success=1");
        exit;
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
