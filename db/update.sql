-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table jadiorder.blw_akun_penjualan
CREATE TABLE IF NOT EXISTS `blw_akun_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `akun` text DEFAULT NULL,
  `status` text DEFAULT NULL COMMENT '1 = pengajuan, 2 = verifikasi',
  `sample` text DEFAULT NULL,
  `katalog` text DEFAULT NULL,
  `tanggal` date DEFAULT curdate(),
  `hapus` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table jadiorder.blw_akun_penjualan: ~1 rows (approximately)
INSERT INTO `blw_akun_penjualan` (`id`, `akun`, `status`, `sample`, `katalog`, `tanggal`, `hapus`) VALUES
	(3, '1', '1', 'assets/penjualan/sample_1707198240.jpg', 'assets/penjualan/katalog_1707198240.pdf', '2024-02-06', 0);

-- Dumping structure for table jadiorder.blw_dropshipper
CREATE TABLE IF NOT EXISTS `blw_dropshipper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT 1 COMMENT '1 = pengisian data, 2 = pembayaran, 3 = akun terverfikasi',
  `pembayaran` text DEFAULT '0',
  `akun` text DEFAULT NULL,
  `nama` text DEFAULT NULL,
  `lahir_tempat` text DEFAULT NULL,
  `lahir_tanggal` text DEFAULT NULL,
  `kelamin` set('l','p') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `agama` text DEFAULT NULL,
  `kawin` set('kawin','belum kawin') DEFAULT NULL,
  `pekerjaan` text DEFAULT NULL,
  `kewarganegaraan` set('wni','bukan wni') DEFAULT NULL,
  `ktp` text DEFAULT NULL,
  `tanggal` date DEFAULT curdate(),
  `hapus` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table jadiorder.blw_dropshipper: ~1 rows (approximately)
INSERT INTO `blw_dropshipper` (`id`, `status`, `pembayaran`, `akun`, `nama`, `lahir_tempat`, `lahir_tanggal`, `kelamin`, `alamat`, `agama`, `kawin`, `pekerjaan`, `kewarganegaraan`, `ktp`, `tanggal`, `hapus`) VALUES
	(15, 3, 'assets/dropshipper/bukti_1705952871.jpg', '1', 'Jhon Doe', '3', '1998-01-23', 'l', 'Alamat RT 01 RW 01', 'islam', 'kawin', 'Wiraswasta', 'wni', 'assets/dropshipper/c4ca4238a0b923820dcc509a6f75849b_1705946670.jpg', '2024-01-23', 0);

