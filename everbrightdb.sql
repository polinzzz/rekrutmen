-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2025 at 05:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `everbrightdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_pendukung`
--

CREATE TABLE `dokumen_pendukung` (
  `id` int(11) NOT NULL,
  `pelamar_id` int(11) DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `ijazah` varchar(255) DEFAULT NULL,
  `transkrip` varchar(255) DEFAULT NULL,
  `sertifikat` varchar(255) DEFAULT NULL,
  `skck` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `vaksin1` varchar(255) DEFAULT NULL,
  `vaksin2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen_pendukung`
--

INSERT INTO `dokumen_pendukung` (`id`, `pelamar_id`, `foto_ktp`, `ijazah`, `transkrip`, `sertifikat`, `skck`, `npwp`, `vaksin1`, `vaksin2`) VALUES
(1, 1, 'WIN_20250122_15_57_44_Pro.jpg', 'WIN_20250122_15_57_44_Pro.jpg', 'WIN_20250122_15_57_44_Pro.jpg', 'WIN_20250122_15_57_44_Pro.jpg', 'WIN_20250122_15_57_44_Pro.jpg', 'WIN_20250122_15_57_44_Pro.jpg', 'WIN_20250122_15_57_44_Pro.jpg', 'Memo Internal-Pemberitahuan untuk Melaksanakan Pengayaan Ujikom+Lamp.pdf'),
(4, 4, 'gg.jpg', 'gg.jpg', 'gg.jpg', 'gg.jpg', 'gg.jpg', 'gg.jpg', 'gg.jpg', 'gg.jpg'),
(5, 5, 'FOTO.jpeg', 'FOTO.jpeg', 'FOTO.jpeg', 'FOTO.jpeg', 'FOTO.jpeg', 'FOTO.jpeg', 'FOTO.jpeg', 'FOTO.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_pelamar`
--

CREATE TABLE `jawaban_pelamar` (
  `id` int(11) NOT NULL,
  `pelamar_nik` varchar(20) DEFAULT NULL,
  `soal_id` int(11) DEFAULT NULL,
  `jawaban` char(1) DEFAULT NULL,
  `is_benar` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jawaban_pelamar`
--

INSERT INTO `jawaban_pelamar` (`id`, `pelamar_nik`, `soal_id`, `jawaban`, `is_benar`) VALUES
(1, '12312411431434', 1, 'c', 1),
(2, '12312411431434', 2, 'c', 1),
(3, '12312411431434', 3, 'd', 1),
(4, '12312411431434', 4, 'c', 0),
(5, '12312411431434', 5, 'c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_ujian`
--

CREATE TABLE `jawaban_ujian` (
  `id` int(11) NOT NULL,
  `pelamar_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `jawaban` char(1) NOT NULL,
  `waktu_jawab` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `ID` int(11) NOT NULL,
  `Posisi` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_deskripsi` varchar(255) DEFAULT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tanggal_post` date NOT NULL,
  `batas_akhir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lowongan`
--

INSERT INTO `lowongan` (`ID`, `Posisi`, `deskripsi`, `foto_deskripsi`, `lokasi`, `tanggal_post`, `batas_akhir`) VALUES
(1, 'Sales Marketing', 'Kualifikasi:\r\nPria/Wanita, usia maksimal 25 tahun\r\nPendidikan minimal SMA/SMK sederajat (lebih disukai D3/S1)\r\nMemiliki pengalaman di bidang penjualan menjadi nilai tambah\r\nMampu berkomunikasi dengan baik dan bekerja dalam tim\r\n', 'd3ebef8b3becacc1b580ddf58f466d21.jpeg', 'Medan', '2025-05-28', '2025-06-13'),
(2, 'Manager Operasional', 'Kualifikasi:\r\nPria/Wanita, usia maksimal 35 tahun\r\nPendidikan minimal S2\r\nMemiliki pengalaman di bidang penjualan menjadi nilai tambah\r\nMampu berkomunikasi dengan baik dan bekerja dalam tim\r\n', 'c1e51dd2d7bb4455d0a7d06839731c16.jpeg', 'Medan', '2025-06-09', '2025-06-18');

-- --------------------------------------------------------

--
-- Table structure for table `pelamar`
--

CREATE TABLE `pelamar` (
  `id` int(11) NOT NULL,
  `posisi_dilamar` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status_pernikahan` varchar(50) DEFAULT NULL,
  `kewarganegaraan` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status_lamaran` varchar(50) DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelamar`
--

INSERT INTO `pelamar` (`id`, `posisi_dilamar`, `email`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jk`, `agama`, `alamat`, `status_pernikahan`, `kewarganegaraan`, `foto`, `status_lamaran`) VALUES
(1, 'Sales', 'polin@gmail.com', '12312411431434', 'polin', 'medan', '2003-07-16', 'Laki-laki', NULL, 'medan', 'Belum Menikah', 'WNI', 'WIN_20250122_15_49_49_Pro.jpg', 'Ditolak'),
(4, 'Manager Operasional', 'polinlumbantoruan790@gmail.com', '123141435', 'polin lumbantoruan', 'bandung', '2025-06-14', 'Laki-laki', '', 'medan', 'belum menikah', 'WNI', 'FOTO.jpeg', 'Menunggu'),
(5, 'Manager Operasional', 'dear@gmail.com', '120391271846', 'dear', 'medan', '2025-06-04', 'Perempuan', NULL, 'medan', 'belum menikah', 'WNI', 'FOTO.jpeg', 'Ujian');

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id` int(11) NOT NULL,
  `pelamar_id` int(11) NOT NULL,
  `jenjang` varchar(50) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `ipk` varchar(10) DEFAULT NULL,
  `tahun_masuk` int(11) DEFAULT NULL,
  `tahun_keluar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id`, `pelamar_id`, `jenjang`, `instansi`, `jurusan`, `ipk`, `tahun_masuk`, `tahun_keluar`) VALUES
(1, 1, 'D3', 'Politeknik LP3I Medan', 'TEKNOLOGI KOMPUTER', '3.9', 2022, 2025),
(4, 4, 'D3', 'Politeknik LP3I Medan', 'TK', '3.7', 0, 0),
(5, 5, 'D3', 'Politeknik LP3I Medan', 'TK', '3.7', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman_kerja`
--

CREATE TABLE `pengalaman_kerja` (
  `id` int(11) NOT NULL,
  `pelamar_id` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `tahun_masuk` int(11) NOT NULL,
  `tahun_keluar` int(11) NOT NULL,
  `gaji_sebelumnya` decimal(15,2) DEFAULT NULL,
  `alasan_keluar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengalaman_kerja`
--

INSERT INTO `pengalaman_kerja` (`id`, `pelamar_id`, `nama_perusahaan`, `tahun_masuk`, `tahun_keluar`, `gaji_sebelumnya`, `alasan_keluar`) VALUES
(1, 1, 'PT.EVERBRIGHT MEDAN', 2024, 2025, 0.00, '-'),
(4, 4, '-', 0, 0, 0.00, '-'),
(5, 5, '-', 0, 0, 0.00, '-');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `created_at`, `tanggal`) VALUES
(1, 'interview', 'Jadwal Interview akan masuk ke Gmail masing masing jika anda terpilih', '2025-05-28 07:33:37', '2025-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `soal_ujian`
--

CREATE TABLE `soal_ujian` (
  `id` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `pilihan_a` varchar(255) NOT NULL,
  `pilihan_b` varchar(255) NOT NULL,
  `pilihan_c` varchar(255) NOT NULL,
  `pilihan_d` varchar(255) NOT NULL,
  `jawaban` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soal_ujian`
--

INSERT INTO `soal_ujian` (`id`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `jawaban`, `created_at`) VALUES
(1, 'Lengkapi deret berikut:\r\n2, 6, 12, 20, 30, ...', '36', '40', '42', '50', 'c', '2025-05-28 07:42:04'),
(2, 'Ketika atasan memberikan tugas mendadak dengan tenggat waktu singkat, Anda biasanya:', 'Mengerjakan sesuai kemampuan meskipun terlambat', 'Mengeluh karena tidak adil', 'Berusaha mengatur waktu dan menyelesaikan tepat waktu', 'Meminta rekan kerja mengerjakannya', 'c', '2025-05-28 07:42:36'),
(3, 'Sinonim dari kata \"Efisien\" adalah...', 'Cepat', 'Efektif', ' Produktif', ' Hemat', 'd', '2025-05-28 07:43:06'),
(4, ' Hemat', 'Mendapat cuti hamil saja', 'Mendapat gaji, cuti, dan jaminan sosial', 'Mendapat uang lembur setiap hari', 'Tidak memiliki kewajiban', 'b', '2025-05-28 07:43:39'),
(5, 'Jika Anda melihat rekan kerja melakukan pelanggaran ringan, apa yang akan Anda lakukan?', 'Membiarkannya karena bukan urusan saya', ' Ikut-ikutan karena tidak ada yang tahu', 'Menegur secara baik dan melaporkan jika perlu', 'Menyebarkannya ke grup kerja', 'c', '2025-05-28 07:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp` varchar(6) DEFAULT NULL,
  `token_ganti_password` text NOT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nama_lengkap`, `email`, `password`, `no_hp`, `pendidikan`, `alamat`, `created_at`, `otp`, `token_ganti_password`, `otp_expiry`, `reset_token`, `token_expired`) VALUES
(1, '', 'Polin Lumbantoruan', 'polin@gmail.com', 'polin123', '081290548271', 'D3', 'Medan', '2025-05-28 07:27:13', NULL, '', NULL, NULL, NULL),
(2, '', 'pelamar2', 'pelamar2@gmail.com', 'pelamar2', '0873446745454', 'D3', 'Bandung', '2025-06-07 04:08:50', NULL, '', NULL, NULL, NULL),
(3, '', 'polin', 'polinlumbantoruan37@gmail.com', 'polin123', '0895323329874', 'D3', 'Medan,Binjai,Deli serdang', '2025-06-09 17:03:31', '198492', 'df263d996281d984952c07998dc543581749531953', '2025-06-09 19:27:38', NULL, NULL),
(5, '', 'pelamar4', 'pelamar4@gmail.com', 'pelamar4', '0821047', 'SMA/SMK', 'medan', '2025-06-10 05:44:06', NULL, '', NULL, NULL, NULL),
(6, '', 'pelamar5', 'pelamar5@gmail.com', '$2y$10$V1zeMLtm1Xq5JRnMAZCiNugBSdS5naNSJUs4SE.6NMo4VJlHzWSkK', '020407104', 'S2', 'medan', '2025-06-10 05:47:39', NULL, '', NULL, NULL, NULL),
(7, '', 'alif', 'alif@gmail.com', '$2y$10$vtKCJCRS/TzGqpZ.ogZcKeHv2kwQZ1EWsSBQKAEsD1GxtuHpHdKiS', '082162081058', 'D3', 'ppppppppppppp', '2025-06-16 07:16:23', NULL, '', NULL, NULL, NULL),
(8, '', 'firma', 'firmadeni062@gmail.com', '$2y$10$fA43u3otgD0UcHExROUp.OJofIrm715CqMmFw1B.2ZdH812LLiGse', '07817467', 'D3', 'medan', '2025-06-17 04:54:12', NULL, 'a5e00132373a7031000fd987a3c9f87b1750136075', NULL, NULL, NULL),
(9, '', 'firma2', 'firmad062@gmail.com', '$2y$10$DvrXDxIaSBQxFzK1z2MatOvZBSf1n.wScvAkdhkm7/Wnuz/tpxe/m', '07834784', 'D3', 'medan', '2025-06-17 04:56:10', NULL, 'be83ab3ecd0db773eb2dc1b0a17836a11750136195', NULL, NULL, NULL),
(11, 'polin', 'polin', 'polinlumbantoruan790@gmail.com', '$2y$10$3r4q97vs5SPRNuWqHKR5PuherPP2hanY0mxRFT6W6htHl0phx30HS', '0895323329874', 'D3', 'medan', '2025-06-24 06:25:17', NULL, 'a760880003e7ddedfef56acb3b09697f1750837698', NULL, NULL, NULL),
(13, '', 'pelamar6', 'pelamar6@gmail.com', '$2y$10$OMw7VasBhcX3z06Olnyff.u5UUnqO.cGhK4GyLcuw1uqEBj/62WRK', '08535025', 'D3', 'Medan', '2025-06-25 06:41:41', NULL, '', NULL, NULL, NULL),
(14, 'dear', 'dear', 'dear@gmail.com', '$2y$10$Y7O0euvFOT5jcrO/fR8Sw.TA4IzZmHzsGrc3b8zfNBEYI2QxUgxnO', '087418214', 'S2', 'Medan', '2025-06-25 08:18:51', NULL, '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen_pendukung`
--
ALTER TABLE `dokumen_pendukung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelamar_id` (`pelamar_id`);

--
-- Indexes for table `jawaban_pelamar`
--
ALTER TABLE `jawaban_pelamar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelamar_nik` (`pelamar_nik`),
  ADD KEY `soal_id` (`soal_id`);

--
-- Indexes for table `jawaban_ujian`
--
ALTER TABLE `jawaban_ujian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_pelamar_soal` (`pelamar_id`,`soal_id`),
  ADD KEY `soal_id` (`soal_id`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelamar_id` (`pelamar_id`);

--
-- Indexes for table `pengalaman_kerja`
--
ALTER TABLE `pengalaman_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelamar_id` (`pelamar_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen_pendukung`
--
ALTER TABLE `dokumen_pendukung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jawaban_pelamar`
--
ALTER TABLE `jawaban_pelamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jawaban_ujian`
--
ALTER TABLE `jawaban_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengalaman_kerja`
--
ALTER TABLE `pengalaman_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen_pendukung`
--
ALTER TABLE `dokumen_pendukung`
  ADD CONSTRAINT `dokumen_pendukung_ibfk_1` FOREIGN KEY (`pelamar_id`) REFERENCES `pelamar` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jawaban_pelamar`
--
ALTER TABLE `jawaban_pelamar`
  ADD CONSTRAINT `jawaban_pelamar_ibfk_1` FOREIGN KEY (`pelamar_nik`) REFERENCES `pelamar` (`nik`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_pelamar_ibfk_2` FOREIGN KEY (`soal_id`) REFERENCES `soal_ujian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jawaban_ujian`
--
ALTER TABLE `jawaban_ujian`
  ADD CONSTRAINT `jawaban_ujian_ibfk_1` FOREIGN KEY (`pelamar_id`) REFERENCES `pelamar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_ujian_ibfk_2` FOREIGN KEY (`soal_id`) REFERENCES `soal_ujian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD CONSTRAINT `pendidikan_ibfk_1` FOREIGN KEY (`pelamar_id`) REFERENCES `pelamar` (`id`);

--
-- Constraints for table `pengalaman_kerja`
--
ALTER TABLE `pengalaman_kerja`
  ADD CONSTRAINT `pengalaman_kerja_ibfk_1` FOREIGN KEY (`pelamar_id`) REFERENCES `pelamar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
