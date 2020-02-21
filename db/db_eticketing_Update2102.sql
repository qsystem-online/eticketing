/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.2.30-MariaDB : Database - u5538790_eticketing
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u5538790_eticketing` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `u5538790_eticketing`;

/*Table structure for table `msbranches` */

DROP TABLE IF EXISTS `msbranches`;

CREATE TABLE `msbranches` (
  `fin_branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_branch_code` varchar(10) DEFAULT NULL,
  `fst_branch_name` varchar(100) DEFAULT NULL,
  `fst_address` text DEFAULT NULL,
  `fin_country_id` int(5) DEFAULT NULL,
  `fst_area_code` varchar(13) DEFAULT NULL,
  `fst_postalcode` varchar(10) DEFAULT NULL,
  `fst_branch_phone` varchar(20) DEFAULT NULL,
  `fst_notes` text DEFAULT NULL,
  `fbl_is_hq` tinyint(1) DEFAULT NULL COMMENT 'Hanya boleh ada 1 HQ di table cabang',
  `fst_active` enum('A','S','D') NOT NULL,
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `msbranches` */

insert  into `msbranches`(`fin_branch_id`,`fst_branch_code`,`fst_branch_name`,`fst_address`,`fin_country_id`,`fst_area_code`,`fst_postalcode`,`fst_branch_phone`,`fst_notes`,`fbl_is_hq`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,'JKT','JAKARTA','JAKARTA1',1,'31.73.06','11840','021','KACAB UTAMA JAKBAR 1',1,'A',1,'2020-02-17 18:09:05',1,'2020-02-17 18:10:57'),(2,'SBY','TANGERANG','TANGERANG1',1,'36.71.05','15148','021','KACAB UTAMA TANGERANG 1',0,'A',1,'2020-02-17 18:10:34',1,'2020-02-17 18:11:16'),(3,'TNG','SURABAYA','SURABAYA1',1,'35.78.08','60281','031','KACAB UTAMA SURABAYA 1',0,'A',1,'2020-02-17 18:14:39',1,NULL);

/*Table structure for table `mscountries` */

DROP TABLE IF EXISTS `mscountries`;

CREATE TABLE `mscountries` (
  `fin_country_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_country_name` varchar(100) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL,
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `mscountries` */

insert  into `mscountries`(`fin_country_id`,`fst_country_name`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,'INDONESIA','A',1,'2019-05-03 06:05:02',NULL,NULL),(2,'SINGAPORE','A',1,'2019-05-03 18:10:07',NULL,NULL),(3,'THAILAND','A',1,'2019-05-06 15:16:32',NULL,NULL),(4,'VIETNAM','A',1,'2019-05-06 15:26:41',NULL,NULL),(5,'MALAYSIA','A',1,'2019-05-06 16:07:25',NULL,NULL),(6,'FILIPINA','A',1,'2019-11-13 09:43:12',NULL,NULL);

/*Table structure for table `msservicelevel` */

DROP TABLE IF EXISTS `msservicelevel`;

CREATE TABLE `msservicelevel` (
  `fin_service_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_service_level_name` varchar(100) DEFAULT NULL,
  `fin_service_level_days` int(6) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_service_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `msservicelevel` */

insert  into `msservicelevel`(`fin_service_level_id`,`fst_service_level_name`,`fin_service_level_days`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,'SERVICE RINGAN LV. 1',1,'A',1,'2020-01-09 09:16:30',NULL,NULL),(2,'SERVICE RINGAN LV. 2',2,'A',1,'2020-01-09 09:16:54',NULL,NULL),(3,'SERVICE SEDANG LV. 1',3,'A',1,'2020-01-09 09:17:11',NULL,NULL),(4,'SERVICE SEDANG LV. 2',4,'A',1,'2020-01-22 11:03:42',NULL,NULL),(5,'SERVICE BERAT LV. 1',5,'A',1,'2020-01-22 11:04:13',NULL,NULL),(6,'SERVICE BERAT LV. 2',6,'A',1,'2020-01-22 11:04:52',NULL,NULL);

/*Table structure for table `mstickettype` */

DROP TABLE IF EXISTS `mstickettype`;

CREATE TABLE `mstickettype` (
  `fin_ticket_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_ticket_type_name` varchar(100) DEFAULT NULL,
  `fst_assignment_or_notice` enum('ASSIGNMENT','NOTICE','INFO') DEFAULT NULL COMMENT '"Assignment" or "Notice" or "Info"',
  `fbl_need_approval` tinyint(1) DEFAULT 0 COMMENT '1 level up yes/no',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_ticket_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `mstickettype` */

insert  into `mstickettype`(`fin_ticket_type_id`,`fst_ticket_type_name`,`fst_assignment_or_notice`,`fbl_need_approval`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,'INFORMASI','NOTICE',0,'A',1,'2020-02-05 14:53:56',NULL,NULL),(2,'PENGUMUMAN','INFO',0,'A',1,'2020-02-05 14:54:34',NULL,NULL),(3,'PERMINTAAN','ASSIGNMENT',0,'A',1,'2020-02-12 10:02:28',NULL,NULL),(4,'PEMERIKSAAN','NOTICE',1,'A',1,'2020-02-12 10:04:24',NULL,NULL),(5,'TUGAS','ASSIGNMENT',1,'A',1,'2020-02-14 14:17:55',NULL,NULL),(6,'PENGUMUMAN NEED APPROVAL','INFO',1,'A',1,'2020-02-14 14:46:18',NULL,NULL);

/*Table structure for table `trticket` */

DROP TABLE IF EXISTS `trticket`;

CREATE TABLE `trticket` (
  `fin_ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_ticket_no` varchar(30) DEFAULT NULL COMMENT 'YYMMDD-99999',
  `fdt_ticket_datetime` datetime NOT NULL,
  `fdt_acceptance_expiry_datetime` datetime NOT NULL,
  `fin_ticket_type_id` int(11) DEFAULT NULL,
  `fin_service_level_id` int(11) DEFAULT NULL COMMENT 'Untuk tipe Notice, tidak perlu service level, tapi deadline akan lgs terisi 7 hari dari tgl ticket',
  `fdt_deadline_datetime` datetime NOT NULL COMMENT 'tgl deadline = tgl Accept + fin_service_level_days (tidak ditampilkan di form ticket)',
  `fdt_deadline_extended_datetime` datetime NOT NULL COMMENT 'tgl extended deadline, secara default akan = tgl deadline, dan tgl extended ini bisa di edit oleh user yg issued (labelnya menggunakan deadline datetime, ditampilkan di form ticket)',
  `fin_issued_by_user_id` bigint(20) DEFAULT NULL,
  `fin_issued_to_user_id` bigint(20) DEFAULT NULL,
  `fin_approved_by_user_id` bigint(20) DEFAULT NULL,
  `fin_to_department_id` bigint(20) DEFAULT NULL,
  `fbl_rejected_view` tinyint(1) DEFAULT 0,
  `fst_status` enum('NEED_APPROVAL','APPROVED/OPEN','ACCEPTED','NEED_REVISION','COMPLETED','COMPLETION_REVISED','CLOSED','ACCEPTANCE_EXPIRED','TICKET_EXPIRED','REJECTED','VOID') DEFAULT NULL,
  `fst_memo` text DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  PRIMARY KEY (`fin_ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `trticket` */

