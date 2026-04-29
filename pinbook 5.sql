-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 04:41 AM
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
(2, 2, '156789023', 'Tanjungsari', '62345678990', NULL),
(14, NULL, NULL, NULL, NULL, '2026-04-14 02:29:43');

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
(3, '9786239987879', 'Tentang Hujan', 1, 1, 4, '2022', 10, 19, 'Novel Hujan merupakan novel yang mengisahkan kisah cinta serta perjuangan hidup Lail. Saat usianya baru menginjak 13 tahun, Lail menjadi seorang yatim piatu akibat ayah dan ibu Lail yang terkena letusan Gunung Api Purba dan gempa yang membuat kota tempat mereka tinggal hancur.', '1776590006_ba4ab86d0b283f87072b.jpg', NULL),
(9, '9786020328076', 'Laskar Pelangi', 1, 7, 1, '2005', 12, 28, 'apaaa', '1776590046_6271689aa0cfa4425e14.jpg', NULL),
(10, '9786231031433', 'Bandung After Rain', 1, 10, 10, '2024', 10, 11, 'Bandung, romansa, dan Ra. Hampir di setiap sudut di Kota Bandung menggambarkan kenangan manis yang Hema lakukan bersama Ra—mantan kekasihnya. 6 tahun lebih memadu kasih, tidak lantas membuat hubungan Hema dan Ra berakhir indah. Nyatanya, hubungan mereka usai tepat sebulan sebelum hari jadi mereka yang ke-7', '1776669410_293ecb020ee4f1e87ef0.jpg', NULL),
(11, '9786349626163', 'Nostalgia With Bandung', 1, 11, 11, '2026', 10, 17, 'Perselingkuhan yang dilakukan Raiven membuatnya hidup dalam penyesalan. Raiven pernah memiliki segalanya, terutama cinta dari Naisa yang begitu tulus. Namun, semuanya hancur karena kesalahannya sendiri. Hal itu lah yang membuat dirinya kehilangan sosok Naisa. Sejak saat itu, hidupnya dipenuhi rasa bersalah yang tak kunjung hilang', '1776669615_008cc3804bf29338f2f3.jpg', NULL),
(12, '9786024818722', 'Laut Bercerita', 1, 12, 1, '2022', 10, 8, 'Buku Laut Bercerita menceritakan terkait perilaku kekejaman dan kebengisan yang dirasakan oleh kelompok aktivis mahasiswa di masa Orde Baru. Tidak hanya itu, novel ini pun merenungkan kembali akan hilangnya tiga belas aktivis, bahkan sampai saat ini belum juga ada yang mendapatkan petunjuknya.', '1776669853_a164b9c82458c5cb4bb7.jpg', NULL),
(25, '9786232054868', 'Buku Siswa: Biologi (Kelompok Peminatan MIPA) Premium K13-R SMA/MA Kelas 11', 1, 1, 2, '2055', 55, 55, 'ujhh', '1777379722_8504d534f6cfabbede4a.jpg', NULL),
(26, '9786347604033', 'Hal-Hal Kecil yang Bikin Bersyukur & Bahagia', 2, 8, 4, '2026', 10, 10, 'Kita hidup di dunia yang serba cepat, serba tergesa-gesa, serba sibuk. Dampaknya, kita jadi terpacu dan akhirnya merasa lelah, capek, dan merasa sendirian. Ya, kita lupa menepi dan memperhatikan sekitar. Kita terlalu sibuk memikirkan mimpi dan pencapaian yang besar, hingga lupa dengan hal-hal kecil yang sudah ada dan bermakna. Inilah saatnya kita rehat untuk merenungi satu per satu karunia yang kita punya dan sempat kita abaikan. Percayalah, rasa syukur akan tercipta, rasa negatif menghilang, dan kebahagiaan kembali menghampiri usai diri berkutat dengan duniawi. Mari duduk dan buka jurnal. Siapkan pulpen dan hati untuk menata ulang diri dan membuat hidup menyenangkan.', '1777380007_a5c851d9ca9238f12244.avif', NULL),
(27, '9786230077722', 'Kelas Ini Tidak Pernah Selesai', 2, 8, 11, '2026', 12, 13, 'Karena pelajaran sesungguhnya sering kali dimulai justru saat bel pulang berbunyi. Di balik tumpukan RPP, target kurikulum, dan nilai KKM, ada drama manusia yang sering luput dari pandangan mata. Buku ini bukan tentang tip menjadi guru teladan atau cara mencetak juara olimpiade. Ini adalah kumpulan kisah tentang mereka yang duduk di barisan paling belakang. Tentang murid yang \"hanya\" bisa menggambar di kertas ulangan, tentang si pembuat onar yang sebenarnya kesepian, dan tentang anak yang mengirim voice note izin sakit karena sedang \"galau\".\r\n\r\nDevi Saidulloh, seorang guru IPA yang biasa berkutat dengan rumus Fisika dan Biologi, mengajak kita masuk ke ruang-ruang kelas yang sunyi. Ia merekam jejak-jejak kecil yang sering kali dianggap angin lalu, tetapi ternyata menjadi penopang hidup seseorang bertahun-tahun kemudian. Membaca buku ini akan membuatmu sadar bahwa tugas seorang guru bukan sekadar mengisi kepala dengan ilmu, melainkan menyalakan lentera di hati yang redup. Bagi para guru yang pernah merasa lelah, bagi para murid yang pernah merasa tak terlihat, dan bagi siapa saja yang pernah duduk di bangku sekolah: Silakan masuk. Kelas ini tidak pernah selesai.\r\n\r\n***\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.\r\n', '1777380148_5cc5ac7cd1fecb3fb15d.avif', NULL),
(28, '9786020851563', 'Novel Milea Suara Dari Dilan', 1, 1, 1, '2020', 12, 12, '“Dilan memberi penggambaran lain dari sebuah penaklukan cinta & bagaimana indahnya cinta sederhana anak zaman dahulu.” @refaniris\r\n“Cuma satu yang kuinginkan, aku ingin cowok seperti Dilan.” @_SLovaFC\r\n“Dilan brengsek! Dia selalu tahu caranya menjadi pusat perhatian, bahkan ketika jadi buku, setiap serinya selalu ditunggu.” @Tedy_Pensil\r\n“Membaca Dilan itu seperti jatuh cinta lagi, lagi, dan lagi. Ah, indah, deh. Rasanya gak akan pernah bosan membacanya.” @agungwyd\r\n“Bukan cuma sekadar novel, tapi bisa menjadikan yang malas baca jadi mau baca.” @cobra_iqq\r\n“Kisah cintanya gak lebay. Dilan tahu bagaimana memperlakukan wanita. Novelnya keren, bahasanya gak bertele-tele.” @AH_DILAN\r\n“Terima kasih Dilan telah menginspirasiku lewat ceritamu bersama Milea. Terima kasih Surayah, novelmu seru.” @EnciSrifiyani\r\n“Dari Dilan kita belajar mengistimewakan wanita, romantis yang gak kuno, bahkan menjadi ayah & bunda yang hebat :)” @ginaalna\r\n“Kurasa Dilan satu-satunya novel yang aku harap ceritanya terus berlanjut, dan tidak ingin ada akhir.” @TriaFitriaN41', '1777380310_f4169535fe5abceb3193.avif', NULL);

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
(129, 131, 3, 1),
(185, 188, 3, 1),
(186, 189, 3, 1),
(187, 190, 9, 1),
(188, 190, 27, 1);

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
(4, 'Ensiklopedia'),
(6, 'Anatomi');

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
  `status` enum('menunggu','dipinjam','kembali','terlambat') DEFAULT 'menunggu',
  `alamat_pengantaran` text DEFAULT NULL,
  `metode_pengambilan` varchar(20) DEFAULT NULL,
  `status_pengantaran` varchar(50) DEFAULT 'menunggu_pembayaran',
  `alamat` text DEFAULT NULL,
  `status_pengiriman` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_anggota`, `id_petugas`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `alamat_pengantaran`, `metode_pengambilan`, `status_pengantaran`, `alamat`, `status_pengiriman`) VALUES
(83, 2, 2, '2026-04-22', '2026-04-27', 'menunggu', NULL, 'Ambil', 'selesai', NULL, NULL),
(128, 2, 2, '2026-04-21', '2026-04-28', 'menunggu', NULL, 'Ambil', 'menunggu_pembayaran', NULL, NULL),
(130, 2, 2, '2026-04-29', '2026-05-03', 'menunggu', NULL, 'Ambil', 'menunggu_pembayaran', NULL, NULL),
(131, 2, 2, '2026-05-05', '2026-04-10', 'menunggu', NULL, 'Ambil', 'menunggu_pembayaran', NULL, NULL),
(188, 2, 2, '2026-04-28', '2026-05-05', 'kembali', NULL, 'ambil', 'selesai', NULL, NULL),
(189, 2, 2, '2026-04-28', '2026-05-05', 'dipinjam', NULL, 'ambil', 'ambil', NULL, NULL),
(190, 2, 2, '2026-04-28', '2026-05-05', 'kembali', NULL, 'ambil', 'selesai', NULL, NULL),
(191, 2, 2, '2026-04-28', '2026-05-05', 'kembali', NULL, 'ambil', 'selesai', NULL, NULL);

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
(11, 'Sinar Angsa', 'Jakarta'),
(14, 'Yrama Widya', 'Jakarta'),
(15, 'Lentera', 'Surian');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `tanggal_dikembalikan` timestamp NULL DEFAULT current_timestamp(),
  `denda` decimal(10,2) DEFAULT 0.00,
  `status_bayar` varchar(20) DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_peminjaman`, `tanggal_dikembalikan`, `denda`, `status_bayar`) VALUES
