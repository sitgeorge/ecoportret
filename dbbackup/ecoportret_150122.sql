CREATE DATABASE  IF NOT EXISTS `ecoportret` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ecoportret`;
-- MySQL dump 10.13  Distrib 5.6.19, for linux-glibc2.5 (x86_64)
--
-- Host: 127.0.0.1    Database: ecoportret
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `costtype`
--

DROP TABLE IF EXISTS `costtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `costtype` (
  `costtypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `costtypename` varchar(250) NOT NULL,
  `costtypeshortname` varchar(3) NOT NULL,
  PRIMARY KEY (`costtypeid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `costtype`
--

LOCK TABLES `costtype` WRITE;
/*!40000 ALTER TABLE `costtype` DISABLE KEYS */;
INSERT INTO `costtype` VALUES (1,'Материалы','МАТ'),(2,'Полуфабрикаты','П/Ф'),(3,'Покупные комплектующие изделия','ПКИ');
/*!40000 ALTER TABLE `costtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail`
--

DROP TABLE IF EXISTS `detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail` (
  `detailid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fileid` int(10) unsigned NOT NULL,
  `detailname` varchar(2000) DEFAULT NULL,
  `detailtypeid` int(10) unsigned DEFAULT NULL,
  `detaildescription` varchar(255) DEFAULT NULL,
  `detailgost` varchar(255) DEFAULT NULL COMMENT 'GOST',
  `amount` mediumtext,
  `amountmaterial` float DEFAULT NULL,
  `amountmaterialtotal` float DEFAULT NULL,
  `docalc` bit(1) NOT NULL DEFAULT b'0',
  `detailpriceid` int(10) unsigned DEFAULT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `sortorder` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` varchar(50) NOT NULL COMMENT 'host name',
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL COMMENT 'host name',
  PRIMARY KEY (`detailid`),
  KEY `fk_detail_file1_idx` (`fileid`),
  KEY `fk_detail_detailtype1_idx` (`detailtypeid`),
  KEY `fk_detail_detailprice_idx` (`detailpriceid`),
  CONSTRAINT `fk_detail_detailprice` FOREIGN KEY (`detailpriceid`) REFERENCES `detailprice` (`detailpriceid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detail_detailtype` FOREIGN KEY (`detailtypeid`) REFERENCES `detailtype` (`detailtypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detail_file1` FOREIGN KEY (`fileid`) REFERENCES `file` (`fileid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail`
--

LOCK TABLES `detail` WRITE;
/*!40000 ALTER TABLE `detail` DISABLE KEYS */;
INSERT INTO `detail` VALUES (3,790,'detail 1',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:09:47','gbsnix',NULL,NULL),(5,790,'detail 2',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:14:28','gbsnix',NULL,NULL),(6,790,'detail 3',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:14:28','gbsnix',NULL,NULL),(8,790,'detail 2_1',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:15:18','gbsnix',NULL,NULL),(9,790,'detail 3_1',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:15:18','gbsnix',NULL,NULL),(11,790,'detail 2_1_1',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(12,790,'detail 3_1_1',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',1,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(14,790,'detail 2_1_2',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',2,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(15,790,'detail 3_1_2',1,'detail_description','detail_gost','1',0.1,NULL,'\0',1,'detail_comment',2,'2014-12-15 20:16:08','gbsnix',NULL,NULL);
/*!40000 ALTER TABLE `detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detailprice`
--

DROP TABLE IF EXISTS `detailprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detailprice` (
  `detailpriceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `detailtypeid` int(10) unsigned NOT NULL,
  `shippername` varchar(500) NOT NULL,
  `detailpricecause` varchar(250) NOT NULL,
  `pricevalue` float NOT NULL,
  `valuedate` datetime NOT NULL,
  PRIMARY KEY (`detailpriceid`),
  KEY `fk_detailprice_1_idx` (`detailtypeid`),
  CONSTRAINT `fk_detailprice_detailtype` FOREIGN KEY (`detailtypeid`) REFERENCES `detailtype` (`detailtypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detailprice`
--

LOCK TABLES `detailprice` WRITE;
/*!40000 ALTER TABLE `detailprice` DISABLE KEYS */;
INSERT INTO `detailprice` VALUES (1,1,'Поставщик 1','Накладная 1',15.3,'2013-10-15 00:00:00');
/*!40000 ALTER TABLE `detailprice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detailtreepath`
--

DROP TABLE IF EXISTS `detailtreepath`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detailtreepath` (
  `detailtreepathid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ancestorid` int(10) unsigned NOT NULL,
  `descendantid` int(10) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` varchar(50) NOT NULL COMMENT 'host name',
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL COMMENT 'host name',
  PRIMARY KEY (`detailtreepathid`),
  KEY `fk_detailtreepath_detail1_idx` (`ancestorid`),
  KEY `fk_detailtreepath_detail2_idx` (`descendantid`),
  CONSTRAINT `fk_detailtreepath_detail1` FOREIGN KEY (`ancestorid`) REFERENCES `detail` (`detailid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detailtreepath_detail2` FOREIGN KEY (`descendantid`) REFERENCES `detail` (`detailid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detailtreepath`
--

LOCK TABLES `detailtreepath` WRITE;
/*!40000 ALTER TABLE `detailtreepath` DISABLE KEYS */;
INSERT INTO `detailtreepath` VALUES (2,5,5,0,'2014-12-15 20:14:28','gbsnix',NULL,NULL),(3,6,6,0,'2014-12-15 20:14:28','gbsnix',NULL,NULL),(7,5,8,1,'2014-12-15 20:15:18','gbsnix',NULL,NULL),(8,8,8,0,'2014-12-15 20:15:18','gbsnix',NULL,NULL),(10,6,9,1,'2014-12-15 20:15:18','gbsnix',NULL,NULL),(11,9,9,0,'2014-12-15 20:15:18','gbsnix',NULL,NULL),(16,5,11,2,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(17,8,11,1,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(18,11,11,0,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(19,6,12,2,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(20,9,12,1,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(21,12,12,0,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(25,5,14,2,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(26,8,14,1,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(27,14,14,0,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(28,6,15,2,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(29,9,15,1,'2014-12-15 20:16:08','gbsnix',NULL,NULL),(30,15,15,0,'2014-12-15 20:16:08','gbsnix',NULL,NULL);
/*!40000 ALTER TABLE `detailtreepath` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detailtype`
--

DROP TABLE IF EXISTS `detailtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detailtype` (
  `detailtypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `detailtypename` varchar(2000) NOT NULL,
  `measurementunitid` int(10) unsigned NOT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `inactive` bit(1) NOT NULL DEFAULT b'0',
  `costtypeid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`detailtypeid`),
  KEY `fk_detailtype_measurementunit_idx` (`measurementunitid`),
  KEY `fk_detailtype_costtypeid_idx` (`costtypeid`),
  CONSTRAINT `fk_detailtype_costtype` FOREIGN KEY (`costtypeid`) REFERENCES `costtype` (`costtypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detailtype_measurementunit` FOREIGN KEY (`measurementunitid`) REFERENCES `measurementunit` (`measurementunitid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detailtype`
--

LOCK TABLES `detailtype` WRITE;
/*!40000 ALTER TABLE `detailtype` DISABLE KEYS */;
INSERT INTO `detailtype` VALUES (1,'Винт 2М6х10.58.0112 ГОСТ 1491-80',2,'','\0',3),(2,'Ткань полульняная парусина',7,'','\0',1),(3,'Круг В8 (Катанка)',3,'','\0',1),(4,'Эмаль',3,'','\0',2),(5,'Шплинт 2х20.001 ГОСТ 397-79',6,'','\0',1),(6,'Винт 2М6х10.58.019 ГОСТ 17475-80',6,'','\0',1),(7,'ваыа',2,'','\0',1),(8,'erwr',1,'rewrwer','\0',2),(9,'fgdfg',1,'dfgdg','\0',3);
/*!40000 ALTER TABLE `detailtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `fileid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `filetypeid` int(10) unsigned DEFAULT NULL,
  `isfolder` bit(1) NOT NULL DEFAULT b'0',
  `sortorder` int(10) unsigned NOT NULL DEFAULT '0',
  `isprotected` bit(1) NOT NULL DEFAULT b'0',
  `comment` varchar(1000) DEFAULT NULL,
  `rank` varchar(2000) DEFAULT NULL,
  `filestoragedescriptor` varchar(2000) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` varchar(50) NOT NULL COMMENT 'host name',
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL COMMENT 'host name',
  PRIMARY KEY (`fileid`),
  KEY `fk_file_filetypeid_idx` (`filetypeid`),
  CONSTRAINT `fk_file_filetypeid` FOREIGN KEY (`filetypeid`) REFERENCES `filetype` (`filetypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=797 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (379,'folder 1 ',NULL,'',1,'\0','folder 1 vvv',NULL,NULL,'2014-12-08 18:12:51','gbsnix','2014-12-25 22:21:52','localhost'),(380,'folder 2',NULL,'',1,'\0','folder 2',NULL,NULL,'2014-12-08 18:12:51','gbsnix',NULL,NULL),(381,'folder 3',NULL,'',1,'\0','folder 3',NULL,NULL,'2014-12-08 18:12:51','gbsnix',NULL,NULL),(382,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-08 18:13:14','gbsnix',NULL,NULL),(384,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(386,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(388,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 18:14:01','gbsnix',NULL,NULL),(389,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-08 18:17:52','gbsnix',NULL,NULL),(390,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-08 18:17:52','gbsnix',NULL,NULL),(391,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-08 18:17:52','gbsnix',NULL,NULL),(411,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 20:56:54','gbsnix','2014-12-09 17:20:10','176.9.43.104'),(444,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(445,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(446,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(447,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(461,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-09 15:36:09','gbsnix',NULL,NULL),(471,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-09 16:23:04','176.9.43.104',NULL,NULL),(472,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-09 16:23:08','176.9.43.104',NULL,NULL),(490,'rrr',NULL,'',1,'\0','yygyug',NULL,NULL,'2014-12-09 17:19:41','176.9.43.104',NULL,NULL),(518,'folder 1-1-2_copy(1)',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-09 20:28:45','176.9.43.104',NULL,NULL),(519,'gggg',NULL,'',1,'\0','gggg',NULL,NULL,'2014-12-09 20:32:21','176.9.43.104',NULL,NULL),(602,'pkg_kunena_v3.0.6_2014-07-28.zip',1,'\0',1,'\0',NULL,NULL,NULL,'2014-12-10 13:07:51','OWNEROR-DUT53ON',NULL,NULL),(603,'pkg_kunena_v3.0.6_2014-07-28.zip',1,'\0',1,'\0',NULL,NULL,NULL,'2014-12-10 13:14:00','OWNEROR-DUT53ON',NULL,NULL),(618,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(619,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(620,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(621,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(622,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(623,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(624,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(625,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 17:55:19','176.9.43.104',NULL,NULL),(626,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 17:55:20','176.9.43.104',NULL,NULL),(627,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:55:20','176.9.43.104',NULL,NULL),(628,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:55:20','176.9.43.104',NULL,NULL),(629,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(630,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(631,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(632,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(633,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(634,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(635,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(636,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(637,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(638,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:55:25','176.9.43.104',NULL,NULL),(639,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:55:26','176.9.43.104',NULL,NULL),(640,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(641,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(642,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(643,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(644,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(645,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(646,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(647,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(648,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(649,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(650,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:55:44','gbsnix',NULL,NULL),(651,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(652,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(653,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(654,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(655,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(656,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(657,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(658,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(659,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(660,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:57:13','gbsnix',NULL,NULL),(661,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:57:14','gbsnix',NULL,NULL),(662,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 17:58:04','gbsnix',NULL,NULL),(663,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 17:58:04','gbsnix',NULL,NULL),(664,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:58:04','gbsnix',NULL,NULL),(665,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:58:04','gbsnix',NULL,NULL),(666,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 17:58:04','gbsnix',NULL,NULL),(667,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 17:58:05','gbsnix',NULL,NULL),(668,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 17:58:05','gbsnix',NULL,NULL),(669,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 17:58:05','gbsnix',NULL,NULL),(670,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 17:58:05','gbsnix',NULL,NULL),(671,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:58:05','gbsnix',NULL,NULL),(672,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 17:58:05','gbsnix',NULL,NULL),(673,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(674,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(675,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(676,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(677,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(678,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(679,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(680,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(681,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 18:06:04','gbsnix',NULL,NULL),(682,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 18:06:05','gbsnix',NULL,NULL),(683,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 18:06:05','gbsnix',NULL,NULL),(684,'folder 1_copy(1)',NULL,'',1,'\0','folder 1',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(685,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(686,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(687,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(688,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(689,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(690,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(691,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(692,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 18:06:44','gbsnix',NULL,NULL),(693,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 18:06:45','gbsnix',NULL,NULL),(694,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 18:06:45','gbsnix',NULL,NULL),(735,'folder 1-1_copy(1)',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 18:36:17','176.9.43.104',NULL,NULL),(736,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:36:17','176.9.43.104',NULL,NULL),(737,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:36:17','176.9.43.104',NULL,NULL),(738,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 18:36:17','176.9.43.104',NULL,NULL),(739,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 18:36:17','176.9.43.104',NULL,NULL),(740,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 18:36:17','176.9.43.104',NULL,NULL),(741,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(742,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(743,'folder 1_copy(1)',NULL,'',1,'\0','folder 124324234sfsdf234324',NULL,NULL,'2014-12-10 19:09:52','gbsnix','2014-12-25 20:03:05','localhost'),(744,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 19:09:52','gbsnix',NULL,NULL),(745,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 19:09:52','gbsnix',NULL,NULL),(746,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 19:09:52','gbsnix',NULL,NULL),(747,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 19:09:52','gbsnix',NULL,NULL),(748,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 19:09:52','gbsnix',NULL,NULL),(749,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 19:09:52','gbsnix',NULL,NULL),(750,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(751,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(752,'ttt',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(753,'ttt_copy(1)',NULL,'',2,'\0','lkj',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(754,'folder 1-1_copy(1)',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(755,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(756,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(757,'folder 2-2-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(758,'document',2,'\0',1,'\0','Document MS Word',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(759,'sheet',3,'\0',2,'\0','Document MS Excel',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(760,'details',1,'\0',3,'\0','Details',NULL,NULL,'2014-12-10 19:09:53','gbsnix',NULL,NULL),(761,'details',1,'\0',4,'\0','Details',NULL,NULL,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(772,'folder 3',NULL,'',1,'\0','folder 3',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(773,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(774,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(775,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(776,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(777,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(778,'rrr',NULL,'',1,'\0','yygyug',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(779,'folder 1-1-2_copy(1)',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:20:21','gbsnix',NULL,NULL),(780,'gggg',NULL,'',1,'\0','gggg',NULL,NULL,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(781,'folder 3_copy(1)',NULL,'',1,'\0','folder 3',NULL,NULL,'2014-12-15 17:37:10','176.9.43.104',NULL,NULL),(782,'folder 1-1',NULL,'',1,'\0','folder 1-1',NULL,NULL,'2014-12-15 17:37:10','176.9.43.104',NULL,NULL),(783,'folder 1-1-1',NULL,'',1,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:37:10','176.9.43.104',NULL,NULL),(784,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(785,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(786,'folder 1-1-2',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(787,'rrr',NULL,'',1,'\0','yygyug',NULL,NULL,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(788,'folder 1-1-2_copy(1)',NULL,'',2,'\0','folder 1_2_2',NULL,NULL,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(789,'gggg',NULL,'',1,'\0','gggg',NULL,NULL,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(790,'test',1,'\0',1,'','lala',NULL,NULL,'2014-12-15 19:21:21','176.9.43.104',NULL,NULL),(791,'folder 4',NULL,'',1,'\0','comment for folder 4',NULL,NULL,'2014-12-25 00:06:03','localhost',NULL,NULL),(792,'ggg.jpg_copy(1)',4,'\0',1,'\0','',NULL,NULL,'2014-12-25 00:32:56','localhost',NULL,NULL),(793,'ggg.jpg_copy(2)',4,'\0',1,'\0','',NULL,NULL,'2014-12-25 20:05:19','localhost',NULL,NULL),(794,'pkg_kunena_v3.0.6_2014-07-28.zip',1,'\0',1,'\0',NULL,NULL,NULL,'2014-12-25 20:07:16','localhost',NULL,NULL),(796,'pkg_kunena_v3.0.6_2014-07-28.zip_copy(1)',1,'\0',1,'\0',NULL,NULL,NULL,'2014-12-25 20:48:11','localhost',NULL,NULL);
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filetreepath`
--

DROP TABLE IF EXISTS `filetreepath`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filetreepath` (
  `filetreepathid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ancestorid` int(10) unsigned NOT NULL,
  `descendantid` int(10) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` varchar(50) NOT NULL COMMENT 'host name',
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL COMMENT 'host name',
  PRIMARY KEY (`filetreepathid`),
  KEY `fk_filetreepath_file1_idx` (`ancestorid`),
  KEY `fk_filetreepath_file2_idx` (`descendantid`),
  CONSTRAINT `fk_filetreepath_file1` FOREIGN KEY (`ancestorid`) REFERENCES `file` (`fileid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_filetreepath_file2` FOREIGN KEY (`descendantid`) REFERENCES `file` (`fileid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3420 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filetreepath`
--

LOCK TABLES `filetreepath` WRITE;
/*!40000 ALTER TABLE `filetreepath` DISABLE KEYS */;
INSERT INTO `filetreepath` VALUES (2126,379,379,0,'2014-12-08 18:12:51','gbsnix',NULL,NULL),(2127,380,380,0,'2014-12-08 18:12:51','gbsnix',NULL,NULL),(2128,381,381,0,'2014-12-08 18:12:52','gbsnix',NULL,NULL),(2129,379,382,1,'2014-12-08 18:13:14','gbsnix',NULL,NULL),(2130,382,382,0,'2014-12-08 18:13:14','gbsnix',NULL,NULL),(2135,379,384,2,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(2136,382,384,1,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(2137,384,384,0,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(2141,379,386,2,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(2142,382,386,1,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(2143,386,386,0,'2014-12-08 18:13:47','gbsnix',NULL,NULL),(2150,388,388,0,'2014-12-08 18:14:01','gbsnix',NULL,NULL),(2157,388,389,1,'2014-12-08 18:17:52','gbsnix',NULL,NULL),(2164,388,390,1,'2014-12-08 18:17:52','gbsnix',NULL,NULL),(2171,388,391,1,'2014-12-08 18:17:52','gbsnix',NULL,NULL),(2229,411,411,0,'2014-12-08 20:56:54','gbsnix',NULL,NULL),(2353,381,444,1,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2354,381,445,2,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2355,381,446,2,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2356,381,447,3,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2357,444,444,0,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2358,444,445,1,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2359,444,446,1,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2360,444,447,2,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2361,445,445,0,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2362,445,447,1,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2363,446,446,0,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2364,447,447,0,'2014-12-08 21:13:42','gbsnix',NULL,NULL),(2383,379,388,3,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2384,379,389,4,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2385,379,390,4,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2386,379,391,4,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2387,382,388,2,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2388,382,389,3,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2389,382,390,3,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2390,382,391,3,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2391,384,388,1,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2392,384,389,2,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2393,384,390,2,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2394,384,391,2,'2014-12-09 13:59:51','gbsnix',NULL,NULL),(2398,381,411,1,'2014-12-09 14:07:04','gbsnix',NULL,NULL),(2436,388,461,1,'2014-12-09 15:36:09','gbsnix',NULL,NULL),(2437,379,461,4,'2014-12-09 15:36:09','gbsnix',NULL,NULL),(2438,382,461,3,'2014-12-09 15:36:09','gbsnix',NULL,NULL),(2439,384,461,2,'2014-12-09 15:36:09','gbsnix',NULL,NULL),(2440,461,461,0,'2014-12-09 15:36:09','gbsnix',NULL,NULL),(2452,379,471,1,'2014-12-09 16:23:04','176.9.43.104',NULL,NULL),(2453,471,471,0,'2014-12-09 16:23:04','176.9.43.104',NULL,NULL),(2455,379,472,1,'2014-12-09 16:23:09','176.9.43.104',NULL,NULL),(2456,472,472,0,'2014-12-09 16:23:09','176.9.43.104',NULL,NULL),(2475,381,490,1,'2014-12-09 17:19:41','176.9.43.104',NULL,NULL),(2476,490,490,0,'2014-12-09 17:19:41','176.9.43.104',NULL,NULL),(2579,381,518,1,'2014-12-09 20:28:45','176.9.43.104',NULL,NULL),(2580,518,518,0,'2014-12-09 20:28:45','176.9.43.104',NULL,NULL),(2584,519,519,0,'2014-12-09 20:32:21','176.9.43.104',NULL,NULL),(2585,381,519,2,'2014-12-09 20:32:33','176.9.43.104',NULL,NULL),(2586,444,519,1,'2014-12-09 20:32:33','176.9.43.104',NULL,NULL),(2807,602,602,0,'2014-12-10 13:07:51','OWNEROR-DUT53ON',NULL,NULL),(2808,603,603,0,'2014-12-10 13:14:00','OWNEROR-DUT53ON',NULL,NULL),(3219,379,735,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3220,735,735,0,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3221,735,736,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3222,735,737,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3223,735,738,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3224,735,739,3,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3225,735,740,3,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3226,735,741,3,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3227,735,742,3,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3228,379,736,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3229,736,736,0,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3230,736,738,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3231,736,739,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3232,736,740,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3233,736,741,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3234,736,742,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3235,379,737,2,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3236,737,737,0,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3237,379,738,3,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3238,738,738,0,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3239,738,739,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3240,738,740,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3241,738,741,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3242,738,742,1,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3243,379,739,4,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3244,379,740,4,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3245,379,741,4,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3246,379,742,4,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3247,742,742,0,'2014-12-10 18:36:18','176.9.43.104',NULL,NULL),(3250,743,743,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3251,743,744,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3252,743,745,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3253,743,746,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3254,743,747,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3255,743,748,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3256,743,749,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3257,743,750,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3258,743,751,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3259,743,752,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3260,743,753,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3261,743,754,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3262,743,755,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3263,743,756,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3264,743,757,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3265,743,758,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3266,743,759,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3267,743,760,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3268,743,761,4,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3269,744,744,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3270,744,745,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3271,744,746,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3272,744,747,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3273,744,748,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3274,744,749,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3275,744,750,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3276,744,751,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3277,745,745,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3278,745,747,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3279,745,748,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3280,745,749,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3281,745,750,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3282,745,751,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3283,746,746,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3284,747,747,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3285,747,748,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3286,747,749,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3287,747,750,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3288,747,751,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3289,751,751,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3290,752,752,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3291,753,753,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3292,754,754,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3293,754,755,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3294,754,756,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3295,754,757,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3296,754,758,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3297,754,759,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3298,754,760,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3299,754,761,3,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3300,755,755,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3301,755,757,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3302,755,758,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3303,755,759,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3304,755,760,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3305,755,761,2,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3306,756,756,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3307,757,757,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3308,757,758,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3309,757,759,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3310,757,760,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3311,757,761,1,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3312,761,761,0,'2014-12-10 19:09:54','gbsnix',NULL,NULL),(3345,380,772,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3346,772,772,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3347,772,773,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3348,772,774,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3349,772,775,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3350,772,776,3,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3351,772,777,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3352,772,778,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3353,772,779,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3354,772,780,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3355,380,773,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3356,773,773,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3357,773,774,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3358,773,775,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3359,773,776,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3360,773,780,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3361,380,774,3,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3362,774,774,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3363,774,776,1,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3364,380,775,3,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3365,775,775,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3366,380,776,4,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3367,776,776,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3368,380,777,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3369,777,777,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3370,380,778,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3371,778,778,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3372,380,779,2,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3373,779,779,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3374,380,780,3,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3375,780,780,0,'2014-12-15 17:20:22','gbsnix',NULL,NULL),(3376,380,781,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3377,781,781,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3378,781,782,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3379,781,783,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3380,781,784,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3381,781,785,3,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3382,781,786,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3383,781,787,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3384,781,788,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3385,781,789,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3386,380,782,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3387,782,782,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3388,782,783,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3389,782,784,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3390,782,785,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3391,782,789,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3392,380,783,3,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3393,783,783,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3394,783,785,1,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3395,380,784,3,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3396,784,784,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3397,380,785,4,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3398,785,785,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3399,380,786,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3400,786,786,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3401,380,787,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3402,787,787,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3403,380,788,2,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3404,788,788,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3405,380,789,3,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3406,789,789,0,'2014-12-15 17:37:11','176.9.43.104',NULL,NULL),(3407,790,790,0,'2014-12-15 19:21:21','176.9.43.104',NULL,NULL),(3408,791,791,0,'2014-12-25 00:06:03','localhost',NULL,NULL),(3409,792,792,0,'2014-12-25 00:32:56','localhost',NULL,NULL),(3410,793,793,0,'2014-12-25 20:05:19','localhost',NULL,NULL),(3413,791,794,1,'2014-12-25 20:07:16','localhost',NULL,NULL),(3414,794,794,0,'2014-12-25 20:07:16','localhost',NULL,NULL),(3419,796,796,0,'2014-12-25 20:48:11','localhost',NULL,NULL);
/*!40000 ALTER TABLE `filetreepath` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filetype`
--

DROP TABLE IF EXISTS `filetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filetype` (
  `filetypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filetypename` varchar(50) NOT NULL,
  `isinternal` bit(1) NOT NULL DEFAULT b'0',
  `allowedit` bit(1) NOT NULL DEFAULT b'0',
  `allowdelete` bit(1) NOT NULL DEFAULT b'0',
  `allowrename` bit(1) NOT NULL DEFAULT b'0',
  `allowcomment` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`filetypeid`),
  UNIQUE KEY `filetypename_UNIQUE` (`filetypename`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filetype`
--

LOCK TABLES `filetype` WRITE;
/*!40000 ALTER TABLE `filetype` DISABLE KEYS */;
INSERT INTO `filetype` VALUES (1,'detail','','','','',''),(2,'ms-word','\0','\0','','\0',''),(3,'ms-excel','\0','\0','','\0',''),(4,'image','\0','\0','','\0',''),(5,'dictionary','','','','\0','');
/*!40000 ALTER TABLE `filetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filetypeext`
--

DROP TABLE IF EXISTS `filetypeext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filetypeext` (
  `filetypeextid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filetypeextname` varchar(10) NOT NULL,
  `filetypeid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`filetypeextid`),
  KEY `fk_filetypeext_filetype1_idx` (`filetypeid`),
  CONSTRAINT `fk_filetypeext_filetype1` FOREIGN KEY (`filetypeid`) REFERENCES `filetype` (`filetypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filetypeext`
--

LOCK TABLES `filetypeext` WRITE;
/*!40000 ALTER TABLE `filetypeext` DISABLE KEYS */;
INSERT INTO `filetypeext` VALUES (1,'doc',2),(2,'docx',2),(3,'xls',3),(4,'xlsx',3),(5,'jpeg',4),(6,'jpg',4),(7,'det',1),(8,'dic',5);
/*!40000 ALTER TABLE `filetypeext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurementunit`
--

DROP TABLE IF EXISTS `measurementunit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measurementunit` (
  `measurementunitid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `measurementunitname` varchar(50) NOT NULL,
  `inactive` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`measurementunitid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurementunit`
--

LOCK TABLES `measurementunit` WRITE;
/*!40000 ALTER TABLE `measurementunit` DISABLE KEYS */;
INSERT INTO `measurementunit` VALUES (1,'м','\0'),(2,'кв.м','\0'),(3,'кг','\0'),(4,'л','\0'),(5,'т','\0'),(6,'шт','\0'),(7,'п.м','\0');
/*!40000 ALTER TABLE `measurementunit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `settingid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settingname` varchar(50) NOT NULL,
  `settingbit` bit(1) NOT NULL DEFAULT b'0',
  `settingdatetime` datetime DEFAULT NULL,
  `settinglong` mediumtext,
  `settingstring` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`settingid`),
  UNIQUE KEY `settingname_UNIQUE` (`settingname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmpmap`
--

DROP TABLE IF EXISTS `tmpmap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmpmap` (
  `filenewid` int(11) NOT NULL,
  `fileoldid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmpmap`
--

LOCK TABLES `tmpmap` WRITE;
/*!40000 ALTER TABLE `tmpmap` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmpmap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ecoportret'
--
/*!50003 DROP FUNCTION IF EXISTS `detail_get_allowed_name` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `detail_get_allowed_name`(v_sourcedetailname varchar(100), v_dest_detailid int(10)) RETURNS varchar(100) CHARSET utf8
BEGIN
	declare result varchar(100);
	declare v_detailname_count int;

	select v_sourcedetailname into result;

	if v_dest_detailid is not null then

		select count(*) into v_detailname_count from 
		detailtreepath as c1 join detail t on t.detailid = c1.descendantid 
		where c1.ancestorid = v_dest_detailid and c1.level = 1 and t.detailname like concat(v_sourcedetailname, '_copy%');

	else

		select count(*) into v_detailname_count
		from detailtreepath ftp join detailtreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
		left join detailtreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
		join detail f on f.detailid = ftp.ancestorid
		where ftp3.ancestorid is null and ftp3.descendantid is null and f.detailname like concat(v_sourcedetailname, '_copy%');

	end if;
	
	if v_detailname_count = 0 then

		if v_dest_detailid is not null then
			select count(*) into v_detailname_count from 
			detailtreepath as c1 join detail t on t.detailid = c1.descendantid 
			where c1.ancestorid = v_dest_detailid and c1.level = 1 and t.detailname like v_sourcedetailname;

		else

			select count(*) into v_detailname_count
			from detailtreepath ftp join detailtreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
			left join detailtreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
			join detail f on f.detailid = ftp.ancestorid
			where ftp3.ancestorid is null and ftp3.descendantid is null and f.detailname like v_sourcedetailname;

		end if;
		
		if v_detailname_count > 0 then
			select concat(v_sourcedetailname, '_copy(1)') into result;
		end if;
	else
		select concat(v_sourcedetailname, '_copy(', v_detailname_count + 1, ')') into result;
	end if;

RETURN result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `filetype_getid_by_extname` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `filetype_getid_by_extname`(fileextname varchar(10)) RETURNS int(10)
BEGIN
	declare result int(10);

	select filetypeid into result from filetypeext where filetypeextname like fileextname;

	RETURN ifnull(result, 0);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `file_get_allowed_name` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `file_get_allowed_name`(v_sourcefilename varchar(100), v_dest_fileid int(10)) RETURNS varchar(100) CHARSET utf8
BEGIN
	declare result varchar(100);
	declare v_filename_count int;

	select v_sourcefilename into result;

	if v_dest_fileid is not null then

		select count(*) into v_filename_count from 
		filetreepath as c1 join file t on t.fileid = c1.descendantid 
		where c1.ancestorid = v_dest_fileid and c1.level = 1 and t.filename like concat(v_sourcefilename, '_copy%');

	else

		select count(*) into v_filename_count
		from filetreepath ftp join filetreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
		left join filetreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
		join file f on f.fileid = ftp.ancestorid
		where ftp3.ancestorid is null and ftp3.descendantid is null and f.filename like concat(v_sourcefilename, '_copy%');

	end if;
	
	if v_filename_count = 0 then

		if v_dest_fileid is not null then
			select count(*) into v_filename_count from 
			filetreepath as c1 join file t on t.fileid = c1.descendantid 
			where c1.ancestorid = v_dest_fileid and c1.level = 1 and t.filename like v_sourcefilename;

		else

			select count(*) into v_filename_count
			from filetreepath ftp join filetreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
			left join filetreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
			join file f on f.fileid = ftp.ancestorid
			where ftp3.ancestorid is null and ftp3.descendantid is null and f.filename like v_sourcefilename;

		end if;
		
		if v_filename_count > 0 then
			select concat(v_sourcefilename, '_copy(1)') into result;
		end if;
	else
		select concat(v_sourcefilename, '_copy(', v_filename_count + 1, ')') into result;
	end if;

RETURN result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `detail_copy` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `detail_copy`(v_detailid int(10), v_dest_ancestorid int(10), v_createdby varchar(50))
BEGIN
    declare result int(10);
	declare newid int(10);
	declare done int default false;
	declare v_ancestorid, v_descendantid int(10);
	declare v_level tinyint(3);
	declare v_detailname varchar(100);
	declare v_detailname_count int;
	declare cur cursor for select ancestorid, descendantid, level from detailtreepath where ancestorid = v_detailid;
/*
	select a.ancestorid, b.descendantid, (a.level + b.level + 1) as level
    from detailtreepath as a join detailtreepath as b
    where b.ancestorid = v_detailid and a.descendantid = v_dest_ancestorid;
*/
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    drop temporary table if exists temp_table;
    create temporary table temp_table (detailnewid int(10), detailoldid int(10));

    drop temporary table if exists temp_table2;
    create temporary table temp_table2 (detailnewid int(10), detailoldid int(10));

    drop temporary table if exists temp_table_parents;
    create temporary table temp_table_parents (parentid int(10), level tinyint(3));

	if v_dest_ancestorid is not null then
/*
		insert into temp_table select v_dest_ancestorid, v_dest_ancestorid;
		insert into temp_table2 select v_dest_ancestorid, v_dest_ancestorid;
*/		
		insert into temp_table_parents select ancestorid, level from detailtreepath where descendantid = v_dest_ancestorid;
		insert into temp_table select parentid, parentid from temp_table_parents;
		insert into temp_table2 select parentid, parentid from temp_table_parents;
	end if;

    drop temporary table if exists temp_table3;
    create temporary table temp_table3 (ancestorid int(10), descendantid int(10), level tinyint(3));

	open cur;
read_loop: loop
    fetch cur into v_ancestorid, v_descendantid, v_level;
	if done then
      leave read_loop;
    end if;

	select detailname into v_detailname from detail where detailid = v_descendantid;

/*************** CALC new name *******************************/
	if v_descendantid = v_detailid then
/*    
		if v_dest_ancestorid is not null then
			select count(*) into v_detailname_count from 
			detailtreepath as c1 join detail t on t.detailid = c1.descendantid 
			where c1.ancestorid = v_dest_ancestorid and c1.level = 1 and t.detailname like concat(v_detailname, '_copy%');
		else
			select count(*) into v_detailname_count
			from detailtreepath ftp join detailtreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
			left join detailtreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
			join detail f on f.detailid = ftp.ancestorid
			where ftp3.ancestorid is null and ftp3.descendantid is null and f.detailname like concat(v_detailname, '_copy%');
		end if;
		
		if v_detailname_count = 0 then
			if v_dest_ancestorid is not null then
				select count(*) into v_detailname_count from 
				detailtreepath as c1 join detail t on t.detailid = c1.descendantid 
				where c1.ancestorid = v_dest_ancestorid and c1.level = 1 and t.detailname like v_detailname;
			else
				select count(*) into v_detailname_count
				from detailtreepath ftp join detailtreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
				left join detailtreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
				join detail f on f.detailid = ftp.ancestorid
				where ftp3.ancestorid is null and ftp3.descendantid is null and f.detailname like v_detailname;
			end if;
			
			if v_detailname_count > 0 then
				select concat(v_detailname, '_copy(1)') into v_detailname;
			end if;
		else
			select concat(v_detailname, '_copy(', v_detailname_count + 1, ')') into v_detailname;
		end if;
*/        
        select detail_get_allowed_name(v_detailname, v_dest_ancestorid) into v_detailname;
	end if;
/*************** CALC new name *******************************/

/*
	insert into detail (detailname, detailtypeid, isfolder, sortorder, isprotected, comment, createdby, created)
	select v_detailname, detailtypeid, isfolder, sortorder, isprotected, comment, v_createdby, now() 
	from detail where detailid = v_descendantid;
*/
	insert into detail (fileid, detailname, detaildescription, detailgost, amount, measurementunitid, amountmaterial, comment, sortorder, createdby, created,
		docalc, detailpriceid)
	select fileid, detailname, detaildescription, detailgost, amount, measurementunitid, amountmaterial, comment, sortorder, v_createdby, now(), docalc, detailpriceid 
	from file where detailid = v_descendantid;

	select LAST_INSERT_ID() into newid;

/*
	insert into detailtreepath (ancestorid, descendantid, level, created, createdby)
    select v_ancestorid, newid, v_level, now(), v_createdby;
*/

	if v_dest_ancestorid is not null then
		insert into temp_table3 (ancestorid, descendantid, level)
		select parentid, v_descendantid, v_level + ttp.level + 1
		from temp_table_parents ttp;
/*		
		insert into temp_table3 (ancestorid, descendantid, level)
		select v_dest_ancestorid, v_descendantid, (a.level + b.level + 1) as level
		from detailtreepath as a join detailtreepath as b
		where b.ancestorid = v_detailid and a.descendantid = v_dest_ancestorid and b.descendantid = v_descendantid;

		insert into temp_table3 (ancestorid, descendantid, level)
		select ancestorid, v_descendantid, level + 1
		from detailtreepath
		where descendantid = v_dest_ancestorid and ancestorid <> v_dest_ancestorid;
*/
	end if;

	/* all children */
	insert into temp_table3 (ancestorid, descendantid, level)
	select ancestorid, descendantid, level from detailtreepath where ancestorid = v_descendantid; 

	insert into temp_table select newid, v_descendantid;
	insert into temp_table2 select newid, v_descendantid;

end loop;
	close cur;

	/*DEBUG*/
/*
	select * from temp_table;
	select * from temp_table2;
	select * from temp_table3;
	select * from temp_table_parents;

	select count(*) from temp_table;
	select count(*) from temp_table2;
	select count(*) from temp_table3;


	select fanc.detailnewid as detailnewid_anc, fdesc.detailnewid, ftp.level, now(), v_createdby from
	temp_table3 as ftp right join temp_table as fdesc on fdesc.detailoldid = ftp.descendantid 
	right join temp_table2 as fanc on fanc.detailoldid = ftp.ancestorid;

	select count(*) from
	temp_table3 as ftp right join temp_table as fdesc on fdesc.detailoldid = ftp.descendantid 
	right join temp_table2 as fanc on fanc.detailoldid = ftp.ancestorid;
*/
	/*DEBUG*/

	insert into detailtreepath (ancestorid, descendantid, level, created, createdby)
	select fanc.detailnewid as detailnewid_anc, fdesc.detailnewid, ftp.level, now(), v_createdby from
	temp_table3 as ftp right join temp_table as fdesc on fdesc.detailoldid = ftp.descendantid 
	right join temp_table2 as fanc on fanc.detailoldid = ftp.ancestorid;

	drop temporary table temp_table;
	drop temporary table temp_table2;
	drop temporary table temp_table3;
	drop temporary table temp_table_parents;

    select 1 into result;
	select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `detail_delete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `detail_delete`(v_detailid int(10))
BEGIN
	declare result int(10);

	declare exit handler for SQLEXCEPTION set result = 0;
	
    drop temporary table if exists temp_table;
    create temporary table temp_table (id int(10));
    
    insert into temp_table 
		select distinct detailid
			from detailtreepath join detail on detailtreepath.descendantid = detail.detailid
			where ancestorid = v_detailid;

   
	delete ftp1 from detailtreepath as ftp1 inner join detailtreepath as ftp2 on ftp1.descendantid = ftp2.descendantid
	where ftp2.ancestorid = v_detailid;	
	
    delete from detail where detailid in (select id from temp_table);
    select row_count() into result;
    
	drop temporary table temp_table;
 
	select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `detail_insert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `detail_insert`(v_parentid int(10),  v_fileid int(10), v_detailname varchar(2000), v_detailtypeid int(10), v_detaildescription varchar(255), 
	v_detailgost varchar(255), v_amount long, v_amountmaterial float, v_comment varchar(1000), v_createdby varchar(50),
    v_docalc bit(1), v_detailpriceid int(10))
BEGIN
	declare v_newid, v_maxsortorder int(10);
    declare result int(10);
    
	declare exit handler for SQLEXCEPTION set result = 0;

	select max(ifnull(f.sortorder, 0)) into v_maxsortorder from detailtreepath ftp join detail f on f.detailid = ftp.descendantid
	where ftp.ancestorid = v_parentid and ftp.level = 1;
	   
	insert into detail (fileid, detailname, detailtypeid, detaildescription, detailgost, amount, 
		amountmaterial, comment, sortorder, createdby, created, docalc, detailpriceid) values 
		(v_fileid, v_detailname, v_detailtypeid, v_detaildescription, v_detailgost, v_amount, 
        v_amountmaterial, v_comment, ifnull(v_maxsortorder, 0)+1, v_createdby, now(), v_docalc, v_detailpriceid);
		
	select LAST_INSERT_ID() into v_newid;
	
	insert into detailtreepath (ancestorid, descendantid, level, created, createdby)
		select ancestorid, v_newid, level + 1, now(), v_createdby from detailtreepath
		where descendantid = v_parentid
		union all
		select v_newid, v_newid, 0, now(), v_createdby;
	
    set result = v_newid;
    select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `detail_move` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `detail_move`(v_detailid int(10), v_dest_ancestorid int(10), v_createdby varchar(50))
BEGIN
	/* TODO: Doesnt work for trees that starts from parent=null */
    declare result int(10);
   
	declare exit handler for SQLEXCEPTION set result = 0;

ext: begin

	if v_dest_ancestorid is not null then
		if exists(select * from detailtreepath where ancestorid = v_detailid and descendantid = v_dest_ancestorid) then
			select 0 into result;
			leave ext;
		end if;
	end if;

/*
	delete a from filetreepath as a
    join filetreepath as d on a.descendantid = d.descendantid
    left join filetreepath as x on x.ancestorid = d.ancestorid and x.descendantid = a.ancestorid
    where d.ancestorid = v_fileid and x.ancestorid is null;
*/
	delete ftp from detailtreepath ftp join detailtreepath ftp2 on ftp.descendantid = ftp2.descendantid where ftp2.ancestorid = v_fileid and ftp.ancestorid <> v_detailid;

	if v_dest_ancestorid is not null then
		insert into detailtreepath (ancestorid, descendantid, level, created, createdby)
		select ftp.ancestorid, ftp2.descendantid, ftp.level + ftp2.level + 1, now(), v_createdby
		from detailtreepath ftp join detailtreepath ftp2 where ftp2.ancestorid = v_fileid and ftp.descendantid = v_dest_ancestorid;
	end if;

    select row_count() into result;
end ext;
	select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `detail_update` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `detail_update`(v_detailid int(10), v_detailname varchar(2000), v_detaildescription varchar(255), v_detailgost varchar(255), v_amount long, 
	v_measurementunitid int(10), v_amountmaterial float, v_comment varchar(1000), v_updatedby varchar(50),
    v_docalc bit(1), v_detailpriceid int(10))
BEGIN
	declare result int(10);

	declare exit handler for SQLEXCEPTION set result = 0;

	update detail 
    set
		detailname = v_detailname,
        detaildescription = v_detaildescription,
        detailgost = v_detailgost,
        amount = v_amount,
        measurementunitid = v_measurementunitid, 
        amountmaterial = v_amountmaterial,
        comment = v_comment,
        updated = now(),
        updatedby = v_updatedby,
        docalc = v_docalc,
        detailpriceid = v_detailpriceid
	where
		detailid = v_detailid;
        
	select last_insert_id() into result;
    select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `file_copy` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `file_copy`(v_fileid int(10), v_dest_ancestorid int(10), v_createdby varchar(50))
BEGIN
    declare result int(10);
	declare newid int(10);
	declare done int default false;
	declare v_ancestorid, v_descendantid int(10);
	declare v_level tinyint(3);
	declare v_filename varchar(100);
	declare v_filename_count int;
	declare cur cursor for select ancestorid, descendantid, level from filetreepath where ancestorid = v_fileid;
/*
	select a.ancestorid, b.descendantid, (a.level + b.level + 1) as level
    from filetreepath as a join filetreepath as b
    where b.ancestorid = v_fileid and a.descendantid = v_dest_ancestorid;
*/
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    drop temporary table if exists temp_table;
    create temporary table temp_table (filenewid int(10), fileoldid int(10));

    drop temporary table if exists temp_table2;
    create temporary table temp_table2 (filenewid int(10), fileoldid int(10));

    drop temporary table if exists temp_table_parents;
    create temporary table temp_table_parents (parentid int(10), level tinyint(3));

	if v_dest_ancestorid is not null then
/*
		insert into temp_table select v_dest_ancestorid, v_dest_ancestorid;
		insert into temp_table2 select v_dest_ancestorid, v_dest_ancestorid;
*/		
		insert into temp_table_parents select ancestorid, level from filetreepath where descendantid = v_dest_ancestorid;
		insert into temp_table select parentid, parentid from temp_table_parents;
		insert into temp_table2 select parentid, parentid from temp_table_parents;
	end if;

    drop temporary table if exists temp_table3;
    create temporary table temp_table3 (ancestorid int(10), descendantid int(10), level tinyint(3));

	open cur;
read_loop: loop
    fetch cur into v_ancestorid, v_descendantid, v_level;
	if done then
      leave read_loop;
    end if;

	select filename into v_filename from file where fileid = v_descendantid;

/*************** CALC new name *******************************/
	if v_descendantid = v_fileid then
/*
		if v_dest_ancestorid is not null then
			select count(*) into v_filename_count from 
			filetreepath as c1 join file t on t.fileid = c1.descendantid 
			where c1.ancestorid = v_dest_ancestorid and c1.level = 1 and t.filename like concat(v_filename, '_copy%');
		else
			select count(*) into v_filename_count
			from filetreepath ftp join filetreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
			left join filetreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
			join file f on f.fileid = ftp.ancestorid
			where ftp3.ancestorid is null and ftp3.descendantid is null and f.filename like concat(v_filename, '_copy%');
		end if;
		
		if v_filename_count = 0 then
			if v_dest_ancestorid is not null then
				select count(*) into v_filename_count from 
				filetreepath as c1 join file t on t.fileid = c1.descendantid 
				where c1.ancestorid = v_dest_ancestorid and c1.level = 1 and t.filename like v_filename;
			else
				select count(*) into v_filename_count
				from filetreepath ftp join filetreepath ftp2 on ftp2.descendantid = ftp.descendantid and ftp2.ancestorid = ftp.ancestorid
				left join filetreepath ftp3 on ftp2.descendantid = ftp3.descendantid and ftp.ancestorid <> ftp3.ancestorid
				join file f on f.fileid = ftp.ancestorid
				where ftp3.ancestorid is null and ftp3.descendantid is null and f.filename like v_filename;
			end if;
			
			if v_filename_count > 0 then
				select concat(v_filename, '_copy(1)') into v_filename;
			end if;
		else
			select concat(v_filename, '_copy(', v_filename_count + 1, ')') into v_filename;
		end if;
*/
		select file_get_allowed_name(v_filename, v_dest_ancestorid) into v_filename;
	end if;
/*************** CALC new name *******************************/

	insert into file (filename, filetypeid, isfolder, sortorder, isprotected, comment, createdby, created)
	select v_filename, filetypeid, isfolder, sortorder, isprotected, comment, v_createdby, now() 
	from file where fileid = v_descendantid;

	select LAST_INSERT_ID() into newid;

/*
	insert into filetreepath (ancestorid, descendantid, level, created, createdby)
    select v_ancestorid, newid, v_level, now(), v_createdby;
*/

	if v_dest_ancestorid is not null then
		insert into temp_table3 (ancestorid, descendantid, level)
		select parentid, v_descendantid, v_level + ttp.level + 1
		from temp_table_parents ttp;
/*		
		insert into temp_table3 (ancestorid, descendantid, level)
		select v_dest_ancestorid, v_descendantid, (a.level + b.level + 1) as level
		from filetreepath as a join filetreepath as b
		where b.ancestorid = v_fileid and a.descendantid = v_dest_ancestorid and b.descendantid = v_descendantid;

		insert into temp_table3 (ancestorid, descendantid, level)
		select ancestorid, v_descendantid, level + 1
		from filetreepath
		where descendantid = v_dest_ancestorid and ancestorid <> v_dest_ancestorid;
*/
	end if;

	/* all children */
	insert into temp_table3 (ancestorid, descendantid, level)
	select ancestorid, descendantid, level from filetreepath where ancestorid = v_descendantid; 

	insert into temp_table select newid, v_descendantid;
	insert into temp_table2 select newid, v_descendantid;

end loop;
	close cur;

	/*DEBUG*/
/*
	select * from temp_table;
	select * from temp_table2;
	select * from temp_table3;
	select * from temp_table_parents;

	select count(*) from temp_table;
	select count(*) from temp_table2;
	select count(*) from temp_table3;


	select fanc.filenewid as filenewid_anc, fdesc.filenewid, ftp.level, now(), v_createdby from
	temp_table3 as ftp right join temp_table as fdesc on fdesc.fileoldid = ftp.descendantid 
	right join temp_table2 as fanc on fanc.fileoldid = ftp.ancestorid;

	select count(*) from
	temp_table3 as ftp right join temp_table as fdesc on fdesc.fileoldid = ftp.descendantid 
	right join temp_table2 as fanc on fanc.fileoldid = ftp.ancestorid;
*/
	/*DEBUG*/

	insert into filetreepath (ancestorid, descendantid, level, created, createdby)
	select fanc.filenewid as filenewid_anc, fdesc.filenewid, ftp.level, now(), v_createdby from
	temp_table3 as ftp join temp_table as fdesc on fdesc.fileoldid = ftp.descendantid 
	join temp_table2 as fanc on fanc.fileoldid = ftp.ancestorid;

	drop temporary table temp_table;
	drop temporary table temp_table2;
	drop temporary table temp_table3;
	drop temporary table temp_table_parents;

    select 1 into result;
	select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `file_delete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `file_delete`(v_fileid int(10))
BEGIN
	declare result int(10);

	declare exit handler for SQLEXCEPTION set result = 0;
	
    drop temporary table if exists temp_table;
    create temporary table temp_table (id int(10));
    
    insert into temp_table 
		select distinct fileid
			from filetreepath join file on filetreepath.descendantid = file.fileid
			where ancestorid = v_fileid;

   
	delete ftp1 from filetreepath as ftp1 inner join filetreepath as ftp2 on ftp1.descendantid = ftp2.descendantid
	where ftp2.ancestorid = v_fileid;	
	
    delete from file where fileid in (select id from temp_table);
    select row_count() into result;
    
	drop temporary table temp_table;
 
	select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `file_insert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `file_insert`(v_parentid int(10),  v_filename varchar(100), v_filetypeid int(10), v_isfolder bit, v_isprotected bit, v_comment varchar(1000), v_createdby varchar(50))
BEGIN
	declare v_newid, v_maxsortorder int(10);
    declare result int(10);
    
	declare exit handler for SQLEXCEPTION set result = 0;

	select max(ifnull(f.sortorder, 0)) into v_maxsortorder from filetreepath ftp join file f on f.fileid = ftp.descendantid
	where ftp.ancestorid = v_parentid and ftp.level = 1;
	   
	insert into file (filename, filetypeid, isfolder, isprotected, created, createdby, sortorder, comment) values 
		(v_filename, v_filetypeid, v_isfolder, v_isprotected, now(), v_createdby, ifnull(v_maxsortorder, 0)+1, v_comment);
		
	select LAST_INSERT_ID() into v_newid;
	
	insert into filetreepath (ancestorid, descendantid, level, created, createdby)
		select ancestorid, v_newid, level + 1, now(), v_createdby from filetreepath
		where descendantid = v_parentid
		union all
		select v_newid, v_newid, 0, now(), v_createdby;
	
    set result = v_newid;
    select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `file_move` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `file_move`(v_fileid int(10), v_dest_ancestorid int(10), v_createdby varchar(50))
BEGIN
	/* TODO: Doesnt work for trees that starts from parent=null */
    declare result int(10);
   
	declare exit handler for SQLEXCEPTION set result = 0;

ext: begin

	if v_dest_ancestorid is not null then
		if exists(select * from filetreepath where ancestorid = v_fileid and descendantid = v_dest_ancestorid) then
			select 0 into result;
			leave ext;
		end if;
	end if;

/*
	delete a from filetreepath as a
    join filetreepath as d on a.descendantid = d.descendantid
    left join filetreepath as x on x.ancestorid = d.ancestorid and x.descendantid = a.ancestorid
    where d.ancestorid = v_fileid and x.ancestorid is null;
*/
	delete ftp from filetreepath ftp join filetreepath ftp2 on ftp.descendantid = ftp2.descendantid where ftp2.ancestorid = v_fileid and ftp.ancestorid <> v_fileid;

	if v_dest_ancestorid is not null then
		insert into filetreepath (ancestorid, descendantid, level, created, createdby)
		select ftp.ancestorid, ftp2.descendantid, ftp.level + ftp2.level + 1, now(), v_createdby
		from filetreepath ftp join filetreepath ftp2 where ftp2.ancestorid = v_fileid and ftp.descendantid = v_dest_ancestorid;
	end if;

    select row_count() into result;
end ext;
	select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `file_update` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `file_update`(v_fileid int(10), v_filename varchar(100), v_comment varchar(1000), v_updatedby varchar(50))
BEGIN
	declare result int(10);

	declare exit handler for SQLEXCEPTION set result = 0;

	update file 
    set
		filename = v_filename,
        comment = v_comment,
        updated = now(),
        updatedby = v_updatedby
	where
		fileid = v_fileid;
        
	select last_insert_id() into result;
    select result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-22 12:27:22
