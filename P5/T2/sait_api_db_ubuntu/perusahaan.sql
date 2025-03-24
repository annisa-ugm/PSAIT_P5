/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.22-MariaDB : Database - pegawai db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pegawai_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pegawai_db`;

-- Tabel Departemen
DROP TABLE IF EXISTS `departemen`;
CREATE TABLE `departemen` (
  `id_departemen` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_departemen` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_departemen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data ke tabel Departemen
INSERT INTO `departemen` (`nama_departemen`) VALUES 
('Manajemen'),
('Sumber Daya Manusia'),
('Pemasaran'),
('Teknologi Informasi'),
('Desain');

/* Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* Data for the table `pegawai` */

INSERT INTO `pegawai`(`nama`, `jabatan`) VALUES 
('Annisa', 'Manager'),
('Felisa', 'HRD'),
('Irene', 'Marketing'),
('Deandra', 'IT Support'),
('Tyas', 'Developer'),
('Husna', 'System Analyst'),
('Putri', 'Designer');

-- Tabel Relasional: Departemen - Pegawai (Many-to-Many)
DROP TABLE IF EXISTS `departemen_pegawai`;
CREATE TABLE `departemen_pegawai` (
  `id_pegawai` INT(11) NOT NULL,
  `id_departemen` INT(11) NOT NULL,
  PRIMARY KEY (`id_pegawai`, `id_departemen`),
  FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai`(`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_departemen`) REFERENCES `departemen`(`id_departemen`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data ke tabel Relasional Departemen-Pegawai
INSERT INTO `departemen_pegawai` (`id_pegawai`, `id_departemen`) VALUES 
(1, 1), -- Annisa (Manager) → Manajemen
(2, 2), -- Felisa (HRD) → Sumber Daya Manusia
(3, 3), -- Irene (Marketing) → Pemasaran
(4, 4), -- Deandra (IT Support) → Teknologi Informasi
(5, 4), -- Tyas (Developer) → Teknologi Informasi
(6, 4), -- Husna (System Analyst) → Teknologi Informasi
(7, 5); -- Putri (Designer) → Desain

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