insert  into `trticket`(`fin_ticket_id`,`fst_ticket_no`,`fdt_ticket_datetime`,`fdt_acceptance_expiry_datetime`,`fin_ticket_type_id`,`fin_service_level_id`,`fdt_deadline_datetime`,`fdt_deadline_extended_datetime`,`fin_issued_by_user_id`,`fin_issued_to_user_id`,`fin_approved_by_user_id`,`fin_to_department_id`,`fbl_rejected_view`,`fst_status`,`fst_memo`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,'eTICK/202002/00001','2020-02-17 15:40:22','2020-02-20 15:40:22',6,NULL,'2020-02-20 15:40:22','2020-02-20 15:40:22',15,0,NULL,0,0,'TICKET_EXPIRED','JALANKAN SOP KERJA. GUNAKAN ALAT PELINDUNG DIRI KESEHATAN & KESELAMATAN KERJA (K3)','A',1,'2020-02-17 15:40:22',NULL,'0000-00-00 00:00:00'),(2,'eTICK/202002/00002','2020-02-17 15:43:57','2020-02-20 15:43:58',5,NULL,'2020-02-24 15:43:58','2020-02-24 15:43:58',1,6,NULL,NULL,0,'ACCEPTED','Tolong siapkan data karyawan baru dan fc. ktp, kk dan ijazah pendidikan terakhir','A',1,'2020-02-17 15:43:58',19,'2020-02-17 17:36:59'),(3,'eTICK/202002/00003','2020-02-17 15:47:04','2020-02-20 15:47:04',5,6,'2020-02-21 15:47:04','2020-02-21 15:47:04',1,6,28,NULL,0,'NEED_APPROVAL','Tolong maintenance mesin di produksi','A',1,'2020-02-17 15:47:04',NULL,'0000-00-00 00:00:00'),(4,'eTICK/202002/00004','2020-02-17 15:51:06','2020-02-20 15:51:07',5,6,'2020-02-24 15:00:07','2020-02-24 15:00:07',6,1,NULL,NULL,0,'ACCEPTED','Tolong sediakan sparepart, masker dan helm pelindung. Stocknya sudah habis di gudang.','A',6,'2020-02-17 15:51:07',1,'2020-02-19 16:18:53'),(5,'eTICK/202002/00005','2020-02-17 16:00:42','2020-02-20 16:00:42',5,NULL,'2020-02-24 16:00:42','2020-02-24 16:00:42',6,9,1,NULL,0,'APPROVED/OPEN','Tolong cek stock gudang di gedung A','A',6,'2020-02-17 16:00:42',1,'2020-02-17 17:34:09'),(6,'eTICK/202002/00006','2020-02-17 16:09:24','2020-02-20 16:09:24',5,NULL,'2020-02-24 16:09:24','2020-02-24 16:09:24',9,1,NULL,NULL,0,'APPROVED/OPEN','Tolong tambah personel untuk di lapangan, produksi kekurangan personel. Banyak yang resign.','A',9,'2020-02-17 16:09:24',NULL,'0000-00-00 00:00:00'),(7,'eTICK/202002/00007','2020-02-17 16:39:01','2020-02-20 16:39:01',3,NULL,'2020-02-20 16:39:01','2020-02-20 16:39:01',1,0,15,9,0,'TICKET_EXPIRED','Sebelum akhir bulan, gudang sudah harus rapih pengaturannya, semuanya harus sistematis, jika sudah langsung diinput ke sistem sesuai dengan kode barang. Jika masih berantakan semua personel gudang akan diberi SP 1.\r\n(Pengumuman untuk Department Gudang)','A',1,'2020-02-17 16:39:01',28,'2020-02-17 17:35:08'),(8,'eTICK/202002/00008','2020-02-18 13:29:37','2020-02-21 13:29:37',2,NULL,'2020-02-21 13:29:37','2020-02-21 13:29:37',6,0,NULL,1,0,'APPROVED/OPEN','JALANKAN SOP KERJA. GUNAKAN ALAT PELINDUNG DIRI KESEHATAN & KESELAMATAN KERJA (K3)','A',6,'2020-02-18 13:29:38',NULL,'0000-00-00 00:00:00'),(9,'eTICK/202002/00009','2020-02-19 00:24:17','2020-02-22 00:24:17',5,0,'2020-02-19 00:24:17','2020-02-19 00:24:17',6,14,16,NULL,0,'NEED_APPROVAL','Buatkan Laporan sales periode 2019-01 sd 2019-12.','A',6,'2020-02-19 00:24:18',NULL,'0000-00-00 00:00:00'),(10,'eTICK/202002/00010','2020-02-19 16:29:35','2020-02-22 16:29:35',5,4,'2020-02-23 16:29:35','2020-02-23 16:29:35',1,6,15,NULL,0,'ACCEPTED','Tolong cek barang masuk di gudang sparepart.','A',1,'2020-02-19 16:29:35',6,'2020-02-19 16:39:36');

