-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql203.byetcluster.com
-- Generation Time: Dec 15, 2017 at 09:52 AM
-- Server version: 5.6.35-81.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_21240545_Engineeringcareers`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
CREATE TABLE IF NOT EXISTS `Admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Admin_Password` varchar(30) NOT NULL,
  `SecurityQuestion` varchar(30) NOT NULL,
  `SecurityAnswer` varchar(30) NOT NULL,
  `adminemail` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Careerevents`
--

DROP TABLE IF EXISTS `Careerevents`;
CREATE TABLE IF NOT EXISTS `Careerevents` (
  `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Organizer_ID` int(11) DEFAULT NULL,
  `Event_Name` varchar(20) DEFAULT NULL,
  `Venue_ID` int(11) DEFAULT NULL,
  `Start_Date` date DEFAULT NULL,
  `End_date` date DEFAULT NULL,
  `Last_available_purchase_day_n_time` datetime DEFAULT NULL,
  `Start` time DEFAULT NULL,
  `End` time DEFAULT NULL,
  `Event_Description` text,
  `Max_Capacity` int(11) DEFAULT NULL,
  `Category` varchar(30) DEFAULT NULL,
  `Admin_ID` int(11) NOT NULL,
  PRIMARY KEY (`Event_ID`),
  KEY `FK` (`Organizer_ID`,`Venue_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3035 ;

--
-- Dumping data for table `Careerevents`
--

INSERT INTO `Careerevents` (`Event_ID`, `Organizer_ID`, `Event_Name`, `Venue_ID`, `Start_Date`, `End_date`, `Last_available_purchase_day_n_time`, `Start`, `End`, `Event_Description`, `Max_Capacity`, `Category`, `Admin_ID`) VALUES
(3001, 2002, 'Petrochemicals', 4001, '2017-10-30', '2017-10-30', '2017-10-28 00:00:00', '09:00:00', '17:00:00', 'A career fair with mainly companies of the petrochemical industry interested in Chemeng Recruits.', 10, 'Chemical Engineering', 0),
(3030, 2003, 'Aristotles Event', 4009, '2018-01-15', '2018-01-16', '2018-01-13 09:00:00', '09:00:00', '18:00:00', 'In this event, the biggest companies around London in the Mechanical Engineering Industry will join ', 5, 'Mechanical Engineering', 0),
(3031, 2003, 'Computing', 4010, '2017-12-16', '2017-12-16', '2017-12-14 09:00:00', '11:00:00', '17:00:00', 'This is for computer science potential employees, talking to the biggest tech companies.', 5, 'Computer Science', 0),
(3032, 2003, 'ExamplePastEvent', 4009, '2017-12-11', '2017-12-11', '2017-12-11 09:00:00', '08:00:00', '12:00:00', 'This is an example past event', 3, 'Chemical Engineering', 0),
(3033, 2004, 'Mercedez-Benz Drivin', 4001, '2018-01-09', '2018-01-09', '2018-01-06 15:00:00', '14:00:00', '21:00:00', 'Experience all kinds of thrills behind the wheel - challenging driver training, fascinating tours, exciting travel experiences and one-off incentive activities ', 10, 'Mechanical Engineering', 0),
(3034, 2002, 'Petroleum', 4012, '2017-12-31', '2017-12-31', '2017-12-28 09:00:00', '08:00:00', '09:00:00', 'Want to know more about the petrol industry? Join us!', 5, 'Chemical Engineering', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Companies`
--

DROP TABLE IF EXISTS `Companies`;
CREATE TABLE IF NOT EXISTS `Companies` (
  `Company_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_ID` int(11) DEFAULT NULL,
  `Company_Name` varchar(30) DEFAULT NULL,
  `Representative_Name` varchar(40) DEFAULT NULL,
  `Representative_Email` varchar(30) NOT NULL,
  PRIMARY KEY (`Company_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5033 ;

--
-- Dumping data for table `Companies`
--

INSERT INTO `Companies` (`Company_ID`, `Event_ID`, `Company_Name`, `Representative_Name`, `Representative_Email`) VALUES
(1101, 3001, 'Shell', 'John Smith', 'johnsmith@shell.com'),
(5023, 3030, 'Rolls Royce', 'Emma Watson', 'emma@rolls.com'),
(5024, 3030, 'Shell', 'Emir Imran', 'Emir@shell.com'),
(5025, 3031, 'Apple', 'Emily Clark', 'emilyclark@gmail.com'),
(5026, 3031, 'Dell', 'John Dawood', 'johnny@dell.com'),
(5027, 3032, 'Example Past company', 'Rep Name', 'Repemail@gmail.com'),
(5028, 3033, 'Mercedez Benz ', 'John Smith', 'johnsmith@mercedezbenz.com'),
(5029, 3034, 'SHELL', 'John Doe', 'johndoe@shell.com'),
(5030, 3034, 'BP', 'Jane doe', 'janedoe@bp.com'),
(5031, 3034, 'Atkins', 'Atkinson', 'atkinson@atkins.com'),
(5032, 3034, 'Exxon', 'Eddy hong', 'ed@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Education`
--

DROP TABLE IF EXISTS `Education`;
CREATE TABLE IF NOT EXISTS `Education` (
  `Education_ID` int(11) NOT NULL AUTO_INCREMENT,
  `University` varchar(40) DEFAULT NULL,
  `Degree_Type` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`Education_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10009 ;

--
-- Dumping data for table `Education`
--

INSERT INTO `Education` (`Education_ID`, `University`, `Degree_Type`) VALUES
(10003, 'UCL', 'MEng'),
(10006, 'University of Birmingham', 'BEng'),
(10007, 'Cambridge', 'MEng'),
(10008, '', 'Choose...');

-- --------------------------------------------------------

--
-- Table structure for table `Host_Organizer`
--

DROP TABLE IF EXISTS `Host_Organizer`;
CREATE TABLE IF NOT EXISTS `Host_Organizer` (
  `Organizer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` enum('Mr','Mrs','Ms','Dr','Miss') NOT NULL,
  `First_Name` varchar(30) DEFAULT NULL,
  `Last_Name` varchar(30) DEFAULT NULL,
  `Password` text,
  `Email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Organizer_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2006 ;

--
-- Dumping data for table `Host_Organizer`
--

INSERT INTO `Host_Organizer` (`Organizer_ID`, `Title`, `First_Name`, `Last_Name`, `Password`, `Email`) VALUES
(2002, 'Mr', 'Eddy', 'Lee', '$2y$10$zNNqlfc8QIReHDPHvMvpQOM/qckU99N7rpgKglHvKzA3/npWqCMGW', 'eddylee@gmail.com'),
(2003, 'Mr', 'Aristotle', 'Smith', '$2y$10$Cuj6JIBkKV4Pssmw9RFUNuN7l1zo5iNa9KWUpUXbwAurgEslT8QaW', 'aristotlesmith@gmail.com'),
(2004, 'Mrs', 'Brenda', 'Bardelle', '$2y$10$NlIZ/oGVJTLtgaVx6ghzfeq4cp4ekqy/j/q4eMIb4DRB7z5SVZPNO', 'bardelle.brenda30@gmail.com'),
(2005, 'Mrs', 'Sarah', 'Dawood', '$2y$10$G97rgTgz4rCrLhxCDqN/v.RRXJozYOEx.T4o191e5M8DRghNZDPca', 'sarahdawood@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Potential_Employee`
--

DROP TABLE IF EXISTS `Potential_Employee`;
CREATE TABLE IF NOT EXISTS `Potential_Employee` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Education_ID` int(11) DEFAULT NULL,
  `Title` enum('Mr','Mrs','Ms','Dr','Miss') DEFAULT NULL,
  `First_Name` varchar(30) DEFAULT NULL,
  `Last_name` varchar(30) DEFAULT NULL,
  `Password` text,
  `Email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1033 ;

--
-- Dumping data for table `Potential_Employee`
--

INSERT INTO `Potential_Employee` (`User_ID`, `Education_ID`, `Title`, `First_Name`, `Last_name`, `Password`, `Email`) VALUES
(1019, 10003, 'Mrs', 'Adriana', 'Lima', '$2y$10$6cCMBq4PFBuC0/G/G5E9CeGfvY7GezTLbk/Sa5ueW1nErEG4Vyfcm', 'adrianalima1@gmail.com'),
(1026, 10003, 'Mr', 'Adrian', 'Causby', '$2y$10$0xkBBooWHo2lUg/zoyw9zOKZjI9qLxnbsdOKpdzHBSD.K7zS2OTyi', 'adrian.tc1521@gmail.com'),
(1027, 10003, 'Mr', 'Tom', 'Creed', '$2y$10$nOLSKPTf3PJJtjdbLBDwEuvZkOYP4I2oWzvnFyESdSXdl4vmXtxr6', 'thomascreed@gmail.com'),
(1028, 10003, 'Mr', 'Shervin', 'Rad', '$2y$10$wemWKcYa44WQ2Y5sq7eVAuDGtprnrwJW.LsZ.CYZsoZ1Hm3wtQR.S', 'shervin.rad.15@ucl.ac.uk'),
(1029, 10006, 'Ms', 'Zac', 'Tribbian', '$2y$10$6EOzJle2kUvJCZihA7j6a.CydlsrFTFk4sarcBJng/iCqK9jvMaR2', 'zactribbian@gmail.com'),
(1030, 10007, 'Mrs', 'Emily', 'Wathfored', '$2y$10$IjuLN8EyEAAnZFiJ8b/uXeK.YAbeuScY/BxXP6Dldn6XBUoMTeFxe', 'emily123@gmail.com'),
(1031, 10008, 'Mr', 'James', 'Saagar', '$2y$10$DW7/KCLpAy/1boJPxNv9c..il3REA3rAQN9V7./sej2lXOA7Y7Q5O', 'jamesss@gmail.com'),
(1032, 10008, 'Mr', 'Eddy', 'Zhen', '$2y$10$b7SWHoAcv5pCoba6RXIy1epYDAtSWiCg3wao4/BmCf2goOdH5xqYm', 'eddy123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

DROP TABLE IF EXISTS `Reviews`;
CREATE TABLE IF NOT EXISTS `Reviews` (
  `Review_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Rating` enum('1','2','3','4','5') NOT NULL,
  `bywhom` varchar(30) NOT NULL,
  PRIMARY KEY (`Review_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Reviews`
--

INSERT INTO `Reviews` (`Review_ID`, `Event_ID`, `User_ID`, `Description`, `Rating`, `bywhom`) VALUES
(6, 3032, 0, 'This was an Amazing EVENT. I highly recommend. ', '5', 'Adrian'),
(7, 3032, 0, 'Terrible event DO NOT RECOMMEND', '1', 'Eddy');

-- --------------------------------------------------------

--
-- Table structure for table `Tickets`
--

DROP TABLE IF EXISTS `Tickets`;
CREATE TABLE IF NOT EXISTS `Tickets` (
  `Ticket_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Event_ID` int(11) DEFAULT NULL,
  `Purchase_timedate` datetime NOT NULL,
  PRIMARY KEY (`Ticket_ID`),
  KEY `FK` (`Event_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9146 ;

--
-- Dumping data for table `Tickets`
--

INSERT INTO `Tickets` (`Ticket_ID`, `User_ID`, `Event_ID`, `Purchase_timedate`) VALUES
(9001, 1019, 3001, '0000-00-00 00:00:00'),
(9135, 1026, 3030, '2017-12-14 22:51:50'),
(9136, 1026, 3031, '2017-12-14 23:28:26'),
(9138, 1027, 3030, '2017-12-14 23:39:18'),
(9139, 1026, 3032, '2017-12-10 00:00:00'),
(9140, 1028, 3030, '2017-12-15 06:49:57'),
(9141, 1029, 3030, '2017-12-15 07:21:34'),
(9142, 1030, 3030, '2017-12-15 07:54:34'),
(9143, 1031, 3033, '2017-12-15 07:58:01'),
(9144, 1032, 3032, '2017-12-15 00:00:00'),
(9145, 1032, 3034, '2017-12-15 09:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `Venue`
--

DROP TABLE IF EXISTS `Venue`;
CREATE TABLE IF NOT EXISTS `Venue` (
  `Venue_ID` int(11) NOT NULL AUTO_INCREMENT,
  `AddressLine1` varchar(50) DEFAULT NULL,
  `City` varchar(30) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `Postal_Code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Venue_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4013 ;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`Venue_ID`, `AddressLine1`, `City`, `Country`, `Postal_Code`) VALUES
(4001, 'Gower St, Bloomsbury, London, UK', 'London', 'United Kingdom', 'WC1E 6BT'),
(4009, 'UCL', 'London', 'United Kingdom', 'NW8 9XT'),
(4010, 'Drayton House', 'London', 'United Kingdom', 'NW8 92T'),
(4011, '14613 Bar Harbor Rd', 'Fontana', 'USA', 'CA 92336'),
(4012, 'American Church', 'London', 'United Kingdom', '123 320');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
