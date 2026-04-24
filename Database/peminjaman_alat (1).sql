-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260205.9579895a86
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2026 at 11:12 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_alat`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id_alat` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `nama_alat` varchar(70) DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `foto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id_alat`, `id_kategori`, `nama_alat`, `stok`, `foto`) VALUES
(1, 2, 'tenda', 77, 'https://omeuj.b-cdn.net/wp-content/uploads/Tenda-de-Acampamento-Familiar-8-10-Pessoas-Port%C3%A1til-e-Imperme%C3%A1vel-com-Saco-de-Transporte-4.3x3x2m.jpg'),
(2, 2, 'tas', 5, 'https://png.pngtree.com/png-clipart/20230103/original/pngtree-blue-school-bag-cartoon-illustration-png-image_8864296.png'),
(4, 7, 'pensil', 96, 'https://down-id.img.susercontent.com/file/id-11134207-7r98r-lxfhf70k4jsa4e'),
(5, 15, 'mic', 15, 'https://images.pexels.com/photos/207474/pexels-photo-207474.jpeg?cs=srgb&dl=audio-black-classic-207474.jpg&fm=jpg'),
(6, 11, 'laptop', 12, 'https://wallpapers.com/images/featured/laptop-pictures-2l1fs0hwq4c9obgx.jpg'),
(7, 7, 'pulpen', 60, 'https://tse2.mm.bing.net/th/id/OIP.qlc31OpAf0y3h1UNQvci-QHaEd?pid=Api&P=0&h=180'),
(8, 15, 'speaker', 5, 'https://m.media-amazon.com/images/I/81SOmiG+iDL._AC_SL1500_.jpg'),
(9, 18, 'infocus', 4, 'https://images-na.ssl-images-amazon.com/images/I/71PWccaKMTL._AC_SL1500_.jpg'),
(10, 16, 'monitor', 62, 'https://m.media-amazon.com/images/I/71IC5qsZKpL._AC_SL1000_.jpg'),
(11, 16, 'tv led', 9, 'https://tse2.mm.bing.net/th/id/OIP.o2ytqyrbvHQhhAEIP42YzwHaEC?pid=Api&P=0&h=180');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `keterangan_kategori` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `keterangan_kategori`) VALUES
(2, 'peralatan kemah', 'tenda '),
(6, 'alat gambar', 'digunakan untuk menggambar'),
(7, 'alat belajar', 'digunakan untuk pembelajaran'),
(11, 'alat ngoding', 'digunakan untuk coding'),
(15, 'alat suara', 'digunakan untuk kegiatan'),
(16, 'elektronik', 'hati hari dalam menggunakan alat ini'),
(17, 'alat gambar', 'digunakan untuk kreasi di buku gambar'),
(18, 'barang', 'digunakan untuk dibaca '),
(19, 'alat kebersihan', 'digunakan untuk membersihkan lingkungan '),
(20, 'alat informasi', 'digunakan untuk menginformasikan ');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int NOT NULL,
  `id_user` int NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_user`, `aksi`, `waktu`) VALUES
(1, 1, 'Admin mengubah data peminjaman ID: 27', '2026-04-23 05:39:01'),
(2, 7, 'User melakukan request pinjam alat baru', '2026-04-23 05:46:59'),
(3, 2, 'Petugas menyetujui peminjaman ID: 32', '2026-04-23 05:49:41'),
(4, 2, 'Petugas mengonfirmasi pengembalian alat ID: 32', '2026-04-23 05:49:51'),
(5, 2, 'Petugas mengonfirmasi pengembalian alat ID: 27', '2026-04-23 05:49:55'),
(6, 3, 'User melakukan request pinjam alat baru', '2026-04-23 05:50:36'),
(7, 22, 'User login ke sistem', '2026-04-23 06:24:41'),
(8, 1, 'User login ke sistem', '2026-04-23 06:30:39'),
(9, 2, 'User login ke sistem', '2026-04-23 18:30:34'),
(10, 2, 'User login ke sistem', '2026-04-23 18:35:13'),
(11, 2, 'User login ke sistem', '2026-04-23 18:37:17'),
(12, 2, 'User login ke sistem', '2026-04-23 18:39:27'),
(13, 23, 'User login ke sistem', '2026-04-23 19:01:37'),
(14, 1, 'User login ke sistem', '2026-04-23 19:01:50'),
(15, 23, 'User login ke sistem', '2026-04-24 02:06:32'),
(16, 1, 'User login ke sistem', '2026-04-24 02:06:43'),
(17, 1, 'User login ke sistem', '2026-04-24 07:36:13'),
(18, 1, 'User login ke sistem', '2026-04-24 07:50:12'),
(19, 1, 'User login ke sistem', '2026-04-24 07:52:22'),
(20, 1, 'User login ke sistem', '2026-04-24 07:55:17'),
(21, 1, 'User login ke sistem', '2026-04-24 07:58:04'),
(22, 7, 'User login ke sistem', '2026-04-24 07:58:22'),
(23, 7, 'User login ke sistem', '2026-04-24 10:06:12'),
(24, 1, 'User login ke sistem', '2026-04-24 10:08:11'),
(25, 7, 'User login ke sistem', '2026-04-24 10:12:12'),
(26, 3, 'User login ke sistem', '2026-04-24 10:24:02'),
(27, 1, 'User login ke sistem', '2026-04-24 10:24:47'),
(28, 7, 'User login ke sistem', '2026-04-24 10:28:20'),
(29, 1, 'User login ke sistem', '2026-04-24 10:29:04'),
(30, 1, 'User login ke sistem', '2026-04-24 10:29:54'),
(31, 1, 'User login ke sistem', '2026-04-24 10:30:03'),
(32, 1, 'User login ke sistem', '2026-04-24 10:30:35'),
(33, 1, 'User login ke sistem', '2026-04-24 10:34:44'),
(34, 1, 'User login ke sistem', '2026-04-24 10:37:08'),
(35, 2, 'User login ke sistem', '2026-04-24 10:41:29'),
(36, 1, 'User login ke sistem', '2026-04-24 10:42:19'),
(37, 1, 'User login ke sistem', '2026-04-24 10:51:15'),
(38, 1, 'User login ke sistem', '2026-04-24 10:54:37'),
(39, 1, 'User login ke sistem', '2026-04-24 10:55:33'),
(40, 1, 'User login ke sistem', '2026-04-24 10:55:56'),
(41, 1, 'User login ke sistem', '2026-04-24 10:56:39'),
(42, 1, 'User login ke sistem', '2026-04-24 10:58:47'),
(43, 2, 'User login ke sistem', '2026-04-24 10:59:56'),
(44, 14, 'User login ke sistem', '2026-04-24 11:00:47'),
(45, 1, 'User login ke sistem', '2026-04-24 11:07:28');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_alat` int DEFAULT NULL,
  `jumlah_pinjam` int DEFAULT NULL,
  `tgl_pinjam` timestamp NULL DEFAULT NULL,
  `tgl_kembali_asli` timestamp NULL DEFAULT NULL,
  `status` enum('pending','dipinjam','kembali') DEFAULT 'pending',
  `kondisi_keluar` varchar(50) DEFAULT 'Bagus',
  `kondisi_masuk` varchar(50) DEFAULT NULL,
  `id_petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_alat`, `jumlah_pinjam`, `tgl_pinjam`, `tgl_kembali_asli`, `status`, `kondisi_keluar`, `kondisi_masuk`, `id_petugas`) VALUES
