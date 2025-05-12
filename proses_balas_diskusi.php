<?php
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'smpm29';
$username = 'root';
$password = '';

$userId = $_SESSION['user']['id'] ?? null;

if (!$userId || empty($_POST['diskusi_id']) || empty($_POST['konten'])) {
    header("Location: forum_diskusi.php?error=invalid_input");
    exit;
}

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $diskusiId = $_POST['diskusi_id'];
    $konten = $_POST['konten'];

    // Prepare and execute query
    $stmt = $pdo->prepare("INSERT INTO replies (discussion_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$diskusiId, $userId, $konten]);

    // Redirect on success
    header("Location: forum_diskusi.php?success=balasan_dikirim");
} catch (PDOException $e) {
    echo "Gagal mengirim balasan: " . $e->getMessage();
}
?>
