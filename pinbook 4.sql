-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_daftar` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `user_id`, `nisn`, `alamat`, `no_hp`, `tanggal_daftar`) VALUES
(2, 2, '1234', 'Tanjungsari', '62345678990', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tersedia` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `isbn`, `judul`, `id_kategori`, `id_penulis`, `id_penerbit`, `tahun_terbit`, `jumlah`, `tersedia`, `deskripsi`, `cover`, `id_rak`) VALUES
(3, '9786239987879', 'Tentang Hujan', 1, 1, 4, '2022', 10, 9, 'Novel Hujan merupakan novel yang mengisahkan kisah cinta serta perjuangan hidup Lail. Saat usianya baru menginjak 13 tahun, Lail menjadi seorang yatim piatu akibat ayah dan ibu Lail yang terkena letusan Gunung Api Purba dan gempa yang membuat kota tempat mereka tinggal hancur.', '1776590006_ba4ab86d0b283f87072b.jpg', NULL),
(9, '9786020328076', 'Laskar Pelangi', 2, 7, 1, '2005', 12, 24, 'apaaa', '1776590046_6271689aa0cfa4425e14.jpg', NULL),
(10, '9786231031433', 'Bandung After Rain', 1, 10, 10, '2024', 10, 7, 'Bandung, romansa, dan Ra. Hampir di setiap sudut di Kota Bandung menggambarkan kenangan manis yang Hema lakukan bersama Ra—mantan kekasihnya. 6 tahun lebih memadu kasih, tidak lantas membuat hubungan Hema dan Ra berakhir indah. Nyatanya, hubungan mereka usai tepat sebulan sebelum hari jadi mereka yang ke-7', '1776669410_293ecb020ee4f1e87ef0.jpg', NULL),
(11, '9786349626163', 'Nostalgia With Bandung', 1, 11, 11, '2026', 10, 7, 'Perselingkuhan yang dilakukan Raiven membuatnya hidup dalam penyesalan. Raiven pernah memiliki segalanya, terutama cinta dari Naisa yang begitu tulus. Namun, semuanya hancur karena kesalahannya sendiri. Hal itu lah yang membuat dirinya kehilangan sosok Naisa. Sejak saat itu, hidupnya dipenuhi rasa bersalah yang tak kunjung hilang', '1776669615_008cc3804bf29338f2f3.jpg', NULL),
(12, '9786024818722', 'Laut Bercerita', 1, 12, 1, '2022', 10, 7, 'Buku Laut Bercerita menceritakan terkait perilaku kekejaman dan kebengisan yang dirasakan oleh kelompok aktivis mahasiswa di masa Orde Baru. Tidak hanya itu, novel ini pun merenungkan kembali akan hilangnya tiga belas aktivis, bahkan sampai saat ini belum juga ada yang mendapatkan petunjuknya.', '1776669853_a164b9c82458c5cb4bb7.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buku_rak`
--

CREATE TABLE `buku_rak` (
  `id` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku_rak`
--

INSERT INTO `buku_rak` (`id`, `id_buku`, `id_rak`) VALUES
(1, 3, 1),
(6, 9, 1),
(7, 10, 3),
(8, 11, 1),
(9, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL,
  `id_pengembalian` int(11) DEFAULT NULL,
  `jumlah_denda` decimal(10,2) DEFAULT NULL,
  `status` enum('belum_bayar','sudah_bayar') DEFAULT 'belum_bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id_detail`, `id_peminjaman`, `id_buku`, `jumlah`) VALUES
(80, 83, 12, 1),
(126, 128, 9, 1),
(128, 130, 11, 1),
(129, 131, 3, NULL),
(145, 146, 3, NULL),
(146, 147, 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Novel'),
(2, 'Pendidikan'),
(4, 'Ensiklopedia');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','kembali','terlambat') DEFAULT NULL,
  `alamat_pengantaran` text DEFAULT NULL,
  `metode_pengambilan` varchar(20) DEFAULT NULL,
  `status_pengantaran` varchar(50) DEFAULT 'menunggu_pembayaran',
  `status_pengajuan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_anggota`, `id_petugas`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `alamat_pengantaran`, `metode_pengambilan`, `status_pengantaran`, `status_pengajuan`) VALUES
(137, 2, 1, '2026-04-26', '2026-05-03', 'kembali', 'Tanjungsari', 'antar', 'selesai', NULL),
(146, 2, NULL, '2026-04-26', '2026-05-03', '', NULL, NULL, 'menunggu_pembayaran', NULL),
(147, 2, NULL, '2026-04-26', '2026-05-03', '', NULL, NULL, 'menunggu_pembayaran', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `nama_penerbit` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `nama_penerbit`, `alamat`) VALUES
(1, 'Gramedia', 'Jakarta'),
(2, 'Erlangga', 'Surabaya'),
(4, 'Sabak Grip', 'Jakarta'),
(6, 'Bentang Pustaka ', 'Jakarta'),
(7, 'Kubu Buku', 'Bogor'),
(10, 'Black Swan Books', 'Jakarta'),
(11, 'Sinar Angsa', 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `tanggal_dikembalikan` timestamp NULL DEFAULT current_timestamp(),
  `denda` decimal(10,2) DEFAULT 0.00,
  `tgl_kembali_asli` date DEFAULT NULL,
  `status_bayar` enum('belum','pending','lunas') DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_peminjaman`, `tanggal_dikembalikan`, `denda`, `tgl_kembali_asli`, `status_bayar`) VALUES
(90, 137, '2026-04-29 10:27:44', 0.00, '2026-04-26', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL,
  `nama_penulis` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id_penulis`, `nama_penulis`) VALUES
(1, 'Tere Liye'),
(2, 'Ahmad Sofwan'),
(5, 'Andi Muhammad Sofwan'),
(7, 'Andrea Hirata'),
(8, 'Argian Pgs'),
(10, 'Wulan Nur Amalia'),
(11, 'Raisyamq'),
(12, 'Laila S. Chudori'),
(13, 'dddd');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `user_id`, `jabatan`) VALUES
(1, 7, 'Sirkulasi');

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL,
  `nama_rak` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`id_rak`, `nama_rak`, `lokasi`) VALUES
