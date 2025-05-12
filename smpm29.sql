-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2025 pada 01.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smpm29`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `teacher_id`) VALUES
(1, 'Bahasa Indonesia', NULL, NULL),
(2, 'Penjas', NULL, NULL),
(3, 'Kuis Bahasa Inggris: Uji Kemampuan Dasar', NULL, NULL),
(4, 'Kuis Matematika: Pengetahuan Dasar Matematika', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `discussions`
--

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `discussions`
--

INSERT INTO `discussions` (`id`, `course_id`, `user_id`, `title`, `content`, `created_at`) VALUES
(2, NULL, 1, 'Matimatika', 'Soal Perbandingan Dalam sebuah kelas, perbandingan jumlah siswa laki-laki dan perempuan adalah 3:4. Jika jumlah siswa perempuan ada 36 orang, berapa jumlah siswa laki-laki?', '2025-04-26 12:37:23'),
(4, NULL, 1, 'Bahas Indonesia', 'Mari kita diskusikan tentang bahasa Indonesia secara umum, ya! Bisa mulai dari aspek tata bahasa, penggunaan kata yang tepat, atau bahkan perubahan bahasa yang terjadi dalam kehidupan sehari-hari.', '2025-04-26 22:48:09'),
(5, NULL, 1, 'Kemuhammadiyahan: Peran dan Tantangan dalam Masyarakat Modern', 'Kemuhammadiyahan merupakan ajaran yang diusung oleh Muhammadiyah, salah satu organisasi Islam terbesar di Indonesia, yang didirikan oleh KH. Ahmad Dahlan pada tahun 1912. Organisasi ini memiliki visi untuk menegakkan ajaran Islam yang murni, memperjuangkan pendidikan, dan meningkatkan kesejahteraan umat. Diskusi ini bertujuan untuk menggali lebih dalam mengenai peran Muhammadiyah dalam masyarakat modern serta tantangan-tantangan yang dihadapinya.', '2025-04-28 06:05:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materials`
--

