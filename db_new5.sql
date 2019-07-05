-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: db_eoq
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(150) NOT NULL,
  `stok` int(10) unsigned NOT NULL,
  `harga_barang` int(10) unsigned NOT NULL,
  `biaya_pemesanan` int(10) unsigned NOT NULL,
  `biaya_penyimpanan` int(10) unsigned NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  `idsupplier` int(10) unsigned NOT NULL,
  `idkategori` int(10) unsigned NOT NULL,
  `idetalase` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_barang` (`idusers`),
  KEY `fk_idkategori_barang` (`idkategori`),
  KEY `fk_idetalase_barang` (`idetalase`),
  KEY `fk_idsupplier_barang` (`idsupplier`),
  CONSTRAINT `fk_idetalase_barang` FOREIGN KEY (`idetalase`) REFERENCES `etalase` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idkategori_barang` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idsupplier_barang` FOREIGN KEY (`idsupplier`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idusers_barang` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,'Test 1',9,15000,1000,400,'2021-05-23','2019-05-20 16:49:23','2019-07-04 09:48:32',2,2,2,2),(2,'Test 2',6,18000,500,500,'2021-12-24','2019-05-20 17:07:45','2019-07-01 12:40:08',2,1,2,2),(3,'test3',15,12000,3000,600,'2020-08-13','2019-07-04 08:24:10','2019-07-04 12:00:30',2,1,2,2),(4,'Test 4',8,10000,400,500,'2020-08-14','2019-07-04 18:42:36','2019-07-04 11:43:04',2,2,2,2);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diskons`
--

DROP TABLE IF EXISTS `diskons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diskons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diskon` double unsigned NOT NULL,
  `min` int(10) unsigned DEFAULT '0',
  `max` int(10) unsigned DEFAULT '0',
  `tipe` enum('unit','incremental') NOT NULL DEFAULT 'unit',
  `idbarang` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idbarang_diskons` (`idbarang`),
  CONSTRAINT `fk_idbarang_diskons` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diskons`
--

LOCK TABLES `diskons` WRITE;
/*!40000 ALTER TABLE `diskons` DISABLE KEYS */;
INSERT INTO `diskons` VALUES (3,0.05,5,10,'unit',2,'2019-06-25 18:47:31','2019-06-25 12:10:52'),(5,0.03,5,10,'incremental',2,'2019-06-25 19:11:13',NULL),(6,0.1,10,20,'incremental',2,'2019-06-25 19:11:29',NULL),(7,0.15,20,35,'incremental',2,'2019-06-25 19:12:01',NULL),(8,0.08,10,35,'unit',1,'2019-06-25 19:13:14','2019-07-01 09:52:14'),(9,0.05,1,19,'incremental',1,'2019-07-01 17:10:20','2019-07-01 10:55:38'),(10,0.1,20,49,'incremental',1,'2019-07-01 17:11:06','2019-07-01 10:55:47'),(11,0.15,50,100,'incremental',1,'2019-07-01 17:11:26','2019-07-01 10:55:55');
/*!40000 ALTER TABLE `diskons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etalase`
--

DROP TABLE IF EXISTS `etalase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etalase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etalase` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_etalase` (`idusers`),
  CONSTRAINT `fk_idusers_etalase` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etalase`
--

LOCK TABLES `etalase` WRITE;
/*!40000 ALTER TABLE `etalase` DISABLE KEYS */;
INSERT INTO `etalase` VALUES (2,'AAAbbb','2019-05-19 14:49:37','2019-05-19 07:53:33',2);
/*!40000 ALTER TABLE `etalase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_kategori` (`idusers`),
  CONSTRAINT `fk_idusers_kategori` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (2,'aaabbb','2019-05-19 14:20:49','2019-05-19 07:37:09',2);
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembelian`
--

