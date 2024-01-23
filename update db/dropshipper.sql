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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table jadiorder.blw_dropshipper_syarat
CREATE TABLE IF NOT EXISTS `blw_dropshipper_syarat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `akun` text NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` date DEFAULT curdate(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
