-- MySQL dump 10.16  Distrib 10.1.41-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ro-div_tms
-- ------------------------------------------------------
-- Server version	10.1.41-MariaDB-0+deb9u1

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
-- Current Database: `ro-div_tms`
--


--
-- Table structure for table `calendar_admins`
--

DROP TABLE IF EXISTS `calendar_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_admins` (
  `admin_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(40) NOT NULL DEFAULT '',
  `admin_password` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_events` (
  `event_id` int(10) unsigned NOT NULL,
  `event_day` int(2) NOT NULL DEFAULT '0',
  `event_month` int(2) NOT NULL DEFAULT '0',
  `event_year` int(4) NOT NULL DEFAULT '0',
  `event_time` varchar(5) NOT NULL DEFAULT '',
  `event_title` varchar(200) NOT NULL DEFAULT '',
  `event_desc` mediumtext NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `training_requests`
--

DROP TABLE IF EXISTS `training_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training_requests` (
  `ID` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Type1` varchar(50) NOT NULL,
  `Type2` varchar(50) NOT NULL,
  `Rating` varchar(50) NOT NULL,
  `Airport` varchar(50) NOT NULL,
  `Reason` varchar(500) NOT NULL,
  `Tracking` int(50) NOT NULL AUTO_INCREMENT,
  `Deadlines1` varchar(100) NOT NULL DEFAULT 'NA',
  `Deadlines2` varchar(100) NOT NULL DEFAULT 'NA',
  `Deadlines3` varchar(100) NOT NULL DEFAULT 'NA',
  `Chosen` varchar(10) NOT NULL DEFAULT 'NO',
  `Trainer` varchar(50) NOT NULL DEFAULT 'NA',
  `ReportStatus` varchar(50) NOT NULL DEFAULT 'Pending',
  `Summary` varchar(500) NOT NULL,
  `Pros` varchar(500) NOT NULL,
  `Cons` varchar(500) NOT NULL,
  `Suggestions` varchar(500) NOT NULL,
  `Time_start` varchar(40) NOT NULL,
  `Time_end` varchar(40) NOT NULL DEFAULT 'N/A',
  `Isvisible` varchar(50) NOT NULL DEFAULT 'YES',
  PRIMARY KEY (`Tracking`)
) ENGINE=InnoDB AUTO_INCREMENT=1176 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Rating` varchar(50) NOT NULL,
  `Division` varchar(40) NOT NULL,
  `Acces` varchar(50) NOT NULL DEFAULT 'USER',
  `admin_dataprotection` varchar(40) NOT NULL DEFAULT 'NO',
  `admin_dataprotection_timestamp` varchar(40) NOT NULL DEFAULT 'NEVER',
  `member_dataprotection` varchar(40) NOT NULL DEFAULT 'NO',
  `member_dataprotection_timestamp` varchar(40) NOT NULL DEFAULT 'NEVER',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-30 12:36:14