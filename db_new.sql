-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: db_apotek
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
-- Table structure for table `buying`
--

DROP TABLE IF EXISTS `buying`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buying` (
  `idbuying` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned NOT NULL,
  `price_item` int(10) unsigned NOT NULL,
  `price_manage` int(10) unsigned NOT NULL,
  `status` enum('wait','process','done') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(10) unsigned NOT NULL,
  `iditems` int(10) unsigned NOT NULL,
  `idsuppliers` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idbuying`),
  KEY `fk_id_buying` (`id`),
  KEY `fk_iditems_buying` (`iditems`),
  KEY `fk_idsuppliers_buying` (`idsuppliers`),
  CONSTRAINT `fk_id_buying` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_iditems_buying` FOREIGN KEY (`iditems`) REFERENCES `items` (`iditems`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idsuppliers_buying` FOREIGN KEY (`idsuppliers`) REFERENCES `suppliers` (`idsuppliers`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buying`
--

LOCK TABLES `buying` WRITE;
/*!40000 ALTER TABLE `buying` DISABLE KEYS */;
INSERT INTO `buying` VALUES (2,15,10000,2000,'wait','2019-03-22 15:58:20','2019-03-22 09:18:47',2,1,1);
/*!40000 ALTER TABLE `buying` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `idcategories` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idcategories`),
  KEY `fk_id_categories` (`id`),
  CONSTRAINT `fk_id_categories` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (3,'ahuy','2019-03-20 14:17:19',NULL,2),(8,'mantap','2019-03-20 14:41:30',NULL,2),(9,'coeg','2019-03-20 14:41:39',NULL,2),(10,'buntut maung','2019-03-20 14:41:48',NULL,2);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etalase`
--

DROP TABLE IF EXISTS `etalase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etalase` (
  `idetalase` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etalase` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idetalase`),
  KEY `fk_id_etalase` (`id`),
  CONSTRAINT `fk_id_etalase` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etalase`
--

LOCK TABLES `etalase` WRITE;
/*!40000 ALTER TABLE `etalase` DISABLE KEYS */;
INSERT INTO `etalase` VALUES (2,'Coba Lagi','2019-03-20 14:49:07','2019-03-20 07:53:12',2),(3,'Ahuy mang','2019-03-20 15:56:43',NULL,2);
/*!40000 ALTER TABLE `etalase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `iditems` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `stock` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `discount` double NULL,
  `price_order` int(10) unsigned NOT NULL,
  `price_store` int(10) unsigned NOT NULL,
  `expire_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(10) unsigned NOT NULL,
  `idcategories` int(10) unsigned NOT NULL,
  `idetalase` int(10) unsigned NOT NULL,
  PRIMARY KEY (`iditems`),
  KEY `fk_id_items` (`id`),
  KEY `fk_idcategories_items` (`idcategories`),
  KEY `fk_idetalase_items` (`idetalase`),
  CONSTRAINT `fk_id_items` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idcategories_items` FOREIGN KEY (`idcategories`) REFERENCES `categories` (`idcategories`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_idetalase_items` FOREIGN KEY (`idetalase`) REFERENCES `etalase` (`idetalase`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'naon weh',10,80000,'2020-02-02','2019-03-20 16:05:35','2019-03-22 10:18:59',2,10,3),(2,'aduh',10,50000,'2020-02-02','2019-03-20 16:17:17','2019-03-20 09:17:29',2,10,3);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
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
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `idsuppliers` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idsuppliers`),
  KEY `fk_id_suppliers` (`id`),
  CONSTRAINT `fk_id_suppliers` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'PT. Ahuy','ahuy@gmail.com','08988888888','Jl. naon weh','2019-03-21 14:16:32',NULL,2),(2,'PT Maju','maju@gmail.com','0896555958859','Jl. mana weh','2019-03-22 17:30:32',NULL,2);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `idtransactions` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price_item` int(10) unsigned NOT NULL,
  `price_total` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id` int(10) unsigned NOT NULL,
  `iditems` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idtransactions`),
  KEY `fk_id_transactions` (`id`),
  KEY `fk_iditems_transactions` (`iditems`),
  CONSTRAINT `fk_id_transactions` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_iditems_transactions` FOREIGN KEY (`iditems`) REFERENCES `items` (`iditems`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (2,2,80000,160000,'2019-03-22 17:43:42','2019-03-22 10:46:15',2,1),(3,1,50000,50000,'2019-03-22 17:44:58',NULL,2,2);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
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
INSERT INTO `users` VALUES (1,'Ganjar Hadiatna','ganjarhadiatna.gh@gmail.com',NULL,'$2y$10$1o7CYuAuQM5vCZZ2tRJpUuvr6jHHhf60.yLlgfRevNsvlBwHteKLa','R8b66L3pstgj4Aok99PUFSpJjfzETzREW5kKzJpxAp1juLQHySxamoSpo5Bi','2019-03-09 03:41:37','2019-03-09 03:41:37'),(2,'Ganjar Hadiatna','ganjardbc@gmail.com',NULL,'$2y$10$e4obUbdolHN.NiEGedXKG.UWuuNnbF.mhMSsOeXWchPXYecM8kBVS','doudG5JWgYfrMBMjztTPIThlflWW5Mc9zhWkGFRe7TyRx0y5LPNegrsoTp6V','2019-03-09 03:42:53','2019-03-09 03:42:53');
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

-- Dump completed on 2019-04-01 20:17:43
