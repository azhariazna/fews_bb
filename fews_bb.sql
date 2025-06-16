-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 02:33 PM
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
-- Database: `fews_bb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_telemetri`
--

CREATE TABLE `tb_telemetri` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(50) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `tma` varchar(50) DEFAULT NULL,
  `hujan` varchar(50) DEFAULT NULL,
  `koordinat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_telemetri`
--

INSERT INTO `tb_telemetri` (`id`, `nama_lokasi`, `waktu`, `tma`, `hujan`, `koordinat`) VALUES
(1, 'AWLR Mataiyang', '2025-06-16 10:21:43', '1', NULL, '116.909048611528,-8.83958586887169'),
(2, 'AWLR Menala', '2025-06-16 10:21:44', '2', NULL, '116.863538752057,-8.75746961012613'),
(3, 'AWLR Kuang', '2025-06-16 10:21:45', '3', NULL, '116.85415633366,-8.74045765656102');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_telemetri`
--
ALTER TABLE `tb_telemetri`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
