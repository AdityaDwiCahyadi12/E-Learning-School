<?php
session_start();

// Koneksi database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'smpm29';

$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Ambil data dari form
$discussion_id = intval($_POST['discussion_id']);
$content = $mysqli->real_escape_string($_POST['content']);

// Ambil user_id dari session (pastikan user sudah login dan session user_id tersedia)
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    die("Anda harus login untuk membalas diskusi.");
}

// Insert balasan
$sql = "INSERT INTO replies (discussion_id, user_id, content, created_at) VALUES ($discussion_id, $user_id, '$content', NOW())";

if ($mysqli->query($sql)) {
    header("Location: forum_diskusi.php");
    exit;
} else {
    echo "Gagal menyimpan balasan: " . $mysqli->error;
}
?>