-- Dumping structure for table jadiorder.blw_dropshipper_bank
CREATE TABLE IF NOT EXISTS `blw_dropshipper_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `akun` text NOT NULL,
  `bank` text DEFAULT NULL,
  `nama` text DEFAULT NULL,
  `kode` text DEFAULT NULL,
  `rekening` text DEFAULT NULL,
  `nominal` text DEFAULT '0',
  `tanggal` date DEFAULT curdate(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table jadiorder.blw_dropshipper_bank: ~2 rows (approximately)
INSERT INTO `blw_dropshipper_bank` (`id`, `akun`, `bank`, `nama`, `kode`, `rekening`, `nominal`, `tanggal`) VALUES
	(4, '7', 'BRI', 'Jhon Doe', '006', '66718290100', '250000', '2024-01-23'),
	(5, '7', 'Mandiri', 'Jhon Doe', '008', '8789202', '0', '2024-01-23');

-- Dumping structure for table jadiorder.blw_dropshipper_syarat
CREATE TABLE IF NOT EXISTS `blw_dropshipper_syarat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `akun` text NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` date DEFAULT curdate(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table jadiorder.blw_dropshipper_syarat: ~1 rows (approximately)
INSERT INTO `blw_dropshipper_syarat` (`id`, `akun`, `isi`, `tanggal`) VALUES
	(2, '7', '<p style="margin-bottom: 1rem; color: rgb(151, 154, 167); font-family: poppins, sans-serif; font-size: 16px;">Disarankan sebelum mengakses Situs ini lebih jauh, Anda terlebih dahulu membaca dan memahami syarat dan ketentuan yang berlaku. Syarat dan ketentuan berikut adalah ketentuan dalam pengunjungan Situs, isi dan/atau konten, layanan, serta fitur lainnya yang ada di website kami. Dengan mengakses atau menggunakan Situs ini, informasi, atau aplikasi lainnya dalam bentuk mobile application yang disediakan oleh atau dalam Situs, berarti Anda telah memahami dan menyetujui serta terikat dan tunduk dengan segala syarat dan ketentuan yang berlaku di Situs ini.</p><ol style="color: rgb(151, 154, 167); font-family: poppins, sans-serif; font-size: 16px;"><li><span style="font-weight: bolder;">DEFENISI</span><br>Setiap kata atau isitilah berikut yang digunakan di dalam Syarat dan Ketentuan ini memiliki arti seperti berikut di bawah, kecuali jika kata atau istilah yang bersangkutan di dalam pemakaiannya dengan tegas menentukan lain<ul><li>“Kami”, berarti selaku pemilik dan pengelola Situs, serta aplikasi lainnya dan/atau mobile application.</li><li>“Anda”, berarti tiap orang yang mengakses dan menggunakan layanan dan jasa yang disediakan oleh Kami.</li><li>“Layanan”, berarti tiap dan keseluruhan jasa serta informasi yang ada pada Situs, dan tidak terbatas pada informasi yang disediakan, layanan aplikasi dan fitur, dukungan data, serta mobile application yang disediakan oleh Kami.</li><li>“Pengguna”, berarti tiap orang yang mengakses dan menggunakan layanan dan jasa yang disediakan oleh Kami, termasuk diantaranya Pengguna Belum Terdaftar dan Pengguna Terdaftar.</li><li>“Pengguna Terdaftar”, berarti tiap orang yang mengakses dan menggunakan layanan dan jasa yang disediakan oleh Kami, serta telah melakukan registrasi dan memiliki akun pada Situs Kami.</li><li>“Pihak Ketiga”, berarti pihak ketiga manapun, termasuk namun tidak terbatas juga untuk menghindari keraguan, baik individu maupun entitas, pihak lain dalam kontrak, pemerintah, atau swasta.</li><li>“Profil”, berarti data pribadi yang digunakan oleh Pengguna, dan menjadi informasi dasar bagi Pengguna.</li><li>“Konten”, berarti teks, data, informasi, angka, gambar, grafik, foto, audio, video, nama pengguna, informasi, aplikasi, tautan, komentar, peringkat, desain, atau materi lainnya yang ditampilkan pada Situs.</li></ul></li><li><span style="font-weight: bolder;">LAYANAN DAN/ATAU JASA</span><ul><li>Informasi yang terdapat dalam Situs Kami ditampilkan sesuai keadaan kenyataan untuk tujuan informasi umum. Kami berusaha untuk selalu menyediakan dan menampilkan informasi yang terbaru dan akurat, namun Kami tidak menjamin bahwa segala informasi sesuai dengan ketepatan waktu atau relevansi dengan kebutuhan Anda.</li><li>Informasi di Situs ini disediakan untuk membantu Anda dalam memilih acara yang sesuai dengan kebutuhan Anda. Dan Anda sepenuhnya bertanggung jawab atas tiap dan seluruh keputusan terkait pemilihan acara.</li></ul></li><li><span style="font-weight: bolder;">PENGGUNAAN LAYANAN DAN JASA</span><br>Dengan Anda melanjutkan penggunaan atau pengaksesan Situs ini, berarti Anda telah menyatakan serta menjamin kepada Kami bahwa :<ul><li>Anda hanya diperkenankan untuk mengakses dan/atau menggunakan Situs ini untuk keperluan pribadi.</li><li>Anda tidak diperkenankan menggunakan Situs dalam hal sebagai berikut :<ul><li>Untuk menyakiti, menyiksa, mempermalukan, memfitnah, mencemarkan nama baik, mengancam, mengintimidasi atau mengganggu orang atau bisnis lain, atau apapun yang melanggar privasi atau yang Kami anggap cabul, menghina, penuh kebencian, tidak senonoh, tidak patut, tidak pantas, tidak dapat diterima, mendiskriminasikan atau merusak.</li><li>Dalam cara yang melawan hukum, tindakan penipuan atau tindakan komersil.</li><li>Melanggar atau menyalahi hak orang lain, termasuk tanpa kecuali : hak paten, merek dagang, hak cipta, rahasia dagang, publisitas, dan hak milik lainnya.</li><li>Untuk membuat, memeriksa, memperbarui, mengubah atau memperbaiki database, rekaman atau direktori Anda ataupun orang lain.</li><li>Mengubah atau mengatur ulang bagian apapun dalam Situs ini yang akan mengganggu atau menaruh beban berlebihan pada sistem komunikasi dan teknis kami.</li><li>Mengunakan kode computer otomatis, proses, program, robot, net crawler, spider, pemrosesan data, trawling atau kode computer, proses, program atau sistem ‘screen scraping’ alternatif.</li></ul></li><li>Kami tidak bertanggung jawab atas kehilangan akibat kegagalan mengakses Situs, dan metode penggunaan Situs yang di luar kendali Kami.</li><li>Kami tidak bertanggung jawab atau dapat dipersalahkan atas kehilangan atau kerusakan yang diluar perkiraan saat Anda mengakses atau menggunakan Situs ini. Ini termasuk kehilangan penghematan yang diharapkan, kehilangan bisnis atau kesempatan bisnis, kehilangan pemasukan atau keuntungan, atau kehilangan atau kerusakan apapun yang Anda harus alami akibat penggunaan Situs ini.</li></ul></li></ol>', '2024-01-23');

-- Dumping structure for table jadiorder.blw_pembayaran_pre
CREATE TABLE IF NOT EXISTS `blw_pembayaran_pre` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usrid` bigint(20) NOT NULL,
  `usrid_temp` int(11) NOT NULL,
  `tipeco` int(11) NOT NULL COMMENT '0=user,1=nonuser',
  `tgl` datetime NOT NULL,
  `digital` int(11) NOT NULL COMMENT '0=tidak,1=iya',
  `gudang` int(11) NOT NULL,
  `idbayar` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `saldo` int(11) NOT NULL,
  `transfer` int(11) NOT NULL,
  `kodebayar` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `metode` int(11) NOT NULL,
  `metode_bayar` int(11) NOT NULL COMMENT '1=cod,2=transfer,3=tripay,4=midtrans',
  `status` int(1) NOT NULL COMMENT '0=belumselesai,1=sudahselesai,2=batal',
  `dropship` text NOT NULL,
  `dropshipnomer` text NOT NULL,
  `dropshipkurir` text NOT NULL,
  `dropshipresi` text NOT NULL,
  `alamat` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `kurir` int(11) NOT NULL,
  `paket` int(11) NOT NULL,
  `dari` int(11) NOT NULL,
  `tujuan` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `produk` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

