-- MySQL dump 10.13  Distrib 5.5.32, for Win32 (x86)
--
-- Host: localhost    Database: appgames
-- ------------------------------------------------------
-- Server version	5.5.32

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
-- Table structure for table `game_officials`
--

DROP TABLE IF EXISTS `game_officials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slot` int(11) NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `assignRole` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assignState` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personNameFull` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gameId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_official_game_slot_index` (`gameId`,`slot`),
  KEY `IDX_B7810586EC55B7A4` (`gameId`),
  CONSTRAINT `FK_B7810586EC55B7A4` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_officials`
--

LOCK TABLES `game_officials` WRITE;
/*!40000 ALTER TABLE `game_officials` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_officials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_teams`
--

DROP TABLE IF EXISTS `game_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slot` int(11) NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `levelKey` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groupKeySlot` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conduct` longtext COLLATE utf8_unicode_ci,
  `gameId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_team_game_slot_index` (`gameId`,`slot`),
  KEY `IDX_A4F15BD7EC55B7A4` (`gameId`),
  CONSTRAINT `FK_A4F15BD7EC55B7A4` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_teams`
--

LOCK TABLES `game_teams` WRITE;
/*!40000 ALTER TABLE `game_teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectKey` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `num` int(11) NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `levelKey` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groupKey` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groupType` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dtBeg` datetime NOT NULL,
  `dtEnd` datetime DEFAULT NULL,
  `link` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_project_num_index` (`projectKey`,`num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `program` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` int(11) DEFAULT NULL,
  `sport` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `domainSub` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level_sport_index` (`sport`),
  KEY `level_domain_index` (`domain`),
  KEY `level_domain_sub_index` (`domainSub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `levels`
--

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_teams`
--

DROP TABLE IF EXISTS `project_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectKey` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `levelKey` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `groupKey` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_team_game_slot_index` (`projectKey`,`levelKey`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_teams`
--

LOCK TABLES `project_teams` WRITE;
/*!40000 ALTER TABLE `project_teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `season` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sport` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `domainSub` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_season_index` (`season`),
  KEY `project_sport_index` (`sport`),
  KEY `project_domain_index` (`domain`),
  KEY `project_domain_sub_index` (`domainSub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-30 13:50:14
