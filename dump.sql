-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: restaurant-free-tier-please.ckcnlmnjbyec.us-east-1.rds.amazonaws.com    Database: restaurant
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `points` (
  `phone_number` varchar(10) NOT NULL,
  `points` int NOT NULL,
  PRIMARY KEY (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `points`
--

LOCK TABLES `points` WRITE;
/*!40000 ALTER TABLE `points` DISABLE KEYS */;
/*!40000 ALTER TABLE `points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pref_driner`
--

DROP TABLE IF EXISTS `pref_driner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pref_driner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pref_driner`
--

LOCK TABLES `pref_driner` WRITE;
/*!40000 ALTER TABLE `pref_driner` DISABLE KEYS */;
/*!40000 ALTER TABLE `pref_driner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `r_table`
--

DROP TABLE IF EXISTS `r_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `r_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_seats` int NOT NULL,
  `rest_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `res_id_idx` (`rest_id`),
  CONSTRAINT `res_id` FOREIGN KEY (`rest_id`) REFERENCES `restaurant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `r_table`
--

LOCK TABLES `r_table` WRITE;
/*!40000 ALTER TABLE `r_table` DISABLE KEYS */;
INSERT INTO `r_table` VALUES (3,8,2),(8,4,2),(10,2,2),(12,2,2),(13,4,2),(14,8,2),(15,8,3),(16,8,3),(17,4,3),(18,4,3),(19,2,3),(20,2,3);
/*!40000 ALTER TABLE `r_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `phone_number` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `num_guests` int NOT NULL,
  `user` varchar(16) DEFAULT NULL,
  `rest_id` int NOT NULL,
  `cc_number` varchar(45) DEFAULT NULL,
  `cc_cvv` int DEFAULT NULL,
  `cc_month` int DEFAULT NULL,
  `cc_year` year DEFAULT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `is_cancelled` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `res_rest_id_idx` (`rest_id`),
  KEY `datetime` (`date`,`time`),
  CONSTRAINT `res_rest_id` FOREIGN KEY (`rest_id`) REFERENCES `restaurant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (1,'John Doe','5555555555','johndoe@example.com','2022-11-21','12:00:00',3,NULL,2,NULL,NULL,NULL,NULL,0,1),(2,'test','5555555555','test','2022-11-21','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,0,1),(3,'test','5555555555','test','2022-11-21','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(4,'test','5555555555','test','2022-11-22','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(5,'test','5555555555','test','2022-11-22','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(6,'test','5555555555','test','2022-11-22','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(7,'test','5555555555','test','2022-11-22','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(8,'test','5555555555','test','2022-11-22','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(9,'test','5555555555','test','2022-11-22','12:00:00',1,NULL,2,NULL,NULL,NULL,NULL,1,0),(11,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-11-21','16:30:00',9,NULL,2,NULL,NULL,NULL,NULL,1,0),(12,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-11-21','13:30:00',9,NULL,2,NULL,NULL,NULL,NULL,1,0),(24,'Admin','5555555555','admin@example.com','2022-11-27','13:00:00',4,'admin',2,NULL,NULL,NULL,NULL,1,0),(26,'Admin','5555555555','admin@example.com','2022-11-27','17:00:00',8,NULL,2,NULL,NULL,NULL,NULL,1,0),(27,'Admin','5555555555','admin@example.com','2022-11-27','17:00:00',16,NULL,2,NULL,NULL,NULL,NULL,1,0),(28,'Admin','5555555555','admin@example.com','2022-11-27','18:00:00',3,NULL,2,NULL,NULL,NULL,NULL,1,0),(29,'Admin','5555555555','admin@example.com','2022-11-27','19:00:00',3,NULL,2,NULL,NULL,NULL,NULL,1,0),(30,'Admin','5555555555','admin@example.com','2022-11-28','12:00:00',14,NULL,2,'NULL',0,0,0000,0,1),(31,'Admin','5555555555','admin@example.com','2022-11-28','12:30:00',5,NULL,2,'R91DPiSf1xk8Xsa+6l/bRY902Fu9c9Y+vOk87nB6jw==',0,10,2024,0,1),(32,'Admin','5555555555','admin@example.com','2022-11-27','19:00:00',5,NULL,2,'5WjGooLC+zpg+s7n6Xn3HYo77yu5JTo2FIc6tWnx3g==',456,10,2024,1,0),(33,'Admin','5555555555','admin@example.com','2022-12-30','09:30:00',1,NULL,2,'NULL',0,0,0000,1,0),(34,'Admin','5555555555','admin@example.com','2022-12-30','13:00:00',1,NULL,2,'NULL',0,0,0000,1,0),(36,'Admin','5555555555','admin@example.com','2022-11-30','13:30:00',1,'admin',2,'NULL',0,0,0000,1,0),(42,'Austin Thibodeaux','5555555555','a@a.a','2022-11-30','13:30:00',1,'',2,NULL,0,0,0000,0,1),(43,'Austin Thibodeaux','5555555555','a@a.a','2022-11-30','13:00:00',1,'admin',2,NULL,0,0,0000,0,1),(44,'Zaid Kidwai','8321231231','uniqueemail@mail.com','2022-11-30','19:30:00',2,'',2,NULL,0,0,0000,0,1),(45,'Bill Nye','8321231232','billnye@billy.com','2022-12-01','12:00:00',2,'admin',2,NULL,0,0,0000,1,0),(46,'Bill Nye','8321231232','billnye@billy.com','2022-12-01','12:00:00',2,'admin',2,NULL,0,0,0000,1,0),(47,'Admin','5555555555','admin@admin.test','2022-12-01','09:30:00',2,'admin@admin.test',2,NULL,0,0,0000,1,0),(48,'Admin','5555555555','admin@admin.test','2022-12-01','10:00:00',2,'admin@admin.test',2,NULL,0,0,0000,1,0),(49,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-12-01','09:30:00',1,'admin@admin.test',2,NULL,0,0,0000,1,0),(50,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-12-01','06:30:00',1,'',2,NULL,0,0,0000,0,1),(51,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-12-01','06:30:00',1,'',2,NULL,0,0,0000,0,1),(52,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-12-01','06:00:00',1,'',2,NULL,0,0,0000,0,1),(53,'Austin Thibodeaux','2818189473','austhib@protonmail.com','2022-12-01','09:00:00',1,'ad6min@admin.tes',2,NULL,0,0,0000,0,1),(54,'Austin Thibodeaux','5555555555','austin@gmailk.com','2022-12-01','11:30:00',7,'',2,NULL,0,0,0000,1,0),(55,'ngfnxfg','5555555555','sfhgfd@g.com','2022-12-01','12:00:00',5,'ghuieogh@gmcil.c',2,'uUJWc9Daxf5YF7FQY6ge/fVN55sav13aqVUuNJulGKy4p',654,11,2024,0,1),(56,'Austin Daniel Thibodeaux','2818189473','gdfg@gdfg.com','2022-12-01','15:00:00',5,'',2,NULL,0,0,0000,0,0),(57,'Austin Thibodeaux','5555555555','adthibod@cougarnet.uh.edu','2022-12-31','06:30:00',6,'adthibod@cougarn',2,'gPACS9x/11nGETXhrFzmVRdmT89fkFpRhc+ifiT0u4Svy',456,11,2024,0,1),(58,'Austin Thibodeaux','5555555555','adthibod@cougarnet.uh.edu','2022-12-01','15:00:00',8,'adthibod@cougarn',2,NULL,0,0,0000,0,1);
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserved_table`
--

DROP TABLE IF EXISTS `reserved_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserved_table` (
  `resv_id` int NOT NULL,
  `table_id` int NOT NULL,
  PRIMARY KEY (`resv_id`,`table_id`),
  KEY `rt_table_id_idx` (`table_id`),
  CONSTRAINT `rt_resv_id` FOREIGN KEY (`resv_id`) REFERENCES `reservation` (`id`),
  CONSTRAINT `rt_table_id` FOREIGN KEY (`table_id`) REFERENCES `r_table` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserved_table`
--

LOCK TABLES `reserved_table` WRITE;
/*!40000 ALTER TABLE `reserved_table` DISABLE KEYS */;
INSERT INTO `reserved_table` VALUES (7,3),(11,3),(12,3),(26,3),(30,3),(32,3),(54,3),(56,3),(57,3),(1,8),(4,8),(5,8),(6,8),(7,8),(8,8),(9,8),(24,8),(27,8),(29,8),(31,8),(1,10),(11,10),(28,10),(31,10),(33,10),(34,10),(36,10),(43,10),(44,10),(45,10),(47,10),(50,10),(52,10),(53,10),(12,12),(28,12),(42,12),(46,12),(48,12),(49,12),(51,12),(27,13),(27,14),(30,14),(55,14),(58,14);
/*!40000 ALTER TABLE `reserved_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `street_address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `state` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant`
--

LOCK TABLES `restaurant` WRITE;
/*!40000 ALTER TABLE `restaurant` DISABLE KEYS */;
INSERT INTO `restaurant` VALUES (2,'3402 Scott St,','Houston','TX'),(3,'6007 Farm to Market 2920','Spring','TX'),(4,'18602 Kuykendahl Rd Ste 200,','Spring','TX');
/*!40000 ALTER TABLE `restaurant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_days`
--

DROP TABLE IF EXISTS `special_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `special_days` (
  `month` int NOT NULL,
  `day` int NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`month`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_days`
--

LOCK TABLES `special_days` WRITE;
/*!40000 ALTER TABLE `special_days` DISABLE KEYS */;
INSERT INTO `special_days` VALUES (12,31,'New Years');
/*!40000 ALTER TABLE `special_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('CUSTOMER','STAFF','ADMIN') NOT NULL,
  `name` varchar(45) NOT NULL,
  `mail_addr` varchar(45) NOT NULL,
  `billing_addr` varchar(45) DEFAULT NULL,
  `points` int NOT NULL DEFAULT '0',
  `pref_pay_method` enum('CASH','CHECK','CARD') NOT NULL,
  `employed_at_rest` int DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `employed_at_rest_idx` (`employed_at_rest`),
  CONSTRAINT `employed_at_rest` FOREIGN KEY (`employed_at_rest`) REFERENCES `restaurant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('','','$2y$10$UZQZk5rA8oBNg7gU.rgJ8O/QU6EcfSUw3c7EwWN1kc2IvHi7oLT6a','2022-12-01 05:54:05','CUSTOMER','','','',0,'CARD',NULL),('admin@admin.test','admin@admin.test','$2y$10$wiCK3nLKxAraY4ED7asRe.4zqpOhOxk7z7rFryvx3FA9xLNK6OIua','2022-12-01 03:56:43','ADMIN','Admin','goiejg;','goiejg;',27,'CARD',2),('admin@admin.test2','admin@admin.test2','$2y$10$auuXgCQbui.M4KUPPJay7O2gn/BOg2FiX39FCq16FsvJfj2m/XTza','2022-12-01 05:21:47','CUSTOMER','Admin 2','gjsnl','gjsnl',0,'CARD',NULL),('admin@admin.test3','admin@admin.test3','$2y$10$/cWlvlBNNvagC3W5BP8SiuBWZ5gk5EmCaghKz.wOJO6zTS9CqXtzi','2022-12-01 05:51:51','CUSTOMER','Admin 3','gdjflkg','gdjflkg',0,'CARD',NULL),('admin@admin.test4','admin@admin.test4','$2y$10$kqXllDIwxbFeDVQ.n7U4uerWa.dRaj8bvJNjAlxdesBYMoj48M5um','2022-12-01 05:53:16','CUSTOMER','Admin 4','gfdgdfgd','gfdgdfgd',0,'CARD',NULL),('adthibod@cougarnet.uh.edu','adthibod@cougarnet.uh.edu','$2y$10$u5ITMe7FvpsoyyET3A02JOZw/ttwos6cObPHN0.48ivlxzFG0uZLm','2022-12-01 04:07:38','CUSTOMER','Austin Thibodeaux','gjioepjge','gjioepjge',12,'CARD',NULL),('austhib@protonma','austhib@protonmail.com','$2y$10$8TEYJtut8RTbne0bEqvmOupea.HSlgvdvqc.gqMLetvh7f8oax2.m','2022-11-10 06:53:53','CUSTOMER','Austin Thibodeaux','5555 Example Street','5555 Example Street',0,'CARD',NULL),('ded@gmail.com','ded@gmail.com','$2y$10$5Kf3OGlzwMSL9kpJMEH0UuB9mN.KH4NqEGOortFqjSKufUASK8fTG','2022-12-01 15:58:55','CUSTOMER','Walt Disney','1482 E Buena Vista Dr, Lake Buena Vista, FL 3','1482 E Buena Vista Dr, Lake Buena Vista, FL 3',0,'CASH',NULL),('downsyndromer@gmail.com','downsyndromer@gmail.com','$2y$10$ZqdL.AkEGIXU8uqP7gtEoeR8M/HD4yhulJ13nySlQ1c9ZW2Tqtg0W','2022-12-01 15:55:41','CUSTOMER','Filthy Frank','1234 Upyours Rd.','1234 Upyours Rd.',0,'CARD',NULL),('ghuieogh@gmcil.com','ghuieogh@gmcil.com','$2y$10$fpqSkV4fwjkdv1JmR6JH5e2Oz8s5GlY9ucZSbA89dPEE0debltDt6','2022-12-01 16:03:33','CUSTOMER','Joe','4444 street','4444 street',0,'CARD',NULL),('lowry.brain@com','lowry.brain@com','$2y$10$AwCjVycND8vZdenqKhQQ8ulTQUIGkjkqR56FhFZncpfJC4aEyVH0m','2022-12-01 20:16:14','CUSTOMER','Brian Lowry','1482 E Buena Vista Dr, Lake Buena Vista, FL 3','1482 E Buena Vista Dr, Lake Buena Vista, FL 3',0,'CARD',NULL),('Mickey_Mouse','Disney@god.org','$2y$10$akT.X/d3q/ZF/WhZRVsO5uB4DJR6gFojM4nz/JrEbVYVSaRZZchq2','2022-12-01 03:23:28','STAFF','Walt Disney','1482 E Buena Vista Dr, Lake Buena Vista, FL 3','',0,'CASH',3),('North_Korea','Rocketman@gmail.com','$2y$10$sn6xGSRfsJXLF.pP5AswVuwFBML8gfI7FmWM9YObtvsmW0G07SIoa','2022-12-01 03:31:35','STAFF','Kim jong-un','73 Gunnersbury Avenue, London W5 4LP',NULL,0,'CASH',2),('Sleepy_Joe','joe.biden@gmail.com','$2y$10$b2SN5v.lL.g/vjonZkk6pOQCVnSRrVjViZ.1yHK1.qFl0kWvgxen2','2022-12-01 20:02:29','STAFF','Joe Biden','1600 Pennsylvania Ave NW, Washington, DC 2000',NULL,0,'CASH',3),('SpaceX_tesla','wlon.musk@tesla.com','$2y$10$Tq7iNBsfSBNpiwz4/3O8Du3/57pg3/lzY.c2NdaerN2Ppf7b9Rfp6','2022-12-01 20:04:52','STAFF','Elon Musk','1355 Market St. #900, San Francisco, CA 94103',NULL,0,'CASH',2),('tonald_Drump','buildthegreatwall@gmail.com','$2y$10$ZHYOD4PAsA2K4eoA9zpZ7O6rNTfZNI0hyVLBrsigDmZhWeRFGELEq','2022-12-01 03:27:06','STAFF','Donald Trump','725 5th Ave, New York, NY 10022',NULL,0,'CASH',2),('Zaid_Kidwai','zkidwai@cougarnet.uh.edu','$2y$10$/q1iU2tYtU2PLzLbx1piROGMv5FDVuwqIzqILTjuBRaOonbViL81q','2022-12-01 20:24:04','STAFF','Zaid Kidwai','18302 Spring Oak Blvd',NULL,0,'CASH',4);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-01 20:10:55
