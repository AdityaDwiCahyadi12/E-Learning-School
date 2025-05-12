<?php
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'smpm29';

$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_error) {
    echo json_encode(['error' => 'Koneksi database gagal']);
    exit;
}

$sql = "SELECT * FROM tasks ORDER BY created_at DESC LIMIT 1"; // ambil tugas terbaru
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $task = $result->fetch_assoc();
    echo json_encode($task);
} else {
    echo json_encode(['error' => 'Data tugas tidak ditemukan']);
}

$mysqli->close();
?>
