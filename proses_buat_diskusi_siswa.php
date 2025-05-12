<?php
// Mulai session
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

// Buat koneksi PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil data dari form dan session
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId || empty($_POST['judul']) || empty($_POST['konten'])) {
    header("Location: forum_diskusi.php?error=invalid_input");
    exit;
}

$judul = $_POST['judul'];
$konten = $_POST['konten'];

// Insert ke database
try {
    $stmt = $pdo->prepare("INSERT INTO discussions (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$userId, $judul, $konten]);
    header("Location: forum_diskusi.php?success=diskusi_dibuat");
} catch (PDOException $e) {
    echo "Gagal membuat diskusi: " . $e->getMessage();
}