(1, '500-700', 'Lantai 1'),
(3, '100-200', 'lantai c');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `jenis` enum('denda','pengiriman','penarikan') DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `status` enum('belum_bayar','lunas') DEFAULT 'belum_bayar',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `bukti_bayar` varchar(225) NOT NULL,
  `metode` enum('qris','cod') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_peminjaman`, `jenis`, `jumlah`, `status`, `tanggal`, `bukti_bayar`, `metode`) VALUES
(2, 83, '', 15000.00, '', '2026-04-21 08:22:31', '1776784960_6576b77da6ca4240dcbf.jpg', NULL),
(3, 83, '', 15000.00, '', '2026-04-21 08:22:50', '1776784976_93bc415dbae0f55f34f9.jpg', NULL),
(51, 130, '', 15000.00, '', '2026-04-25 17:35:27', '1777163734_d92c9fc8ef0e3ab741a6.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','anggota') DEFAULT 'anggota',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `role`, `foto`, `status`, `created_at`) VALUES
(1, 'imey siti', 'imey.siti67@smk.belajar.id', 'imey', '$2y$10$FMQRdH0ecCbZZVWtN2n7/u1YZN/gr7X98Er4NG4sqDAWCXlZwmB6S', 'admin', '1776539548_ee02c0c1343665a4ad77.jpg', 'aktif', '2026-04-18 19:05:41'),
(2, 'insaniar', 'insaniar12@gmail.com', 'ican', '$2y$10$FMQRdH0ecCbZZVWtN2n7/u1YZN/gr7X98Er4NG4sqDAWCXlZwmB6S', 'anggota', '1776539561_b6afb70397bbc2d83c70.png', 'aktif', '2026-04-18 19:05:41'),
(5, 'Karisa Wulan Dini', 'KarisaWulan@gmail.com', 'Icaa', '$2y$10$yP8qobKNGBvfGcL3I00Qi.7tIwZ4AQGpnfV5Tm9.vNUEvhGb3QNiu', 'anggota', '1777197756_74f16221565640dcfc23.png', 'aktif', '2026-04-20 07:45:39'),
(6, 'Ahmad Mauludin', 'ahmad.mauludin247@guru.smk.belajar.id', 'ahmad', '$2y$10$d2OvE6FRyDwHZwg55mtVAe8qkwEtNcUiz3tVTcb1XPOtyta0q.Whi', 'anggota', '1776704171_2798ff7be70b12e5d6ed.png', 'aktif', '2026-04-20 16:56:11'),
(7, 'Asep', 'Asep09@gmail.com', 'Asep', '$2y$10$CIBNdhuPZ/6udu7BcUU4huwYc3L0CGAJ9E0/B3z0DmMRa8IfsQ4CK', 'petugas', '1777197703_4d640f981734df358792.jpg', 'aktif', '2026-04-20 17:46:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_penulis` (`id_penulis`),
  ADD KEY `id_penerbit` (`id_penerbit`);

--
-- Indexes for table `buku_rak`
--
ALTER TABLE `buku_rak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id_denda`),
  ADD KEY `id_pengembalian` (`id_pengembalian`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id_penulis`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `buku_rak`
--
ALTER TABLE `buku_rak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id_penulis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id_penulis`),
  ADD CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`);

--
-- Constraints for table `buku_rak`
--
ALTER TABLE `buku_rak`
  ADD CONSTRAINT `buku_rak_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `buku_rak_ibfk_2` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id_rak`) ON DELETE CASCADE;

--
-- Constraints for table `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id_pengembalian`);

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE;

--
-- Constraints for table `petugas`
--
ALTER TABLE `petugas`
  ADD CONSTRAINT `petugas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