(20, 3, 4, 15, '2026-04-12 17:00:00', '2026-04-13 02:37:54', 'kembali', 'Bagus', 'Rusak Ringan', 2),
(21, 3, 4, 12, '2026-04-21 17:00:00', '2026-04-22 05:49:11', 'kembali', 'Bagus', 'Bagus', 2),
(22, 7, 2, 1, '2026-04-21 17:00:00', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', 2),
(23, 18, 4, 12, '2026-04-22 18:04:42', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(24, 3, 2, 1, '2026-04-22 20:15:23', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(25, 3, 4, 54, '2026-04-22 21:22:58', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(26, 3, 4, 13, '2026-04-22 21:25:40', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(27, 14, 4, 25, '2026-04-22 23:03:54', '2026-04-23 05:49:55', 'kembali', 'Bagus', 'Baik', NULL),
(28, 14, 2, 1, '2026-04-22 23:06:47', '2026-04-23 04:22:02', 'kembali', 'Bagus', 'Baik', NULL),
(29, 7, 4, 6, '2026-04-22 23:09:24', '2026-04-23 04:20:03', 'kembali', 'Bagus', 'Baik', NULL),
(30, 7, 1, 1, '2026-04-22 23:10:04', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(31, 7, 4, 12, '2026-04-22 23:37:45', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(32, 7, 4, 12, '2026-04-23 05:46:59', '2026-04-23 05:49:51', 'kembali', 'Bagus', 'Baik', NULL),
(33, 3, 4, 12, '2026-04-23 05:50:36', NULL, 'pending', 'Bagus', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','peminjam') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'malvien', '$2y$12$7gSP.JYklB0kS4Vc992KhO4eT0jhB.3hrlRDqc9Tnis6m4IxRwIGK', 'admin'),
(2, 'rizky', '$2y$12$4Zf.13udyZwF7hpj/JYdQeGhJu95NhwxgSe7eP.JYF.TYTfwqoxB2', 'petugas'),
(3, 'rendi', '$2y$12$0csx3jY37XfpJhhDHkniZ.4PeEVU.BauuFtXlVdxlNE5.Ls230NH6', 'peminjam'),
(4, 'rezka parsha', '$2y$10$Y3nz77Ocb3CkhyQwCcyqTekd1qn6R6opBSTHaKb3sUcGQak7kmcNO', 'peminjam'),
(7, 'arif', '$2y$12$dYUkTJaJ9EF.Y7i3wHDYX.Qe1PNNqzxFmE1B91MmuDW6PjjIEwanW', 'peminjam'),
(13, 'qqw', '$2y$12$6d.wLnY39A6omzqptI8HH.4/TrcvEgnxeU5126qqyOBxO5av.puAq', 'peminjam'),
(14, 'yaspa', '$2y$12$A9Jq7P5jlIUb/C8.hrJejuc7g9jQTS4MSq9Ubz8SAMg03C.FHWCNS', 'peminjam'),
(15, 'resky', '$2y$12$dO4.B1p64Wol4VfANZnSFuSyCbUXN3Gr.NhO/Bc.HtDnj0jtUqA3G', 'peminjam'),
(16, 'kiki', '$2y$12$tE4bg/92pu91JOKqoaOgsOluvmJN1Y68jSbt3WzAD0fy5SwI8kwdy', 'peminjam'),
(18, 'hiruman', '$2y$12$DIMqR5oaZuzLDj0bw39FLODG66.cR5rN.5s4w.gAG2JSPvTsCGJZq', 'peminjam'),
(19, 'parva rpl2', '$2y$12$j3eJfCn0E8yNkhT4x5Rb5OQcx5ZXvYXYhgBqEsagxV5pIlmY/7z7S', 'peminjam'),
(20, 'gopal', '$2y$12$Gd/WQChW0Etv3n7TNDBAN.bp0w7qEOU/LxBLJDTY0WmUp4DrFWyqW', 'peminjam'),
(21, 'gibrin', '$2y$12$KEqXTRlQQOkEnNIMyyhdFOTroY.tUetCCD9znY/d3cqi2Y2Z9PWzW', 'peminjam'),
(22, 'abc', '$2y$12$qKP6eY17PzSA4uhWz5CYK.CjVq2M6ZwUXKXj2zDw91rGJhLdYl036', 'peminjam'),
(23, 'hilman', '$2y$12$HqU2dDNH5rEQNzfcGlJ9aOaRhg0QpgHIz6HFq55gxsSxquaFotvGu', 'peminjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id_alat`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_log_user` (`id_user`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_alat` (`id_alat`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat`
--
ALTER TABLE `alat`
  ADD CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id_alat`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
