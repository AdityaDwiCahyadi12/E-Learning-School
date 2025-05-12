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

// Ambil data dari form
$judul = $_POST['judul'];
$konten = $_POST['konten'];
$user_id = 1; // Gantilah dengan ID pengguna yang terautentikasi, misalnya menggunakan session

// Sanitasi input
$judul = htmlspecialchars($judul, ENT_QUOTES, 'UTF-8');
$konten = htmlspecialchars($konten, ENT_QUOTES, 'UTF-8');

// Validasi input
if (empty($judul) || empty($konten)) {
    die("Judul dan konten tidak boleh kosong.");
}

// Menyimpan diskusi ke database
$sqlDiskusi = "INSERT INTO discussions (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $mysqli->prepare($sqlDiskusi);
$stmt->bind_param("iss", $user_id, $judul, $konten);

if ($stmt->execute()) {
    // Redirect ke halaman forum setelah berhasil
    header("Location: forum_diskusi.php");
    exit;
} else {
    // Jika gagal
    die("Gagal memposting diskusi.");
}

// Tutup koneksi
$stmt->close();
$mysqli->close();
?>