(105, 188, '2026-04-28 03:37:56', 0.00, 'lunas'),
(106, 188, '2026-04-22 11:24:49', 5000.00, 'lunas'),
(107, 188, '2026-05-09 11:39:53', 2000.00, 'belum');

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
(12, 'Laila S. Chudori');

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
(3, '100-200', 'lantai c'),
(5, '800 - 900', 'lantai 2 b');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penarikan`
--

CREATE TABLE `tb_penarikan` (
  `id` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `biaya` int(11) DEFAULT 0,
  `status` enum('diajukan','diproses','selesai') DEFAULT 'diajukan',
  `tanggal_ambil` date DEFAULT NULL,
  `petugas_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_penarikan`
--

INSERT INTO `tb_penarikan` (`id`, `id_peminjaman`, `alamat`, `biaya`, `status`, `tanggal_ambil`, `petugas_id`, `created_at`, `updated_at`) VALUES
(1, 176, 'sumedang', 0, 'diajukan', '2026-04-21', 2, '2026-04-28 02:29:06', '2026-04-28 02:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `jenis` enum('antar','denda','lainnya') NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `metode` enum('transfer','cod') DEFAULT NULL,
  `status` enum('Pending','Verifikasi','Lunas') DEFAULT 'Pending',
  `tanggal` datetime NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, 'Asep', 'Asep09@gmail.com', 'Asep1', '$2y$10$CIBNdhuPZ/6udu7BcUU4huwYc3L0CGAJ9E0/B3z0DmMRa8IfsQ4CK', 'petugas', '1777381309_3027d4efb41049acdba9.jpg', 'aktif', '2026-04-20 17:46:37');

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
-- Indexes for table `tb_penarikan`
--
ALTER TABLE `tb_penarikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `transaksi_ibfk_1` (`id_peminjaman`);

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
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id_penulis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_penarikan`
--
ALTER TABLE `tb_penarikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
