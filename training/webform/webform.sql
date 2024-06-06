/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`webforms` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `webforms`;

CREATE TABLE `webforms`.`webform` (
  `RegID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Applicant` varchar(60) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` enum('Female','Male') NOT NULL,
  `YearPass` smallint(5) unsigned NOT NULL,
  `Branch` enum('Biology','Computer Science','Economics','Vocational') NOT NULL,
  `FName` varchar(60) NOT NULL,
  `MName` varchar(60) NOT NULL,
  `Location` varchar(60) NOT NULL,
  `Mobile` varchar(25) NOT NULL,
  `EMail` varchar(60) DEFAULT NULL,
  `Remarks` text,
  PRIMARY KEY (`RegID`),
  UNIQUE KEY `ApplicantUnq` (`Applicant`,`DOB`,`Gender`,`YearPass`,`Branch`,`FName`,`MName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
