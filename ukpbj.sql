/*
Navicat MySQL Data Transfer

Source Server         : Localhot
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ukpbj

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-12-05 23:17:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(100) DEFAULT NULL,
  `ikon` varchar(100) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', 'Home', 'fas fa-home', '1', null, null, null);
INSERT INTO `menus` VALUES ('2', 'Transaksi', 'fas fa-clipboard-list', '2', null, null, null);
INSERT INTO `menus` VALUES ('3', 'Master', '\r\nfas fa-cogs', '3', null, null, null);

-- ----------------------------
-- Table structure for `m_dinas`
-- ----------------------------
DROP TABLE IF EXISTS `m_dinas`;
CREATE TABLE `m_dinas` (
  `id_dinas` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(55) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_dinas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_dinas
-- ----------------------------
INSERT INTO `m_dinas` VALUES ('1', 'DINAS SOSIAL', 'Jl. Jend Sudirman. Komplek Perkantoran ', '7366112', 'DINAS SOSIAL');
INSERT INTO `m_dinas` VALUES ('3', 'Dinas BP2 Keluarga Berencana dan Pengendalian Anak', 'Jl. Jend. Sudirman Gedung Bukit Selembak', '0882731873', 'DINAS PENGENDALIAN PENDUDUK KELUARGA BERENCANA PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK');
INSERT INTO `m_dinas` VALUES ('4', 'DISHUB', 'Tanjung Balai Karimun', '0882731873', 'DINAS PERHUBUNGAN');

-- ----------------------------
-- Table structure for `m_penyedia`
-- ----------------------------
DROP TABLE IF EXISTS `m_penyedia`;
CREATE TABLE `m_penyedia` (
  `id_penyedia` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) NOT NULL,
  `alamat` text,
  `npwp` varchar(200) DEFAULT NULL,
  `nomor_siup` varchar(200) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_penyedia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_penyedia
-- ----------------------------
INSERT INTO `m_penyedia` VALUES ('1', 'PT Sideveloper', 'Kendal', '123456789', '1234567890', '1', 'arif.kurniawan@pel.co.id', '0882731873');
INSERT INTO `m_penyedia` VALUES ('2', 'Penyedia 2', 'Semarang', '987654321', '0987654321', '2', 'arif.kurniawan@pel.co.id', '01923019230');
INSERT INTO `m_penyedia` VALUES ('4', 'Arif Kurniawan', 'Surabaya', '01.061.208.3-093.000', '39198239', '3', 'el.shevarif@gmail.com', '0882731873');

-- ----------------------------
-- Table structure for `m_syscode`
-- ----------------------------
DROP TABLE IF EXISTS `m_syscode`;
CREATE TABLE `m_syscode` (
  `id_syscode` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`id_syscode`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_syscode
-- ----------------------------
INSERT INTO `m_syscode` VALUES ('1', 'KT', 'Sangat Buruk', '1');
INSERT INTO `m_syscode` VALUES ('2', 'KT', 'Buruk', '2');
INSERT INTO `m_syscode` VALUES ('3', 'KT', 'Baik', '3');
INSERT INTO `m_syscode` VALUES ('4', 'KT', 'Sangat Baik', '4');
INSERT INTO `m_syscode` VALUES ('5', 'KW', 'Sangat Terlambat', '1');
INSERT INTO `m_syscode` VALUES ('6', 'KW', 'Terlambat', '2');
INSERT INTO `m_syscode` VALUES ('7', 'KW', 'Tepat Waktu', '3');
INSERT INTO `m_syscode` VALUES ('8', 'KW', 'Sangat Tepat Waktu', '4');
INSERT INTO `m_syscode` VALUES ('9', 'TL', 'Buruk', '1');
INSERT INTO `m_syscode` VALUES ('10', 'TL', 'Cukup', '2');
INSERT INTO `m_syscode` VALUES ('11', 'TL', 'Baik', '3');
INSERT INTO `m_syscode` VALUES ('12', 'TL', 'Prima', '4');
INSERT INTO `m_syscode` VALUES ('13', 'JP', 'PT', '1');
INSERT INTO `m_syscode` VALUES ('14', 'JP', 'CV', '2');
INSERT INTO `m_syscode` VALUES ('15', 'JP', 'Perseorangan', '3');
INSERT INTO `m_syscode` VALUES ('16', 'JP', 'UMKM', '4');

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id_permission` int(11) NOT NULL AUTO_INCREMENT,
  `id_privilege` int(11) DEFAULT NULL,
  `id_sub_menu` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '1', '1', null, '1');
INSERT INTO `permissions` VALUES ('2', '1', '2', null, '2');
INSERT INTO `permissions` VALUES ('3', '1', '3', null, '2');
INSERT INTO `permissions` VALUES ('4', '2', '1', null, '1');
INSERT INTO `permissions` VALUES ('5', '2', '2', null, '2');
INSERT INTO `permissions` VALUES ('6', '2', '3', null, '2');
INSERT INTO `permissions` VALUES ('7', '3', '1', null, '1');
INSERT INTO `permissions` VALUES ('8', '3', '2', null, '2');
INSERT INTO `permissions` VALUES ('9', '3', '3', null, '2');
INSERT INTO `permissions` VALUES ('10', '4', '1', null, '1');
INSERT INTO `permissions` VALUES ('11', '4', '2', null, '2');
INSERT INTO `permissions` VALUES ('12', '4', '3', null, '2');
INSERT INTO `permissions` VALUES ('13', '4', '4', null, '3');
INSERT INTO `permissions` VALUES ('14', '4', '5', null, '3');
INSERT INTO `permissions` VALUES ('15', '4', '6', null, '3');
INSERT INTO `permissions` VALUES ('16', '1', '6', null, '3');

-- ----------------------------
-- Table structure for `privileges`
-- ----------------------------
DROP TABLE IF EXISTS `privileges`;
CREATE TABLE `privileges` (
  `id_privilege` int(11) NOT NULL AUTO_INCREMENT,
  `nama_privilege` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_privilege`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of privileges
-- ----------------------------
INSERT INTO `privileges` VALUES ('1', 'Pejabat Pembuat Komitmen', null, null);
INSERT INTO `privileges` VALUES ('2', 'Kepala UKPBJ', null, null);
INSERT INTO `privileges` VALUES ('3', 'Kepala Dinas', null, null);
INSERT INTO `privileges` VALUES ('4', 'Admin', null, null);

-- ----------------------------
-- Table structure for `submenus`
-- ----------------------------
DROP TABLE IF EXISTS `submenus`;
CREATE TABLE `submenus` (
  `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sub_menu` varchar(100) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_sub_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of submenus
-- ----------------------------
INSERT INTO `submenus` VALUES ('1', 'Ranking', '1', '1', 'home', null, null);
INSERT INTO `submenus` VALUES ('2', 'Penilaian', '1', '2', 'penilaian', null, null);
INSERT INTO `submenus` VALUES ('3', 'Laporan', '2', '2', 'penilaian/laporan', null, null);
INSERT INTO `submenus` VALUES ('4', 'User', '1', '3', 'master/user', null, null);
INSERT INTO `submenus` VALUES ('5', 'Dinas', '2', '3', 'master/dinas', null, null);
INSERT INTO `submenus` VALUES ('6', 'Penyedia', '3', '3', 'master/penyedia', null, null);

-- ----------------------------
-- Table structure for `transaksi`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_penyedia` int(11) NOT NULL,
  `id_dinas` int(11) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `hal_surat` varchar(100) DEFAULT NULL,
  `nama_pekerjaan` varchar(100) DEFAULT NULL,
  `nilai_kontrak` double DEFAULT NULL,
  `nilai_kontrak_hps` double DEFAULT NULL,
  `tahun_paket` char(4) DEFAULT NULL,
  `persentase_realisasi` double DEFAULT NULL,
  `nomor_kontrak` varchar(100) DEFAULT NULL,
  `biaya` int(11) DEFAULT NULL,
  `realisasi` varchar(100) DEFAULT NULL,
  `kualitas` int(11) DEFAULT NULL,
  `ketepatan_waktu` int(11) DEFAULT NULL,
  `tingkat_layanan` int(11) DEFAULT NULL,
  `biaya_nilai` int(11) DEFAULT NULL,
  `realisasi_nilai` int(11) DEFAULT NULL,
  `kualitas_nilai` int(11) DEFAULT NULL,
  `ketepatan_waktu_nilai` int(11) DEFAULT NULL,
  `tingkat_layanan_nilai` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `fk_transaksi_penyedia` (`id_penyedia`),
  KEY `fk_transaksi_dinas` (`id_dinas`),
  KEY `fk_transaksi_usercreate` (`created_by`),
  CONSTRAINT `fk_transaksi_dinas` FOREIGN KEY (`id_dinas`) REFERENCES `m_dinas` (`id_dinas`) ON UPDATE CASCADE,
  CONSTRAINT `fk_transaksi_penyedia` FOREIGN KEY (`id_penyedia`) REFERENCES `m_penyedia` (`id_penyedia`) ON UPDATE CASCADE,
  CONSTRAINT `fk_transaksi_usercreate` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES ('1', '2', '1', 'NM/10/2020', '2020-12-02', 'COBA', 'Design Web', '6000000', '6000000', '2020', '100', 'NK/0.1/2020', '100', 'asdadd', '1', '1', '1', '10', '15', '10', '20', '5', '2020-12-04 17:21:55', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_privilege` int(11) NOT NULL,
  `id_dinas` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `golongan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `user_ppk` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '1', '1', 'ppk1', '$2y$10$Xkkv0kgSk1UduoKeiy1K/.cIbB7wW1c7ftooR/.AMNL/Gf8vGF1zm', 'PPK Dinas Sosial', '19450817.201908.1.01', 'V', '08985565211', 'arif.kurniawan@pel.co.id', null);
INSERT INTO `users` VALUES ('2', '4', null, 'admin', '$2y$10$GxktxSxcinRopc.3oR8PE.aDNGeZp8jTo3WJHHjZhnuZu9KdRchT.', 'Admin', '123', '-', '-', 'arif.kurniawan@pel.co.id', null);
INSERT INTO `users` VALUES ('4', '3', '1', 'kepala_dinas1', '$2y$10$Ng1LyjaECbRdtkNVjC2QZu.zT7T8VdxethkE0NIegQnzFgs2cqtVC', 'Kepala Dinas Sosial', '29302130', 'V', '08985565211', 'kepaladinassosial@karimun.net', null);
INSERT INTO `users` VALUES ('5', '2', null, 'kepala_ukpbj', '$2y$10$Y0ZYjYx9kdJ39YdpEwABB.QBUhqRKDfc8Buvc8VHiiQj0rzrwfld2', 'Kepala UKPBJ', '29302130', 'I', '08985565211', 'arif.kurniawan@pel.co.id', null);
