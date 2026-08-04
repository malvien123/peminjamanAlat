-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260205.9579895a86
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 04, 2026 at 02:55 AM
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
(2, 2, 'tas', 16, 'https://png.pngtree.com/png-clipart/20230103/original/pngtree-blue-school-bag-cartoon-illustration-png-image_8864296.png'),
(4, 7, 'pensil', 84, 'https://down-id.img.susercontent.com/file/id-11134207-7r98r-lxfhf70k4jsa4e'),
(5, 15, 'mic', 15, 'https://images.pexels.com/photos/207474/pexels-photo-207474.jpeg?cs=srgb&dl=audio-black-classic-207474.jpg&fm=jpg'),
(6, 11, 'laptop', 0, 'https://wallpapers.com/images/featured/laptop-pictures-2l1fs0hwq4c9obgx.jpg'),
(7, 7, 'pulpen', 60, 'https://tse2.mm.bing.net/th/id/OIP.qlc31OpAf0y3h1UNQvci-QHaEd?pid=Api&P=0&h=180'),
(8, 15, 'speaker', 5, 'https://m.media-amazon.com/images/I/81SOmiG+iDL._AC_SL1500_.jpg'),
(9, 18, 'infocus', 5, 'https://images-na.ssl-images-amazon.com/images/I/71PWccaKMTL._AC_SL1500_.jpg'),
(10, 16, 'monitor', 62, 'https://m.media-amazon.com/images/I/71IC5qsZKpL._AC_SL1000_.jpg'),
(11, 16, 'tv led', 10, 'https://tse2.mm.bing.net/th/id/OIP.o2ytqyrbvHQhhAEIP42YzwHaEC?pid=Api&P=0&h=180');

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
(17, 'alat gambar', 'digunakan untuk kreasi di buku gambar anak'),
(18, 'barang', 'digunakan untuk barang'),
(19, '13', 'digunakan untuk membersihkan lingkungan sekitar ');

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
(45, 1, 'User login ke sistem', '2026-04-24 11:07:28'),
(46, 2, 'User login ke sistem', '2026-04-24 11:34:08'),
(47, 2, 'Petugas menyetujui peminjaman ID: 33', '2026-04-24 11:34:49'),
(48, 2, 'Petugas mengonfirmasi pengembalian alat ID: 33', '2026-04-24 11:35:33'),
(49, 2, 'User login ke sistem', '2026-04-24 11:40:36'),
(50, 14, 'User login ke sistem', '2026-04-24 11:48:49'),
(51, 1, 'User login ke sistem', '2026-04-24 11:56:57'),
(52, 1, 'User login ke sistem', '2026-04-24 12:56:32'),
(53, 1, 'User login ke sistem', '2026-04-24 12:57:53'),
(54, 1, 'User login ke sistem', '2026-04-24 12:59:42'),
(55, 1, 'User login ke sistem', '2026-04-24 13:08:55'),
(56, 28, 'User login ke sistem', '2026-04-24 13:09:48'),
(57, 29, 'User login ke sistem', '2026-04-24 13:49:00'),
(58, 29, 'User melakukan request pinjam alat baru', '2026-04-24 13:49:11'),
(59, 2, 'User login ke sistem', '2026-04-24 13:49:34'),
(60, 2, 'Petugas menyetujui peminjaman ID: 34', '2026-04-24 13:49:38'),
(61, 1, 'User login ke sistem', '2026-04-24 13:49:51'),
(62, 1, 'Admin mengubah data peminjaman ID: 34', '2026-04-24 13:50:31'),
(63, 7, 'User login ke sistem', '2026-04-24 13:57:22'),
(64, 7, 'User melakukan request pinjam alat baru', '2026-04-24 13:57:31'),
(65, 2, 'User login ke sistem', '2026-04-24 13:57:47'),
(66, 2, 'Petugas menyetujui peminjaman ID: 35', '2026-04-24 13:57:51'),
(67, 1, 'User login ke sistem', '2026-04-24 13:58:04'),
(68, 1, 'Admin mengubah data peminjaman ID: 35', '2026-04-24 13:58:27'),
(69, 2, 'User login ke sistem', '2026-04-24 14:01:33'),
(70, 2, 'Petugas mengonfirmasi pengembalian alat ID: 35', '2026-04-24 14:01:35'),
(71, 2, 'Petugas mengonfirmasi pengembalian alat ID: 34', '2026-04-24 14:01:38'),
(72, 1, 'User login ke sistem', '2026-04-24 14:01:48'),
(73, 1, 'User login ke sistem', '2026-05-06 03:18:00'),
(74, 1, 'User login ke sistem', '2026-05-07 00:36:16'),
(75, 14, 'User login ke sistem', '2026-05-07 00:37:19'),
(76, 14, 'User melakukan request pinjam alat baru', '2026-05-07 00:37:28'),
(77, 1, 'User login ke sistem', '2026-05-07 00:37:43'),
(78, 1, 'User login ke sistem', '2026-05-11 01:39:29'),
(79, 1, 'User login ke sistem', '2026-05-11 02:10:48'),
(80, 2, 'User login ke sistem', '2026-05-11 02:20:44'),
(81, 1, 'User login ke sistem', '2026-05-11 03:58:05'),
(82, 2, 'User login ke sistem', '2026-05-11 03:59:28'),
(83, 14, 'User login ke sistem', '2026-05-11 04:00:33'),
(84, 1, 'User login ke sistem', '2026-05-11 04:03:14'),
(85, 1, 'User login ke sistem', '2026-05-11 04:11:17'),
(86, 1, 'User login ke sistem', '2026-05-11 11:26:34'),
(87, 1, 'User login ke sistem', '2026-05-12 10:23:50'),
(88, 1, 'User login ke sistem', '2026-05-12 10:25:09'),
(89, 33, 'User login ke sistem', '2026-05-12 10:27:30'),
(90, 1, 'User login ke sistem', '2026-05-12 10:27:42'),
(91, 32, 'User login ke sistem', '2026-05-12 10:28:03'),
(92, 1, 'User login ke sistem', '2026-05-12 10:29:11'),
(93, 1, 'User login ke sistem', '2026-05-12 10:43:27'),
(94, 1, 'User login ke sistem', '2026-05-12 10:48:13'),
(95, 1, 'User login ke sistem', '2026-05-12 10:54:15'),
(96, 1, 'User login ke sistem', '2026-05-12 10:55:59'),
(97, 1, 'Admin mengubah data peminjaman ID: 36', '2026-05-12 10:58:31'),
(98, 14, 'User login ke sistem', '2026-05-12 11:05:59'),
(99, 14, 'User melakukan request pinjam alat baru', '2026-05-12 11:06:07'),
(100, 2, 'User login ke sistem', '2026-05-12 11:06:37'),
(101, 2, 'Petugas menyetujui peminjaman ID: 37', '2026-05-12 11:06:43'),
(102, 1, 'User login ke sistem', '2026-05-12 11:06:54'),
(103, 1, 'Admin mengubah data peminjaman ID: 37', '2026-05-12 11:07:17'),
(104, 1, 'Admin mengubah data peminjaman ID: 37', '2026-05-12 11:07:47'),
(105, 1, 'User login ke sistem', '2026-05-12 11:08:46'),
(106, 2, 'User login ke sistem', '2026-05-12 11:08:59'),
(107, 2, 'Petugas mengonfirmasi pengembalian alat ID: 37', '2026-05-12 11:09:02'),
(108, 1, 'User login ke sistem', '2026-05-12 11:09:20'),
(109, 1, 'User login ke sistem', '2026-05-12 11:13:45'),
(110, 1, 'User login ke sistem', '2026-05-12 11:26:29'),
(111, 1, 'User login ke sistem', '2026-05-12 11:27:59'),
(112, 1, 'User login ke sistem', '2026-05-12 11:38:07'),
(113, 1, 'User login ke sistem', '2026-05-13 02:31:43'),
(114, 14, 'User login ke sistem', '2026-05-13 02:33:00'),
(115, 1, 'User login ke sistem', '2026-05-13 02:33:19'),
(116, 1, 'User login ke sistem', '2026-05-13 03:10:01'),
(117, 3, 'User login ke sistem', '2026-05-13 03:45:45'),
(118, 35, 'User login ke sistem', '2026-05-13 03:47:17'),
(119, 1, 'User login ke sistem', '2026-05-13 03:47:58'),
(120, 14, 'User login ke sistem', '2026-05-13 03:56:45'),
(121, 14, 'User melakukan request pinjam alat baru', '2026-05-13 03:57:26'),
(122, 2, 'User login ke sistem', '2026-05-13 03:57:56'),
(123, 2, 'Petugas menyetujui peminjaman ID: 38', '2026-05-13 03:58:43'),
(124, 1, 'User login ke sistem', '2026-05-13 03:59:03'),
(125, 2, 'User login ke sistem', '2026-05-13 03:59:57'),
(126, 2, 'Petugas mengonfirmasi pengembalian alat ID: 38', '2026-05-13 04:00:29'),
(127, 1, 'User login ke sistem', '2026-05-13 04:01:09'),
(128, 14, 'User login ke sistem', '2026-05-13 04:09:48'),
(129, 14, 'User melakukan request pinjam alat baru', '2026-05-13 04:10:01'),
(130, 1, 'User login ke sistem', '2026-05-13 04:10:24'),
(131, 2, 'User login ke sistem', '2026-05-13 04:11:20'),
(132, 2, 'Petugas menyetujui peminjaman ID: 39', '2026-05-13 04:11:26'),
(133, 1, 'User login ke sistem', '2026-05-13 04:11:40'),
(134, 1, 'Admin mengubah data peminjaman ID: 39', '2026-05-13 04:12:50'),
(135, 2, 'User login ke sistem', '2026-05-13 04:30:19'),
(136, 2, 'Petugas mengonfirmasi pengembalian alat ID: 39', '2026-05-13 04:30:27'),
(137, 1, 'User login ke sistem', '2026-05-13 04:30:43'),
(138, 2, 'User login ke sistem', '2026-05-13 04:33:15'),
(139, 1, 'User login ke sistem', '2026-05-13 04:34:31'),
(140, 7, 'User login ke sistem', '2026-05-13 04:37:02'),
(141, 7, 'User melakukan request pinjam alat baru', '2026-05-13 04:37:12'),
(142, 2, 'User login ke sistem', '2026-05-13 04:37:31'),
(143, 2, 'Petugas menyetujui peminjaman ID: 40', '2026-05-13 04:37:34'),
(144, 1, 'User login ke sistem', '2026-05-13 04:37:45'),
(145, 1, 'Admin mengubah data peminjaman ID: 40', '2026-05-13 04:38:15'),
(146, 2, 'User login ke sistem', '2026-05-13 04:39:17'),
(147, 14, 'User login ke sistem', '2026-05-13 04:40:16'),
(148, 1, 'User login ke sistem', '2026-05-13 06:39:14'),
(149, 14, 'User login ke sistem', '2026-05-13 06:45:04'),
(150, 2, 'User login ke sistem', '2026-05-13 06:49:18'),
(151, 1, 'User login ke sistem', '2026-05-17 07:28:22'),
(152, 14, 'User login ke sistem', '2026-05-17 07:28:46'),
(153, 14, 'User melakukan request pinjam alat baru', '2026-05-17 07:28:52'),
(154, 1, 'User login ke sistem', '2026-05-17 07:29:05'),
(155, 2, 'User login ke sistem', '2026-05-17 07:40:23'),
(156, 2, 'Petugas menyetujui peminjaman ID: 41', '2026-05-17 07:41:07'),
(157, 2, 'Petugas mengonfirmasi pengembalian alat ID: 41', '2026-05-17 07:42:27'),
(158, 14, 'User login ke sistem', '2026-05-17 07:45:28'),
(159, 14, 'User melakukan request pinjam alat baru', '2026-05-17 07:47:42'),
(160, 2, 'User login ke sistem', '2026-05-17 07:48:49'),
(161, 2, 'Petugas menyetujui peminjaman ID: 42', '2026-05-17 07:48:51'),
(162, 2, 'Petugas mengonfirmasi pengembalian alat ID: 42', '2026-05-17 07:48:53'),
(163, 14, 'User login ke sistem', '2026-05-17 07:49:02'),
(164, 1, 'User login ke sistem', '2026-05-18 00:29:09'),
(165, 1, 'User login ke sistem', '2026-06-10 10:39:12'),
(166, 1, 'User login ke sistem', '2026-06-10 10:41:30'),
(167, 14, 'User login ke sistem', '2026-06-10 10:53:57'),
(168, 14, 'User melakukan request pinjam alat baru', '2026-06-10 10:54:15'),
(169, 1, 'User login ke sistem', '2026-06-10 10:55:37'),
(170, 14, 'User login ke sistem', '2026-06-10 11:09:33'),
(171, 2, 'User login ke sistem', '2026-06-10 11:09:44'),
(172, 2, 'Petugas menyetujui peminjaman ID: 43', '2026-06-10 11:10:19'),
(173, 14, 'User login ke sistem', '2026-06-10 11:11:30'),
(174, 1, 'User login ke sistem', '2026-07-29 09:41:31'),
(175, 1, 'User login ke sistem', '2026-07-29 09:42:34'),
(176, 1, 'User login ke sistem', '2026-07-29 09:47:34'),
(177, 1, 'User login ke sistem', '2026-07-29 09:53:04'),
(178, 1, 'User login ke sistem', '2026-07-29 09:59:29'),
(179, 1, 'User login ke sistem', '2026-07-29 10:07:18'),
(180, 2, 'User login ke sistem', '2026-07-29 10:11:00'),
(181, 2, 'Petugas mengonfirmasi pengembalian alat ID: 43', '2026-07-29 10:16:23'),
(182, 1, 'User login ke sistem', '2026-07-29 10:16:41'),
(183, 3, 'User login ke sistem', '2026-07-29 10:17:03'),
(184, 14, 'User login ke sistem', '2026-07-29 10:17:48'),
(185, 42, 'User login ke sistem', '2026-07-29 10:19:56'),
(186, 1, 'User login ke sistem', '2026-07-29 10:20:16'),
(187, 42, 'User login ke sistem', '2026-07-29 10:20:32'),
(188, 42, 'User login ke sistem', '2026-07-29 10:25:07'),
(189, 43, 'User login ke sistem', '2026-07-29 11:10:28'),
(190, 43, 'User melakukan request pinjam alat baru', '2026-07-29 11:12:25'),
(191, 2, 'User login ke sistem', '2026-07-29 11:12:39'),
(192, 2, 'Petugas menyetujui peminjaman ID: 44', '2026-07-29 11:12:44'),
(193, 1, 'User login ke sistem', '2026-07-29 11:12:57'),
(194, 1, 'User login ke sistem', '2026-07-29 11:38:49'),
(195, 1, 'Admin mengubah data peminjaman ID: 44', '2026-07-29 11:49:44'),
(196, 1, 'User login ke sistem', '2026-07-30 02:14:31'),
(197, 1, 'User login ke sistem', '2026-07-30 02:14:54'),
(198, 1, 'User login ke sistem', '2026-07-30 04:54:57'),
(199, 1, 'User login ke sistem', '2026-07-31 02:32:50'),
(200, 1, 'User login ke sistem', '2026-07-31 23:30:31'),
(201, 1, 'Admin mengubah data peminjaman ID: 44', '2026-07-31 23:31:00'),
(202, 1, 'Admin mengubah data peminjaman ID: 44', '2026-07-31 23:34:34'),
(203, 1, 'Admin mengubah data peminjaman ID: 44', '2026-07-31 23:34:52'),
(204, 1, 'Admin mengubah data peminjaman ID: 44', '2026-07-31 23:35:08'),
(205, 1, 'Admin membuatkan peminjaman manual untuk user ID: 21', '2026-07-31 23:52:43'),
(206, 1, 'Admin mengubah data peminjaman ID: 45', '2026-07-31 23:53:04'),
(207, 1, 'Admin/Petugas menghapus data peminjaman ID: 45', '2026-07-31 23:53:21'),
(208, 1, 'Admin membuatkan peminjaman manual untuk user ID: 42', '2026-07-31 23:54:38'),
(209, 1, 'Admin/Petugas menghapus data peminjaman ID: 46', '2026-08-01 00:00:01'),
(210, 1, 'Admin membuatkan peminjaman manual untuk user ID: 23', '2026-08-01 00:00:15'),
(211, 1, 'Admin mengubah data peminjaman ID: 47', '2026-08-01 00:00:39'),
(212, 1, 'Admin mengubah data pengembalian ID: 43', '2026-08-01 00:07:10'),
(213, 2, 'User login ke sistem', '2026-08-01 00:09:12'),
(214, 2, 'User login ke sistem', '2026-08-01 00:12:04'),
(215, 2, 'User login ke sistem', '2026-08-01 00:16:08'),
(216, 1, 'User login ke sistem', '2026-08-01 00:30:38'),
(218, 1, 'User login ke sistem', '2026-08-01 00:59:10'),
(219, 1, 'User login ke sistem', '2026-08-01 15:55:15'),
(220, 2, 'User login ke sistem', '2026-08-01 16:19:42'),
(221, 2, 'Petugas menyetujui peminjaman ID: 47', '2026-08-01 16:19:51'),
(222, 1, 'User login ke sistem', '2026-08-02 00:08:05'),
(223, 7, 'User login ke sistem', '2026-08-02 00:11:13'),
(224, 7, 'User melakukan request pinjam alat baru', '2026-08-02 00:11:28'),
(225, 2, 'User login ke sistem', '2026-08-02 00:14:29'),
(226, 2, 'Petugas menyetujui peminjaman ID: 48', '2026-08-02 00:14:35'),
(227, 2, 'User login ke sistem', '2026-08-02 00:24:55'),
(228, 1, 'User login ke sistem', '2026-08-02 00:26:47'),
(229, 1, 'User login ke sistem', '2026-08-02 00:27:41'),
(230, 1, 'User login ke sistem', '2026-08-02 00:33:55'),
(231, 45, 'User login ke sistem', '2026-08-02 00:46:46'),
(232, 1, 'User login ke sistem', '2026-08-02 00:47:33'),
(233, 2, 'User login ke sistem', '2026-08-02 00:50:04'),
(234, 2, 'Petugas mengonfirmasi pengembalian alat ID: 47', '2026-08-02 00:58:05'),
(235, 45, 'User login ke sistem', '2026-08-02 00:58:35'),
(236, 1, 'User login ke sistem', '2026-08-02 01:04:14'),
(237, 45, 'User login ke sistem', '2026-08-02 01:06:00'),
(238, 45, 'User melakukan request pinjam alat baru', '2026-08-02 01:08:22'),
(239, 1, 'User login ke sistem', '2026-08-02 01:08:51'),
(240, 1, 'Admin/Petugas menghapus data peminjaman ID: 26', '2026-08-02 01:59:41'),
(241, 1, 'Admin mengubah data pengembalian ID: 27', '2026-08-02 02:02:04'),
(242, 1, 'Admin mengubah data pengembalian ID: 30', '2026-08-02 02:11:34'),
(243, 1, 'Admin/Petugas menghapus data peminjaman ID: 27', '2026-08-02 02:12:22'),
(244, 1, 'Admin/Petugas menghapus data peminjaman ID: 28', '2026-08-02 02:14:34'),
(245, 1, 'Admin membuatkan peminjaman manual untuk user ID: 45', '2026-08-02 02:17:49'),
(246, 1, 'Admin mengubah data pengembalian ID: 29', '2026-08-02 02:18:17'),
(247, 1, 'Admin/Petugas menghapus data peminjaman ID: 29', '2026-08-02 02:18:24'),
(248, 1, 'Admin/Petugas menghapus data peminjaman ID: 49', '2026-08-02 02:23:37'),
(249, 2, 'User login ke sistem', '2026-08-02 02:35:32'),
(250, 2, 'Petugas mengonfirmasi pengembalian alat ID: 48', '2026-08-02 02:36:47'),
(251, 45, 'User login ke sistem', '2026-08-02 02:37:12'),
(252, 45, 'User melakukan request pinjam alat baru', '2026-08-02 02:37:24'),
(253, 49, 'User login ke sistem', '2026-08-02 02:39:23'),
(254, 51, 'User login ke sistem', '2026-08-02 02:46:15'),
(255, 52, 'User login ke sistem', '2026-08-02 02:49:10'),
(256, 53, 'User login ke sistem', '2026-08-02 02:50:52'),
(257, 7, 'User login ke sistem', '2026-08-02 10:53:08'),
(258, 7, 'User melakukan request pinjam alat baru', '2026-08-02 10:53:26'),
(259, 2, 'User login ke sistem', '2026-08-02 10:53:44'),
(260, 2, 'Petugas menyetujui peminjaman ID: 52', '2026-08-02 10:53:52');

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
(30, 7, 1, 1, '2026-04-22 23:10:04', '2026-08-01 17:00:00', 'kembali', 'Bagus', 'Rusak Ringan', NULL),
(31, 7, 4, 12, '2026-04-22 23:37:45', '2026-04-22 17:00:00', 'kembali', 'Bagus', 'Baik', NULL),
(32, 7, 4, 12, '2026-04-23 05:46:59', '2026-04-23 05:49:51', 'kembali', 'Bagus', 'Baik', NULL),
(33, 3, 4, 12, '2026-04-23 05:50:36', '2026-04-24 04:35:33', 'kembali', 'Bagus', 'Baik', NULL),
(34, 29, 11, 2, '2026-04-24 06:49:11', '2026-04-24 07:01:38', 'kembali', 'Bagus', 'Baik', NULL),
(38, 14, 4, 6, '2026-05-12 20:57:26', '2026-05-12 21:00:29', 'kembali', 'Bagus', 'Baik', NULL),
(39, 14, 7, 12, '2026-05-12 21:10:01', '2026-05-12 21:30:27', 'kembali', 'Bagus', 'Baik', NULL),
(41, 14, 1, 13, '2026-05-17 00:28:52', '2026-05-17 00:42:27', 'kembali', 'Bagus', 'Baik', NULL),
(42, 14, 1, 23, '2026-05-17 00:47:42', '2026-05-17 00:48:53', 'kembali', 'Bagus', 'Baik', NULL),
(43, 14, 1, 12, '2026-06-10 03:54:15', '2026-07-31 17:00:00', 'kembali', 'Bagus', 'Rusak Ringan', NULL),
(47, 23, 9, 5, '2026-07-31 17:00:15', '2026-08-01 17:58:05', 'kembali', 'Baik', 'Baik', NULL),
(48, 7, 4, 14, '2026-08-01 17:11:28', '2026-08-01 19:36:47', 'kembali', 'Bagus', 'Baik', NULL),
(50, 45, 6, 3, '2026-08-01 19:17:49', NULL, 'dipinjam', 'Baik', NULL, NULL),
(51, 45, 9, 1, '2026-08-01 19:37:24', NULL, 'pending', 'Bagus', NULL, NULL),
(52, 7, 4, 12, '2026-08-02 03:53:26', NULL, 'dipinjam', 'Bagus', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','peminjam') DEFAULT NULL,
  `no_hp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `no_hp`) VALUES
(1, 'malvien', '$2y$12$7gSP.JYklB0kS4Vc992KhO4eT0jhB.3hrlRDqc9Tnis6m4IxRwIGK', 'admin', '12345678'),
(2, 'rizky', '$2y$12$4Zf.13udyZwF7hpj/JYdQeGhJu95NhwxgSe7eP.JYF.TYTfwqoxB2', 'petugas', '1234567890'),
(3, 'rendi R', '$2y$12$ff6xs5kEL2ZuNIcHYBhJq.exrZ5T2CRJx5vYbbeS/bn8siwa2Kmv.', 'peminjam', ''),
(4, 'rezka parsha A', '$2y$10$Y3nz77Ocb3CkhyQwCcyqTekd1qn6R6opBSTHaKb3sUcGQak7kmcNO', 'peminjam', '12345678910'),
(7, 'arif', '$2y$12$dYUkTJaJ9EF.Y7i3wHDYX.Qe1PNNqzxFmE1B91MmuDW6PjjIEwanW', 'peminjam', '+6283836949705'),
(13, 'qqwaaa', '$2y$12$PHzYpuIzKxw3zX00mWA0SuyFzE4JxBLJv0ftDkZzQSPWzYM9r/RZy', 'peminjam', ''),
(14, 'yaspa', '$2y$12$A9Jq7P5jlIUb/C8.hrJejuc7g9jQTS4MSq9Ubz8SAMg03C.FHWCNS', 'peminjam', ''),
(15, 'resky', '$2y$12$dO4.B1p64Wol4VfANZnSFuSyCbUXN3Gr.NhO/Bc.HtDnj0jtUqA3G', 'peminjam', ''),
(16, 'kiki', '$2y$12$tE4bg/92pu91JOKqoaOgsOluvmJN1Y68jSbt3WzAD0fy5SwI8kwdy', 'peminjam', ''),
(18, 'hiruman ', '$2y$12$jfdCe1iXy/EUY7wz817DA.Okrdl7m2SLM7a4W7aaKa3OLEQWSszRi', 'peminjam', ''),
(20, 'gopal', '$2y$12$Gd/WQChW0Etv3n7TNDBAN.bp0w7qEOU/LxBLJDTY0WmUp4DrFWyqW', 'peminjam', ''),
(21, 'gibrin', '$2y$12$KEqXTRlQQOkEnNIMyyhdFOTroY.tUetCCD9znY/d3cqi2Y2Z9PWzW', 'peminjam', ''),
(22, 'abc', '$2y$12$qKP6eY17PzSA4uhWz5CYK.CjVq2M6ZwUXKXj2zDw91rGJhLdYl036', 'peminjam', ''),
(23, 'hilman', '$2y$12$HqU2dDNH5rEQNzfcGlJ9aOaRhg0QpgHIz6HFq55gxsSxquaFotvGu', 'peminjam', ''),
(24, 'titi', '$2y$12$fhhUQvPpGqdZjknM8HmFJ.REhL61NXAUvPhUD472buGyuTeKCQT0O', 'peminjam', ''),
(25, 'titiw', '$2y$12$SEjcZAyjla78zSRvQdRZU.tJ3o8kbDH7B8VGGv2BIlWIamr99UFnG', 'peminjam', ''),
(26, 'rr', '$2y$12$oE.EuKbEAJtUK5nh8QRVq.4mHELqiC1g9JbyKYCR6xjWKyXx23BJq', 'peminjam', ''),
(28, 'cd', '$2y$12$lfTImGJ09a4rvMNJErpZh.V02e/uRRf2QaftLCQpFwU/ptuNJETFK', 'peminjam', ''),
(29, 'gh', '$2y$12$SHvt7.uPY.3/J5Rq0.wWIuWzJvA4jumBw.q1g/x38wG6067xYzcCG', 'peminjam', ''),
(32, 'sasa', '$2y$12$bvChTQRH1Cox3eknpV7WF.mo8cWj0ulGeSYsd2IKWJDdKtAJwu1Iq', 'peminjam', ''),
(33, 'sasi S', '$2y$12$zIHpUto//n/xt6ymCfRaheuMkLrN7A0PTTkpAwAruY1OMtq4ZpbfC', 'peminjam', ''),
(35, 'gaza', '$2y$12$skUw8.y3N2nyS.B0eC3GVOeBPwp6kasfDTAooqxRI2WQqJnIiYTpS', 'peminjam', ''),
(37, 'parva rpl2', '$2y$12$SsIkQj7bpIrnUkuDyZo8.eHODn/UoaQYY239dQxS0kCdLr..NBw8C', 'peminjam', ''),
(38, 'zx', '$2y$12$YxNb08ER1NBN/FmdVouJnukFlCqwI42iizqwXzM63qQEYuobdetLW', 'peminjam', ''),
(42, 'dasi', '$2y$12$A1QeHFiRNl365O9xHkb4FOKcMNqHdrzU1Vvc8MraWb8wpkNY9gVBC', 'peminjam', ''),
(43, 'ridwan', '$2y$12$KiYmSxrBB0CiGgqV78o8FOSP5d2JNB..DDSEz8v/W8Q/ASPHu0IH2', 'peminjam', ''),
(45, 'bunda', '$2y$12$yCnmjBWDbGUa8g8g6T9CreOJr7I.oor8IU9ruHbC/bi9SXhP6J9ta', 'peminjam', '083899940333'),
(47, 'nanda', '$2y$12$pIutroq8wLzZwjVBUz.qyuomFLfkgLf/XuY1IgEjDcejCDBsZjGpm', 'peminjam', '132132543'),
(48, 'das', '$2y$12$oTuwVLZnlBmxaSnJ6TAzw./qU.bTh.R9GhC1OUDTf3XmgpZFdRscG', 'peminjam', '886371737192'),
(49, 'dds', '$2y$12$t8C7CkGWTgtxkValuyK4ROOKwkh.WNsN.oND4WwHhq7A3XhxeMTGK', 'peminjam', '1234321'),
(51, 'x', '$2y$12$bxz0v8WylTmZGiQsTJJMdukrH8ss2YvtgLTnMYj/bFdMtR.GbM.kC', 'peminjam', '1234'),
(52, 'sule', '$2y$12$PjRpuAhmBIK0GMv2lyJT8eJVusj03U9xnqpwUyUorZ5o7i/NDUmFe', 'peminjam', '12'),
(53, 'cx', '$2y$12$hX7n2fu4g0u8Cs1DHgCs7uTcZ960XMIf8Ym2LVoPi0Y4XrUGWyRd.', 'peminjam', '1');

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
  MODIFY `id_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