-- Dumping data for table jadiorder.blw_pembayaran_pre: ~12 rows (approximately)
INSERT INTO `blw_pembayaran_pre` (`id`, `usrid`, `usrid_temp`, `tipeco`, `tgl`, `digital`, `gudang`, `idbayar`, `total`, `saldo`, `transfer`, `kodebayar`, `voucher`, `diskon`, `metode`, `metode_bayar`, `status`, `dropship`, `dropshipnomer`, `dropshipkurir`, `dropshipresi`, `alamat`, `berat`, `ongkir`, `kurir`, `paket`, `dari`, `tujuan`, `cod`, `produk`) VALUES
	(114, 1, 0, 0, '2024-02-02 15:40:52', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT0000000', 1, 1250, 0, 0, 0, 119, 2932, 0, '8'),
	(115, 1, 0, 0, '2024-02-02 15:41:42', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, '', '', '', '', 1, 1250, 122000, 9, 15, 119, 2932, 0, '8'),
	(116, 1, 0, 0, '2024-02-02 15:42:16', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT0000000', 1, 1250, 0, 0, 0, 119, 2932, 0, '8'),
	(117, 1, 0, 0, '2024-02-02 15:42:38', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, '', '', '', '', 1, 1250, 136000, 8, 13, 119, 2932, 0, '8'),
	(118, 1, 0, 0, '2024-02-02 15:44:23', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT0100000', 1, 1250, 0, 0, 0, 119, 2932, 0, '8'),
	(119, 1, 0, 0, '2024-02-02 15:50:12', 0, 0, 8, 10000, 0, 146000, 0, 0, 0, 1, 0, 1, '', '', '', '', 1, 1250, 136000, 8, 13, 119, 2932, 0, '8'),
	(120, 1, 0, 0, '2024-02-02 15:52:55', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT000000', 1, 1250, 0, 0, 0, 119, 2932, 0, '9'),
	(121, 1, 0, 0, '2024-02-02 15:54:58', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT0100000', 1, 1250, 0, 0, 0, 119, 2932, 0, '9'),
	(122, 1, 0, 0, '2024-02-02 15:55:29', 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT0100000', 1, 1250, 0, 0, 0, 119, 2932, 0, '9'),
	(123, 1, 0, 0, '2024-02-02 15:57:35', 0, 0, 12, 10000, 0, 10000, 0, 0, 0, 1, 0, 1, 'Bagas Pramono', '085855011542', 'JNT', 'JT0000000', 1, 1250, 0, 0, 0, 119, 2932, 0, '9'),
	(124, 1, 0, 0, '2024-02-04 17:35:59', 0, 0, 0, 2000, 0, 0, 0, 0, 0, 0, 0, 2, 'Bagas Pramono', '085855011542', 'JNT', 'JT000000', 1, 250, 0, 0, 0, 119, 2932, 0, '10'),
	(125, 1, 0, 0, '2024-02-04 17:39:53', 0, 0, 0, 2000, 0, 0, 0, 0, 0, 0, 0, 0, 'Bagas Pramono', '085855011542', 'JNT', 'JT0000000', 1, 250, 0, 0, 0, 119, 2932, 0, '10');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