/*Table structure for table `trticket_docs` */

DROP TABLE IF EXISTS `trticket_docs`;

CREATE TABLE `trticket_docs` (
  `fin_rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_doc_title` varchar(256) DEFAULT NULL,
  `fst_status` varchar(25) DEFAULT NULL,
  `fst_filename` varchar(256) DEFAULT NULL,
  `fst_memo` text DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fin_insert_id` int(11) DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `trticket_docs` */

insert  into `trticket_docs`(`fin_rec_id`,`fst_doc_title`,`fst_status`,`fst_filename`,`fst_memo`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (5,'sdasdasd','NEED_APPROVAL','deposit3_donna.jpeg','TUGASasdasdasd','A',12,'2020-02-14 17:58:47',NULL,NULL),(6,'sdasdasd',NULL,'ming_poi_topup.jpg','TUGASasdasdasd','A',12,'2020-02-14 17:59:01',NULL,NULL),(7,'','ACCEPTED','kartu-bpjs-kesehatan.jpg','Tolong siapkan data karyawan baru dan fc. ktp, kk dan ijazah pendidikan terakhir','A',1,'2020-02-19 15:31:21',NULL,NULL);

/*Table structure for table `trticket_log` */

DROP TABLE IF EXISTS `trticket_log`;

CREATE TABLE `trticket_log` (
  `fin_rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `fin_ticket_id` int(11) NOT NULL,
  `fdt_status_datetime` datetime NOT NULL,
  `fst_status` enum('NEED_APPROVAL','APPROVED/OPEN','ACCEPTED','NEED_REVISION','REVISED','COMPLETED','COMPLETION_REVISED','CLOSED','ACCEPTANCE_EXPIRED','TICKET_EXPIRED','VOID','REJECTED') DEFAULT NULL COMMENT 'acceptance exp = adl batas wkt bila ticket tidak di accept(fdt_acceptance_expiry_datetime). ticket exp = sdh melewati batas deadline.',
  `fst_status_memo` text DEFAULT NULL,
  `fin_status_by_user_id` bigint(20) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  PRIMARY KEY (`fin_rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `trticket_log` */

insert  into `trticket_log`(`fin_rec_id`,`fin_ticket_id`,`fdt_status_datetime`,`fst_status`,`fst_status_memo`,`fin_status_by_user_id`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,1,'2020-02-17 15:40:22','APPROVED/OPEN','JALANKAN SOP KERJA. GUNAKAN ALAT PELINDUNG DIRI KESEHATAN & KESELAMATAN KERJA (K3)',1,'A',1,'2020-02-17 15:40:22',NULL,'0000-00-00 00:00:00'),(2,2,'2020-02-17 15:43:57','APPROVED/OPEN','Tolong siapkan data karyawan baru dan fc. ktp, kk dan ijazah pendidikan terakhir',1,'A',1,'2020-02-17 15:43:58',NULL,'0000-00-00 00:00:00'),(3,3,'2020-02-17 15:47:04','NEED_APPROVAL','Tolong maintenance mesin di produksi',1,'A',1,'2020-02-17 15:47:04',NULL,'0000-00-00 00:00:00'),(4,4,'2020-02-17 15:51:06','APPROVED/OPEN','Tolong sediakan sparepart, masker dan helm pelindung. Stocknya sudah habis di gudang.',6,'A',19,'2020-02-17 15:51:07',NULL,'0000-00-00 00:00:00'),(5,5,'2020-02-17 16:00:42','NEED_APPROVAL','Tolong cek stock gudang di gedung A',6,'A',19,'2020-02-17 16:00:42',NULL,'0000-00-00 00:00:00'),(6,6,'2020-02-17 16:09:24','APPROVED/OPEN','Tolong tambah personel untuk di lapangan, produksi kekurangan personel. Banyak yang resign.',9,'A',9,'2020-02-17 16:09:24',NULL,'0000-00-00 00:00:00'),(7,7,'2020-02-17 16:39:01','NEED_APPROVAL','Sebelum akhir bulan, gudang sudah harus rapih pengaturannya, semuanya harus sistematis, jika sudah langsung diinput ke sistem sesuai dengan kode barang. Jika masih berantakan semua personel gudang akan diberi SP 1.',1,'A',1,'2020-02-17 16:39:01',NULL,'0000-00-00 00:00:00'),(8,5,'2020-02-17 17:34:09','APPROVED/OPEN','Disetujui',1,'A',1,'2020-02-17 17:34:09',NULL,'0000-00-00 00:00:00'),(9,7,'2020-02-17 17:35:08','APPROVED/OPEN','Lanjutkan',15,'A',28,'2020-02-17 17:35:08',NULL,'0000-00-00 00:00:00'),(10,2,'2020-02-17 17:36:59','ACCEPTED','SIAP!!!',6,'A',19,'2020-02-17 17:36:59',NULL,'0000-00-00 00:00:00'),(11,4,'2020-02-17 17:49:37','NEED_REVISION','Perpanjang waktu, saat ini barang yang diminta belum tersedia di supplier.',1,'A',1,'2020-02-17 17:49:37',NULL,'0000-00-00 00:00:00'),(12,8,'2020-02-18 13:29:37','APPROVED/OPEN','JALANKAN SOP KERJA. GUNAKAN ALAT PELINDUNG DIRI KESEHATAN & KESELAMATAN KERJA (K3)',6,'A',6,'2020-02-18 13:29:38',NULL,'0000-00-00 00:00:00'),(13,9,'2020-02-19 00:24:17','NEED_APPROVAL','Buatkan Laporan sales periode 2019-01 sd 2019-12.',6,'A',6,'2020-02-19 00:24:18',NULL,'0000-00-00 00:00:00'),(14,4,'2020-02-19 16:17:59','REVISED','Oke sudah tambah waktu ya',6,'A',6,'2020-02-19 16:17:59',NULL,'0000-00-00 00:00:00'),(15,4,'2020-02-19 16:18:53','ACCEPTED','thankyu',1,'A',1,'2020-02-19 16:18:53',NULL,'0000-00-00 00:00:00'),(16,10,'2020-02-19 16:29:35','NEED_APPROVAL','Tolong cek barang masuk di gudang sparepart.',1,'A',1,'2020-02-19 16:29:35',NULL,'0000-00-00 00:00:00'),(17,10,'2020-02-19 16:30:42','APPROVED/OPEN','Disetujui',15,'A',15,'2020-02-19 16:30:42',NULL,'0000-00-00 00:00:00'),(18,10,'2020-02-19 16:39:36','ACCEPTED','Laksanakan',6,'A',6,'2020-02-19 16:39:36',NULL,'0000-00-00 00:00:00'),(19,1,'2020-02-21 08:19:31','TICKET_EXPIRED','TICKET_EXPIRED BY SYSTEM',1,'A',1,'2020-02-21 08:19:31',NULL,'0000-00-00 00:00:00'),(20,7,'2020-02-21 08:19:31','TICKET_EXPIRED','TICKET_EXPIRED BY SYSTEM',1,'A',1,'2020-02-21 08:19:31',NULL,'0000-00-00 00:00:00');

/*Table structure for table `trticketexpiry_log` */

DROP TABLE IF EXISTS `trticketexpiry_log`;

CREATE TABLE `trticketexpiry_log` (
  `rec_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fdt_log_start_datetime` datetime DEFAULT NULL,
  `fdt_log_end_datetime` datetime DEFAULT NULL,
  `fin_count` int(11) DEFAULT NULL,
  KEY `rec_id` (`rec_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `trticketexpiry_log` */

insert  into `trticketexpiry_log`(`rec_id`,`fdt_log_start_datetime`,`fdt_log_end_datetime`,`fin_count`) values (1,'2020-02-02 17:51:22','0000-00-00 00:00:00',1),(2,'2020-02-02 17:04:54','2020-02-03 19:14:02',2),(3,NULL,NULL,NULL),(4,'2020-02-01 21:58:10',NULL,1),(5,'2020-02-03 10:36:06','2020-02-03 10:36:07',3),(6,'2020-02-01 10:40:36','2020-02-01 10:40:36',1),(7,'2020-02-04 11:46:29','2020-02-04 11:46:30',3),(8,NULL,NULL,NULL),(9,'2020-02-05 07:47:59','2020-02-05 07:48:00',1),(10,'2020-02-06 08:44:12','2020-02-06 08:44:12',1),(11,'2020-02-07 08:31:46','2020-02-07 08:31:46',1),(12,'2020-02-08 11:25:45','2020-02-08 11:25:45',1),(13,'2020-02-09 09:10:43','2020-02-09 09:10:43',1),(14,'2020-02-10 08:42:20','2020-02-10 08:42:20',1),(15,'2020-02-11 08:22:56','2020-02-11 08:22:56',1),(16,'2020-02-12 08:31:28','2020-02-12 08:31:28',1),(17,'2020-02-13 09:08:28','2020-02-13 09:08:28',1),(18,'2020-02-14 08:14:35','2020-02-14 08:14:35',1),(19,'2020-02-15 08:53:00','2020-02-15 08:53:00',1),(20,'2020-02-16 19:54:43','2020-02-16 19:54:43',1),(21,'2020-02-17 08:36:36','2020-02-17 08:36:36',1),(22,'2020-02-18 08:33:34','2020-02-18 08:33:35',1),(23,'2020-02-19 08:47:24','2020-02-19 08:47:24',1),(24,'2020-02-20 08:59:28','2020-02-20 08:59:28',1),(25,'2020-02-21 08:19:31','2020-02-21 08:19:31',1);

/*Table structure for table `trverification` */

DROP TABLE IF EXISTS `trverification`;

CREATE TABLE `trverification` (
  `fin_rec_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fin_branch_id` int(11) DEFAULT NULL,
  `fst_controller` varchar(100) DEFAULT NULL,
  `fst_verification_type` varchar(100) DEFAULT NULL,
  `fin_transaction_id` int(11) DEFAULT NULL,
  `fst_transaction_no` varchar(25) DEFAULT NULL,
  `fin_seqno` int(5) DEFAULT NULL,
  `fst_message` text DEFAULT NULL,
  `fin_department_id` int(5) DEFAULT NULL,
  `fin_user_group_id` int(2) DEFAULT NULL,
  `fst_verification_status` enum('NV','RV','VF','RJ','VD') DEFAULT 'NV' COMMENT 'NV = Need Verification, RV = Ready to verification, VF=Verified, RJ= Rejected, VD= Void',
  `fst_notes` text DEFAULT NULL,
  `fst_model` varchar(100) DEFAULT NULL COMMENT 'Akan di panggil bila proses verifikasi selesai',
  `fst_method` varchar(100) DEFAULT NULL COMMENT 'Akan di panggil bila proses verifikasi selesai',
  `fst_show_record_method` varchar(256) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL,
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8;

/*Data for the table `trverification` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `fin_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_username` varchar(50) NOT NULL,
  `fst_password` varchar(256) NOT NULL,
  `fst_fullname` varchar(256) NOT NULL,
  `fst_gender` enum('M','F') NOT NULL,
  `fdt_birthdate` date NOT NULL,
  `fst_birthplace` varchar(256) NOT NULL,
  `fst_address` text DEFAULT NULL,
  `fst_phone` varchar(100) DEFAULT NULL,
  `fst_email` varchar(100) DEFAULT NULL,
  `fin_branch_id` int(5) NOT NULL,
  `fin_department_id` bigint(20) NOT NULL,
  `fin_group_id` bigint(20) DEFAULT NULL,
  `fbl_admin` tinyint(1) NOT NULL DEFAULT 0,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  PRIMARY KEY (`fin_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`fin_user_id`,`fst_username`,`fst_password`,`fst_fullname`,`fst_gender`,`fdt_birthdate`,`fst_birthplace`,`fst_address`,`fst_phone`,`fst_email`,`fin_branch_id`,`fin_department_id`,`fin_group_id`,`fbl_admin`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'enny06','c50e5b88116a073a72aea201b96bfe8e','Enny Nur@ini','F','1979-10-06','Jakarta','Perum Pondok Makmur Jl. Srikaya 2 No 23 RT.006/RW.008, Kel. Kutabaru, Kec. Pasar Kemis, Kab. Tangerang','08128042742','enny06@yahoo.com',1,1,3,1,'A','0000-00-00 00:00:00',0,'2019-12-24 12:57:50',1),(2,'devi','06a6077b0cfcb0f4890fb5f2543c43be','Devi Bastian','M','1978-08-26','Pematang Siantar','','','devibong@yahoo.com',1,1,2,1,'A','0000-00-00 00:00:00',0,'2019-11-07 17:08:14',1),(3,'SALES NO 1','06a6077b0cfcb0f4890fb5f2543c43be','Sales No 1 National','M','1989-07-17','Jakarta','','','',1,1,4,1,'A','2019-07-06 17:37:42',0,'2019-11-07 17:09:59',1),(4,'SALES NO 2','06a6077b0cfcb0f4890fb5f2543c43be','Sales No 2 Regional','M','1989-07-17','Jakarta','','','',1,1,4,1,'A','2019-07-06 17:39:31',0,'2019-11-07 17:10:25',1),(5,'SALES NO 3','06a6077b0cfcb0f4890fb5f2543c43be','Sales No 3 Area','M','1989-07-17','Jakarta','','','',1,1,7,1,'A','2019-07-06 17:39:31',0,'2019-11-07 17:11:01',1),(6,'TUBAGUS','827ccb0eea8a706c4c34a16891f84e7b','TUBAGUS','M','1989-07-17','Jakarta','-','-','-',1,1,4,0,'A','2019-11-26 18:09:40',1,'2020-02-04 10:48:56',19),(7,'DHANI','827ccb0eea8a706c4c34a16891f84e7b','DHANI AHMAD','M','1989-01-01','Jakarta','','','',1,1,3,1,'A','2019-11-26 18:24:56',1,'2020-02-13 11:28:35',21),(8,'ALIANG','06a6077b0cfcb0f4890fb5f2543c43be','ALIANG','M','1989-04-01','Jakarta','','','',1,1,5,1,'A','2019-11-26 18:26:40',1,'2020-01-31 15:28:29',21),(9,'ANOM_','d923721a4cdc11c435f7609dcecb864c','ANOM_','M','1989-08-17','Jakarta','','','',1,1,7,0,'A','2019-11-26 18:28:15',1,'2019-12-20 15:26:22',1),(10,'BACHM','06a6077b0cfcb0f4890fb5f2543c43be','BACHMID','M','1989-05-18','Jakarta','','','',1,5,7,0,'A','2019-11-26 18:30:54',1,'2019-12-20 15:28:01',1),(11,'SUPIR1','5f4dcc3b5aa765d61d8327deb882cf99','SOPIR 1','M','2019-12-01','Jakarta','','','',1,6,8,0,'A','2019-12-03 10:30:01',12,'2019-12-09 12:46:08',1),(12,'SUPIR2','5f4dcc3b5aa765d61d8327deb882cf99','SOPIR / DRIVER 2','M','2019-12-31','Jakarta','','','',1,6,8,1,'A','2019-12-03 10:31:18',12,'2020-02-10 09:27:44',1),(13,'ALIANDO','06a6077b0cfcb0f4890fb5f2543c43be','ALIANDO','M','1989-07-17','JAKARTA','JAKARTA','','',1,5,6,0,'A','2019-12-09 12:38:23',1,'2019-12-09 13:28:12',1),(14,'CECEP','06a6077b0cfcb0f4890fb5f2543c43be','CECEP','F','1980-11-27','JAKARTA','KALIDERES','0812','',1,3,6,1,'A','2020-01-10 14:05:00',1,'0000-00-00 00:00:00',0),(15,'POPON','827ccb0eea8a706c4c34a16891f84e7b','POPON','F','1970-01-01','JAKARTA','','','',1,1,2,1,'A','2020-02-11 16:21:51',1,'2020-02-13 14:28:29',1),(16,'BOSQUE','827ccb0eea8a706c4c34a16891f84e7b','BOSQUE','M','1970-01-01','JAKARTA','','','',1,1,1,1,'A','2020-02-11 16:38:20',1,'2020-02-13 14:27:57',1),(17,'TIK TOK','5f4dcc3b5aa765d61d8327deb882cf99','TIK TOK','M','1982-02-19','JAKARTA','','','',1,3,2,1,'A','2020-02-14 14:30:11',1,'0000-00-00 00:00:00',0),(18,'RAISA','5f4dcc3b5aa765d61d8327deb882cf99','RAISA','F','1988-03-04','JAKARTA','','','',1,1,2,1,'A','2020-02-14 14:31:35',1,'0000-00-00 00:00:00',0);

/*Table structure for table `usersgroup` */

DROP TABLE IF EXISTS `usersgroup`;

CREATE TABLE `usersgroup` (
  `fin_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `fst_group_name` varchar(256) NOT NULL,
  `fin_level` enum('1','2','3','4','5','6') NOT NULL COMMENT '1=Top management, 2=Upper management, 3=Middle management, 4=Supervisors, 5=Line workers, 6=public',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`fin_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `usersgroup` */

insert  into `usersgroup`(`fin_group_id`,`fst_group_name`,`fin_level`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'PRESIDENT MANAGER','1','A','2020-02-17 14:35:36',4,NULL,NULL),(2,'GENERAL MANAGER','2','A','2020-02-17 14:36:36',4,NULL,NULL),(3,'MANAGER','3','A','2020-02-17 14:36:44',4,NULL,NULL),(4,'SUPERVISOR','4','A','2020-02-17 14:37:01',4,NULL,NULL),(5,'STAFF','5','A','2020-02-17 14:37:13',4,NULL,NULL),(6,'SALES','5','A','2020-02-17 14:37:26',4,NULL,NULL),(7,'DRIVER','5','A','2020-02-17 14:37:43',4,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
