-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: db_eoq
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.16.04.2

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,'Test 1',100,15000,1000,1000,'2021-05-23','2019-05-20 16:49:23','2019-05-20 10:06:36',2,2,2,2),(2,'Test 2',150,20000,500,500,'2021-12-24','2019-05-20 17:07:45',NULL,2,1,2,2);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
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
  `biaya_gudang` int(10) unsigned NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembelian`
--

LOCK TABLES `pembelian` WRITE;
/*!40000 ALTER TABLE `pembelian` DISABLE KEYS */;
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
  `jumlah_unit` int(10) unsigned NOT NULL,
  `total_cost` int(10) unsigned NOT NULL,
  `reorder_point` int(10) unsigned NOT NULL,
  `frekuensi_pembelian` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idusers` int(10) unsigned NOT NULL,
  `idbarang` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idusers_pemesanan` (`idusers`),
  KEY `fk_idbarang_pemesanan` (`idbarang`),
  CONSTRAINT `fk_idbarang_pemesanan` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idusers_pemesanan` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemesanan`
--

LOCK TABLES `pemesanan` WRITE;
/*!40000 ALTER TABLE `pemesanan` DISABLE KEYS */;
INSERT INTO `pemesanan` VALUES (1,14,2007000,30,7.14,'2019-05-20 19:00:09',NULL,2,2),(2,14,1514000,20,7.14,'2019-05-20 19:06:47',NULL,2,1),(5,14,2007000,30,7.14,'2019-05-20 19:15:05',NULL,2,2),(6,14,1514000,20,7.14,'2019-05-20 19:16:45',NULL,2,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan`
--

LOCK TABLES `penjualan` WRITE;
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
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
INSERT INTO `supplier` VALUES (1,'AAA BBB','aaa@gmail.com','111222333444','jl. aaa',3,'2019-05-14 03:42:05','2019-05-20 11:32:32',2),(2,'BBB','bbb@gmail.com','222233334444','jl. bbb',2,'2019-05-14 04:37:18','2019-05-20 08:59:23',2);
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
INSERT INTO `users` VALUES (1,'Ganjar Hadiatna','ganjarhadiatna.gh@gmail.com',NULL,'$2y$10$1o7CYuAuQM5vCZZ2tRJpUuvr6jHHhf60.yLlgfRevNsvlBwHteKLa','R8b66L3pstgj4Aok99PUFSpJjfzETzREW5kKzJpxAp1juLQHySxamoSpo5Bi','2019-03-08 20:41:37','2019-03-08 20:41:37'),(2,'Ganjar Hadiatna','ganjardbc@gmail.com',NULL,'$2y$10$e4obUbdolHN.NiEGedXKG.UWuuNnbF.mhMSsOeXWchPXYecM8kBVS','4eJgwvHTtDch4SUnBGibg9oNPqQsOwOU9ATHQdsc6Kb7DYybR2IpIGSxNIVZ','2019-03-08 20:42:53','2019-03-08 20:42:53');
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

-- Dump completed on 2019-05-21 15:54:58
