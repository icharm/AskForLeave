-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: askforleave
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `ask_admin`
--

DROP TABLE IF EXISTS `ask_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ask_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `email` varchar(25) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `salt` int(25) NOT NULL,
  `phone` int(12) NOT NULL,
  `date` datetime NOT NULL,
  `power` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ask_admin`
--

LOCK TABLES `ask_admin` WRITE;
/*!40000 ALTER TABLE `ask_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `ask_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ask_class`
--

DROP TABLE IF EXISTS `ask_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ask_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL COMMENT 'ask_teacher表外键',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `disc` text CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ask_class`
--

LOCK TABLES `ask_class` WRITE;
/*!40000 ALTER TABLE `ask_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `ask_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ask_leave_queue`
--

DROP TABLE IF EXISTS `ask_leave_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ask_leave_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `reason` text CHARACTER SET utf8 NOT NULL,
  `status` int(2) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ask_leave_queue`
--

LOCK TABLES `ask_leave_queue` WRITE;
/*!40000 ALTER TABLE `ask_leave_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `ask_leave_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ask_mentor`
--

DROP TABLE IF EXISTS `ask_mentor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ask_mentor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `gender` int(2) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ask_mentor`
--

LOCK TABLES `ask_mentor` WRITE;
/*!40000 ALTER TABLE `ask_mentor` DISABLE KEYS */;
/*!40000 ALTER TABLE `ask_mentor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ask_student`
--

DROP TABLE IF EXISTS `ask_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ask_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(25) CHARACTER SET utf8 NOT NULL,
  `name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `gender` int(2) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ask_student`
--

LOCK TABLES `ask_student` WRITE;
/*!40000 ALTER TABLE `ask_student` DISABLE KEYS */;
/*!40000 ALTER TABLE `ask_student` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-01 19:20:57