INSERT INTO `materials` (`id`, `course_id`, `title`, `content`, `file_path`, `created_by`, `created_at`) VALUES
(2, NULL, 'Hakikat Ilmu Sains dan Metode Ilmiah', 'Kehidupan manusia yang semakin berkembang dalam hal jumlah penduduk\r\ndan kebutuhannya mendorong para ilmuwan Sains menciptakan berbagai\r\npenemuan untuk membantu kehidupan manusia dan lingkungan sekitar. ', 'uploads/materi/1745673263_IPA.pdf', 1, '2025-04-26 13:14:23'),
(4, NULL, 'BASIC ENGLISH (FOR YOUNG LEARNERS)', 'Definite articles adalah kata sandang tertentu yang berupa kata sandang „the‟ dan\r\ndigunakan pada bentuk-bentuk kata tertentu saja. Sedangkan indefinite articles adalah\r\nmemakai kata sandang „a‟ dan „an‟ yang memiliki arti sebuah. Berikut ini penjelasan kedua\r\nartikel dalam bahasa Inggris.', 'uploads/materi/1745820513_Basic English.pdf', 1, '2025-04-28 06:08:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_text` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 31, 'Dalam permainan sepak bola, jumlah pemain dalam satu tim adalah...', '7 orang', '9 orang', '11 orang', '16 orang', 'C'),
(4, 33, 'Choose the right question: ____ do you like to read books?', 'What', 'When', 'Where', 'Why', 'A'),
(5, 34, 'Tentukan hasil dari 7 x (6 + 4) ÷ 2!', '35', '40', '45', '60', 'B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `question_options`
--

CREATE TABLE `question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `title`, `duration_minutes`, `start_time`, `end_time`) VALUES
(3, 1, 'Kuis UTS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 2, 'Penjas', 15, '2025-04-27 19:34:00', '2025-05-01 07:34:00'),
(32, 1, 'Bahasa Indonesia', 15, '2025-04-28 12:20:00', '2025-04-28 12:20:00'),
(33, 3, 'Kuis Bahasa Inggris: Uji Kemampuan Dasar', 10, '2025-05-09 13:10:00', '2025-06-12 01:10:00'),
(34, 4, 'Kuis Matematika: Pengetahuan Dasar Matematika', 25, '2025-04-29 14:33:00', '2025-04-30 12:33:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `correct_answers` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `replies`
--

INSERT INTO `replies` (`id`, `discussion_id`, `user_id`, `content`, `created_at`) VALUES
(2, 4, 3, 'Tata bahasa Indonesia tidak serumit bahasa lainnya, seperti bahasa Inggris atau Jerman, yang memiliki banyak aturan gramatikal yang perlu dipelajari. Misalnya, dalam bahasa Indonesia kita lebih banyak menggunakan urutan Subjek-Predikat-Objek (S-P-O) dalam kalimat yang sederhana, seperti “Saya (S) makan (P) nasi (O).” Namun, perubahan urutan ini dapat digunakan untuk memberi penekanan atau menunjukkan konteks tertentu.', '2025-05-05 10:45:57'),
(3, 5, 6, 'Assalamualaikum Izin Berdiskusi.\r\nKemuhammadiyahan memang memiliki peran yang sangat penting dalam perkembangan umat Islam di Indonesia, terutama dalam konteks pendidikan dan sosial. Muhammadiyah, yang didirikan oleh KH. Ahmad Dahlan, memiliki visi untuk mengusung ajaran Islam yang murni dengan penekanan pada aspek pendidikan, kesehatan, dan sosial. Mereka menekankan pentingnya pemahaman Islam yang moderat dan rasional, yang menyesuaikan dengan kebutuhan masyarakat modern.', '2025-05-06 11:02:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `instruction` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `allow_late_submission` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `start_time`, `deadline`, `category`, `instruction`, `attachment`, `points`, `allow_late_submission`, `created_at`) VALUES
(1, 'Menganalisis dan Membuat Teks Deskripsi', 'Pantai ini memiliki pasir yang putih dan lembut. Di sepanjang garis pantainya, terdapat deretan pohon kelapa yang melambai-lambai tertiup angin. Air laut yang jernih berwarna biru kehijauan, dengan ombak yang tenang menghempas perlahan ke bibir pantai. Suasana di pagi hari sangatlah sejuk, dengan matahari yang baru terbit menyinari seluruh pantai. Beberapa nelayan sedang bersiap untuk pergi melaut, dan ada juga pengunjung yang berjalan-jalan di tepi pantai sambil menikmati pemandangan. Keindahan alam ini membuat hati terasa damai dan tenang.', '2025-04-27 09:36:00', '2025-05-04 09:36:00', 'Individu', 'Petunjuk Tugas:\r\n\r\n1. Bacalah teks deskripsi yang ada di bawah ini dengan seksama.\r\n2. Setelah itu, buatlah analisis singkat tentang struktur teks deskripsi yang terdapat pada teks tersebut.\r\n3. Buatlah teks deskripsi dengan topik \"Suasana Pantai pada Pagi Hari\" menggunakan struktur teks yang sudah kamu pelajari (perkenalan, deskripsi bagian, dan penutupan).', NULL, 100, 0, '2025-04-27 02:39:48'),
(3, 'Analisis Penggunaan Tenses dalam Bahasa Inggris', 'Tugas ini bertujuan untuk menguji pemahaman dan kemampuan Anda dalam menggunakan tenses dalam bahasa Inggris. Anda diminta untuk menganalisis dan menjelaskan penggunaan tenses yang ada dalam kalimat-kalimat berikut. Selain itu, Anda juga harus membuat contoh kalimat menggunakan tenses yang diminta.', '2025-04-28 13:16:00', '2025-05-09 13:16:00', 'Individu', '**Instruksi Tugas:**\r\n\r\n1. **Identifikasi Tenses:**  \r\n   - Pilih 5 kalimat bahasa Inggris dari buku atau artikel yang sedang Anda baca.\r\n   - Identifikasi jenis tenses yang digunakan dalam setiap kalimat (Present Simple, Past Simple, Future Tense, dll).\r\n\r\n2. **Analisis Penggunaan Tenses:**  \r\n   - Jelaskan mengapa tenses tersebut digunakan dalam kalimat tersebut. Sertakan alasan penggunaan berdasarkan waktu kejadian yang dijelaskan.\r\n\r\n3. **Buat Contoh Kalimat:**  \r\n   - Setelah menganalisis kalimat yang Anda pilih, buatlah 2 contoh kalimat menggunakan tenses yang sama dengan yang telah Anda identifikasi. Pastikan kalimat-kalimat tersebut relevan dengan konteks sehari-hari.\r\n\r\n4. **Penulisan Tugas:**  \r\n   - Tugas ditulis dalam bentuk laporan dengan penjelasan yang jelas dan terstruktur. Pastikan Anda menggunakan bahasa yang baik dan benar.\r\n', NULL, 100, 0, '2025-04-28 06:17:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_submissions`
--

CREATE TABLE `task_submissions` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `role`, `created_at`) VALUES
(1, 'adityadwicahyadi', '$2y$10$/xxh5zf4L2s4FUg5G/LMZuUdEeQnSC79RmKbykvZCuZdAz7yOthF2', 'adityadwicahyadi@gmail.com', 'Aditya Dwi Cahyadi', 'admin', NULL),
(2, 'ahmadwahyu', '$2y$10$laL7XPHk3y6akKb1KruZ0OouHsDlSGPWZJnuyFJ/584qiSLaiS0d2', 'ahmadwahyu@gmail.com', 'Ahmad Wahyu', 'admin', NULL),
(3, 'raritaoktaviani', '$2y$10$qbbm4UMngS748r4TX0Fh9.5/EzlBWBry7Cu8fI6pUndi/Se99kXVi', 'raritaoktaviani@gmail.com', 'Rarita Oktaviani', 'siswa', NULL),
(5, 'gilangkusay', '$2y$10$Qb/lOAghBl/n5G5Km1vF9.EeFUQ6BpsnPXGhXzTJVi6T7EHZNwMKK', 'gilangkusay@gmail.com', 'Gilang Kusay', 'siswa', NULL),
(6, 'zaydanalhafis', '$2y$10$mMuB0WZPabyPCyHYt7YjMe0MBjTMsVpO1Xn87BrJQK7Wm5p/eWpT6', 'zaydanalhafis@gmail.com', 'Zaydan Alhafis', '', NULL),
(7, 'dewipratama', '$2y$10$hTFo4QordG639QCi83y3i.vPxYhbTRnGmNwBjMBYzg8CJcZkFyPe6', 'dewipratama@gmail.com', 'Dewi Pratama', '', NULL),
(8, 'panjiramadhan', '$2y$10$0KdXMIt7y.wVOt1EggZ52OhBxhVKYyVbZ9LmF5qpjzg4FJkV/p1p6', 'panjiramadhan@gmail.com', 'Panji Ramaadhan', '', NULL),
(9, 'cakrahusam', '$2y$10$Jh/W24cr12CYadAsh9tYbekfXJzAa.Q3DYJQHs8YL84C7PZSDnDy6', 'carahusam@gmail.com', 'Cakra Husam', '', NULL),
(10, 'kevinsanjaya', '$2y$10$KJW4k455bVy23bDSwkMoueLPkaawsvW6oESGTnWCp86A.UVGZ0tx6', 'kevinsanjaya@gmail.com', 'Kevin Sanjaya', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indeks untuk tabel `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indeks untuk tabel `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indeks untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indeks untuk tabel `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_id` (`discussion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task_submissions`
--
ALTER TABLE `task_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `task_submissions`
--
ALTER TABLE `task_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `discussions_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `discussions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `materials_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Ketidakleluasaan untuk tabel `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Ketidakleluasaan untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Ketidakleluasaan untuk tabel `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`),
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
