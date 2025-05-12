<?php
session_start();

$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil data dari form
    $title = $_POST['task_title'] ?? '';
    $description = $_POST['task_description'] ?? '';
    $start_time = $_POST['task_start'] ?? '';
    $deadline = $_POST['task_deadline'] ?? '';
    $category = $_POST['task_category'] ?? '';
    $instruction = $_POST['task_instruction'] ?? '';
    $points = $_POST['task_points'] ?? 0;
    $allow_late_submission = isset($_POST['allow_late_submission']) ? 1 : 0;

    // Tangani upload file (jika ada)
    $attachmentPath = null;
    if (isset($_FILES['task_attachment']) && $_FILES['task_attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/tasks/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['task_attachment']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['task_attachment']['tmp_name'], $targetFile)) {
            $attachmentPath = $targetFile;
        }
    }

    // Validasi sederhana
    if (empty($title) || empty($description) || empty($start_time) || empty($deadline) || empty($category)) {
        die("Semua field wajib diisi.");
    }

    // Simpan data ke tabel tasks
    $sql = "INSERT INTO tasks (title, description, start_time, deadline, category, instruction, attachment, points, allow_late_submission, created_at)
            VALUES (:title, :description, :start_time, :deadline, :category, :instruction, :attachment, :points, :allow_late_submission, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':start_time' => $start_time,
        ':deadline' => $deadline,
        ':category' => $category,
        ':instruction' => $instruction,
        ':attachment' => $attachmentPath,
        ':points' => $points,
        ':allow_late_submission' => $allow_late_submission
    ]);

    // Redirect atau tampilkan pesan sukses
    header("Location: buat_tugas.php?status=success");
    exit;

} catch (PDOException $e) {
    die("Gagal menyimpan tugas: " . $e->getMessage());
}
