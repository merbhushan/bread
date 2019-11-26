-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: bread
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4-log

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
-- Table structure for table `api_api_role`
--

DROP TABLE IF EXISTS `api_api_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_api_role` (
  `api_id` int(10) unsigned NOT NULL,
  `api_role_id` int(10) unsigned NOT NULL,
  KEY `FK_api_role_apis` (`api_id`),
  KEY `FK_api_role_api_roles` (`api_role_id`),
  CONSTRAINT `FK_api_role_api_roles` FOREIGN KEY (`api_role_id`) REFERENCES `api_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_api_role_apis` FOREIGN KEY (`api_id`) REFERENCES `apis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_api_role`
--

LOCK TABLES `api_api_role` WRITE;
/*!40000 ALTER TABLE `api_api_role` DISABLE KEYS */;
INSERT INTO `api_api_role` VALUES (1,1);
/*!40000 ALTER TABLE `api_api_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_role_attribute`
--

DROP TABLE IF EXISTS `api_role_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_role_attribute` (
  `api_role_id` int(10) unsigned NOT NULL,
  `relationship_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attribute_id` int(10) unsigned NOT NULL,
  `search` tinyint(3) unsigned DEFAULT '0',
  `listing` tinyint(3) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_role_attribute`
--

LOCK TABLES `api_role_attribute` WRITE;
/*!40000 ALTER TABLE `api_role_attribute` DISABLE KEYS */;
INSERT INTO `api_role_attribute` VALUES (1,0,4,0,1),(1,0,5,0,1),(1,0,6,0,1),(1,0,7,0,1),(1,0,8,0,1),(1,0,2,0,1),(1,0,1,1,1),(1,0,2,1,1),(1,0,3,1,1);
/*!40000 ALTER TABLE `api_role_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_roles`
--

DROP TABLE IF EXISTS `api_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_roles`
--

LOCK TABLES `api_roles` WRITE;
/*!40000 ALTER TABLE `api_roles` DISABLE KEYS */;
INSERT INTO `api_roles` VALUES (1,'Admin',1,1,'2019-11-25 11:28:09',1,'2019-11-25 11:28:10',NULL,NULL);
/*!40000 ALTER TABLE `api_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apis`
--

DROP TABLE IF EXISTS `apis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `table_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_apis_tables` (`table_id`),
  CONSTRAINT `FK_apis_tables` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apis`
--

LOCK TABLES `apis` WRITE;
/*!40000 ALTER TABLE `apis` DISABLE KEYS */;
INSERT INTO `apis` VALUES (1,'Employee',1,1,1,'2019-11-25 11:27:18',1,'2019-11-25 11:27:20',NULL,NULL);
/*!40000 ALTER TABLE `apis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_relationship`
--

DROP TABLE IF EXISTS `attribute_relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attribute_relationship` (
  `relationship_id` int(10) unsigned NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  KEY `FK__attributes` (`attribute_id`),
  KEY `FK__relationships` (`relationship_id`),
  CONSTRAINT `FK__attributes` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK__relationships` FOREIGN KEY (`relationship_id`) REFERENCES `relationships` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_relationship`
--

LOCK TABLES `attribute_relationship` WRITE;
/*!40000 ALTER TABLE `attribute_relationship` DISABLE KEYS */;
INSERT INTO `attribute_relationship` VALUES (1,4),(1,5),(1,6),(1,7),(1,8),(2,1),(2,2);
/*!40000 ALTER TABLE `attribute_relationship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fields_tables` (`table_id`),
  CONSTRAINT `FK_fields_tables` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributes`
--

LOCK TABLES `attributes` WRITE;
/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
INSERT INTO `attributes` VALUES (1,1,'fname',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(2,1,'lname',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(3,1,'gender',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(4,2,'name',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(5,2,'address',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(6,2,'city',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(7,2,'state',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL),(8,2,'zip',1,1,1,'2019-11-22 16:40:02',1,'2019-11-22 16:40:03',NULL,NULL);
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default`
--

DROP TABLE IF EXISTS `default`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default`
--

LOCK TABLES `default` WRITE;
/*!40000 ALTER TABLE `default` DISABLE KEYS */;
/*!40000 ALTER TABLE `default` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relationships`
--

DROP TABLE IF EXISTS `relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(10) unsigned NOT NULL,
  `relationship_table_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('hasOne','belongsTo','hasMany','belongsToMany','hasOneThrough','hasManyThrough','morphTo','morphOne','morphMany') NOT NULL,
  `detail` json NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_table_id` (`table_id`,`name`),
  KEY `FK_relationships_tables_2` (`relationship_table_id`),
  CONSTRAINT `FK_relationships_tables` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_relationships_tables_2` FOREIGN KEY (`relationship_table_id`) REFERENCES `tables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relationships`
--

LOCK TABLES `relationships` WRITE;
/*!40000 ALTER TABLE `relationships` DISABLE KEYS */;
INSERT INTO `relationships` VALUES (1,1,2,'office','belongsTo','{\"relationship\": \"hasOne\"}',1,1,'2019-11-22 14:35:38',1,'2019-11-22 14:35:39',NULL,NULL),(2,1,1,'office.creator','belongsTo','{\"relationship\": \"hasOne\"}',1,1,'2019-11-22 14:35:38',1,'2019-11-22 14:35:39',NULL,NULL);
/*!40000 ALTER TABLE `relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `primary_key` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,'emp_master','App\\Models\\Employee','emp_id',1,1,'2019-11-22 13:47:59',1,'2019-11-22 13:48:02',NULL,NULL),(2,'office_master','App\\Models\\Office','office_id',1,1,'2019-11-22 13:47:59',1,'2019-11-22 13:48:02',NULL,NULL);
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-26 18:47:16
