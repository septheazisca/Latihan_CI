-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2026 at 08:33 AM
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
-- Database: `perpus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` varchar(6) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username_admin` varchar(20) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `akses_level` enum('1','2','3') NOT NULL,
  `is_delete_admin` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama_admin`, `username_admin`, `password_admin`, `akses_level`, `is_delete_admin`, `created_at`, `updated_at`) VALUES
('ADM000', 'Developer', 'developer', '$2y$10$BtHHWFXmLuhnP79ievN58O8EivCDmojcmNDivaVhmIlBQNSiqr9Ku', '1', '0', '2026-05-05 09:54:41', '2026-05-05 09:54:41'),
('ADM001', 'Septhea Zisca', 'septhea', '$2y$10$/i/wt2GVz/3Dfu.e3hQ7OucrOG1xTOGk2xI2dB.dFJ3XR5vev1uoa', '2', '0', '2026-05-31 05:19:24', '2026-05-31 05:19:24'),
('ADM002', 'Adelia Putri', 'admin_adelia', '$2y$10$u5V1CP3Tw3U6cvMYNl74VOHLnbAYKpgsfkjcht3fDJ2E7LoauyTp2', '3', '0', '2026-05-31 05:24:59', '2026-05-31 05:24:59'),
('ADM003', 'Azahra Rindu', 'admin_azahra', '$2y$10$/2Cjvrk3YLcAIfDUx6C1MutZJeVHI6iFlNcNnxICL831nSWfCl5Ny', '3', '0', '2026-05-31 05:26:17', '2026-05-31 05:26:17'),
('ADM004', 'Rizam Fadilah', 'admin_rizam', '$2y$10$LR8/pqBtg5pEm4vmLN/23uotOvHRpxwBMAFBRETS47bU/5GjQVe8O', '3', '0', '2026-05-31 05:26:34', '2026-05-31 05:26:34'),
('ADM005', 'aaa', 'aaa', '$2y$10$.RbmXn5DxWDG0sRfz7/MS.3zYVpmgwxqZ0oI83v.HLNqx6o4u6B8q', '3', '1', '2026-05-31 06:15:24', '2026-05-31 06:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id_anggota` varchar(6) NOT NULL,
  `nama_anggota` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password_anggota` varchar(255) NOT NULL,
  `is_delete_anggota` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `jenis_kelamin`, `no_tlp`, `alamat`, `email`, `password_anggota`, `is_delete_anggota`, `created_at`, `updated_at`) VALUES
('AGT001', 'Budi Santoso', 'L', '081234567890', 'Jl. Merdeka No.1 Jakarta', 'budi@gmail.com', '$2y$10$0EREV.AVBNdF7zk7V046HuGuSyg4pVzXrZ6NHmGLfyGglaCe61S.K', '0', '2026-05-31 05:36:44', '2026-05-31 05:38:12'),
('AGT002', 'Ghanisha Amalia', 'P', '081234567890', 'Jl. Merdeka No.1 Jakarta', 'ghanisha@gmail.com', '$2y$10$yGAX.ymdv0l5/9r/QPztQ.hf9Z0gLd5tqU3QIH5NxqlaTK/koCnV2', '0', '2026-05-31 05:39:14', '2026-05-31 05:39:14'),
('AGT003', 'Rara Adisti Maharani', 'P', '081234567890', 'Jl. Merdeka No.1 Jakarta', 'rara@gmail.com', '$2y$10$c.cT2LXOp.CDbmWULp02zOlRMOsRO89eJQ73TFPtW0/nukpdNXkd6', '0', '2026-05-31 05:39:42', '2026-05-31 05:39:42'),
('AGT004', 'Ramadan Aprilio', 'L', '081234567890', 'Jl. Merdeka No.1 Jakarta', 'ramadan@gmail.com', '$2y$10$qEF49G5tb3EDo2VMELmyGOCc.l97LKu698vF7imkzciLRLoKhfWEO', '0', '2026-05-31 05:40:08', '2026-05-31 05:40:08'),
('AGT005', 'Ayu Lestari', 'P', '081234567890', 'Jl. Merdeka No.1 Jakarta', 'ayu@gmail.com', '$2y$10$AtWv8PsBzpLe5/TR0BW7puIip6PeBzXAjG5L3mHO0JJV7InaFP596', '0', '2026-05-31 05:40:47', '2026-05-31 05:40:47'),
('AGT006', 'aaa', 'P', '089512094663', 'JL.BUNGUR RAYA', 'septheaziscaaurora@gmail.com', '$2y$10$XgVEaFC3AAJ4b7ngbhB9I.uRo0EeIG6i4BmqnXaZq7RvHQC/uGnZS', '1', '2026-05-31 06:16:09', '2026-05-31 06:16:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `id_buku` varchar(6) NOT NULL,
  `judul_buku` varchar(200) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `jumlah_eksemplar` int(3) NOT NULL,
  `id_kategori` varchar(6) DEFAULT NULL,
  `keterangan` varchar(500) DEFAULT NULL,
  `id_rak` varchar(6) DEFAULT NULL,
  `cover_buku` varchar(30) DEFAULT NULL,
  `e_book` varchar(30) DEFAULT NULL,
  `is_delete_buku` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `judul_buku`, `pengarang`, `penerbit`, `tahun`, `jumlah_eksemplar`, `id_kategori`, `keterangan`, `id_rak`, `cover_buku`, `e_book`, `is_delete_buku`, `created_at`, `updated_at`) VALUES
('BKU001', 'Laskar Pelangi', 'Laskar Pelangi', 'Laskar Pelangi', '2016', 11, 'KAT001', 'Laskar Pelangi', 'RAK001', 'Cover-Buku-260531062103.jpg', 'E-Book-260531062103.pdf', '0', '2026-05-31 06:21:03', '2026-05-31 06:21:03'),
('BKU002', 'Fisika Dasar', 'Fisika Dasar', 'Fisika Dasar', '2016', 9, 'KAT005', 'Fisika Dasar', 'RAK002', 'Cover-Buku-260531062211.jpg', 'E-Book-260531062211.pdf', '0', '2026-05-31 06:22:11', '2026-05-31 06:22:11'),
('BKU003', 'Pemrograman Web', 'Pemrograman Web', 'Pemrograman Web', '2016', 11, 'KAT003', 'Pemrograman Web', 'RAK004', 'Cover-Buku-260531062309.jpg', 'E-Book-260531062309.pdf', '0', '2026-05-31 06:23:09', '2026-05-31 06:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_peminjaman`
--

CREATE TABLE `tbl_detail_peminjaman` (
  `no_peminjaman` varchar(12) DEFAULT NULL,
  `id_buku` varchar(6) DEFAULT NULL,
  `status_pinjam` enum('Sedang Dipinjam','Sudah Dikembalikan') DEFAULT NULL,
  `perpanjangan` int(1) DEFAULT 0,
  `tgl_kembali` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` varchar(6) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `is_delete_kategori` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`, `is_delete_kategori`, `created_at`, `updated_at`) VALUES
('KAT001', 'Fiksi', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('KAT002', 'Non Fiksi', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('KAT003', 'Sains dan Teknologi', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('KAT004', 'Sejarah', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('KAT005', 'Pendidikan', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('KAT006', 'aa', '1', '2026-05-31 06:17:07', '2026-05-31 06:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_peminjaman`
--

CREATE TABLE `tbl_peminjaman` (
  `no_peminjaman` varchar(12) NOT NULL,
  `id_anggota` varchar(6) DEFAULT NULL,
  `tgl_pinjam` date NOT NULL,
  `total_pinjam` int(3) NOT NULL,
  `id_admin` varchar(6) DEFAULT NULL,
  `status_transaksi` enum('Selesai','Berjalan') DEFAULT 'Berjalan',
  `status_ambil_buku` enum('Belum Diambil','Sudah Diambil') DEFAULT 'Belum Diambil',
  `qr_code` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengembalian`
--

CREATE TABLE `tbl_pengembalian` (
  `no_pengembalian` varchar(12) NOT NULL,
  `no_peminjaman` varchar(12) DEFAULT NULL,
  `id_buku` varchar(6) DEFAULT NULL,
  `denda` double DEFAULT 0,
  `tgl_pengembalian` date NOT NULL,
  `id_admin` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rak`
--

CREATE TABLE `tbl_rak` (
  `id_rak` varchar(6) NOT NULL,
  `nama_rak` varchar(50) NOT NULL,
  `is_delete_rak` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rak`
--

INSERT INTO `tbl_rak` (`id_rak`, `nama_rak`, `is_delete_rak`, `created_at`, `updated_at`) VALUES
('RAK001', 'Rak Fiksi', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('RAK002', 'Rak Non Fiksi', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('RAK003', 'Rak Sains', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('RAK004', 'Rak Teknologi', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('RAK005', 'Rak Sejarah', '0', '2026-05-31 12:15:33', '2026-05-31 12:15:33'),
('RAK006', 'aa', '1', '2026-05-31 06:16:41', '2026-05-31 06:16:53'),
('RAK007', 'aa', '1', '2026-05-31 06:17:34', '2026-05-31 06:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_temp_peminjaman`
--

CREATE TABLE `tbl_temp_peminjaman` (
  `id_anggota` varchar(6) DEFAULT NULL,
  `id_buku` varchar(6) DEFAULT NULL,
  `jumlah_temp` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `tbl_detail_peminjaman`
--
ALTER TABLE `tbl_detail_peminjaman`
  ADD KEY `no_peminjaman` (`no_peminjaman`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD PRIMARY KEY (`no_peminjaman`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD PRIMARY KEY (`no_pengembalian`),
  ADD KEY `no_peminjaman` (`no_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tbl_rak`
--
ALTER TABLE `tbl_rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indexes for table `tbl_temp_peminjaman`
--
ALTER TABLE `tbl_temp_peminjaman`
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD CONSTRAINT `tbl_buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`),
  ADD CONSTRAINT `tbl_buku_ibfk_2` FOREIGN KEY (`id_rak`) REFERENCES `tbl_rak` (`id_rak`);

--
-- Constraints for table `tbl_detail_peminjaman`
--
ALTER TABLE `tbl_detail_peminjaman`
  ADD CONSTRAINT `tbl_detail_peminjaman_ibfk_1` FOREIGN KEY (`no_peminjaman`) REFERENCES `tbl_peminjaman` (`no_peminjaman`),
  ADD CONSTRAINT `tbl_detail_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`);

--
-- Constraints for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD CONSTRAINT `tbl_peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`),
  ADD CONSTRAINT `tbl_peminjaman_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `tbl_admin` (`id_admin`);

--
-- Constraints for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD CONSTRAINT `tbl_pengembalian_ibfk_1` FOREIGN KEY (`no_peminjaman`) REFERENCES `tbl_peminjaman` (`no_peminjaman`),
  ADD CONSTRAINT `tbl_pengembalian_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`),
  ADD CONSTRAINT `tbl_pengembalian_ibfk_3` FOREIGN KEY (`id_admin`) REFERENCES `tbl_admin` (`id_admin`);

--
-- Constraints for table `tbl_temp_peminjaman`
--
ALTER TABLE `tbl_temp_peminjaman`
  ADD CONSTRAINT `tbl_temp_peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`),
  ADD CONSTRAINT `tbl_temp_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