DROP TABLE IF EXISTS `pembelian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembelian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(30) NOT NULL,
  `jumlah_pembelian` int(10) unsigned NOT NULL,
  `harga_barang` int(10) unsigned NOT NULL,
  `biaya_penyimpanan` int(10) unsigned NOT NULL,
  `diskon` double DEFAULT NULL,
  `tanggal_pembelian` date NOT NULL,
  `status` enum('aktif','selesai') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  `idbarang` int(10) unsigned NOT NULL,
  `idsupplier` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_pembelian` (`idusers`),
  KEY `fk_idsupplier_pembelian` (`idbarang`),
  KEY `fk_idsupplier_pembelian_2` (`idsupplier`),
  CONSTRAINT `fk_idbarang_pembelian` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idsupplier_pembelian_2` FOREIGN KEY (`idsupplier`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idusers_pembelian` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembelian`
--

LOCK TABLES `pembelian` WRITE;
/*!40000 ALTER TABLE `pembelian` DISABLE KEYS */;
INSERT INTO `pembelian` VALUES (9,'AAA-111',15,20000,500,0.02,'2019-05-26','selesai','2019-05-26 23:33:33','2019-05-26 16:40:17',2,2,1),(10,'AAA-111',10,15000,1000,0.02,'2019-05-26','aktif','2019-05-26 23:41:16',NULL,2,1,2),(17,'AAA-111',6,18000,500,0.02,'2019-07-04','aktif','2019-07-04 19:00:22',NULL,2,2,1),(18,'AAA-111',7,12000,600,0.02,'2019-07-04','selesai','2019-07-04 19:00:22','2019-07-04 12:00:30',2,3,1);
/*!40000 ALTER TABLE `pembelian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemesanan`
--

DROP TABLE IF EXISTS `pemesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pemesanan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `harga_barang` int(10) unsigned NOT NULL,
  `jumlah_unit` int(10) unsigned NOT NULL,
  `total_cost` int(10) unsigned NOT NULL,
  `total_cost_multiitem` int(10) unsigned DEFAULT '0',
  `reorder_point` int(10) unsigned NOT NULL,
  `frekuensi_pembelian` double unsigned NOT NULL,
  `tipe` enum('singleitem','multiitem') DEFAULT 'singleitem',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  `idbarang` int(10) unsigned NOT NULL,
  `idsupplier` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_pemesanan` (`idusers`),
  KEY `fk_idbarang_pemesanan` (`idbarang`),
  KEY `fk_idsupplier_pemesanan` (`idsupplier`),
  CONSTRAINT `fk_idbarang_pemesanan` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idsupplier_pemesanan` FOREIGN KEY (`idsupplier`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idusers_pemesanan` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemesanan`
--

LOCK TABLES `pemesanan` WRITE;
/*!40000 ALTER TABLE `pemesanan` DISABLE KEYS */;
INSERT INTO `pemesanan` VALUES (25,15000,10,258688,0,1,1.84,'singleitem','2019-07-04 18:12:43',NULL,2,1,2),(26,18000,6,110898,234997,0,1.04,'multiitem','2019-07-04 18:13:29','2019-07-04 11:13:29',2,2,1),(27,12000,7,124099,234997,0,1.46,'multiitem','2019-07-04 18:13:29','2019-07-04 11:13:29',2,3,1),(29,15000,18,262376,371645,1,0.92,'multiitem','2019-07-04 18:43:30','2019-07-05 00:48:14',2,1,2),(30,10000,11,75292,371645,0,0.66,'multiitem','2019-07-04 18:43:30','2019-07-05 00:48:14',2,4,2),(31,15000,49,903256,371645,1,0.35,'multiitem','2019-07-05 07:45:12','2019-07-05 00:48:14',2,1,2),(32,10000,21,1045830,371645,0,0.34,'multiitem','2019-07-05 07:45:13','2019-07-05 00:48:14',2,4,2),(33,15000,50,903256,371645,1,0.35,'multiitem','2019-07-05 07:48:14','2019-07-05 00:48:14',2,1,2),(34,10000,21,1045830,371645,0,0.34,'multiitem','2019-07-05 07:48:14','2019-07-05 00:48:14',2,4,2);
/*!40000 ALTER TABLE `pemesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(30) NOT NULL,
  `jumlah_barang` int(10) unsigned NOT NULL,
  `harga_barang` int(10) unsigned NOT NULL,
  `total_biaya` int(10) unsigned NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  `idbarang` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idbarang_penjualan` (`idbarang`),
  KEY `fk_idusers_penjualan` (`idusers`),
  CONSTRAINT `fk_idbarang_penjualan` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idusers_penjualan` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan`
--

LOCK TABLES `penjualan` WRITE;
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
INSERT INTO `penjualan` VALUES (8,'BBB-222',3,20000,60000,'PCS','2019-05-27','2019-05-27 00:52:49',NULL,2,2),(9,'BBB-222',5,15000,75000,'PCS','2019-05-27','2019-05-27 00:53:05',NULL,2,1),(10,'BBB-222',3,15000,45000,'PCS','2019-05-27','2019-05-27 00:55:43',NULL,2,1),(11,'BBB-222',2,15000,30000,'PCS','2019-05-27','2019-05-27 00:56:19',NULL,2,1),(12,'BBB-222',7,20000,140000,'PCS','2019-05-27','2019-05-27 01:12:22',NULL,2,2),(13,'BBB-222',3,20000,60000,'PCS','2019-05-27','2019-05-27 01:12:57',NULL,2,2),(14,'BBB-222',8,20000,160000,'PCS','2019-05-27','2019-05-27 01:15:12',NULL,2,2),(15,'BBB-222',4,20000,80000,'PCS','2019-05-27','2019-05-27 01:15:20',NULL,2,2),(16,'BBB-222',6,20000,120000,'PCS','2019-05-27','2019-05-27 01:15:37',NULL,2,2),(18,'BBB-222',4,20000,80000,'PCS','2019-05-27','2019-05-27 01:41:06',NULL,2,2),(20,'BBB-222',9,15000,135000,'PCS','2019-05-27','2019-05-27 01:55:06',NULL,2,1),(21,'BBB-222',5,20000,100000,'PCS','2019-05-27','2019-05-27 02:07:28',NULL,2,2),(22,'BBB-222',5,15000,75000,'PCS','2019-05-27','2019-05-27 02:07:41',NULL,2,1),(23,'BBB-222',3,15000,45000,'PCS','2019-06-01','2019-06-01 04:08:13',NULL,2,1),(24,'BBB-222',2,18000,36000,'PCS','2019-07-01','2019-07-01 19:39:58',NULL,2,2),(25,'BBB-222',4,18000,72000,'PCS','2019-07-01','2019-07-01 19:40:08',NULL,2,2),(27,'BBB-222',8,15000,120000,'PCS','2019-07-01','2019-07-01 19:49:53',NULL,2,1),(28,'BBB-222',5,15000,75000,'PCS','2019-07-01','2019-07-01 19:50:06',NULL,2,1),(29,'BBB-222',4,15000,60000,'PCS','2019-07-01','2019-07-01 19:50:16',NULL,2,1),(30,'BBB-222',3,12000,36000,'PCS','2019-07-04','2019-07-04 09:08:13',NULL,2,3),(31,'BBB-222',2,12000,24000,'PCS','2019-07-04','2019-07-04 09:08:24',NULL,2,3),(32,'BBB-222',3,12000,36000,'PCS','2019-07-04','2019-07-04 09:08:34',NULL,2,3),(33,'BBB-222',2,12000,24000,'PCS','2019-07-04','2019-07-04 09:08:51',NULL,2,3),(34,'BBB-222',3,10000,30000,'PCS','2019-07-04','2019-07-04 18:42:49',NULL,2,4),(35,'BBB-222',2,10000,20000,'PCS','2019-07-04','2019-07-04 18:42:56',NULL,2,4),(36,'BBB-222',2,10000,20000,'PCS','2019-07-04','2019-07-04 18:43:04',NULL,2,4);
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `leadtime` int(10) unsigned NOT NULL,
  `waktu_operasional` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_supplier` (`idusers`),
  CONSTRAINT `fk_idusers_supplier` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES (1,'AAA BBB','aaa@gmail.com','111222333444','jl. aaa',2,50,'2019-05-14 03:42:05','2019-06-28 04:35:02',2),(2,'BBB','bbb@gmail.com','222233334444','jl. bbb',2,50,'2019-05-14 04:37:18','2019-06-28 04:34:56',2);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ganjar Hadiatna','ganjarhadiatna.gh@gmail.com',NULL,'$2y$10$1o7CYuAuQM5vCZZ2tRJpUuvr6jHHhf60.yLlgfRevNsvlBwHteKLa','R8b66L3pstgj4Aok99PUFSpJjfzETzREW5kKzJpxAp1juLQHySxamoSpo5Bi','2019-03-08 20:41:37','2019-03-08 20:41:37'),(2,'Ganjar Hadiatna','ganjardbc@gmail.com',NULL,'$2y$10$e4obUbdolHN.NiEGedXKG.UWuuNnbF.mhMSsOeXWchPXYecM8kBVS','9ror0jh12upNqCGRqLEQp4GxbSXurIlMv6KdP5uoYpnvUmnKVLXwC2duwdLe','2019-03-08 20:42:53','2019-03-08 20:42:53');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-05 15:13:11
