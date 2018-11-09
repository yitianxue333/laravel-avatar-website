-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2018 at 01:42 AM
-- Server version: 5.6.39-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forge`
--

-- --------------------------------------------------------

--
-- Table structure for table `change_message`
--

CREATE TABLE IF NOT EXISTS `change_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `message` text,
  `send_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text,
  `last_name` text,
  `company` text,
  `use_company` int(1) DEFAULT '-1',
  `user_id` int(11) NOT NULL,
  `tag` text,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `first_name`, `last_name`, `company`, `use_company`, `user_id`, `tag`, `created_at`) VALUES
(1, 'first', 'client', 'Vladi Tech', -1, 2, NULL, '2018-03-16 07:49:00'),
(2, 'Dmitry', 'Stepan', 'Web Solution', -1, 37, NULL, '2018-03-16 10:16:00'),
(3, 'EDUARDO', 'MELCON', NULL, -1, 2, NULL, '2018-03-16 11:21:00'),
(4, 'EDUARDO', 'MELCON', NULL, -1, 2, NULL, '2018-03-16 11:25:00'),
(5, 'LEROY', 'L ROSS & LACARLA ROSS', NULL, 1, 2, NULL, '2018-03-16 11:42:00'),
(6, 'ROBIN', 'KORTE', NULL, -1, 2, NULL, '2018-03-16 11:53:00'),
(7, 'Piao', 'Men', 'ababab', 1, 63, NULL, '2018-03-20 05:47:00'),
(8, '1', '12', 'aaa', -1, 46, NULL, '2018-03-20 06:46:00'),
(9, 'first name', 'last name', 'company name', -1, 46, NULL, '2018-03-20 07:39:00'),
(10, 'n', 'a', 'WILLIAM  NEEL  & BARBARA NEEL', 1, 46, NULL, '2018-03-20 08:40:00'),
(11, 'CHRISTOPHER', 'D THOMPSON AND KAREN THOMPSON', NULL, -1, 46, NULL, '2018-03-20 08:41:00'),
(12, 'RYAN', '& AMY TIRONA', NULL, -1, 46, NULL, '2018-03-20 08:42:00'),
(13, 'VIVIANI', 'LIMA & ANTONIO LIMA', NULL, -1, 46, NULL, '2018-03-20 08:43:00'),
(14, 'WILLIAM', 'SANTNER', NULL, -1, 46, NULL, '2018-03-20 08:44:00'),
(15, 'Piao', 'Wen', NULL, -1, 66, NULL, '2018-03-20 12:01:00'),
(16, 'Piao', 'Men', NULL, 1, 69, NULL, '2018-03-20 14:03:00'),
(17, NULL, NULL, NULL, -1, 72, NULL, '2018-03-21 02:47:00'),
(18, NULL, NULL, NULL, 1, 72, NULL, '2018-03-21 02:48:00'),
(19, 'ISRAEL', 'SECUNDINO', NULL, -1, 46, NULL, '2018-03-21 06:22:00'),
(20, 'TERESITA', 'E CASTILLO', 'TERESITA E CASTILLO & JESUS CASTILLO', 1, 46, NULL, '2018-03-21 06:24:00'),
(21, 'CELIA', 'VACCA', NULL, -1, 64, NULL, '2018-03-21 07:14:00'),
(22, 'Ram', 'Laxman', NULL, -1, 46, NULL, '2018-03-21 07:31:00'),
(23, 'Pritesh', 'Bhadra', NULL, -1, 64, NULL, '2018-03-21 09:44:00'),
(24, 'P', 'Patel', 'Avatar', -1, 64, NULL, '2018-03-21 11:59:00'),
(25, 'John', 'Edmov', 'High Tech Solution', 1, 69, NULL, '2018-03-21 13:10:00'),
(26, 'JOHN', 'MATSON AND MARGARET SOMMERFELD', NULL, -1, 64, NULL, '2018-03-21 14:56:00'),
(27, 'JOHN', 'RAMDEEN', NULL, -1, 64, NULL, '2018-03-22 12:05:00'),
(28, 'CONNIE', 'W KAKLAMANOS', NULL, -1, 64, NULL, '2018-03-22 13:49:00'),
(29, 'DONALD', 'SANTO', NULL, -1, 64, NULL, '2018-03-23 10:19:00'),
(30, 'BRUCE', 'LAUGHRIDGE', NULL, -1, 64, NULL, '2018-03-23 10:22:00'),
(31, 'ORLANDO', 'PELAEZ OR ADA M DE ZAYAS PELAEZ', NULL, -1, 64, NULL, '2018-03-23 10:23:00'),
(32, 'ROBERTO', 'CONTI', NULL, -1, 64, NULL, '2018-03-23 10:24:00'),
(33, 'PROVIDENTIA', 'IGBOELUSI', NULL, -1, 64, NULL, '2018-03-23 10:25:00'),
(34, NULL, NULL, 'HAROLD R GREENBERG', 1, 64, NULL, '2018-03-23 10:25:00'),
(35, 'ANTHONY', 'DUMICICH AND GRAZIELLA DUMICICH', NULL, -1, 64, NULL, '2018-03-23 10:28:00'),
(36, 'SUSAN', 'JONES', NULL, -1, 64, NULL, '2018-03-23 12:05:00'),
(37, 'RUSSEL LITTLE AND WILMA', 'LITTLE', NULL, -1, 64, NULL, '2018-03-23 12:06:00'),
(38, 'EDWARD M', 'SEMANS AND BETTY J SEMANS', NULL, -1, 64, NULL, '2018-03-23 12:07:00'),
(39, NULL, NULL, 'JENNIE DOOLITTLE & Co.', 1, 64, NULL, '2018-03-23 12:08:00'),
(40, 'JUSTIN', 'WHITWORTH', NULL, -1, 64, NULL, '2018-03-23 12:09:00'),
(41, 'DENNIS L', 'DEIBERT', NULL, -1, 64, NULL, '2018-03-23 12:11:00'),
(42, 'BRUCE', 'LAUGHRIDGE', NULL, -1, 64, NULL, '2018-03-23 12:13:00'),
(43, NULL, NULL, 'ORLANDO  PELAEZ & CO', 1, 64, NULL, '2018-03-23 12:14:00'),
(44, 'EDWARD', 'SCOPPA AND DANIELLE LAPOINTE', NULL, -1, 64, NULL, '2018-03-23 12:15:00'),
(45, 'HAROLD R', 'GREENBERG', NULL, -1, 64, NULL, '2018-03-23 12:18:00'),
(46, 'LISA', 'BOCOCK', NULL, -1, 64, NULL, '2018-03-23 12:18:00'),
(47, 'JOE', 'WILCHER', NULL, -1, 64, NULL, '2018-03-23 12:19:00'),
(48, 'KAREN A', 'SHERWOOD', NULL, -1, 64, NULL, '2018-03-23 12:20:00'),
(49, 'WILLIAM', 'SHERMAN', NULL, -1, 64, NULL, '2018-03-23 12:20:00'),
(50, 'DAVID  WILSON & PAMELA', 'WILSON', NULL, -1, 64, NULL, '2018-03-23 12:21:00'),
(51, NULL, NULL, 'KATHLEEN L ROEBER & CO', 1, 64, NULL, '2018-03-23 12:23:00'),
(52, 'Asdf', 'Asdf', 'Asdf', 0, 42, NULL, '2018-03-24 17:50:12'),
(53, 'walter', 'nosy', 'monter', -1, 87, NULL, '2018-03-26 07:16:00'),
(54, 'WATSON', 'DESME AND RINA DESME', NULL, -1, 64, NULL, '2018-03-26 08:24:00'),
(55, 'DAVID  STRINGFELLOW & SARA', 'TINDALE', NULL, -1, 64, NULL, '2018-03-26 08:26:00'),
(56, 'S G', 'Parikh', NULL, -1, 64, NULL, '2018-03-27 06:58:00'),
(57, 'H', 'Shah', NULL, -1, 64, NULL, '2018-03-28 12:28:00'),
(58, 'Dmitry', 'Stepan', 'Web Solution', -1, 69, NULL, '2018-03-29 04:16:00'),
(59, 'MARY', 'MEDEIROS & DIONISIO MEDEIROS', NULL, -1, 64, NULL, '2018-03-29 10:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `clients_contact`
--

CREATE TABLE IF NOT EXISTS `clients_contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `type` int(1) DEFAULT '1',
  `option` int(11) NOT NULL,
  `value` text,
  `is_primary` int(1) DEFAULT '-1',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `clients_contact`
--

INSERT INTO `clients_contact` (`contact_id`, `client_id`, `type`, `option`, `value`, `is_primary`) VALUES
(4, 1, 1, 1, '1232', 1),
(5, 1, 2, 1, 'test@test.com', 1),
(6, 2, 1, 1, '123456789', 1),
(7, 2, 2, 1, 'dragonfire.0827@gmail.com', 1),
(8, 3, 1, 1, '(813) 872-8481', -1),
(9, 3, 2, 1, 'ALLISON@FERNANDEZINS.COM', -1),
(10, 4, 1, 1, '(407) 447-2204', -1),
(11, 4, 2, 1, 'ALLISON@FERNANDEZINS.COM', -1),
(12, 5, 1, 1, '(813) 685-7731', -1),
(13, 5, 2, 1, 'TOMO@ODIORNEINSURANCE.COM', 1),
(14, 6, 1, 1, '(239) 591-0963', -1),
(15, 6, 2, 1, 'ro@ro.com', 1),
(16, 7, 1, 1, '123456789', 1),
(17, 7, 2, 1, 'client1@ok.com', 1),
(18, 10, 1, 1, '(954) 281-7080', -1),
(19, 10, 2, 1, 'christir@john-galt.com', -1),
(20, 11, 1, 1, '(813) 982-4077', -1),
(21, 11, 2, 1, 'GENA.SWANSON@GREATFLORIDA.COM', -1),
(22, 12, 1, 1, '(813) 641-8331', -1),
(23, 12, 2, 1, 'cheryldeleon@live.com', -1),
(24, 13, 1, 1, '(954) 420-9051', -1),
(25, 13, 2, 1, 'PROSA@FREEUNIVERSALQUOTES.COM', -1),
(26, 14, 1, 1, '(954) 581-7740', -1),
(27, 14, 2, 1, 'INFO@rickgibbspa.com', -1),
(28, 15, 1, 1, '123456789', 1),
(29, 15, 2, 1, 'abcd@ok.com', 1),
(30, 16, 1, 1, '12345679', 1),
(31, 16, 2, 1, 'aa@aa.com', 1),
(32, 19, 1, 1, '(813) 999-2113', -1),
(33, 19, 2, 1, 'ra@se.com', -1),
(34, 20, 1, 1, '(813) 605-8010', -1),
(35, 20, 2, 1, 'MG.INSURANCE.AGENT@GMAIL.COM', -1),
(36, 21, 1, 1, '(813) 465-7939', -1),
(37, 21, 2, 1, 'ce@va.com', 1),
(38, 22, 1, 1, '9155447788', -1),
(39, 22, 2, 1, 'rm@la.com', -1),
(40, 24, 1, 1, '8135140333', 1),
(41, 25, 1, 1, '+79147115735', 1),
(42, 25, 2, 1, 'client1@client.com', 1),
(43, 26, 1, 1, '(813) 514-0333', -1),
(44, 26, 2, 1, 'cCAROLE@AVATARINS.COM', -1),
(45, 27, 1, 1, '1(941) 758-4600', -1),
(46, 27, 2, 1, 'sssley@academyins.net', -1),
(47, 28, 1, 1, '(727) 392-1090', -1),
(48, 28, 2, 1, 'ppam@harborstarins.com', -1),
(49, 29, 1, 1, '(727) 377-10000', -1),
(50, 29, 2, 1, 'CSR@wwwWEINSUREFL.COM', -1),
(51, 30, 1, 1, '(813) 6-9660', -1),
(52, 30, 2, 1, 'RDAWSON@SDAWSONINSURANCE.COM', -1),
(53, 31, 1, 1, '(813)-4331', -1),
(54, 31, 2, 1, 'edda@odfaithis.com', -1),
(55, 32, 1, 1, '(239) 774-9010', -1),
(56, 32, 2, 1, 'FILDA@GMAIL.COM', -1),
(57, 34, 1, 1, '(813) 88363', -1),
(58, 34, 2, 1, 'N@CHARLIES-AGENTS.COM', -1),
(59, 36, 1, 1, '(813) 4-0150', -1),
(60, 36, 2, 1, 'm@haborstarins.com', -1),
(61, 37, 1, 1, '(727) 32-5559', -1),
(62, 37, 2, 1, 'CT@W2INSURE.COM', 1),
(63, 38, 1, 1, '(813) 72-4100', -1),
(64, 38, 2, 1, 'larry@landmioup.com', -1),
(65, 39, 1, 1, '(727) 7-1495', -1),
(66, 39, 2, 1, 'CL.GYXD@STATEFARM.COM', -1),
(67, 40, 1, 1, '(813) 78-1465', -1),
(68, 40, 2, 1, 'D@SARM.COM', -1),
(69, 41, 1, 1, '(813) 2-4191', -1),
(70, 41, 2, 1, 'info@elre.com', -1),
(71, 42, 1, 1, '(813) 1-9660', -1),
(72, 42, 2, 1, 'RN@WATTSDAWRANCE.COM', 1),
(73, 43, 1, 1, '(813) 345-431', -1),
(74, 43, 2, 1, 'da@dfaithis.com', -1),
(75, 44, 1, 1, '(813) 374-0150', -1),
(76, 44, 2, 1, 'SIO@AURANCE.ORG', -1),
(77, 45, 1, 1, '(813) 1-8363', -1),
(78, 45, 2, 1, 'I@CHARLITS.COM', -1),
(79, 46, 1, 1, '(813) 200-8454', -1),
(80, 46, 2, 1, 'AN@BLKINS.COM', -1),
(81, 47, 1, 1, '(561) 471-13', -1),
(82, 47, 2, 1, 'corrdence@insuranceexpress.com', -1),
(83, 48, 1, 1, '(813) 94-7765', -1),
(84, 48, 2, 1, 'BRIAN@ABCDENNISINSURANCE.COM', 1),
(85, 49, 1, 1, '(561) 1-9813', -1),
(86, 49, 2, 1, 'spondence@insuexpress.com', -1),
(87, 50, 1, 1, '(727) 736-229', -1),
(88, 50, 2, 1, 'k@naclerioagency.com', -1),
(89, 51, 1, 1, '(813) 5-7731', -1),
(90, 51, 2, 1, 'INFO@oeinsurance.com', -1),
(91, 52, 1, 1, 'asdf', 1),
(92, 53, 1, 1, '1231241422', -1),
(93, 54, 1, 1, '(813) 3-0150', -1),
(94, 54, 2, 1, 'SAGY@AL.COM', -1),
(95, 55, 1, 1, '(813) 5-0333', -1),
(96, 55, 2, 1, 'CE@AVNS.COM', -1),
(97, 57, 1, 1, '2323232323', -1),
(98, 57, 2, 1, 'h@sh.com', -1),
(107, 58, 1, 1, '123456789', -1),
(108, 58, 2, 1, 'dragonfire.0827@gmail.com', -1),
(109, 59, 1, 1, '5656565656', -1),
(110, 59, 2, 1, 'ma@me.com', -1);

-- --------------------------------------------------------

--
-- Table structure for table `clients_login`
--

CREATE TABLE IF NOT EXISTS `clients_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `password` text,
  `logged_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients_properties`
--

CREATE TABLE IF NOT EXISTS `clients_properties` (
  `property_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `street1` text,
  `street2` text,
  `city` text,
  `state` text,
  `zip_code` text,
  `country` text,
  `type` int(1) NOT NULL DEFAULT '1',
  `tax` double(10,2) DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=180 ;

--
-- Dumping data for table `clients_properties`
--

INSERT INTO `clients_properties` (`property_id`, `client_id`, `street1`, `street2`, `city`, `state`, `zip_code`, `country`, `type`, `tax`, `longitude`, `latitude`) VALUES
(62, 1, 'street 1', 'Hong Kong', 'Schenectady', 'state', '12345', 'United States', 1, 0.20, NULL, NULL),
(63, 1, 'street 1', 'Hong Kong', 'Schenectady', 'state', '12345', 'United States', -1, 0.20, NULL, NULL),
(64, 2, 'Prospekt 100-Letiya Vladivostoky', NULL, 'Zaporizhzhia', 'Primorskiy kray', '69000', 'Russia', 1, NULL, 131.907044, 43.15902),
(65, 2, 'Prospekt 100-Letiya Vladivostoky', NULL, 'Zaporizhzhia', 'Primorskiy kray', '69000', 'Ukraine', -1, NULL, NULL, NULL),
(66, 3, '3121  W PARIS ST', 'HILLSBOROUGH', 'Tampa', 'Florida', '33614', 'United States', 1, 0.20, -82.4951779, 28.0032179),
(67, 3, '3121  W PARIS ST', 'HILLSBOROUGH', 'Tampa', 'Florida', '33614', 'United States', -1, 0.20, NULL, NULL),
(68, 4, '3121  W PARIS ST', 'HILLSBOROUGH', 'Tampa', NULL, '33614', 'United States', 1, 0.20, -82.4951779, 28.003221),
(69, 4, '3121  W PARIS ST', 'HILLSBOROUGH', 'Tampa', NULL, '33614', 'United States', -1, 0.20, NULL, NULL),
(70, 5, '611 WIGGINS CT', 'HILLSBOROUGH', 'Plant City', 'Florida', '33563', 'United States', 1, 0.20, NULL, NULL),
(71, 5, '605 WIGGINS CT', 'HILLSBOROUGH', 'Plant City', 'Florida', '33563', 'United States', -1, 0.20, NULL, NULL),
(72, 6, '3079 POINCIANA DR', 'COLLIER', 'Naples', 'Florida', '34105', 'United States', 1, 0.20, -81.77009319999999, 26.1895881),
(73, 6, '3079 POINCIANA DR', 'COLLIER', 'Naples', 'Florida', '34105', 'United States', -1, 0.20, NULL, NULL),
(74, 7, '789 Guanghua Rd', 'China', 'Yanji Shi', 'Yanbian', NULL, 'China', 1, NULL, 129.511579, 42.892101),
(75, 7, '789 Guanghua Rd', 'China', 'Yanji Shi', 'Yanbian', NULL, 'China', -1, NULL, NULL, NULL),
(76, 8, 'asf', 'Hong Kong', 'Wong Nai Tau (Sha Tin)', NULL, NULL, 'Hong Kong', 1, NULL, NULL, NULL),
(77, 8, 'asf', 'Hong Kong', 'Wong Nai Tau (Sha Tin)', NULL, NULL, 'Hong Kong', -1, NULL, NULL, NULL),
(78, 9, 'street1', 'Hong Kong', 'Wong Nai Tau (Sha Tin)', NULL, NULL, 'Hong Kong', 1, NULL, 114.206369, 22.390949),
(79, 9, 'street1', 'Hong Kong', 'Wong Nai Tau (Sha Tin)', NULL, NULL, 'Hong Kong', -1, NULL, NULL, NULL),
(80, 10, '21380 SONESTA WAY', 'PALM BEACH', 'Boca Raton', 'Florida', '33433', 'United States', 1, NULL, NULL, NULL),
(81, 10, '21381 SONESTA WAY', 'PALM BEACH', 'Boca Raton', 'Florida', '33433', 'United States', -1, NULL, NULL, NULL),
(82, 11, '916 SILVER RIDGE  WAY', 'HILLSBOROUGH', 'Valrico', 'Florida', '33594', 'United States', 1, NULL, NULL, NULL),
(83, 11, '916 SILVER RIDGE  WAY', 'HILLSBOROUGH', 'Valrico', 'Florida', '33594', 'United States', -1, NULL, NULL, NULL),
(84, 12, '11259 CREEK HAVEN DR', 'HILLSBOROUGH', 'Riverview', 'Florida', '33569', 'United States', 1, NULL, -82.30777379999999, 27.8366599),
(85, 12, '11259 CREEK HAVEN DR', 'HILLSBOROUGH', 'Riverview', 'Florida', '33569', 'United States', -1, NULL, NULL, NULL),
(86, 13, '21577 GUADALAJARA AVE', 'PALM BEACH', 'Boca Raton', 'Florida', '33433', 'United States', 1, NULL, -80.1522565, 26.3563161),
(87, 13, '21577 GUADALAJARA AVE', 'PALM BEACH', 'Boca Raton', 'Florida', '33433', 'United States', -1, NULL, NULL, NULL),
(88, 14, 'dongcheng', NULL, 'Beijing', NULL, NULL, 'China', 1, NULL, 116.416357, 39.928353),
(89, 14, '3433 SANDS HARBOR TRCE', 'BROWARD', 'Pompano Beach', 'Florida', '33069', 'United States', -1, NULL, NULL, NULL),
(90, 15, 'ul. Makovskogo, 290', NULL, 'Vladivostok', 'Primorskiy kray', '690024', 'Russia', 1, NULL, 132.080218, 43.279978),
(91, 15, '789 Guanghua Rd', 'China', 'Yanji Shi', 'Yanbian', NULL, 'China', -1, NULL, NULL, NULL),
(92, 16, 'Zarechnaya Ulitsa, 37', 'Russia', 'Vladivostok', 'Primorskiy kray', '690000', 'Russia', 1, NULL, 132.073027, 43.28354),
(93, 16, 'Zarechnaya Ulitsa, 37', 'Russia', 'Los Angeles', 'Primorskiy kray', '690000', 'Russia', -1, NULL, NULL, NULL),
(94, 17, 'asd', 'United States', 'Los Angeles', NULL, NULL, 'United States', 1, NULL, NULL, NULL),
(95, 17, 'asd', 'United States', 'Los Angeles', NULL, NULL, 'United States', -1, NULL, NULL, NULL),
(96, 18, 'asd', 'United States', 'Los Angeles', NULL, NULL, 'United States', 1, NULL, -118.3683401, 34.0608797),
(97, 18, 'asd', 'United States', 'Los Angeles', NULL, NULL, 'United States', -1, NULL, NULL, NULL),
(98, 19, '1965 KINGS HWY', 'PINELLAS', 'Clearwater', 'Florida', '33755', 'United States', 1, NULL, -82.7793531, 27.9933292),
(99, 19, '1965 KINGS HWY', 'PINELLAS', 'Clearwater', 'Florida', '33755', 'United States', -1, NULL, NULL, NULL),
(100, 20, '7114  N TAMPANIA AVE', 'HILLSBOROUGH', 'Tampa', 'Florida', '33614', 'United States', 1, NULL, -82.48688779999999, 28.013406),
(101, 20, '7114  N TAMPANIA AVE', 'HILLSBOROUGH', 'Tampa', 'Florida', '33614', 'United States', -1, NULL, NULL, NULL),
(102, 21, '1301 SW 11TH AVE', 'LEE', 'Cape Coral', 'Florida', '33991', 'United States', 1, NULL, -81.9970895, 26.6279128),
(103, 21, '5119  SPRINGWOOD  DR', 'HILLSBOROUGH', 'Tampa', 'Florida', '33624', 'United States', -1, NULL, NULL, NULL),
(104, 22, '231, Dr. D. N. Road', 'Fort', 'Mumbai', 'Maharashtra', '400001', 'India', 1, NULL, 85.3154296875, 27.722778798571326),
(105, 22, '231, Dr. D. N. Road', 'Fort', 'Mumbai', 'Maharashtra', '400001', 'India', -1, NULL, NULL, NULL),
(106, 23, '1101 E Cumberland Avenue', 'USA', 'Tampa', 'FL', '33602', 'USA', 1, NULL, -82.4480713, 27.9447103),
(107, 23, '1101 E Cumberland Avenue', 'USA', 'Tampa', 'FL', '33602', 'USA', -1, NULL, NULL, NULL),
(108, 24, '1101 E Cumberland Ave', 'United States', 'Tampa', 'fl', '33602', 'United States', 1, NULL, -82.4480713, 27.9447103),
(109, 24, '1101 E Cumberland Ave', 'United States', 'Tampa', 'fl', '33602', 'United States', -1, NULL, NULL, NULL),
(110, 25, '2501 se snapper st', NULL, 'Port St. Lucie', 'FL', '34952', 'United States', 1, NULL, -80.31412929999999, 27.2674358),
(111, 25, '2501 se snapper st', NULL, 'Port St. Lucie', 'FL', '34952', 'United States', -1, NULL, NULL, NULL),
(112, 26, '3197 WINDRUSH BOURNE #35', 'SARASOTA', 'Sarasota', 'Florida', '34235', 'United States', 1, NULL, NULL, NULL),
(113, 26, '3197 WINDRUSH BOURNE #35', 'SARASOTA', 'Sarasota', 'Florida', '34235', 'United States', -1, NULL, NULL, NULL),
(114, 27, '6048 24TH AVE N', 'PINELLAS', 'Saint Petersburg', 'Florida', '33710', 'United States', 1, NULL, NULL, NULL),
(115, 27, '6048 24TH AVE N', 'PINELLAS', 'Saint Petersburg', 'Florida', '33710', 'United States', -1, NULL, NULL, NULL),
(116, 28, '2725 ASHWOOD CT', 'PINELLAS', 'CLEARWATER', 'florida', '33761', 'USA', 1, NULL, -82.7201698, 28.0206891),
(117, 28, '2725 ASHWOOD CT', 'PINELLAS', 'CLEARWATER', 'florida', '33761', 'USA', -1, NULL, NULL, NULL),
(118, 29, '2582 FOREST RUN CT #105', 'PINELLAS', 'Clearwater', 'Florida', '33761', 'United States', 1, NULL, -82.72611100000002, 28.015113),
(119, 29, '2582 FOREST RUN CT #105', 'PINELLAS', 'Clearwater', 'Florida', '33761', 'United States', -1, NULL, NULL, NULL),
(120, 30, '3501 S DREXEL AVE', 'HILLSBOROUGH', 'Tampa', 'Florida', '33629', 'United States', 1, NULL, -82.49780009999999, 27.9111109),
(121, 30, '3501 S DREXEL AVE', 'HILLSBOROUGH', 'Tampa', 'Florida', '33629', 'United States', -1, NULL, NULL, NULL),
(122, 31, '12202 RAMBLING STREAM DR', 'HILLSBOROUGH', 'Riverview', 'Florida', '33569', 'United States', 1, NULL, -82.32007109999999, 27.8218728),
(123, 31, '12202 RAMBLING STREAM DR', 'HILLSBOROUGH', 'Riverview', 'Florida', '33569', 'United States', -1, NULL, NULL, NULL),
(124, 32, '437 FOREST HILLS BLVD', 'COLLIER', 'Naples', 'Florida', '34113', 'United States', 1, NULL, NULL, NULL),
(125, 32, '437 FOREST HILLS BLVD', 'COLLIER', 'Naples', 'Florida', '34113', 'United States', -1, NULL, NULL, NULL),
(126, 33, '251 MAISON GRANDE AVE', 'LEE', 'Lehigh Acres', 'Florida', '33936', 'United States', 1, NULL, NULL, NULL),
(127, 33, '251 MAISON GRANDE AVE', 'LEE', 'Lehigh Acres', 'Florida', '33936', 'United States', -1, NULL, NULL, NULL),
(128, 34, '6819 GUILFORD BRIDGE DR', 'HILLSBOROUGH', 'Apollo Beach', 'Florida', '33572', 'United States', 1, NULL, NULL, NULL),
(129, 34, '6819 GUILFORD BRIDGE DR', 'HILLSBOROUGH', 'Apollo Beach', 'Florida', '33572', 'United States', -1, NULL, NULL, NULL),
(130, 35, '3806 HOLLOW WOOD DR', 'HILLSBOROUGH', 'Valrico', 'Florida', '33596', 'United States', 1, NULL, NULL, NULL),
(131, 35, '3806 HOLLOW WOOD DR', 'HILLSBOROUGH', 'Valrico', 'Florida', '33596', 'United States', -1, NULL, NULL, NULL),
(132, 36, '602 ROSIER RD', 'HILLSBOROUGH', 'Brandon', 'Florida', '33510', 'United States', 1, NULL, -82.29324749999999, 27.956371),
(133, 36, '602 ROSIER RD', 'HILLSBOROUGH', 'Brandon', 'Florida', '33510', 'United States', -1, NULL, NULL, NULL),
(134, 37, '4919 SANDPOINTE DR', 'PASCO', 'New Port Richey', 'Florida', '34655', 'United States', 1, NULL, -82.6502814, 28.2306844),
(135, 37, '4919 SANDPOINTE DR', 'PASCO', 'New Port Richey', 'Florida', '34655', 'United States', -1, NULL, NULL, NULL),
(136, 38, '1516 DISTANT OAKS DR', 'PASCO', 'Wesley Chapel', 'Florida', '33543', 'United States', 1, NULL, NULL, NULL),
(137, 38, '1516 DISTANT OAKS DR', 'PASCO', 'Wesley Chapel', 'Florida', '33543', 'United States', -1, NULL, NULL, NULL),
(138, 39, '2788 61ST WAY  N', 'PINELLAS', 'Saint Petersburg', 'Florida', '33710', 'United States', 1, NULL, NULL, NULL),
(139, 39, '2788 61ST WAY  N', 'PINELLAS', 'Saint Petersburg', 'Florida', '33710', 'United States', -1, NULL, NULL, NULL),
(140, 40, '40230 SUNBURST DR', 'PASCO', 'Dade City', 'Florida', '33525', 'United States', 1, NULL, NULL, NULL),
(141, 40, '40230 SUNBURST DR', 'PASCO', 'Dade City', 'Florida', '33525', 'United States', -1, NULL, NULL, NULL),
(142, 41, '8315 W ELM ST', 'HILLSBOROUGH', 'Tampa', 'Florida', '33615', 'United States', 1, NULL, NULL, NULL),
(143, 41, '1411 SE 35TH ST', 'LEE', 'Cape Coral', 'Florida', '33904', 'United States', -1, NULL, NULL, NULL),
(144, 42, '3501 S DREXEL AVE', 'HILLSBOROUGH', 'Tampa', 'Florida', '33629', 'United States', 1, NULL, -82.49780009999999, 27.9111109),
(145, 42, '3501 S DREXEL AVE', 'HILLSBOROUGH', 'Tampa', 'Florida', '33629', 'United States', -1, NULL, NULL, NULL),
(146, 43, '12202 RAMBLING STREAM DR', 'HILLSBOROUGH', 'Riverview', 'Florida', '33569', 'United States', 1, NULL, NULL, NULL),
(147, 43, '12202 RAMBLING STREAM DR', 'HILLSBOROUGH', 'Riverview', 'Florida', '33569', 'United States', -1, NULL, NULL, NULL),
(148, 44, '15915 NORTHLAKE VILLAGE DR', 'HILLSBOROUGH', 'Odessa', 'Florida', '33556', 'United States', 1, NULL, -82.6002618, 28.0992902),
(149, 44, '15915 NORTHLAKE VILLAGE DR', 'HILLSBOROUGH', 'Odessa', 'Florida', '33556', 'United States', -1, NULL, NULL, NULL),
(150, 45, '6819 GUILFORD BRIDGE DR', 'HILLSBOROUGH', 'Apollo Beach', 'Florida', '33572', 'United States', 1, NULL, NULL, NULL),
(151, 45, '20647 NE 8TH PL', 'MIAMI-DADE', 'Miami', 'Florida', '33179', 'United States', -1, NULL, NULL, NULL),
(152, 46, '18534 WISTERIA RD', 'LEE', 'Fort Myers', 'Florida', '33967', 'United States', 1, NULL, NULL, NULL),
(153, 46, '18534 WISTERIA RD', 'LEE', 'Fort Myers', 'Florida', '33967', 'United States', -1, NULL, NULL, NULL),
(154, 47, '4610 W BALLAST POINT BLVD', 'HILLSBOROUGH', 'Tampa', 'Florida', '33611', 'United States', 1, NULL, -82.5237159, 27.8893434),
(155, 47, '4610 W BALLAST POINT BLVD', 'HILLSBOROUGH', 'Tampa', 'Florida', '33611', 'United States', -1, NULL, NULL, NULL),
(156, 48, '1846   KETTLER DR', 'PASCO', 'Lutz', 'Florida', '33559', 'United States', 1, NULL, -82.40345529999999, 28.1840689),
(157, 48, '1846   KETTLER DR', 'PASCO', 'Lutz', 'Florida', '33559', 'United States', -1, NULL, NULL, NULL),
(158, 49, '2191 SW CONGRESS BLVD', 'PALM BEACH', 'Boynton Beach', 'Florida', '33426', 'United States', 1, NULL, NULL, NULL),
(159, 49, '2191 SW CONGRESS BLVD', 'PALM BEACH', 'Boynton Beach', 'Florida', '33426', 'United States', -1, NULL, NULL, NULL),
(160, 50, '518 STILL MEADOWS CIR W', 'PINELLAS', 'Palm Harbor', 'Florida', '34683', 'United States', 1, NULL, -82.7470934, 28.0727917),
(161, 50, '518 STILL MEADOWS CIR W', 'PINELLAS', 'Palm Harbor', 'Florida', '34683', 'United States', -1, NULL, NULL, NULL),
(162, 51, '1932 CROWN PARK DR', 'HILLSBOROUGH', 'Valrico', 'Florida', '33594', 'United States', 1, NULL, NULL, NULL),
(163, 51, '1307 S SHANNON AVE', 'BREVARD', 'Indialantic', 'Florida', '32903', 'United States', -1, NULL, NULL, NULL),
(164, 52, 'Asdf', 'Asdf', NULL, NULL, NULL, 'united states', 1, 0.00, NULL, NULL),
(165, 52, 'Asdf', 'Asdf', NULL, NULL, NULL, 'united states', -1, 0.00, NULL, NULL),
(166, 53, 'Arlington', 'United States', 'Arlington', NULL, NULL, 'United States', 1, NULL, -77.09098089999999, 38.8816208),
(167, 53, 'Arlington', 'United States', 'Arlington', NULL, NULL, 'United States', -1, NULL, NULL, NULL),
(168, 54, '23211 BAYOU GROVE ST', 'PASCO', 'Land O Lakes', 'Florida', '34639', 'United States', 1, NULL, -82.43214019999999, 28.2063884),
(169, 54, '23211 BAYOU GROVE ST', 'PASCO', 'Land O Lakes', 'Florida', '34639', 'United States', -1, NULL, NULL, NULL),
(170, 55, '14730  OAK VINE DR.', 'HILLSBOROUGH', 'Lutz', 'Florida', '33559', 'United States', 1, NULL, -82.424455, 28.084099),
(171, 55, '14730  OAK VINE DR.', 'HILLSBOROUGH', 'Lutz', 'Florida', '33559', 'United States', -1, NULL, NULL, NULL),
(172, 56, 'Opp. Lodha Heaven, Kalyan Shil Road', 'Dombivali East', 'Kalyan', 'Maharashtra', '421204', 'India', 1, NULL, 72.8342862, 18.9374053),
(173, 56, '231, Dr. D. N. Road', 'Fort', 'Mumbai', 'Maharashtra', NULL, 'India', -1, NULL, NULL, NULL),
(174, 57, '22, Bazar Gate Street', 'Fort', 'Mumbai', 'Maharashtra', '400001', 'India', 1, NULL, 72.8357765, 18.9379467),
(175, 57, '22, Bazar Gate Street', 'Fort', 'Mumbai', 'Maharashtra', '40000', 'India', -1, NULL, NULL, NULL),
(176, 58, 'Ulitsa Ovchinnikova, 52', NULL, 'Vladivostok', 'Primorskiy kray', '690048', NULL, 1, NULL, 131.9095387, 43.1555778),
(177, 58, 'Ulitsa Ovchinnikova, 52', 'Ukraine', 'Vladivostok', 'Primorskiy kray', '69004', 'Ukraine', -1, NULL, NULL, NULL),
(178, 59, '1129 CLIPPERS WAY', 'PINELLAS', 'Tarpon Springs', 'Florida', '34689', 'United States', 1, NULL, -82.77164499999999, 28.1336871),
(179, 59, '1129 CLIPPERS WAY', 'PINELLAS', 'Tarpon Springs', 'Florida', '34689', 'United States', -1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_attachments`
--

CREATE TABLE IF NOT EXISTS `client_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_check` int(1) DEFAULT '-1',
  `job_check` int(1) DEFAULT '-1',
  `invoice_check` int(1) DEFAULT '-1',
  `alias` text NOT NULL,
  `path` text NOT NULL,
  `note` text,
  `created_at` text,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `completes`
--

CREATE TABLE IF NOT EXISTS `completes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `completed_id` int(10) DEFAULT NULL,
  `completed_type` varchar(20) DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `closed_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `note` text,
  `allday` int(10) DEFAULT '-1',
  `repeat` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `client_id` int(10) DEFAULT NULL,
  `member_id` varchar(20) DEFAULT NULL,
  `is_completed` int(1) DEFAULT '-1',
  `completed_by` int(10) DEFAULT NULL,
  `completed_at` date DEFAULT NULL,
  `property_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text,
  `client_message` text,
  `discount` double(10,2) DEFAULT NULL,
  `discount_percent` int(1) DEFAULT '1',
  `tax` double(10,2) DEFAULT NULL,
  `deposit` double(10,2) DEFAULT NULL,
  `deposit_percent` int(1) DEFAULT '1',
  `job_ids` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `issue_date` date DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `pay_due_type` int(11) DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `sendmail_date` date DEFAULT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `client_id`, `property_id`, `user_id`, `description`, `client_message`, `discount`, `discount_percent`, `tax`, `deposit`, `deposit_percent`, `job_ids`, `status`, `issue_date`, `payment_date`, `pay_due_type`, `created_at`, `received_date`, `sendmail_date`) VALUES
(4, 1, 62, 2, 'For Services Rendered', NULL, 0.00, 1, 0.20, 0.00, 1, '', 3, '2018-03-16', NULL, 3, '2018-03-16', NULL, '2018-03-16'),
(5, 1, 62, 2, 'For Services Rendered', NULL, 0.00, 1, 0.20, 0.00, 1, '', 3, '2018-03-16', '2018-04-15', 3, '2018-03-16', '2018-03-16', '2018-03-16'),
(6, 8, 76, 46, 'For Services Rendered', NULL, 0.00, 1, 0.00, 0.00, 1, '', 1, NULL, NULL, 3, '2018-03-20', NULL, NULL),
(7, 25, 110, 69, 'For Services Rendered', NULL, 0.00, 1, 0.00, 0.00, 1, '', 1, NULL, NULL, 3, '2018-03-24', NULL, NULL),
(8, 53, 166, 87, 'For Services Rendered', NULL, 21.00, 1, 0.00, 9.00, 2, '50', 3, '2018-03-26', NULL, 4, '2018-03-26', NULL, '2018-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `invoices_attachments`
--

CREATE TABLE IF NOT EXISTS `invoices_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `note` text,
  `alias` text NOT NULL,
  `path` text NOT NULL,
  `created_at` text NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices_services`
--

CREATE TABLE IF NOT EXISTS `invoices_services` (
  `invoice_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_name` text,
  `service_description` text,
  `quantity` int(11) DEFAULT NULL,
  `cost` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`invoice_service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `invoices_services`
--

INSERT INTO `invoices_services` (`invoice_service_id`, `invoice_id`, `service_id`, `service_name`, `service_description`, `quantity`, `cost`) VALUES
(5, 4, NULL, NULL, NULL, 1, 0.00),
(6, 5, 0, NULL, NULL, 1, 23.00),
(7, 6, NULL, 'aaa', 'a', 111, 120.00),
(8, 7, NULL, 'Test', NULL, 1, 50.00),
(9, 8, 6, 'walter podolsky', 'service2', 1, 320.00),
(10, 8, 5, 'walter podolsky', 'sevice1', 1, 130.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_reminder`
--

CREATE TABLE IF NOT EXISTS `invoice_reminder` (
  `invoice_reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `details` varchar(250) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `member_id` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`invoice_reminder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `invoice_reminder`
--

INSERT INTO `invoice_reminder` (`invoice_reminder_id`, `job_id`, `details`, `start_date`, `end_date`, `start_time`, `end_time`, `member_id`) VALUES
(1, 36, 'This is your periodic reminder to invoice for job #36.', '2018-03-31', '2018-03-31', NULL, NULL, NULL),
(10, 76, 'This is your periodic reminder to invoice for job #76.', '2018-03-31', '2018-03-31', NULL, NULL, NULL),
(11, 76, 'This is your periodic reminder to invoice for job #76.', '2018-04-30', '2018-04-30', NULL, NULL, NULL),
(12, 76, 'This is your periodic reminder to invoice for job #76.', '2018-05-31', '2018-05-31', NULL, NULL, NULL),
(13, 77, 'This is your periodic reminder to invoice for job #77.', '2018-03-31', '2018-03-31', NULL, NULL, NULL),
(14, 77, 'This is your periodic reminder to invoice for job #77.', '2018-04-30', '2018-04-30', NULL, NULL, NULL),
(15, 78, 'This is your periodic reminder to invoice for job #78.', '2018-03-31', '2018-03-31', NULL, NULL, NULL),
(16, 78, 'This is your periodic reminder to invoice for job #78.', '2018-04-30', '2018-04-30', NULL, NULL, NULL),
(17, 79, 'This is your periodic reminder to invoice for job #79.', '2018-04-30', '2018-04-30', NULL, NULL, NULL),
(18, 79, 'This is your periodic reminder to invoice for job #79.', '2018-05-31', '2018-05-31', NULL, NULL, NULL),
(19, 79, 'This is your periodic reminder to invoice for job #79.', '2018-06-30', '2018-06-30', NULL, NULL, NULL),
(20, 79, 'This is your periodic reminder to invoice for job #79.', '2018-07-31', '2018-07-31', NULL, NULL, NULL),
(21, 79, 'This is your periodic reminder to invoice for job #79.', '2018-08-31', '2018-08-31', NULL, NULL, NULL),
(22, 79, 'This is your periodic reminder to invoice for job #79.', '2018-09-30', '2018-09-30', NULL, NULL, NULL),
(23, 79, 'This is your periodic reminder to invoice for job #79.', '2018-10-31', '2018-10-31', NULL, NULL, NULL),
(24, 80, 'This is your periodic reminder to invoice for job #80.', '2018-05-31', '2018-05-31', NULL, NULL, NULL),
(25, 80, 'This is your periodic reminder to invoice for job #80.', '2018-06-30', '2018-06-30', NULL, NULL, NULL),
(26, 80, 'This is your periodic reminder to invoice for job #80.', '2018-07-31', '2018-07-31', NULL, NULL, NULL),
(27, 80, 'This is your periodic reminder to invoice for job #80.', '2018-08-31', '2018-08-31', NULL, NULL, NULL),
(28, 73, 'This is your periodic reminder to invoice for job #73.', '2018-03-31', '2018-03-31', NULL, NULL, NULL),
(29, 73, 'This is your periodic reminder to invoice for job #73.', '2018-05-31', '2018-05-31', NULL, NULL, NULL),
(30, 75, 'This is your periodic reminder to invoice for job #75.', '2018-03-31', '2018-03-31', NULL, NULL, NULL),
(31, 75, 'This is your periodic reminder to invoice for job #75.', '2018-05-31', '2018-05-31', NULL, NULL, NULL),
(32, 82, 'This is your periodic reminder to invoice for job #82.', '2018-04-30', '2018-04-30', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `description` text,
  `type` int(1) NOT NULL,
  `unscheduled` int(1) NOT NULL DEFAULT '0',
  `visit_frequence` int(11) DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `date_ended` date DEFAULT NULL,
  `time_started` time DEFAULT NULL,
  `time_ended` time DEFAULT NULL,
  `internal_notes` text,
  `invoicing` int(1) DEFAULT '1',
  `duration` int(11) DEFAULT NULL,
  `duration_unit` int(11) DEFAULT NULL,
  `billing_frequency` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `closed_at` date DEFAULT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `client_id`, `property_id`, `quote_id`, `user_id`, `description`, `type`, `unscheduled`, `visit_frequence`, `date_started`, `date_ended`, `time_started`, `time_ended`, `internal_notes`, `invoicing`, `duration`, `duration_unit`, `billing_frequency`, `status`, `created_at`, `closed_at`) VALUES
(1, 7, 74, NULL, 63, 'All other Losses (including Vandalism and Malicious Mischief)', 1, 0, 1, '2018-03-20', '2018-03-28', '01:00:00', '23:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 05:49:17', NULL),
(2, 7, 74, NULL, 63, 'Cloth Washer Leak', 1, 0, 1, '2018-03-20', '2018-03-29', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 06:01:04', NULL),
(3, 7, 74, NULL, 63, 'All other Losses (including Vandalism and Malicious Mischief)', 1, 0, 1, '2018-03-20', '2018-04-05', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 06:06:08', NULL),
(4, 7, 74, NULL, 63, 'Catastrophic Loss', 1, 0, 1, '2018-03-20', '2018-03-27', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 06:12:59', NULL),
(5, 7, 74, NULL, 63, 'Catastrophic Loss', 1, 0, 1, '2018-03-20', '2018-03-27', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 06:16:28', NULL),
(6, 7, 74, NULL, 63, 'Catastrophic Loss', 1, 0, 1, '2018-03-20', '2018-03-27', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 06:19:05', NULL),
(7, 8, 76, NULL, 46, 'All other Losses (including Vandalism and Malicious Mischief)', 1, 0, 1, '2018-03-20', '2018-03-21', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 07:47:30', NULL),
(8, 15, 90, NULL, 66, 'Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', 1, 0, 1, '2018-03-20', '2018-03-29', '12:00:00', '14:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 12:30:25', NULL),
(9, 15, 90, NULL, 66, 'Collapse due to Sinkhole', 1, 0, 1, '2018-03-20', '2018-04-05', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 12:32:47', NULL),
(10, 14, 88, NULL, 46, 'Description', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 12:43:11', NULL),
(11, 14, 88, NULL, 46, 'Description', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 13:03:46', NULL),
(12, 14, 88, NULL, 46, 'Description', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 13:19:19', NULL),
(13, 14, 88, NULL, 46, 'Description', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 13:25:18', NULL),
(14, 14, 88, NULL, 46, 'Description', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 13:30:38', NULL),
(15, 16, 92, NULL, 69, 'Collapse due to Sinkhole', 1, 0, 1, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 14:07:20', NULL),
(16, 16, 92, NULL, 69, 'Falling Objects', 1, 0, 1, '2018-03-20', '2018-04-04', '01:00:00', '21:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-20 14:08:33', NULL),
(17, 16, 92, NULL, 69, 'Description', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 14:12:49', NULL),
(18, 16, 92, NULL, 69, 'Bathroom Leak', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 14:18:25', NULL),
(19, 16, 92, NULL, 69, 'Cloth Washer Leak', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 14:24:03', NULL),
(20, 16, 92, NULL, 69, 'Cloth Washer Leak', 1, 0, 1, '2018-03-20', '2018-03-20', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-20 14:28:43', NULL),
(21, 14, 88, NULL, 46, 'All other Losses (including Vandalism and Malicious Mischief)', 1, 0, 1, '2018-03-21', '2018-03-21', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-21 00:53:25', NULL),
(22, 11, 82, NULL, 46, 'Air conditioner Leak', 1, 0, 1, '2018-03-22', '2018-03-23', '10:06:00', '18:07:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-21 06:39:49', NULL),
(23, 19, 98, NULL, 46, 'Bathroom Leak', 1, 0, 1, '2018-03-22', '2018-03-23', '11:10:00', '19:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-21 06:44:36', NULL),
(24, 13, 86, NULL, 46, 'Falling Objects', 2, 0, 2, '2018-03-21', '2018-03-27', '05:37:00', '20:37:00', NULL, 0, 6, 1, 0, 1, '2018-03-21 07:08:12', NULL),
(25, 22, 104, NULL, 46, 'Collapse due to all other cause of Collapse', 1, 0, 1, '2018-03-21', '2018-03-22', '10:03:00', '18:03:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-21 07:33:40', NULL),
(26, 8, 76, NULL, 46, 'Description', 1, 0, 1, '2018-03-21', '2018-03-28', '01:00:00', '02:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-21 09:40:49', NULL),
(27, 23, 106, NULL, 64, 'Accidental Death', 1, 0, 1, '2018-03-24', '2018-03-24', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-21 09:45:22', NULL),
(28, 24, 108, NULL, 64, 'Collapse due to all other cause of Collapse', 1, 0, 1, '2018-03-21', '2018-03-21', '00:00:00', '00:00:00', NULL, 0, NULL, NULL, 5, 1, '2018-03-21 12:03:29', NULL),
(29, 21, 102, NULL, 64, 'Dishwasher Leak', 1, 0, 1, '2018-03-22', '2018-03-22', NULL, NULL, NULL, 0, NULL, NULL, 5, 1, '2018-03-21 12:05:21', NULL),
(30, 25, 110, NULL, 69, 'Collapse due to Sinkhole', 1, 0, 1, '2018-03-21', '2018-03-28', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 2, '2018-03-21 13:24:12', '2018-03-24'),
(31, 25, 110, NULL, 69, 'Fire Loss', 1, 0, 1, '2018-03-21', '2018-04-05', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-21 13:36:07', NULL),
(32, 24, 108, NULL, 64, 'Description', 1, 0, 1, '2018-03-21', '2018-03-21', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-21 14:22:17', NULL),
(33, 26, 112, NULL, 64, 'Bathroom Leak', 1, 0, 1, '2018-03-22', '2018-03-22', '15:00:00', '15:30:00', '', 1, NULL, NULL, NULL, 1, '2018-03-21 15:35:05', NULL),
(34, 25, 110, NULL, 69, 'Description', 1, 0, 1, '2018-03-22', '2018-04-07', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 08:28:45', NULL),
(35, 27, 114, NULL, 64, 'Fence Damage', 1, 0, 1, '2018-03-23', '2018-03-24', '06:44:00', '22:44:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 12:16:44', NULL),
(36, 25, 110, NULL, 69, 'Description', 2, 0, 1, '2018-03-22', '2018-03-28', '01:00:00', '12:00:00', NULL, 0, 6, 1, 3, 1, '2018-03-22 12:20:40', NULL),
(37, 28, 116, NULL, 64, 'Food Spoilage', 1, 0, 1, '2018-03-22', '2018-03-23', '06:23:00', '17:23:00', NULL, 1, NULL, NULL, 5, 2, '2018-03-22 13:54:53', '2018-03-23'),
(38, 28, 116, NULL, 64, 'Garbage Disposal Leak', 1, 0, 1, '2018-03-29', '2018-03-29', '08:25:00', '20:25:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 13:56:16', NULL),
(39, 11, 82, NULL, 46, 'Description', 1, 0, 1, '2018-03-22', '2018-03-29', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 15:49:58', NULL),
(40, 11, 82, NULL, 46, 'Description', 1, 0, 1, '2018-03-21', '2018-03-30', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 15:50:43', NULL),
(41, 22, 104, NULL, 46, 'Description', 1, 0, 1, '2018-03-21', '2018-03-30', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 15:51:59', NULL),
(42, 9, 78, NULL, 46, 'Description', 1, 0, 1, '2018-03-25', '2018-03-28', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 15:56:38', NULL),
(43, 11, 82, NULL, 46, 'Description', 1, 0, 1, '2018-03-26', '2018-03-29', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-22 16:01:59', NULL),
(44, 24, 108, NULL, 64, 'Lightning ( not resulting in fire )', 1, 0, 2, '2018-03-25', '2018-03-26', '05:00:00', '14:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-23 09:08:45', NULL),
(45, 32, 124, NULL, 64, 'Water Loss', 1, 0, 3, '2018-03-26', '2018-03-27', '18:26:00', '06:26:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-23 10:58:29', NULL),
(46, 40, 140, NULL, 64, 'Air conditioner Leak', 1, 0, 1, '2018-03-23', '2018-03-23', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-23 14:14:45', NULL),
(47, 30, 120, NULL, 64, 'Description', 1, 0, 1, '2018-03-24', '2018-03-24', '06:50:00', NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-23 14:20:58', NULL),
(48, 33, 126, NULL, 64, 'Roof Leak - Large Tree Falling on The Roof', 1, 0, 1, '2018-03-23', '2018-03-23', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-23 14:27:52', NULL),
(49, 41, 142, NULL, 64, 'Condo Association Loss Assessment', 1, 0, 1, '2018-03-25', '2018-03-25', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-23 14:32:18', NULL),
(50, 53, 166, 10, 87, 'Description', 1, 0, 1, '2018-03-26', '2018-03-26', NULL, NULL, NULL, 1, NULL, NULL, 5, 3, '2018-03-26 07:20:24', NULL),
(51, 31, 122, NULL, 64, 'Collapse due to Sinkhole', 1, 0, 1, '2018-03-26', '2018-03-27', '06:27:00', '14:27:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-26 08:00:55', NULL),
(52, 33, 126, NULL, 64, 'Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', 2, 0, 0, '2018-03-28', NULL, '10:32:00', '19:32:00', NULL, 0, 6, 1, 3, 1, '2018-03-26 10:03:07', NULL),
(53, 35, 130, NULL, 64, 'Description', 1, 0, 1, '2018-04-10', '2018-04-12', '12:34:00', '22:34:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-26 10:05:19', NULL),
(54, 36, 132, NULL, 64, 'Condo Association Loss Assessment', 1, 0, 1, '2018-02-01', '2018-02-01', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-26 10:11:37', NULL),
(55, 36, 132, NULL, 64, 'Fire Loss', 1, 0, 1, '2018-03-27', '2018-03-27', '06:54:00', '15:54:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-26 10:24:52', NULL),
(56, 26, 112, NULL, 64, 'Description', 1, 0, 1, '2018-03-26', '2018-03-26', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-26 12:03:45', NULL),
(57, 27, 114, NULL, 64, 'Bathroom Leak', 1, 0, 1, '2018-03-26', '2018-03-26', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-26 12:06:36', NULL),
(58, 26, 112, NULL, 64, 'Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', 1, 0, 1, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-26 15:16:44', NULL),
(59, 56, 172, NULL, 64, 'Description', 1, 0, 1, '2018-03-28', '2018-03-28', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-27 07:38:03', NULL),
(60, 56, 172, NULL, 64, 'Collapse due to all other cause of Collapse', 1, 0, 1, '2018-03-27', '2018-04-06', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-27 08:58:21', NULL),
(61, 56, 172, NULL, 64, 'Description', 1, 0, 1, '2018-03-27', '2018-04-07', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-27 09:03:57', NULL),
(62, 57, 174, NULL, 64, 'Falling Objects', 1, 0, 1, '2018-03-28', '2018-03-29', '10:03:00', '18:03:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-28 12:34:07', NULL),
(63, 57, 174, NULL, 64, 'Bathroom Leak', 1, 0, 1, '2018-04-01', '2018-04-01', '00:00:00', '24:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-28 13:26:40', NULL),
(64, 56, 172, NULL, 64, 'Collapse due to Sinkhole', 1, 0, 1, '2018-03-28', '2018-04-07', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-28 13:46:12', NULL),
(65, 16, 92, NULL, 69, 'Condo Association Loss Assessment', 1, 0, 1, '2018-03-28', '2018-04-05', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-28 23:59:10', NULL),
(66, 16, 92, NULL, 69, 'Cloth Washer Leak', 1, 0, 1, '2018-03-29', '2018-04-07', '01:00:00', '12:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 00:20:17', NULL),
(67, 16, 92, NULL, 69, 'Water Loss', 1, 0, 1, '2018-03-29', '2018-04-07', '02:00:00', '23:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 00:31:52', NULL),
(68, 58, 176, NULL, 69, 'Description', 1, 0, 1, '2018-03-29', '2018-04-07', '12:00:00', '14:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 04:19:18', NULL),
(69, 58, 176, NULL, 69, 'Description', 1, 0, 1, '2018-03-29', '2018-03-29', '12:00:00', '13:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 08:53:29', NULL),
(70, 58, 176, NULL, 69, 'Food Spoilage', 1, 0, 1, '2018-03-29', '2018-03-29', '01:00:00', '21:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 09:52:02', NULL),
(71, 58, 176, NULL, 69, 'Fire ( Including fire caused by lightning)', 1, 0, 1, '2018-03-29', '2018-03-29', '01:00:00', '20:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 10:16:20', NULL),
(72, 46, 152, NULL, 64, 'Windstorm due to Hurricane', 1, 0, 1, '2018-03-30', '2018-03-30', NULL, NULL, NULL, 1, NULL, NULL, 5, 1, '2018-03-29 11:10:21', NULL),
(73, 55, 170, NULL, 64, 'Windstorm due to Tornado', 2, 0, 1, '2018-03-31', '2018-05-31', '09:27:00', '15:28:00', NULL, 0, 2, 3, 3, 1, '2018-03-29 11:59:15', NULL),
(74, 54, 168, NULL, 64, 'Windstorm due to other than Hurricane or Tornado', 1, 0, 1, '2018-03-30', '2018-03-30', '09:00:00', '15:00:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-29 12:05:05', NULL),
(75, 48, 156, NULL, 64, 'Fence Damage', 2, 0, 1, '2018-03-31', '2018-05-31', '10:38:00', '17:00:00', NULL, 0, 2, 3, 3, 1, '2018-03-29 12:10:18', NULL),
(76, 14, 88, NULL, 46, 'Air conditioner Leak', 2, 0, 1, '2018-03-30', '2018-05-30', NULL, NULL, NULL, 0, 2, 3, 3, 1, '2018-03-30 00:44:30', NULL),
(77, 12, 84, NULL, 46, 'Description', 2, 0, 2, '2018-03-30', '2018-05-11', NULL, NULL, NULL, 0, 6, 2, 3, 1, '2018-03-30 00:47:24', NULL),
(78, 12, 84, NULL, 46, 'Description', 2, 0, 1, '2018-03-30', '2018-05-11', NULL, NULL, NULL, 0, 6, 2, 3, 1, '2018-03-30 01:39:52', NULL),
(79, 12, 84, NULL, 46, 'Windstorm due to Tornado', 2, 0, 1, '2018-04-01', '2018-10-01', '10:00:00', '12:00:00', NULL, 0, 6, 3, 3, 1, '2018-03-30 02:02:44', NULL),
(80, 22, 104, NULL, 46, 'Loss Caused by other than Pollutant Hazard - Slip and Fall', 2, 0, 2, '2018-05-01', '2018-08-01', '10:00:00', '12:00:00', NULL, 0, 3, 3, 3, 1, '2018-03-30 02:11:03', NULL),
(81, 40, 140, NULL, 64, 'Lightning ( not resulting in fire )', 2, 0, 0, '2018-04-01', NULL, NULL, NULL, NULL, 0, 6, 1, 3, 1, '2018-03-30 08:35:30', NULL),
(82, 40, 140, NULL, 64, 'Description', 2, 0, 1, '2018-04-01', '2018-04-07', NULL, NULL, NULL, 0, 6, 1, 3, 1, '2018-03-30 08:39:25', NULL),
(83, 57, 174, NULL, 64, 'Dishwasher Leak', 1, 0, 1, '2018-03-30', '2018-03-30', '06:05:00', '22:05:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-30 11:36:19', NULL),
(84, 56, 172, NULL, 64, 'Water Damage (accidental discharge or overflow) due to Plumbing Systems', 1, 0, 1, '2018-03-30', '2018-03-30', '07:36:00', '23:36:00', NULL, 1, NULL, NULL, 5, 1, '2018-03-30 14:07:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_attachments`
--

CREATE TABLE IF NOT EXISTS `jobs_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `alias` text NOT NULL,
  `filepath` text NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_notes`
--

CREATE TABLE IF NOT EXISTS `jobs_notes` (
  `note_id` int(10) NOT NULL AUTO_INCREMENT,
  `job_id` int(10) DEFAULT NULL,
  `service_perform` text,
  `remark` text,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_services`
--

CREATE TABLE IF NOT EXISTS `jobs_services` (
  `job_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_name` text,
  `service_description` text,
  `quantity` int(11) DEFAULT NULL,
  `cost` double(10,2) DEFAULT NULL,
  `quoted` int(11) DEFAULT NULL,
  PRIMARY KEY (`job_service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183 ;

--
-- Dumping data for table `jobs_services`
--

INSERT INTO `jobs_services` (`job_service_id`, `job_id`, `service_id`, `service_name`, `service_description`, `quantity`, `cost`, `quoted`) VALUES
(97, 73, NULL, NULL, NULL, 1, 0.00, NULL),
(98, 74, NULL, NULL, NULL, 1, 0.00, NULL),
(99, 75, NULL, NULL, NULL, 1, 0.00, 0),
(100, 76, NULL, 'Test', NULL, 1, 50.00, NULL),
(101, 77, NULL, 'Test', NULL, 1, 322.00, NULL),
(102, 78, 1, 'Service 1', 'Service 1Service 1Service 1Service 1Service 1Service 1', 4, 100.00, NULL),
(103, 79, NULL, 'Test', NULL, 1, 1223.00, NULL),
(104, 1, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00, NULL),
(105, 2, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00, NULL),
(106, 3, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00, NULL),
(107, 4, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00, NULL),
(108, 5, NULL, 'Test Service 1', NULL, 1, 5000.00, NULL),
(109, 6, NULL, 'Test Service 1', NULL, 0, 5000.00, NULL),
(110, 7, NULL, 'asdfasdf', NULL, 1, 112.00, NULL),
(111, 8, NULL, 'Test', NULL, 1, 34444.00, NULL),
(112, 9, NULL, 'ttt', NULL, 1, 50000.00, NULL),
(113, 10, NULL, 'tewts', NULL, 1, NULL, NULL),
(114, 11, NULL, 'test', NULL, 1, 12.00, NULL),
(115, 12, NULL, 'sss', NULL, 1, 12.00, NULL),
(116, 13, NULL, 'ㅇㅇㅇ', NULL, 1, 13.00, NULL),
(117, 14, NULL, 'aaa', NULL, 1, NULL, NULL),
(118, 15, NULL, 'test', NULL, 1, 12.00, NULL),
(119, 16, NULL, 'asdf', NULL, 1, 232323.00, NULL),
(120, 17, NULL, NULL, NULL, 1, 0.00, NULL),
(121, 18, NULL, '123213', NULL, 1, NULL, NULL),
(122, 19, NULL, 'testestsetsetsetsetsetset', NULL, 1, 123123.00, NULL),
(123, 20, NULL, 'testestsetsetsetsetsetset', NULL, 1, 123123.00, NULL),
(124, 21, NULL, 'serve', NULL, 1, 13.00, NULL),
(125, 22, NULL, NULL, NULL, 1, 0.00, NULL),
(126, 23, NULL, NULL, NULL, 1, 0.00, NULL),
(127, 24, NULL, NULL, NULL, 1, 0.00, NULL),
(128, 25, NULL, NULL, NULL, 1, 0.00, NULL),
(129, 26, NULL, 'Yrdy', NULL, 1, 2323.00, NULL),
(130, 27, NULL, NULL, NULL, 1, 0.00, NULL),
(131, 28, NULL, NULL, NULL, 1, 0.00, NULL),
(132, 29, NULL, NULL, NULL, 1, 0.00, NULL),
(133, 30, NULL, 'Test Service 1', NULL, 1, 5000.00, NULL),
(134, 31, NULL, 'test service 12', NULL, 1, 300.00, NULL),
(135, 32, NULL, NULL, NULL, 1, 0.00, NULL),
(136, 34, NULL, 'Test', NULL, 1, 500.00, NULL),
(137, 35, NULL, NULL, NULL, 1, 0.00, NULL),
(138, 36, NULL, 'Test', NULL, 1, 455.00, NULL),
(139, 37, NULL, NULL, NULL, 1, 0.00, NULL),
(140, 38, NULL, NULL, NULL, 1, 0.00, NULL),
(141, 39, NULL, NULL, NULL, 1, 0.00, NULL),
(142, 40, NULL, 'asdf', NULL, 1, NULL, NULL),
(143, 41, NULL, NULL, NULL, 1, 120.00, NULL),
(144, 42, NULL, NULL, NULL, 1, 0.00, NULL),
(145, 43, NULL, NULL, NULL, 1, 0.00, NULL),
(146, 44, NULL, NULL, NULL, 1, 0.00, NULL),
(147, 45, NULL, NULL, NULL, 1, 0.00, NULL),
(148, 46, NULL, NULL, NULL, 1, 0.00, NULL),
(149, 47, NULL, NULL, NULL, 1, 0.00, NULL),
(150, 48, NULL, NULL, NULL, 1, 0.00, NULL),
(151, 49, NULL, NULL, NULL, 1, 0.00, NULL),
(152, 50, 6, 'walter podolsky', 'service2', 1, 320.00, 320),
(153, 50, 5, 'walter podolsky', 'sevice1', 1, 130.00, 130),
(154, 51, NULL, NULL, NULL, 1, 0.00, NULL),
(155, 52, NULL, NULL, NULL, 1, 0.00, NULL),
(156, 53, NULL, NULL, NULL, 1, 0.00, NULL),
(157, 54, NULL, NULL, NULL, 1, 0.00, NULL),
(158, 55, NULL, NULL, NULL, 1, 0.00, NULL),
(159, 56, NULL, NULL, NULL, 1, 0.00, NULL),
(160, 57, NULL, NULL, NULL, 1, 0.00, NULL),
(161, 58, NULL, 'test', NULL, 1, 5000.00, NULL),
(162, 59, NULL, NULL, NULL, 1, 0.00, NULL),
(163, 60, NULL, 'Test', NULL, 1, 122332.00, NULL),
(164, 61, NULL, NULL, NULL, 1, 2343434.00, NULL),
(165, 62, NULL, NULL, NULL, 1, 0.00, NULL),
(166, 63, NULL, NULL, NULL, 1, 0.00, NULL),
(167, 64, NULL, NULL, NULL, 1, 0.00, NULL),
(168, 65, NULL, NULL, NULL, 1, 0.00, NULL),
(169, 66, NULL, NULL, NULL, 1, 0.00, NULL),
(170, 67, NULL, NULL, NULL, 1, 0.00, NULL),
(171, 68, NULL, NULL, NULL, 1, 0.00, NULL),
(172, 69, NULL, NULL, NULL, 1, 0.00, NULL),
(173, 70, NULL, NULL, NULL, 1, 0.00, NULL),
(174, 71, NULL, NULL, NULL, 1, 0.00, NULL),
(175, 72, NULL, NULL, NULL, 1, 0.00, NULL),
(176, 73, NULL, NULL, NULL, 1, 0.00, NULL),
(177, 74, NULL, NULL, NULL, 1, 0.00, NULL),
(178, 75, NULL, NULL, NULL, 1, 0.00, NULL),
(179, 76, NULL, NULL, NULL, 1, 0.00, NULL),
(180, 77, NULL, 'AAA', 'price', 1, 25.00, NULL),
(181, 78, NULL, NULL, NULL, 1, 0.00, NULL),
(182, 79, NULL, '12312312312', NULL, 1, 100.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_team`
--

CREATE TABLE IF NOT EXISTS `jobs_team` (
  `job_team_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `member_id` text NOT NULL,
  PRIMARY KEY (`job_team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `jobs_team`
--

INSERT INTO `jobs_team` (`job_team_id`, `job_id`, `member_id`) VALUES
(31, 76, '39,40'),
(32, 77, '40'),
(33, 79, '40'),
(34, 1, '65'),
(35, 2, '65'),
(36, 3, '65'),
(37, 4, '65'),
(38, 8, '68'),
(39, 9, '68'),
(40, 10, '42,41'),
(41, 11, '42,41'),
(42, 12, '41,42'),
(43, 13, '42,41'),
(44, 14, '42,41'),
(45, 15, '69'),
(46, 16, '69'),
(47, 17, '69'),
(48, 18, '69'),
(49, 19, '69'),
(50, 20, '69'),
(51, 21, '42,41'),
(52, 23, '76'),
(53, 24, '75'),
(54, 25, '77,78'),
(55, 27, '79'),
(56, 28, '80'),
(57, 29, '80'),
(58, 30, '82'),
(59, 31, '82'),
(60, 32, '81'),
(61, 33, '87'),
(62, 34, '82'),
(63, 36, '82'),
(64, 37, '89,87'),
(65, 38, '79,89'),
(66, 44, '79,89'),
(67, 45, '91'),
(68, 46, '92,89,90'),
(69, 47, '90'),
(70, 48, '90'),
(71, 49, '79'),
(72, 51, '90'),
(73, 52, '91'),
(74, 53, '98'),
(75, 54, '79,90'),
(76, 55, '97'),
(77, 56, '90'),
(78, 57, '90,81,89'),
(79, 58, '97,89,79,66,90'),
(80, 59, '99'),
(81, 60, '99'),
(82, 61, '99'),
(83, 62, '99'),
(84, 63, '99,90,89'),
(85, 64, '99'),
(86, 65, '69'),
(87, 66, '100'),
(88, 67, '100'),
(89, 68, '100'),
(90, 69, '100'),
(91, 70, '102'),
(92, 71, '103'),
(93, 72, '91'),
(94, 73, '90,89'),
(95, 74, '90,92'),
(96, 75, '97,81,89,92'),
(97, 76, '41,42'),
(98, 78, '76'),
(99, 79, '76'),
(100, 80, '78'),
(101, 81, '92'),
(102, 82, '98'),
(103, 83, '104,99'),
(104, 84, '104,105,99');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(10) NOT NULL AUTO_INCREMENT,
  `amount` double(10,2) NOT NULL,
  `note` text,
  `created_at` date DEFAULT NULL,
  `applied_to` int(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `client_id` int(10) NOT NULL,
  `type` int(1) DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `quote_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text,
  `rate_opportunity` int(1) NOT NULL DEFAULT '0',
  `client_message` text,
  `discount` double(10,2) DEFAULT NULL,
  `discount_percent` int(1) DEFAULT '-1',
  `tax` double(10,2) DEFAULT NULL,
  `deposit` double(10,2) DEFAULT NULL,
  `deposit_percent` int(1) DEFAULT '-1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` date NOT NULL,
  `related_job_id` int(11) DEFAULT NULL,
  `sendmail_date` date DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  PRIMARY KEY (`quote_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`quote_id`, `client_id`, `property_id`, `user_id`, `description`, `rate_opportunity`, `client_message`, `discount`, `discount_percent`, `tax`, `deposit`, `deposit_percent`, `status`, `created_at`, `related_job_id`, `sendmail_date`, `approved_date`) VALUES
(3, 1, 62, 2, NULL, 1, NULL, 0.00, 1, 0.20, 0.00, 1, 4, '2018-03-16', 75, '2018-03-16', NULL),
(4, 8, 76, 46, 'description', 1, NULL, 0.00, 1, 0.00, 0.00, 1, 1, '2018-03-20', NULL, NULL, NULL),
(5, 8, 76, 46, 'description', 1, NULL, 0.00, 1, 0.00, 0.00, 1, 1, '2018-03-20', NULL, NULL, NULL),
(6, 8, 76, 46, 'aaaa', 1, NULL, 0.00, 1, 0.00, 0.00, 1, 1, '2018-03-20', NULL, NULL, NULL),
(7, 8, 76, 46, 'aaaa', 1, NULL, 0.00, 1, 0.00, 0.00, 1, 1, '2018-03-20', NULL, NULL, NULL),
(8, 8, 76, 46, 'aaaa', 1, 'asdfsdf', 0.00, 1, 0.00, 0.00, 1, 1, '2018-03-20', NULL, NULL, NULL),
(9, 9, 78, 46, 'description', 1, NULL, 0.00, 1, 0.00, 0.00, 1, 1, '2018-03-20', NULL, NULL, NULL),
(10, 53, 166, 87, 'qwe', 1, NULL, 0.00, 1, 0.00, 0.00, 1, 4, '2018-03-26', 50, '2018-03-26', NULL),
(11, 53, 166, 87, NULL, 4, NULL, 0.00, 1, 0.30, 0.00, 1, 1, '2018-03-26', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotes_attachments`
--

CREATE TABLE IF NOT EXISTS `quotes_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `note` text,
  `alias` text NOT NULL,
  `path` text NOT NULL,
  `invoice_check` int(1) DEFAULT '-1',
  `job_check` int(1) DEFAULT '-1',
  `created_at` text,
  `quote_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes_internalnotes`
--

CREATE TABLE IF NOT EXISTS `quotes_internalnotes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachment_id` int(11) DEFAULT NULL,
  `quote_id` int(11) NOT NULL,
  `note_content` text,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes_services`
--

CREATE TABLE IF NOT EXISTS `quotes_services` (
  `quote_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_name` text,
  `service_description` text,
  `quantity` int(11) DEFAULT NULL,
  `cost` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`quote_service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `quotes_services`
--

INSERT INTO `quotes_services` (`quote_service_id`, `quote_id`, `service_id`, `service_name`, `service_description`, `quantity`, `cost`) VALUES
(3, 3, NULL, NULL, NULL, 1, 0.00),
(4, 4, NULL, 'service 1', NULL, 111, 120.00),
(5, 5, NULL, 'service 1', NULL, 111, 120.00),
(6, 6, NULL, 'asdfsdf', NULL, 1, 123.00),
(7, 7, NULL, 'asdfsdf', 'sdfasdf', 1, 123.00),
(8, 8, NULL, 'asdfsdf', 'sdfasdf', 1, 123.00),
(9, 9, NULL, 'aa', 'aa', 1, 10.00),
(10, 10, 6, 'walter podolsky', 'service2', 1, 320.00),
(11, 10, 5, 'walter podolsky', 'sevice1', 1, 130.00),
(12, 11, 7, 'walter podolsky', 'product1', 1, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `required_deposit`
--

CREATE TABLE IF NOT EXISTS `required_deposit` (
  `require_deposit_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `deposit_require` int(11) NOT NULL,
  `created_date` date DEFAULT NULL,
  `state` int(1) DEFAULT '-1',
  PRIMARY KEY (`require_deposit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `description` text,
  `cost` double(10,2) NOT NULL DEFAULT '0.00',
  `exempt` int(1) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `type`, `description`, `cost`, `exempt`, `user_id`, `sort`) VALUES
(1, 'Service 1', 1, 'Service 1Service 1Service 1Service 1Service 1Service 1', 100.00, -1, 2, 1),
(2, 'Service 2', 1, 'Service 2Service 2Service 2Service 2Service 2', 200.00, -1, 2, 2),
(3, 'teew', 2, 'dafadfadf', 1231.00, -1, 2, 3),
(4, 'Test Service 1', 1, 'Test Service 1', 5000.00, -1, 63, 3),
(5, 'service1', 1, 'sevice1', 130.00, -1, 87, 4),
(6, 'service2', 1, 'service2', 320.00, -1, 87, 5),
(7, 'product1', 2, 'product1', 50.00, -1, 87, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `date_started` date DEFAULT NULL,
  `time_started` time DEFAULT NULL,
  `date_ended` date DEFAULT NULL,
  `time_ended` time DEFAULT NULL,
  `is_allday` int(1) NOT NULL DEFAULT '-1',
  `repeat` int(1) NOT NULL DEFAULT '1',
  `user_id` int(11) DEFAULT NULL,
  `member_id` varchar(20) DEFAULT NULL,
  `is_complete` int(1) NOT NULL DEFAULT '-1',
  `date_completed` date DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `client_id` int(10) DEFAULT NULL,
  `property_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `title`, `description`, `date_started`, `time_started`, `date_ended`, `time_ended`, `is_allday`, `repeat`, `user_id`, `member_id`, `is_complete`, `date_completed`, `job_id`, `client_id`, `property_id`) VALUES
(1, '123123', '123123', '2018-03-05', '00:00:00', '2018-03-05', '23:00:00', 1, 1, 63, NULL, -1, NULL, 1, NULL, NULL),
(2, '123', '123', '2018-03-07', '00:00:00', '2018-03-07', '23:00:00', 1, 1, 63, '65', -1, NULL, 1, NULL, NULL),
(3, '456456', '456456', '2018-03-11', '00:00:00', '2018-03-11', '23:00:00', 1, 1, 63, '65', -1, NULL, 1, NULL, NULL),
(4, 'Asdf', 'Asdf', '2018-03-25', '05:51:00', '2018-03-25', '07:51:00', -1, 1, 42, '45', -1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE IF NOT EXISTS `taxes` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `value` double(10,2) NOT NULL DEFAULT '0.00',
  `is_default` int(1) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`tax_id`, `name`, `description`, `value`, `is_default`, `user_id`) VALUES
(1, 'tax1', NULL, 0.20, 1, 2),
(2, 'tax1', 'this is tax rate', 0.30, -1, 87);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `team_member_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `fullname` text,
  `email` text,
  `phone` text,
  `photo` text,
  `street` text,
  `city` text,
  `state` text,
  `zip_code` text,
  `country` text,
  `permission` text,
  PRIMARY KEY (`team_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_member_id`, `owner_id`, `fullname`, `email`, `phone`, `photo`, `street`, `city`, `state`, `zip_code`, `country`, `permission`) VALUES
(2, 2, 'adminme', 'admin@me.com', NULL, NULL, 'asfasf', 'Florstadt', 'Södermanlands län', '61197', 'Sweden', '1'),
(39, 37, 'Mobile King', 'mobile.king0827@outlook.com', '123456789', NULL, 'Prospekt 100-Letiya Vladivostoky, 103', 'Vladivostok', 'Primorskiy kray', '690000', 'Russia', '1'),
(40, 37, 'iOS King', 'mobile.king0827@hotmail.com', '123456789', NULL, 'Ulitsa Gamarnika, 1', 'Vladivostok', 'Primorskiy kray', '690033', 'Russia', '4'),
(41, 2, 'am', 'am@le.com', '8778877889', '1521202760.png', 'chaoyang', 'Beijing', NULL, NULL, 'China', '4'),
(42, 2, 'tropical', 'tr@tr.com', '2222222222', NULL, 'tongzhou', 'beijing', NULL, NULL, 'China', '3'),
(44, 41, 'asdf', 'asdf@asdf.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(45, 42, '111', '111@me.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(46, 43, 'Nox Tester', 'noxTester@asdf.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(47, 44, '555', '555@me.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(48, 45, 'Andorid King', 'mobile.king01287@outlook.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(49, 47, 'admin you', 'admin@you.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(50, 48, 'admin a', 'admin@a.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(51, 49, 'admin admin', 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(52, 50, '33', '33@me.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(53, 51, '1', '1@me.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(54, 52, 'nox tester', 'nox@me.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(55, 53, 'asdf', '123@me.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(56, 54, 'android king', 'mobile.king0128@outlook.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(57, 55, 'elling knox', 'knox1987@icloud.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(58, 56, 'abc', 'abc@abc.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(59, 57, 'aaaaaaa', 'root@root.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(60, 58, 'fa', 'asfew@me.comasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(61, 59, 'sdfa', 'awefwaef@asf.coma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(62, 60, 'asa', 'aaa@a.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(63, 61, 'ahahs', 'abc@ok.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(64, 62, 'test', 'test@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(65, 63, 'bbb', 'bbb@b.com', '123456798', NULL, '569 Qianjin Rd', 'Yanji Shi', 'Yanbian', NULL, 'China', '1'),
(66, 64, 'santosh', 'santosh@ma.com', NULL, NULL, '2213  PARKWOOD DR', 'HILLSBOROUGH', 'Florida', '33594', 'USA', '1'),
(67, 65, 'ccc', 'ccc@c.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(68, 66, 'ddd', 'ddd@d.com', '12345798', NULL, 'Zarechnaya Ulitsa, 37', 'Vladivostok', 'Primorskiy kray', '690000', 'Russia', '2'),
(69, 69, 'test', 'test1@test.com', '123456789', NULL, 'Zarechnaya Ulitsa, 37', 'Vladivostok', 'Primorskiy kray', '690000', 'Russia', '1'),
(70, 71, 'Mathemba Molo', 'mathemba@avatarvendor.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(71, 72, 'ooo', 'ooo@o.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(72, 73, 'Seye', 'seye@avatavendor.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(73, 74, 'vvv', 'vvv@v.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(74, 75, 'sss', 'sss@s.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(75, 2, 'Florida adjuster services', 'flad@ser.com', '2255441122', NULL, '17526 48TH ST', 'BROWARD', 'Florida', '33029', 'USA', '4'),
(76, 2, 'Jack leakage services', 'ja@le.com', '9898989898', NULL, '1212 BAYOU PASS DR', 'RUSKIN', 'Florida', '33570', 'USA', '3'),
(77, 2, 'Shyam Garud', 'shamgarud3827@gmail.com', '+917276975686', NULL, '231, Dr. D. N. Road', 'Mumbai', 'Maharashtra', '400001', 'India', '5'),
(78, 2, 'Santosh Manjarekar', 'santoshmanjarekar13@gmail.com', '+919969452650', NULL, '231, Dr. D. N. Road', 'Mumbai', 'Maharashtra', '400001', 'India', '6'),
(79, 64, 'Hiren Patel', 'hiren@adhiafunds1.com', '9819235922', NULL, '1101 Dutch Iris Suite 300', 'Tampa', 'FL', '33602', 'USA', '6'),
(80, 64, 'Hiren', 'hiren@globalfundsolutions.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4'),
(81, 64, 'PAMIR PATEL', 'ppatel@avatarins.com', NULL, NULL, '1408 N WESTSHORE BLVD', 'Tampa', 'fl', '33607', '-1', '5'),
(82, 69, 'Pamir', 'test2@test.com', '+12514758458', NULL, '1259 SE Palm Beach Rd', 'Port Saint Lucie', 'FL', '34952', 'United States', '3'),
(83, 78, 'santoshma', 'sa@ma.com', NULL, NULL, '406 CAPRI #I', 'DELRAY BEACH', 'Florida', '33484', 'USA', '1'),
(84, 79, 'Hitesh', 'hitesh@ap.com', NULL, NULL, '3100 WINDRUSH BOURNE #35', 'SARASOTA', 'SARASOTA', '34235', 'USA', '1'),
(85, 80, 'Shyam', 'shyam@ga.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(86, 81, 'Nitin', 'nitin@sh.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(87, 64, 'Hitesh Aparadh', 'hitesh@ap1.com', '9898989898', NULL, 'Room no 8 Building no 19 OLD Navy Nagar', 'Colaba', 'Maharashtra', '400005', 'India', '5'),
(88, 64, 'santosh', 'santosh@ss.com', '9969452650', NULL, '6000 25TH AVE N', 'PINELLAS', 'Florida', '33710', 'USA', '5'),
(89, 64, 'pritesh', 'pritesh@br.com', '5656565656', NULL, '6050 24TH AVE N, PINELLAS', 'Saint Petersburg', 'Florida', '33710', '-1', '5'),
(90, 64, 'Shyam G', 'shyam@gd.com', '8523697412', NULL, '3500 S DREXEL AVE', 'HILLSBOROUGH', 'Florida', '33629', 'USA', '4'),
(91, 64, 'kiran', 'kiran@iv.com', '4565478932', NULL, '400 FOREST HILLS BLVD', 'COLLIER', 'Florida', '34113', 'USA', '3'),
(92, 64, 'STAN TRIEM', 'stan@tr.com', '1212121212', NULL, '1692 PALM LEAF DR', 'BRANDON', 'Florida', '33510', 'USA', '6'),
(93, 64, 'BRENDA  MORGAN', 'br@morgn.com', '9999888855', NULL, '233 TREELINE DR', 'BOCA RATON', 'Florida', '33428', 'USA', '5'),
(95, 87, 'walter podolsky', 'water@podolsky.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(96, 87, 'adol', 'out@look.com', NULL, NULL, 'glasgow', 'glasgow', NULL, NULL, 'United Kingdom', '4'),
(97, 64, 'nitin', 'nitin@shk.com', '7896541236', NULL, '1615  E. DEL WEBB BLVD', 'HILLSBOROUGH', 'Florida', '33573', 'USA', '4'),
(98, 64, 'gfs', 'gfs@gfs.com', '9696969696', NULL, '22832 MARSH WREN DR', 'LAND O LAKES', 'Florida', '34639', 'USA', '5'),
(99, 64, 'Sunil', 'sunil@mh.com', '6666666666', NULL, '231, Bazar Gate', 'Mumbai', 'Maharashtra', '400001', 'India', '4'),
(100, 69, 'test3', 'test3@test.com', '123456789', NULL, 'Ulitsa Gamarnika, 1', 'Vladivostok', 'Primorskiy kray', '690033', 'Russia', '4'),
(101, 91, 'test4', 'test4@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(102, 69, 'test5', 'test5@test.com', '123456789', NULL, 'Ulitsa Prospekt 100 Let Vladivostoka, 57В', 'Vladivostok', 'Primorskiy kray', '690039', 'Russia', '4'),
(103, 69, 'test6', 'test6@test.com', '123456798', NULL, 'Ulitsa Ovchinnikova, 34А', 'Vladivostok', 'Primorskiy kray', '690048', 'Russia', '4'),
(104, 64, 'masa', 'ma@sa.com', '7878787878', NULL, '231, Bora Bazar Street', 'Mumbai', 'Maharashtra', '400001', 'India', '5'),
(105, 64, 'av', 'av@tr.com', '5458745213', NULL, 'Maratha Colony Road', 'Mumbai', 'Maharashtra', '400068', 'India', '6');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE IF NOT EXISTS `timesheets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(250) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `save_date` date DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `approve` int(1) NOT NULL DEFAULT '-1',
  `member_id` int(11) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `category`, `start_time`, `end_time`, `duration`, `save_date`, `note`, `created_at`, `user_id`, `approve`, `member_id`, `visit_id`) VALUES
(31, '67', '09:38:00', '10:27:00', '00:49:00', '2018-03-29', '', '2018-03-29 01:38:56', 90, -1, 100, 469),
(32, '67', '10:40:00', '11:45:00', '01:05:00', '2018-03-29', '', '2018-03-29 02:40:35', 90, -1, 100, 469),
(33, '67', '11:45:00', '12:19:00', '00:34:00', '2018-03-29', '', '2018-03-29 03:45:59', 90, -1, 100, 469),
(34, '68', '12:19:00', '16:50:00', '04:31:00', '2018-03-29', '', '2018-03-29 04:19:54', 90, -1, 100, 479),
(35, '68', '16:50:00', '16:53:00', '00:03:00', '2018-03-29', '', '2018-03-29 08:50:26', 90, -1, 100, 479),
(36, '69', '16:53:00', '04:58:00', '11:55:00', '2018-03-29', '', '2018-03-29 08:53:57', 90, -1, 100, 489),
(37, '69', '04:58:00', '05:43:00', '00:45:00', '2018-03-29', '', '2018-03-29 08:58:54', 90, -1, 100, 489),
(38, '70', '17:52:00', '18:11:00', '00:19:00', '2018-03-29', '', '2018-03-29 09:52:19', 92, -1, 102, 490),
(39, '71', '18:16:00', NULL, NULL, '2018-03-29', '', '2018-03-29 10:16:32', 93, -1, 103, 491),
(40, '64', '16:56:00', '18:27:00', '01:31:00', '2018-03-29', '', '2018-03-29 11:26:03', 89, -1, 99, 440),
(41, '60', '18:27:00', '18:29:00', '00:02:00', '2018-03-29', '', '2018-03-29 12:57:24', 89, -1, 99, 414),
(42, '62', '18:29:00', NULL, NULL, '2018-03-29', '', '2018-03-29 12:59:34', 89, -1, 99, 436),
(43, '56', '19:21:00', NULL, NULL, '2018-03-29', '', '2018-03-29 13:51:02', 84, -1, 90, 399),
(44, '61', '15:08:00', '16:55:00', '01:47:00', '2018-03-30', '', '2018-03-30 09:38:34', 89, -1, 99, 426),
(45, '60', '16:55:00', '16:57:00', '00:02:00', '2018-03-30', '', '2018-03-30 11:25:15', 89, -1, 99, 416),
(46, '60', '16:57:00', '18:01:00', '01:04:00', '2018-03-30', '', '2018-03-30 11:27:35', 89, -1, 99, 415),
(47, 'General', '17:11:00', '19:15:00', '02:04:00', '2018-03-30', '', '2018-03-30 11:41:50', 94, -1, 104, NULL),
(48, '60', '18:01:00', '18:35:00', '00:34:00', '2018-03-30', '', '2018-03-30 12:31:15', 89, -1, 99, 414),
(49, '61', '18:35:00', NULL, NULL, '2018-03-30', '', '2018-03-30 13:05:21', 89, -1, 99, 425),
(50, '83', '19:15:00', NULL, NULL, '2018-03-30', '', '2018-03-30 13:45:54', 94, -1, 104, 569);

-- --------------------------------------------------------

--
-- Table structure for table `timesheets_approve`
--

CREATE TABLE IF NOT EXISTS `timesheets_approve` (
  `approve_id` int(1) NOT NULL AUTO_INCREMENT,
  `timesheets_id` int(1) NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `day` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hours` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expenses` double(10,2) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '-1',
  `user_id` int(1) NOT NULL,
  `save_date` date DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`approve_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` text COLLATE utf8mb4_unicode_ci,
  `owner` int(1) NOT NULL DEFAULT '-1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `team_id` int(10) DEFAULT '0',
  `device_id` text COLLATE utf8mb4_unicode_ci,
  `device` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=96 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `fullname`, `company`, `password`, `remember_token`, `api_token`, `owner`, `created_at`, `updated_at`, `team_id`, `device_id`, `device`) VALUES
(39, 'iOS King', 'mobile.king0827@hotmail.com', NULL, 'iosking tech', '$2y$10$2sgb0fmMXyWvI5Zew5nORexcYDQF2WdF0QRf1qsdHjVdmaFOgFMaC', NULL, 'ggNdO6JVI3WdlZ00gKgRbNDu2nxPE4pAvoASFR4hFlae6jnBOSo0uPImMR6vxWHo', 1, '2018-03-16 21:49:29', '2018-03-20 15:50:20', 40, 'asdfasdfasdfasdfasdfasdfa', 'android'),
(40, 'Mobile King', 'mobile.king0827@outlook.com', NULL, 'mobileking tech', '$2y$10$BLJH3szw6IWbmVTStyrkHujpOibHTYPPIxzJhnFThrbEH1zXmNzBS', 'YbX7nufvNpBWSpBZOQyUGBtRxDvCXRA49or9CH7ogPxrWRx3cfx187bzFc9l', 'b2BMOvPcHdB4gVFDnROh4DWqACt5L4Tn9dflMawkVWHmUkWxbV1EAYnqRlluFuRP', 1, '2018-03-16 21:52:22', '2018-03-24 01:56:25', 39, 'cIeC0l2vh24:APA91bFrxkZ_t8cOcUjCpjEYCEVypKhcIWsXxAz663Ho-J2He05LPMjTq6weMZnzPD7SsypQBMqw3FN77qxMGtStR3k7xwM0znnuaUMLGDYNlUcAOvMuYWmn6jAUs3rBnzll2z9pdaXL', 'android'),
(41, 'asdf', 'asdf@asdf.com', NULL, 'asdf', '$2y$10$GngJcjutDs4Id5vVRbAxfOjUtq5YFHtOWCUdz1ISrIbH1aVN6gyVq', NULL, 'A06w1IJA94tcwgkecdqoztQ1ds1JgoghqSO1O9IxAqmntKX98RpU7QbcVNzleJD2', 1, '2018-03-16 22:04:36', '2018-03-16 22:04:36', 44, 'fpnqCXbvT9w:APA91bH5yRZdRR6bJOIyqiAIWe5pWdLtzehQoVNbAdS_vjvnb8wbS4LTzYIOcr-zskROfJsCqofBAaWT6dk8d8sMQICudkpuMMokuJpdbMwsoOA7mTGoiK3qwqV9CZbjUbkvTY0GZ9Ya', 'android'),
(42, '111', '111@me.com', NULL, '111', '$2y$10$z1qbvws33aRVPlmw7lpfJusr2UyMCQqcZmRpyV1mPfK2ciPsK.iC2', NULL, 'BvR5UyD6M6wvC5x3Lt80FVHDRCAwuwpDq7ZayA9vENrWpoLslRvAqeYoaGNVy4qT', 1, '2018-03-16 22:09:08', '2018-03-29 14:36:48', 45, 'dMlJ1fIrO00:APA91bFxZQ6Q8FugZx33W5gvusFy7ABeNFD4XHKq-lrN83tXNwL-ByhFHFPPpMrS_qAGAYcKz0LT8ygE_Z37YLj7x5j-m30e7Fa-uAY_F-3gZg6PVf7Jo_66MnMIxbHOo57LNIEOrAzT', 'android'),
(43, 'Nox Tester', 'noxTester@asdf.com', NULL, 'Nox Company', '$2y$10$ex97rJ9BLuUR4rNCF/ThVuoKDurquSl7rAV/WWnz3mXYMhRM0Hdrm', NULL, '9AjCEe2GanJTaz27qicAPFDYeosinne7ecw3rNwMTZmNCx2Sc4L8CzaUk0fXQGV2', 1, '2018-03-16 22:11:15', '2018-03-16 22:12:32', 46, 'cRIYfwdwZkA:APA91bE9srFcoTHkAhlT1yhK2t6Mq2G6ggk-BLEEuXgQjCLCTijyIgItSv_vpLsrT-Ls50CVnQuqgbaU-LV6jaE3v7-r38-_5saDjeWkpZ5LYUrfl48pij0Jf_uYcyb_QEy9s98O1iMD', 'android'),
(44, '555', '555@me.com', NULL, '555', '$2y$10$MP.TS3NuOoTe54WOPOJ.i.Hlra/j54obnb0CORBBmEVx6CJmBoAVy', NULL, NULL, 1, '2018-03-16 22:20:22', '2018-03-17 15:31:33', 47, 'fpnqCXbvT9w:APA91bH5yRZdRR6bJOIyqiAIWe5pWdLtzehQoVNbAdS_vjvnb8wbS4LTzYIOcr-zskROfJsCqofBAaWT6dk8d8sMQICudkpuMMokuJpdbMwsoOA7mTGoiK3qwqV9CZbjUbkvTY0GZ9Ya', 'android'),
(45, 'Andorid King', 'mobile.king01287@outlook.com', NULL, 'androidking tech', '$2y$10$eG47qkW97do6FRK0PnFtW.WcI454p3mZX54szK.8WDp5AFNuNgXaa', NULL, 'BsMMWLGAZ6gB4pd1SFVfm6cX0UVtBqBFlhrXmUrFe2aQ7Gw9E6xw9yTXJbTXdQIq', 1, '2018-03-17 00:08:24', '2018-03-17 00:08:24', 48, 'f_1vvxeVuP8:APA91bHid-HINjB0FUiA8U0RWz_HcLqX0YXUlsUtxazzWtdPBoxUimI8eAu-w_bWBLIBJFlxVzR1tmW2PW2XKpXGxz1Uddw4t17jHjh815RZx-e7sym4ArW1bKDsJrcf8Q4t0fg1A4C3', 'android'),
(46, 'admin me', 'admin@me.com', NULL, 'admin solu', '$2y$10$i1FztW8/5QbsUS9VIm5TreQDfrDY0YU9koaxij3l33336Y2Qwt32a', 'HTC3QuBRJpndmXjgHJcyHlb33sXOgsAz9mt2ycjHXzsC3lXhfQ3z76ahbUvh', 'yZA0DXEQThzhpWy7ADfuSGWgWy5qRUsKHQd6pidWTazYktDWheTE1Fu45OH1YwBN', 1, '2018-03-17 00:28:47', '2018-03-27 22:42:49', 2, '0', NULL),
(47, 'admin you', 'admin@you.com', NULL, 'adminyou solu', '$2y$10$ROSV4un8C1wjI29oQJAgeuRPWbAiFEyTmtzcDXn7x2DSksZxEE3dS', NULL, 'Hr6bw4fBQ8vOxS5J8BWHB3t0YJ92BGmkBXuCgmcHYQvBd4w1QdEEYr2IA8rgo8b1', 1, '2018-03-17 00:31:37', '2018-03-17 00:31:37', 49, NULL, NULL),
(48, 'admin a', 'admin@a.com', NULL, 'admin a', '$2y$10$Pgbv.gmBOZukHnNkx5VfN.y1RL3JzdBrcEYrjh6rjImKPkeUSwaUK', NULL, 'n8fgUtjWvy85KcK6Ss8tjZyyC3vXpKMuIVuLYMLQIzNTKUIRqZ3G3pWQog1JXhyh', 1, '2018-03-17 00:34:22', '2018-03-17 00:34:22', 50, 'czXAWi8Xyt4:APA91bGQGUjZJBoROkuaUk_WUOrjdsDEdScGNC121SkJTKUsBm2fYDDCQGw7AtmsmACgfiN9iggleLLYm9eCW00VRis08VPhALoGzs-Lr0mAAJ7v8v1C29KJ8RLHwCT2X4ttRH30RSxC', 'android'),
(49, 'admin admin', 'admin@admin.com', NULL, 'admin solu', '$2y$10$37tHO1BiQw4qim3wjHHeAOgZatS29PQMMQBY8tj1BkJ/GjbQL7CcW', NULL, 'sGlI5W3uQwkqsAZoDe7tMds5s89kRWtMuTkQHNBPdf8ZOotQwVgSDzpuQnHgu9wq', 1, '2018-03-17 01:07:23', '2018-03-17 01:07:23', 51, NULL, NULL),
(54, 'android king', 'mobile.king0128@outlook.com', NULL, 'tech', '$2y$10$cAkPf7zkXhAxA6VGv4Ew5epYWsM5JQby35NHtaWehkqZuuiLRypPu', NULL, '3bRSIWIjO9KdvjJlsQtt9Ld2899IrjaeAcUwJfk9eD7hQiquezYCQHfrPp2XtLKJ', 1, '2018-03-19 12:04:46', '2018-03-19 13:43:49', 56, NULL, NULL),
(60, 'asa', 'aaa@a.com', NULL, 'aaa', '$2y$10$0IG97p6iyF0wh2.NpUwx..flQ.JzNcygLt..n2PRlhABohtC6MMwe', NULL, 'mS9iwmO1E2PRbbZpi9p8SgLaoCN0OaNnaFdQeDVO0Pqw8R72in9tSog9MrxCRFYe', 1, '2018-03-19 18:48:32', '2018-03-19 18:48:32', 62, NULL, NULL),
(61, 'ahahs', 'abc@ok.com', NULL, 'shhehs', '$2y$10$FjczQKqsGHvCfEg88P0XmOGx/MWRM9JXi36110DW0GMZ/p1ULlroO', NULL, 'P4JqirVqo205jlzI2ynXG9kQ5fP1DksbNtZQg0SHLsOqul2b9K2YYTRLTZ7CxJsU', 1, '2018-03-19 20:45:21', '2018-03-19 20:45:21', 63, 'fXpPBgAyfD0:APA91bGd6tibDy4WlSI9T28wFc8MIdnWOm4gO18pdFMWZAIV7e4hCGq3eRri0Va0tY4hFr3ZhihjrSJBbGMLxd2a-QOzrheTG4r0ZOwCANInrlsPuYEXanHV7FjEqr89HCsvM2_EAKJY', 'android'),
(62, 'test', 'test@test.com', NULL, 'test', '$2y$10$71SACTMqQEfwk0KVw4VNBeS.43pu/oHl0eGwG.D8zLE0VfEWkqDNy', NULL, NULL, 1, '2018-03-20 08:26:08', '2018-03-20 08:37:41', 64, NULL, NULL),
(63, 'bbb', 'bbb@b.com', NULL, 'bbb', '$2y$10$B0p2pAhzxCogEEmZltN08O6vu6CA1Uw/Thcdt7s7W0p0xxMgXKxze', 'dO6fy7KKJftfV7qAUaJHJKVY7tzIrwMa0h2KnaFp42PIC4CIQA8Q1F47k7Np', 'wtlrUM0n11KjzbjsItWvouV0or4VC5Fi045lBLXhizpENzWeCCeSkbbH29XQSBA3', 1, '2018-03-20 12:32:06', '2018-03-20 16:25:07', 65, '', 'android'),
(64, 'santosh', 'santosh@ma.com', NULL, 'Implevision Tech', '$2y$10$qTIZGOiFOxRSpJCfwOFeq.1WvTSIASjdGUPLXN5w6/Fif6GFTs3hO', 'R8aMoQcY3J6dqS4tY4khiuAdtJaGZA3YVyCep2ymPE07JWBwFaNvN9AZBjAc', NULL, -1, '2018-03-20 15:47:53', '2018-03-22 18:26:59', 66, 'epJK8Diw4iE:APA91bH-WeVjssWgGRyulaIqXtsUPvANv8iTmZQdVeqjmAhBhTCMwg1c1jyEY5ZIsIn50LkN70CYs0kl7Q_65GwxCgq4RBs302hm_Hc8h9RikHmu1JVHgHpx28kJDH7DXKE1rk4a0qbA', 'android'),
(68, 'am', 'am@le.com', NULL, 'am', '$2y$10$zo926Xh4dbRw/dcV4vSM1OKZdBlAwgfl/sh2ARRr8CUEXOUjyLLPa', NULL, '4OkV0grF3dPTuEiVQMOELlEPU6XH32nIPewBDEGAkPCuLp7DhNI4rFeE8Fr50aPa', 1, '2018-03-20 20:16:45', '2018-03-20 20:17:48', 41, 'fy65SWC7ygg:APA91bHSuMdIzvKkMOerakfMrayGu9SKjQF7UAGV3eLFc_AEV0WQG8fBnIQTeuAdUW7qnLA0IKBOHNor4JTuKoIlo_bStXvnOTD1zeumQo5fdS7mXmyfRsU-TGEUHA3ndMXczZ9JrTLj', 'android'),
(69, 'test', 'test1@test.com', NULL, NULL, '$2y$10$54nXs.Ebxc7FN9jsHc5/tO95O2GNzHVe5hgboRfeSKN8PTvuyxKPm', 'PaOBnEcuB9qPym1w00uT5Dy2SzGsekTU0ko0nPAKaeX0sF4USGc7ItwAmzOl', 'DsLABDkKBLcoJMlsRvbxtIOelGxgiCXaAxyYO5G8KODohQlHwR9ArJ4g3KC5tqzo', -1, '2018-03-20 21:02:36', '2018-03-29 07:00:02', 69, 'dOG1HG2JwDE:APA91bG8S_58K5_4SuQFAbG7btGyNWw3DxbwXtEVQMe-Q5HpC1n0DsIBL3byDBRtSEebub2JFe694PAIuquA852Ks0mMIMGjhgiuT8yiGaDj5_bgVCVpbepJaOVVl8qlV2hvcT1_IMxT', 'android'),
(70, 'tropical', 'tr@tr.com', NULL, 'sss', '$2y$10$6zHZ1fmaOUnlgn8CVP6A9eJAYXKJviNZoHv5N3Y6GYZDfQlZxxHla', NULL, '32fjnk4Hyug6ovbat1LdHATu4bEQ0fSdV4314oseyKCm1peJEoAweTZf3oGyjj9D', 1, '2018-03-21 07:50:48', '2018-03-21 07:52:29', 42, 'c2-nUiLnrJY:APA91bEU4kKRu7vP1dMowDzgJsH06WRD3BMLWnq3gtddzXlI4442AlDQeXTqXxPPzV9t6N2HGCHaA3Y6WWnI2x8ZPBsVK43buqiNP4Ad1N2MJCRhGO26q0zHws5ZzGIu6iQFBRqE0gAw', 'android'),
(71, 'Mathemba Molo', 'mathemba@avatarvendor.com', NULL, 'AVendor', '$2y$10$TuzPoaCazECG7DZonKzN7eHs78/G8omcy8LN8RQCiRqw9skaV1Lra', 'Wk3rHThW8uSxQ4aSdwu5FZ8MyUbO9LIepKiLsgKawlmn19jSpDMbdHZ2uIG8', NULL, -1, '2018-03-21 08:06:20', '2018-03-21 08:06:20', 70, NULL, NULL),
(72, 'ooo', 'ooo@o.com', NULL, 'ooo', '$2y$10$65AoA5JQ8soMEowUa57x5.jSYOXqCCmjrhsTG.gzX0pzMAzTfXxjO', 'HNRI1APDhUrwNZ3H0UAzmVGlP9A5bNM7tYCjXhLtSfSUuEAzQDPx0gAxTtl4', NULL, 1, '2018-03-21 08:17:49', '2018-03-21 08:29:37', 71, NULL, NULL),
(73, 'Seye', 'seye@avatavendor.com', NULL, 'Alex', '$2y$10$xsWsAawUUmB9dQzx0QJ9t.eOJJMU.Sj5aZe1YqUQSqz8XVvryB50K', NULL, NULL, -1, '2018-03-21 08:24:48', '2018-03-21 08:24:48', 72, NULL, NULL),
(74, 'vvv', 'vvv@v.com', NULL, 'vvv', '$2y$10$okUgeA1GT1jVFOy0LVo/0ufyx3BU8PSkbZZs0x2bpGUf0utpzhW7e', NULL, 'kzfOhBTR3hdRRVuMD9HvdcucHXMdSwlXtZvgUK12DRGNoRTA772b03qT214PcKiE', 1, '2018-03-21 08:30:00', '2018-03-21 08:43:30', 73, NULL, NULL),
(75, 'sss', 'sss@s.com', NULL, 'sss', '$2y$10$TbXrxaZ8UpbyqKV.Zo49eeo.EWBwLF9jmiLg8BzxRxO4t1G80IR/q', NULL, 'Lmpz9k2djsEv06dtbHe4N3n9JXuUvyT0OUVJjKlQ2Kh9MylSooI6jTQqtsYTMAN3', 1, '2018-03-21 09:17:24', '2018-03-21 10:24:35', 74, 'cIeC0l2vh24:APA91bFrxkZ_t8cOcUjCpjEYCEVypKhcIWsXxAz663Ho-J2He05LPMjTq6weMZnzPD7SsypQBMqw3FN77qxMGtStR3k7xwM0znnuaUMLGDYNlUcAOvMuYWmn6jAUs3rBnzll2z9pdaXL', 'android'),
(76, 'Hiren Patel', 'hiren@globalfundsolutions.com', NULL, NULL, '$2y$10$NgrtPULarYTKZnPjORLHY.b6mSbN/66Fg01sExP3Xz/7LAxnJ1b7S', 'gNeVSRBX67sB5OAtXSVKiKjAKD7KfOOuEAmVtJq5xZDlSpzihGQTRuVxRStq', NULL, -1, '2018-03-21 19:22:06', '2018-03-21 19:22:06', 80, NULL, NULL),
(77, 'Pamir', 'test2@test.com', NULL, 'Pamir co.LTD', '$2y$10$xlJpDxkPAwEoL0ENO8A46OeWtNE9ywwRdRSeHBJYf4HkXGq7pkn.6', 'KfXilWXcP2pvyv5C3kM0GnYp8BHq3Q0h3GEcQ3rMA8HvUgoIJ8ZORWFZL2Sy', NULL, -1, '2018-03-21 20:25:34', '2018-03-29 06:59:51', 82, 'dOG1HG2JwDE:APA91bG8S_58K5_4SuQFAbG7btGyNWw3DxbwXtEVQMe-Q5HpC1n0DsIBL3byDBRtSEebub2JFe694PAIuquA852Ks0mMIMGjhgiuT8yiGaDj5_bgVCVpbepJaOVVl8qlV2hvcT1_IMxT', 'android'),
(78, 'santoshma', 'sa@ma.com', NULL, 'implevision tech', '$2y$10$l4s99/SM0O7y/UUnNXPag.ubVz4FAJz55XTV7nwIpiPn/yXxSHBte', 'WNIwii87DpfYvBXEBpZ5V5oE3cy2NkI6WArnriFfAvdShqcCSzKiSZEIT3gJ', NULL, -1, '2018-03-21 20:30:39', '2018-03-21 22:27:47', 83, 'epJK8Diw4iE:APA91bH-WeVjssWgGRyulaIqXtsUPvANv8iTmZQdVeqjmAhBhTCMwg1c1jyEY5ZIsIn50LkN70CYs0kl7Q_65GwxCgq4RBs302hm_Hc8h9RikHmu1JVHgHpx28kJDH7DXKE1rk4a0qbA', 'android'),
(79, 'Hitesh', 'hitesh@ap.com', NULL, 'implevision tech', '$2y$10$edhgt.EhhoqXgR3Bzf6WXub9ULyIdxvtXnw5sxyHPmwB1OvaLLB/a', 'C52oXWXvdGVJBKIzjBJGto0PiwR6vH0vUPCnoZnHRQUCckHNP6NflL9taQDh', NULL, -1, '2018-03-21 21:41:31', '2018-03-21 22:40:36', 84, 'epJK8Diw4iE:APA91bH-WeVjssWgGRyulaIqXtsUPvANv8iTmZQdVeqjmAhBhTCMwg1c1jyEY5ZIsIn50LkN70CYs0kl7Q_65GwxCgq4RBs302hm_Hc8h9RikHmu1JVHgHpx28kJDH7DXKE1rk4a0qbA', 'android'),
(80, 'Shyam', 'shyam@ga.com', NULL, 'implevision tech', '$2y$10$jPNCU3JUE2jtCkKu0JVxu.qo6F32bBiUz79yr81X1acQFWKgO8hoa', 'iid5GEMLP9QRcH5gP2HRPdry95sKxxAh08QDmhFgNaJrdlFI2fYEhgTvaLio', NULL, -1, '2018-03-21 21:47:41', '2018-03-21 21:47:41', 85, NULL, NULL),
(81, 'Nitin', 'nitin@sh.com', NULL, 'implevision tech', '$2y$10$j.vJlmVGNcHFWvQEqCb9f.ADTx8UNzGhGIhKoxy4krDcRY07UTZ8K', '6LRxVYzlyu1rhMba8LrKLHkgn59pvKw1loFy5Kar3noxhzMEEvoJ6KgTk07A', NULL, -1, '2018-03-21 21:49:35', '2018-03-21 21:49:35', 86, NULL, NULL),
(82, 'hitesh', 'hitesh@ap1.com', NULL, 'implevision tech', '$2y$10$CW8p8T0qG04nKCnQwz/8v.o9GigtN0lYx40IhjJlUYVXIXVjQMppC', 'fq2KLXANPovjWjVAIbz7OwHWowWVZY1raPi3YKp98qydtI6Zus6vmN7bklKD', NULL, -1, '2018-03-21 22:04:58', '2018-03-22 19:00:52', 87, 'epJK8Diw4iE:APA91bH-WeVjssWgGRyulaIqXtsUPvANv8iTmZQdVeqjmAhBhTCMwg1c1jyEY5ZIsIn50LkN70CYs0kl7Q_65GwxCgq4RBs302hm_Hc8h9RikHmu1JVHgHpx28kJDH7DXKE1rk4a0qbA', 'android'),
(83, 'santosh', 'santosh@ss.com', NULL, 'impl', '$2y$10$.oASXogonaq4tU2E6X0Dc.cpMuKQQG1C5b1/8U0oUQaWMUKADwOja', NULL, NULL, 1, '2018-03-22 19:08:26', '2018-03-22 19:32:29', 88, 'epJK8Diw4iE:APA91bH-WeVjssWgGRyulaIqXtsUPvANv8iTmZQdVeqjmAhBhTCMwg1c1jyEY5ZIsIn50LkN70CYs0kl7Q_65GwxCgq4RBs302hm_Hc8h9RikHmu1JVHgHpx28kJDH7DXKE1rk4a0qbA', 'android'),
(84, 'shyam', 'shyam@gd.com', NULL, 'imple v', '$2y$10$ARleyJsxpCoutBZViv2.Ze5pRsfTqzIckaNge2LVz31x83B2yGlnq', 'nMaUNv5aEcSOszERalg0DSJlxlSpuwFCfm2LqVkaJ8G0cvvkkotZegoIev63', NULL, -1, '2018-03-23 17:41:24', '2018-03-30 20:58:49', 90, 'eRysh8pNj-Q:APA91bG0TdbcayiQ9zq9asIO1JpEqEX_2P6IvHevXl4B6ZdMCU-VBN7lbRX0nEdcuWlW2kTej9RQkrYsl52UuqcAc7Jm3ZLqGWqlYHz6AhYfkbS0h711Xk2Q_QPzyyubezDw4ZzhfAX0', 'android'),
(85, 'kiran', 'kiran@iv.com', NULL, 'imple v', '$2y$10$sGHTf4ILUU/Q6qOZb9s9t.4iu6gHzmV6JhKKcC8XQPQeoGKOKGP2K', 'ToFTyJTsuo5cOtcoVZqIGxb4eESbYjbZHLqqP6ODQeKZicwfKKENjjVfsoNx', NULL, -1, '2018-03-23 18:13:42', '2018-03-23 18:13:42', 91, NULL, NULL),
(86, 'Hiren Patel', 'hiren@adhiafunds1.com', NULL, 'Implevision tech', '$2y$10$tkakuGbiZIsga1q9tDGvo..Al8.R2B6moPgeNnzrVTIw1Vt4m7BDm', 'rv982IwYvDPfWn6KmTR9A9eggef66h9cBodocnlLCOMcPDWRCxnRP4A0YpIe', NULL, -1, '2018-03-23 21:30:50', '2018-03-23 21:38:09', 79, 'cC9O0zn3cMI:APA91bHd9C2hVggUvTTgTjgMhKmlgI0riMwP7gfk-FU06yIB4dtoLkuEHPd1gyILxuBslyuSOqh5YCUv2yIxbk-mYaLeLhSn7K_kwda2Xyi4CFE_l4aTxdcjHj6dafkJZL9kZl9qwMbH', 'android'),
(87, 'walter podolsky', 'water@podolsky.com', NULL, NULL, '$2y$10$7SOff1AyEi8zATzlUuuxTOTRa/CXP5zPnUW6Apsla.c0koRqkkIYi', 'sewrT5kYalf8Yw9R2NsOMGmeS9qI1Sv5ZH0ujlJPfcAEOjn0CrCXWgTf0pvV', NULL, -1, '2018-03-26 14:14:50', '2018-03-26 14:14:50', 95, NULL, NULL),
(88, 'outlook', 'out@look.com', NULL, NULL, '$2y$10$/0Eou64ZrW/9l3kLFD4wLu4WMJLwCX2Dyr.gPpb63E9yPMpYONYJ2', 'Ot8UrfxgH6XDl8jJZwg988IUf6yCicl2HPNBMGKpMOcycynGbbQICU7tGKuw', NULL, -1, '2018-03-26 14:50:28', '2018-03-26 14:50:28', 96, NULL, NULL),
(89, 'Sunil', 'sunil@mh.com', NULL, 'imle', '$2y$10$ogRKpXEX.U53DcMO7yzdmOcwoI.DbDKEKNpaJIy1HOPXwoxdrfapC', NULL, 'BbOHRp44FTtmFodvt4dSP4QhBe73PDAL07PLBd9t5TgTMxRepRjpK67sIH3oVNHO', 1, '2018-03-27 14:42:35', '2018-03-30 19:30:48', 99, 'fEREJ2uWjls:APA91bFve93PxqYkz5EOtZJsw8xLLiI7QZxbN3pY6bWJvKeiUqhjPnI53JxSL3M7KaKpJsZ3C70NWpMvjqfBgB95aCGVoSLZSdNBvH45VWubnKwfXHO1a04Q5coYo3T1M3z2y9sHxwlc', 'android'),
(90, 'test3', 'test3@test.com', NULL, 'test3', '$2y$10$5xHDHZ5m6INi41qiNqIsT.BWoMtlF.XX3Z.bgsFdMdGTkMSrSjI4y', NULL, NULL, 1, '2018-03-29 07:17:59', '2018-03-29 16:43:14', 100, 'eh-JJoVkjpk:APA91bFgA9dKwgRhKLjoec2YOrIy5AbCxaUf1RpouIfuB2r_2P7DAEuhJJAx1d0XIj-Mqz4d31kWodhG2DlbHULhR4KIEK83xUWGh5WAx_M_pKJ0StQhk8h6Lc0X2416sEJAhqnTJrgt', 'android'),
(91, 'test4', 'test4@test.com', NULL, 'test4', '$2y$10$cUa3IQeN5y4VXcbN28aNzu9dJCcdVSAmMTO7y3d/suo9bVdo6.zNm', NULL, NULL, 1, '2018-03-29 16:49:21', '2018-03-29 16:50:15', 101, 'c5qiSU-wUJU:APA91bFg2P44ec3Sa0KS7FJFE34qUnHrT7gTVGtQSiyR8LhIClayxpr3KkuVX1fPmLgVn8gmS1LLwFWAMJV9j5THNR-1qa2DYJ_UHnaMF1N_b0JdRcIbqgObyrzQapPzzatLuEcz4HLd', 'android'),
(92, 'test5', 'test5@test.com', NULL, 'test5', '$2y$10$xa2Apfs32c4l7tDXysh7AONsljumV2CgPL2TgAUPMbTfNdP2gIOWi', NULL, 'WdwqloPQBzVul0Cq19rlmCaOZ1IRc61cnX9rxOoVceHM5oub9LJWiPuAKxNb3Qfk', 1, '2018-03-29 16:50:43', '2018-03-29 16:51:14', 102, 'c5qiSU-wUJU:APA91bFg2P44ec3Sa0KS7FJFE34qUnHrT7gTVGtQSiyR8LhIClayxpr3KkuVX1fPmLgVn8gmS1LLwFWAMJV9j5THNR-1qa2DYJ_UHnaMF1N_b0JdRcIbqgObyrzQapPzzatLuEcz4HLd', 'android'),
(93, 'test6', 'test6@test.com', NULL, 'test6', '$2y$10$mcE3D0vkdO07Bqj6jJHc7OOSvmRFJoqQ8CMBCA32DMHQ8JnOH6E3S', NULL, 'C38dTqwgmWwOTwEe09tixtCvUzIC39x3WO5gtMM47LuQRDpZrNP1Di6mu86ZwvJV', 1, '2018-03-29 17:15:07', '2018-03-29 17:15:31', 103, 'df9vOMGVOSc:APA91bH39F7e_G7AZWx-5B_Mqil9QOZ5EyvMWL7Y3y-tDz3YJ7gfp60XPMoGPA2UxcSim2nKGPbWyRGh6t4at_ZQDLnfxBXWKKrX_f7F2MJ3j3r0oYqeFOtYE8NqHKor6FOsLR0Zv6Tb', 'android'),
(94, 'masa', 'ma@sa.com', NULL, 'imple', '$2y$10$ZrP9hEkHb.JOWCBaDaQX0.mDOmMBYzDrd4nZNJHigI2tUIbP1hHaK', NULL, '0N1k4w9dYQiW6oXCVuWrl7TQK87uJSROv4sOcHnKYnRlF7vpX0eS4zhoxfdkHCD3', 1, '2018-03-30 18:33:01', '2018-03-30 21:11:32', 104, 'd3jdYXLOZm4:APA91bFsj-wnf-QZsuTkiTOWQrOc7D3KRdDPrgonHX9GOxgpsleVunWi1aP_N1bVqy2PuHmkswguEQNg7m6gzcdvnyY0RIV1A7De5Mi9w-0NDcauCQUqBXCJMABg0d3IBaS5hkga48_-', 'android'),
(95, 'av', 'av@tr.com', NULL, 'imlev', '$2y$10$xuR6LzeiOCT76QPu0WUm0.FVh9AnBzyHXsVPJlOYj8ffBHNJL.R2u', NULL, 'BySibGZ8Em6Tc1B58ufjVXxoyHaphiDj6zqL7XFi3XXobQpUShzoaR7kdetiPIMY', 1, '2018-03-30 21:02:42', '2018-03-30 21:10:12', 105, 'eRysh8pNj-Q:APA91bG0TdbcayiQ9zq9asIO1JpEqEX_2P6IvHevXl4B6ZdMCU-VBN7lbRX0nEdcuWlW2kTej9RQkrYsl52UuqcAc7Jm3ZLqGWqlYHz6AhYfkbS0h711Xk2Q_QPzyyubezDw4ZzhfAX0', 'android');

-- --------------------------------------------------------

--
-- Table structure for table `user_position`
--

CREATE TABLE IF NOT EXISTS `user_position` (
  `user_id` int(11) NOT NULL,
  `longitude` double NOT NULL DEFAULT '0',
  `latitude` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_position`
--

INSERT INTO `user_position` (`user_id`, `longitude`, `latitude`) VALUES
(42, -122.08400000000002, 37.421998333333335),
(90, 131.915755, 43.163230000000006),
(93, 131.9100118, 43.1577167),
(84, 72.8336845, 18.9359264),
(89, 72.8336891, 18.9359264),
(94, 72.8336387, 18.9370571),
(95, 72.8336891, 18.9359264);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `member_id` text,
  `title` text,
  `details` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `visit_reminder` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `completed_by` int(11) DEFAULT NULL,
  `completed_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `anytime` int(1) DEFAULT '-1',
  PRIMARY KEY (`visit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=574 ;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`visit_id`, `job_id`, `member_id`, `title`, `details`, `start_date`, `end_date`, `start_time`, `end_time`, `visit_reminder`, `status`, `completed_by`, `completed_on`, `created_at`, `updated_at`, `anytime`) VALUES
(89, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-16', '2018-03-16', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(90, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-17', '2018-03-17', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(91, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-18', '2018-03-18', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(92, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-19', '2018-03-19', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(93, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(94, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(95, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(96, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(97, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(98, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(99, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(100, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(101, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(102, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(103, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(104, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(105, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(106, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(107, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(108, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(109, 76, '39,40', 'Dmitry Stepan - Cloth Washer Leak', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-16 17:58:51', '2018-03-16 17:58:51', -1),
(115, 78, NULL, 'EDUARDO MELCON - Catastrophic Loss', NULL, '2018-03-19', '2018-03-19', '18:17:00', '21:17:00', 0, 1, NULL, NULL, '2018-03-16 19:48:24', '2018-03-16 19:48:24', -1),
(116, 78, NULL, 'EDUARDO MELCON - Catastrophic Loss', NULL, '2018-03-20', '2018-03-20', '18:17:00', '21:17:00', 0, 1, NULL, NULL, '2018-03-16 19:48:24', '2018-03-16 19:48:24', -1),
(117, 77, NULL, 'Dmitry Stepan - Collapse due to all other cause of Collapse', NULL, '2018-03-16', '2018-03-16', '01:00:00', '11:00:00', 0, 1, NULL, NULL, '2018-03-16 20:16:15', '2018-03-16 20:16:15', -1),
(118, 77, NULL, 'Dmitry Stepan - Collapse due to all other cause of Collapse', NULL, '2018-03-17', '2018-03-17', '01:00:00', '11:00:00', 0, 1, NULL, NULL, '2018-03-16 20:16:15', '2018-03-16 20:16:15', -1),
(119, 77, NULL, 'Dmitry Stepan - Collapse due to all other cause of Collapse', NULL, '2018-03-18', '2018-03-18', '01:00:00', '11:00:00', 0, 1, NULL, NULL, '2018-03-16 20:16:15', '2018-03-16 20:16:15', -1),
(120, 77, NULL, 'Dmitry Stepan - Collapse due to all other cause of Collapse', NULL, '2018-03-19', '2018-03-19', '01:00:00', '11:00:00', 0, 1, NULL, NULL, '2018-03-16 20:16:15', '2018-03-16 20:16:15', -1),
(121, 77, NULL, 'Dmitry Stepan - Collapse due to all other cause of Collapse', NULL, '2018-03-20', '2018-03-20', '01:00:00', '11:00:00', 0, 1, NULL, NULL, '2018-03-16 20:16:15', '2018-03-16 20:16:15', -1),
(122, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-16', '2018-03-16', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(123, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-17', '2018-03-17', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(124, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-18', '2018-03-18', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(125, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-19', '2018-03-19', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(126, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-20', '2018-03-20', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(127, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-21', '2018-03-21', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(128, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-22', '2018-03-22', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(129, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-23', '2018-03-23', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(130, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-24', '2018-03-24', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(131, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-25', '2018-03-25', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(132, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-26', '2018-03-26', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(133, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-27', '2018-03-27', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(134, 79, '40', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-28', '2018-03-28', '03:00:00', '10:00:00', 0, 1, NULL, NULL, '2018-03-16 20:20:43', '2018-03-16 20:20:43', -1),
(135, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-20', '2018-03-20', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(136, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-21', '2018-03-21', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(137, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-22', '2018-03-22', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(138, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-23', '2018-03-23', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(139, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-24', '2018-03-24', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(140, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-25', '2018-03-25', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(141, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-26', '2018-03-26', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(142, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-27', '2018-03-27', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(143, 1, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-28', '2018-03-28', '01:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-20 12:49:17', '2018-03-20 12:49:17', -1),
(144, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(145, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(146, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(147, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(148, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(149, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(150, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(151, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(152, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(153, 2, '65', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:01:04', '2018-03-20 13:01:04', -1),
(154, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(155, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(156, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(157, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(158, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(159, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(160, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(161, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(162, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(163, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(164, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(165, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(166, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(167, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(168, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(169, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(170, 3, '65', 'Piao Men - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:06:08', '2018-03-20 13:06:08', -1),
(171, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(172, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(173, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(174, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(175, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(176, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(177, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(178, 4, '65', 'Piao Men - Catastrophic Loss', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:12:59', '2018-03-20 13:12:59', -1),
(179, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(180, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(181, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(182, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(183, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(184, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(185, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(186, 5, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:16:28', '2018-03-20 13:16:28', -1),
(187, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(188, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(189, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(190, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(191, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(192, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(193, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(194, 6, NULL, 'Piao Men - Catastrophic Loss', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 13:19:05', '2018-03-20 13:19:05', -1),
(195, 6, '65', 'aaaaa', 'aaaaa', '2018-03-01', '2018-03-01', '10:00:00', '11:00:00', 0, 1, NULL, NULL, NULL, NULL, -1),
(196, 6, '65', 'aaaaa', 'aaaaa', '2018-03-01', '2018-03-01', '10:00:00', '11:00:00', 0, 1, NULL, NULL, NULL, NULL, -1),
(197, 2, '65', 'new visit', 'details', '2018-04-07', NULL, '00:00:00', '24:00:00', 1, 1, NULL, NULL, NULL, NULL, -1),
(198, 2, '65', 'new visit', 'details', '2018-04-07', NULL, '00:00:00', '24:00:00', 1, 1, NULL, NULL, NULL, NULL, -1),
(199, 7, NULL, '1 12 - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 14:47:30', '2018-03-20 14:47:30', -1),
(200, 7, NULL, '1 12 - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 14:47:30', '2018-03-20 14:47:30', -1),
(211, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-20', '2018-03-20', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(212, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-21', '2018-03-21', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(213, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-22', '2018-03-22', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(214, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-23', '2018-03-23', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(215, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-24', '2018-03-24', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(216, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-25', '2018-03-25', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(217, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-26', '2018-03-26', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(218, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-27', '2018-03-27', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(219, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-28', '2018-03-28', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(220, 8, NULL, 'Piao Wen - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-29', '2018-03-29', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:12', '2018-03-20 19:32:12', -1),
(221, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(222, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(223, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(224, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(225, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(226, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(227, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(228, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(229, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(230, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(231, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(232, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(233, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(234, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(235, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(236, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(237, 9, '68', 'Piao Wen - Collapse due to Sinkhole', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 19:32:47', '2018-03-20 19:32:47', -1),
(238, 10, '42,41', 'WILLIAM SANTNER - Description', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 19:43:11', '2018-03-20 19:43:11', -1),
(239, 11, '42,41', 'WILLIAM SANTNER - Description', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 20:03:46', '2018-03-20 20:03:46', -1),
(241, 13, '42,41', 'WILLIAM SANTNER - Description', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 20:25:18', '2018-03-20 20:25:18', -1),
(242, 14, '42,41', 'WILLIAM SANTNER - Description', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 20:30:38', '2018-03-20 20:30:38', -1),
(252, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-20', '2018-03-20', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(253, 15, '69', 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-21 21:36:00', -1),
(254, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(255, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(256, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(257, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(258, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(259, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(260, 15, NULL, 'Piao Men - Collapse due to Sinkhole', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:04', '2018-03-20 21:08:04', -1),
(261, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-20', '2018-03-20', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(262, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-21', '2018-03-21', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(263, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-22', '2018-03-22', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(264, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-23', '2018-03-23', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(265, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-24', '2018-03-24', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(266, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-25', '2018-03-25', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(267, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-26', '2018-03-26', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(268, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-27', '2018-03-27', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(269, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-28', '2018-03-28', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(270, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-29', '2018-03-29', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(271, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-30', '2018-03-30', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(272, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-03-31', '2018-03-31', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(273, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-04-01', '2018-04-01', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(274, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-04-02', '2018-04-02', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(275, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-04-03', '2018-04-03', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(276, 16, '69', 'Piao Men - Falling Objects', NULL, '2018-04-04', '2018-04-04', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-20 21:08:33', '2018-03-20 21:08:33', -1),
(277, 17, '69', 'Piao Men - Description', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 21:12:49', '2018-03-20 21:12:49', -1),
(278, 18, '69', 'Piao Men - Bathroom Leak', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 21:18:25', '2018-03-20 21:18:25', -1),
(279, 19, '69', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 21:24:03', '2018-03-20 21:24:03', -1),
(280, 20, '69', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-20', '2018-03-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-20 21:28:43', '2018-03-20 21:28:43', -1),
(281, 21, '42,41', 'WILLIAM SANTNER - All other Losses (including Vandalism and Malicious Mischief)', NULL, '2018-03-21', '2018-03-21', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-21 07:53:25', '2018-03-21 07:53:25', -1),
(282, 22, NULL, 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Air conditioner Leak', NULL, '2018-03-22', '2018-03-22', '10:06:00', '18:07:00', 0, 1, NULL, NULL, '2018-03-21 13:39:49', '2018-03-21 13:39:49', -1),
(283, 22, NULL, 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Air conditioner Leak', NULL, '2018-03-23', '2018-03-23', '10:06:00', '18:07:00', 0, 1, NULL, NULL, '2018-03-21 13:39:49', '2018-03-21 13:39:49', -1),
(284, 23, '76', 'ISRAEL SECUNDINO - Bathroom Leak', NULL, '2018-03-22', '2018-03-22', '11:10:00', '19:00:00', 0, 1, NULL, NULL, '2018-03-21 13:44:37', '2018-03-21 13:44:37', -1),
(285, 23, '76', 'ISRAEL SECUNDINO - Bathroom Leak', NULL, '2018-03-23', '2018-03-23', '11:10:00', '19:00:00', 0, 1, NULL, NULL, '2018-03-21 13:44:37', '2018-03-21 13:44:37', -1),
(286, 24, '75', 'VIVIANI LIMA & ANTONIO LIMA - Falling Objects', NULL, '2018-03-21', '2018-03-21', NULL, NULL, 0, 1, NULL, NULL, '2018-03-21 14:08:12', '2018-03-21 14:08:12', -1),
(287, 25, '77,78', 'Ram Laxman - Collapse due to all other cause of Collapse', NULL, '2018-03-21', '2018-03-21', '10:03:00', '18:03:00', 0, 1, NULL, NULL, '2018-03-21 14:33:40', '2018-03-21 14:33:40', -1),
(288, 25, '77,78', 'Ram Laxman - Collapse due to all other cause of Collapse', NULL, '2018-03-22', '2018-03-22', '10:03:00', '18:03:00', 0, 1, NULL, NULL, '2018-03-21 14:33:40', '2018-03-21 14:33:40', -1),
(289, 26, NULL, '1 12 - Description', NULL, '2018-03-21', '2018-03-21', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(290, 26, NULL, '1 12 - Description', NULL, '2018-03-22', '2018-03-22', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(291, 26, NULL, '1 12 - Description', NULL, '2018-03-23', '2018-03-23', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(292, 26, NULL, '1 12 - Description', NULL, '2018-03-24', '2018-03-24', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(293, 26, NULL, '1 12 - Description', NULL, '2018-03-25', '2018-03-25', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(294, 26, NULL, '1 12 - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(295, 26, NULL, '1 12 - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(296, 26, NULL, '1 12 - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '02:00:00', 0, 1, NULL, NULL, '2018-03-21 16:40:49', '2018-03-21 16:40:49', -1),
(297, 27, '79', 'Pritesh Bhadra - Accidental Death', NULL, '2018-03-24', '2018-03-24', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-21 16:45:22', '2018-03-21 16:45:22', -1),
(298, 28, '80', 'P Patel - Collapse due to all other cause of Collapse', NULL, '2018-03-21', '2018-03-21', '00:00:00', '00:00:00', 0, 1, NULL, NULL, '2018-03-21 19:03:29', '2018-03-21 19:04:00', -1),
(299, 29, '80', 'CELIA VACCA - Dishwasher Leak', NULL, '2018-03-22', '2018-03-22', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-21 19:05:21', '2018-03-21 19:05:21', -1),
(308, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(309, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(310, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(311, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(312, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(313, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(314, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(315, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(316, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(317, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(318, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(319, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(320, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(321, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(322, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(323, 31, '82', 'John Edmov - Fire Loss', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-21 20:36:07', '2018-03-21 20:36:07', -1),
(324, 32, '81', 'P Patel - Description', NULL, '2018-03-21', '2018-03-21', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-21 21:22:17', '2018-03-21 21:22:17', -1),
(325, 33, '87', 'Bathroom Leak', 'Bathroom Leak', '2018-03-22', '2018-03-22', '15:00:00', '15:30:00', NULL, 1, NULL, NULL, '2018-03-21 22:35:05', '2018-03-21 22:35:05', -1),
(326, 34, '82', 'John Edmov - Description', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(327, 34, '82', 'John Edmov - Description', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(328, 34, '82', 'John Edmov - Description', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(329, 34, '82', 'John Edmov - Description', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(330, 34, '82', 'John Edmov - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(331, 34, '82', 'John Edmov - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(332, 34, '82', 'John Edmov - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(333, 34, '82', 'John Edmov - Description', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(334, 34, '82', 'John Edmov - Description', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(335, 34, '82', 'John Edmov - Description', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(336, 34, '82', 'John Edmov - Description', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(337, 34, '82', 'John Edmov - Description', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(338, 34, '82', 'John Edmov - Description', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(339, 34, '82', 'John Edmov - Description', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(340, 34, '82', 'John Edmov - Description', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(341, 34, '82', 'John Edmov - Description', NULL, '2018-04-06', '2018-04-06', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(342, 34, '82', 'John Edmov - Description', NULL, '2018-04-07', '2018-04-07', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 15:28:45', '2018-03-22 15:28:45', -1),
(343, 35, '', 'JOHN RAMDEEN - Fence Damage', NULL, '2018-03-23', '2018-03-23', '06:44:00', '22:44:00', 0, 1, NULL, NULL, '2018-03-22 19:16:44', '2018-03-22 19:16:44', -1),
(344, 35, '', 'JOHN RAMDEEN - Fence Damage', NULL, '2018-03-24', '2018-03-24', '06:44:00', '22:44:00', 0, 1, NULL, NULL, '2018-03-22 19:16:44', '2018-03-22 19:16:44', -1),
(345, 36, '82', 'John Edmov - Description', NULL, '2018-03-22', '2018-03-22', NULL, NULL, 0, 1, NULL, NULL, '2018-03-22 19:20:40', '2018-03-22 19:20:40', -1),
(346, 37, '89,87', 'CONNIE W KAKLAMANOS - Food Spoilage', NULL, '2018-03-22', '2018-03-22', '06:23:00', '17:23:00', 0, 2, 64, '2018-03-23 12:02:52', '2018-03-22 20:54:53', '2018-03-22 20:54:53', -1),
(347, 37, '89,87', 'CONNIE W KAKLAMANOS - Food Spoilage', NULL, '2018-03-23', '2018-03-23', '06:23:00', '17:23:00', 0, 2, 64, '2018-03-23 12:02:52', '2018-03-22 20:54:53', '2018-03-22 20:54:53', -1),
(348, 38, '79,89', 'CONNIE W KAKLAMANOS - Garbage Disposal Leak', NULL, '2018-03-29', '2018-03-29', '08:25:00', '20:25:00', 0, 1, NULL, NULL, '2018-03-22 20:56:16', '2018-03-22 20:56:16', -1),
(349, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(350, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(351, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(352, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(353, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(354, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(355, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(356, 39, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:49:58', '2018-03-22 22:49:58', -1),
(357, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(358, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(359, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(360, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(361, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(362, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(363, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(364, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(365, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(366, 40, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:50:43', '2018-03-22 22:50:43', -1),
(367, 41, '', 'Ram Laxman - Description', NULL, '2018-03-21', '2018-03-21', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(368, 41, '', 'Ram Laxman - Description', NULL, '2018-03-22', '2018-03-22', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(369, 41, '', 'Ram Laxman - Description', NULL, '2018-03-23', '2018-03-23', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(370, 41, '', 'Ram Laxman - Description', NULL, '2018-03-24', '2018-03-24', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(371, 41, '', 'Ram Laxman - Description', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(372, 41, '', 'Ram Laxman - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(373, 41, '', 'Ram Laxman - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(374, 41, '', 'Ram Laxman - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(375, 41, '', 'Ram Laxman - Description', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(376, 41, '', 'Ram Laxman - Description', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:51:59', '2018-03-22 22:51:59', -1),
(377, 42, '', 'First name Last name - Description', NULL, '2018-03-25', '2018-03-25', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:56:38', '2018-03-22 22:56:38', -1),
(378, 42, '', 'First name Last name - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:56:38', '2018-03-22 22:56:38', -1),
(379, 42, '', 'First name Last name - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:56:38', '2018-03-22 22:56:38', -1),
(380, 42, '', 'First name Last name - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 22:56:38', '2018-03-22 22:56:38', -1),
(381, 43, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 23:01:59', '2018-03-22 23:01:59', -1),
(382, 43, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 23:01:59', '2018-03-22 23:01:59', -1),
(383, 43, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 23:01:59', '2018-03-22 23:01:59', -1),
(384, 43, '', 'CHRISTOPHER D THOMPSON AND KAREN THOMPSON - Description', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-22 23:01:59', '2018-03-22 23:01:59', -1),
(385, 44, '79,89', 'P Patel - Lightning ( not resulting in fire )', NULL, '2018-03-25', '2018-03-25', '05:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-23 16:08:45', '2018-03-23 16:08:45', -1),
(386, 45, '91', 'ROBERTO CONTI - Water Loss', NULL, '2018-03-26', '2018-03-26', '18:26:00', '06:26:00', 0, 1, NULL, NULL, '2018-03-23 17:58:29', '2018-03-23 17:58:29', -1),
(387, 46, '92,89,90', 'JUSTIN WHITWORTH - Air conditioner Leak', NULL, '2018-03-23', '2018-03-23', '00:00:00', '24:00:00', 0, 1, 64, '2018-03-23 14:18:17', '2018-03-23 21:14:45', '2018-03-23 21:14:45', -1),
(388, 47, '90', 'BRUCE LAUGHRIDGE - Description', NULL, '2018-03-24', '2018-03-24', '06:50:00', NULL, 0, 1, NULL, NULL, '2018-03-23 21:20:58', '2018-03-23 21:20:58', -1),
(389, 48, '90', 'PROVIDENTIA IGBOELUSI - Roof Leak - Large Tree Falling on The Roof', NULL, '2018-03-23', '2018-03-23', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-23 21:27:52', '2018-03-23 21:27:52', -1),
(390, 49, '79', 'DENNIS L DEIBERT - Condo Association Loss Assessment', NULL, '2018-03-25', '2018-03-25', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-23 21:32:18', '2018-03-23 21:32:18', -1),
(391, 50, '', 'Walter Nosy - Description', NULL, '2018-03-26', '2018-03-26', '00:00:00', '24:00:00', 0, 2, 87, '2018-03-26 08:06:10', '2018-03-26 14:20:24', '2018-03-26 14:20:24', -1);
INSERT INTO `visits` (`visit_id`, `job_id`, `member_id`, `title`, `details`, `start_date`, `end_date`, `start_time`, `end_time`, `visit_reminder`, `status`, `completed_by`, `completed_on`, `created_at`, `updated_at`, `anytime`) VALUES
(392, 51, '90', 'ORLANDO PELAEZ OR ADA M DE ZAYAS PELAEZ - Collapse due to Sinkhole', NULL, '2018-03-26', '2018-03-26', '06:27:00', '14:27:00', 0, 1, NULL, NULL, '2018-03-26 15:00:55', '2018-03-26 15:00:55', -1),
(393, 51, '90', 'ORLANDO PELAEZ OR ADA M DE ZAYAS PELAEZ - Collapse due to Sinkhole', NULL, '2018-03-27', '2018-03-27', '06:27:00', '14:27:00', 0, 1, NULL, NULL, '2018-03-26 15:00:55', '2018-03-26 15:00:55', -1),
(394, 53, '98', 'ANTHONY DUMICICH AND GRAZIELLA DUMICICH - Description', NULL, '2018-04-10', '2018-04-10', '12:34:00', '22:34:00', 0, 1, NULL, NULL, '2018-03-26 17:05:19', '2018-03-26 17:05:19', -1),
(395, 53, '98', 'ANTHONY DUMICICH AND GRAZIELLA DUMICICH - Description', NULL, '2018-04-11', '2018-04-11', '12:34:00', '22:34:00', 0, 1, NULL, NULL, '2018-03-26 17:05:19', '2018-03-26 17:05:19', -1),
(396, 53, '98', 'ANTHONY DUMICICH AND GRAZIELLA DUMICICH - Description', NULL, '2018-04-12', '2018-04-12', '12:34:00', '22:34:00', 0, 1, NULL, NULL, '2018-03-26 17:05:19', '2018-03-26 17:05:19', -1),
(397, 54, '79,90', 'SUSAN JONES - Condo Association Loss Assessment', NULL, '2018-02-01', '2018-02-01', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-26 17:11:37', '2018-03-26 17:11:37', -1),
(398, 55, '97', 'SUSAN JONES - Fire Loss', NULL, '2018-03-27', '2018-03-27', '06:54:00', '15:54:00', 0, 1, NULL, NULL, '2018-03-26 17:24:52', '2018-03-26 17:24:52', -1),
(399, 56, '90', 'JOHN MATSON AND MARGARET SOMMERFELD - Description', NULL, '2018-03-26', '2018-03-26', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-26 19:03:45', '2018-03-26 19:03:45', -1),
(400, 57, '90,81,89', 'JOHN RAMDEEN - Bathroom Leak', NULL, '2018-03-26', '2018-03-26', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-26 19:06:36', '2018-03-26 19:06:36', -1),
(401, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-26', '2018-03-26', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(402, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(403, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(404, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(405, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(406, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-29 19:00:00', -1),
(407, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(408, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(409, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(410, 58, '97,89,79,66,90', 'JOHN MATSON AND MARGARET SOMMERFELD - Consequential Fungi , Wet , or Dry Rot or Bacteria Property losses', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-26 22:16:44', '2018-03-26 22:16:44', -1),
(411, 59, '99', 'S G Parikh - Description', NULL, '2018-03-28', '2018-03-28', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-27 14:38:03', '2018-03-27 14:38:03', -1),
(412, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(413, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(414, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(415, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(416, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(417, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(418, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(419, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(420, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(421, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(422, 60, '99', 'S G Parikh - Collapse due to all other cause of Collapse', NULL, '2018-04-06', '2018-04-06', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 15:58:21', '2018-03-27 15:58:21', -1),
(423, 61, '99', 'S G Parikh - Description', NULL, '2018-03-27', '2018-03-27', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(424, 61, '99', 'S G Parikh - Description', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(425, 61, '99', 'S G Parikh - Description', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(426, 61, '99', 'S G Parikh - Description', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(427, 61, '99', 'S G Parikh - Description', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(428, 61, '99', 'S G Parikh - Description', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(429, 61, '99', 'S G Parikh - Description', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(430, 61, '99', 'S G Parikh - Description', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(431, 61, '99', 'S G Parikh - Description', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(432, 61, '99', 'S G Parikh - Description', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(433, 61, '99', 'S G Parikh - Description', NULL, '2018-04-06', '2018-04-06', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(434, 61, '99', 'S G Parikh - Description', NULL, '2018-04-07', '2018-04-07', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-27 16:03:57', '2018-03-27 16:03:57', -1),
(435, 62, '99', 'H Shah - Falling Objects', NULL, '2018-03-28', '2018-03-28', '10:03:00', '18:03:00', 0, 1, NULL, NULL, '2018-03-28 19:34:07', '2018-03-28 19:34:07', -1),
(436, 62, '99', 'H Shah - Falling Objects', NULL, '2018-03-29', '2018-03-29', '10:03:00', '18:03:00', 0, 1, NULL, NULL, '2018-03-28 19:34:07', '2018-03-28 19:34:07', -1),
(438, 63, '99,90,89', 'H Shah - Bathroom Leak', NULL, '2018-04-01', '2018-04-01', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-28 20:33:15', '2018-03-28 20:36:00', -1),
(439, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(440, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(441, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(442, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(443, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(444, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(445, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(446, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(447, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(448, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-06', '2018-04-06', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(449, 64, '99', 'S G Parikh - Collapse due to Sinkhole', NULL, '2018-04-07', '2018-04-07', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-28 20:46:12', '2018-03-28 20:46:12', -1),
(450, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-03-28', '2018-03-28', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(451, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(452, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(453, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(454, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(455, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(456, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(457, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(458, 65, '69', 'Piao Men - Condo Association Loss Assessment', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 06:59:10', '2018-03-29 06:59:10', -1),
(459, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-29', '2018-03-29', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(460, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-30', '2018-03-30', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(461, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-03-31', '2018-03-31', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(462, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-01', '2018-04-01', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(463, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-02', '2018-04-02', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(464, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-03', '2018-04-03', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(465, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-04', '2018-04-04', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(466, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-05', '2018-04-05', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(467, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-06', '2018-04-06', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(468, 66, '100', 'Piao Men - Cloth Washer Leak', NULL, '2018-04-07', '2018-04-07', '01:00:00', '12:00:00', 0, 1, NULL, NULL, '2018-03-29 07:20:17', '2018-03-29 07:20:17', -1),
(469, 67, '100', 'Piao Men - Water Loss', NULL, '2018-03-29', '2018-03-29', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(470, 67, '100', 'Piao Men - Water Loss', NULL, '2018-03-30', '2018-03-30', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(471, 67, '100', 'Piao Men - Water Loss', NULL, '2018-03-31', '2018-03-31', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(472, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-01', '2018-04-01', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(473, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-02', '2018-04-02', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(474, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-03', '2018-04-03', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(475, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-04', '2018-04-04', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(476, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-05', '2018-04-05', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(477, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-06', '2018-04-06', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(478, 67, '100', 'Piao Men - Water Loss', NULL, '2018-04-07', '2018-04-07', '02:00:00', '23:00:00', 0, 1, NULL, NULL, '2018-03-29 07:31:52', '2018-03-29 07:31:52', -1),
(479, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-03-29', '2018-03-29', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(480, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-03-30', '2018-03-30', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(481, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-03-31', '2018-03-31', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(482, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-01', '2018-04-01', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(483, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-02', '2018-04-02', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(484, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-03', '2018-04-03', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(485, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-04', '2018-04-04', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(486, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-05', '2018-04-05', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(487, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-06', '2018-04-06', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(488, 68, '100', 'Dmitry Stepan - Description', NULL, '2018-04-07', '2018-04-07', '12:00:00', '14:00:00', 0, 1, NULL, NULL, '2018-03-29 11:19:18', '2018-03-29 11:19:18', -1),
(489, 69, '100', 'Dmitry Stepan - Description', NULL, '2018-03-29', '2018-03-29', '12:00:00', '13:00:00', 0, 1, NULL, NULL, '2018-03-29 15:53:29', '2018-03-29 15:53:29', -1),
(490, 70, '102', 'Dmitry Stepan - Food Spoilage', NULL, '2018-03-29', '2018-03-29', '01:00:00', '21:00:00', 0, 1, NULL, NULL, '2018-03-29 16:52:02', '2018-03-29 16:52:02', -1),
(491, 71, '103', 'Dmitry Stepan - Fire ( Including fire caused by lightning)', NULL, '2018-03-29', '2018-03-29', '01:00:00', '20:00:00', 0, 1, NULL, NULL, '2018-03-29 17:16:20', '2018-03-29 17:16:20', -1),
(492, 72, '91', 'LISA BOCOCK - Windstorm due to Hurricane', NULL, '2018-03-30', '2018-03-30', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-29 18:10:21', '2018-03-29 18:10:21', -1),
(494, 74, '90,92', 'WATSON DESME AND RINA DESME - Windstorm due to other than Hurricane or Tornado', NULL, '2018-03-30', '2018-03-30', '09:00:00', '15:00:00', 0, 1, NULL, NULL, '2018-03-29 19:07:20', '2018-03-29 19:07:20', -1),
(495, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-03-30', '2018-03-30', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(496, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-04-06', '2018-04-06', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(497, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-04-13', '2018-04-13', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(498, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-04-20', '2018-04-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(499, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-04-27', '2018-04-27', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(500, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-05-04', '2018-05-04', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(501, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-05-11', '2018-05-11', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(502, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-05-18', '2018-05-18', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(503, 76, '41,42', 'WILLIAM SANTNER - Air conditioner Leak', NULL, '2018-05-25', '2018-05-25', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:44:31', '2018-03-30 07:44:31', -1),
(504, 77, '', 'RYAN & AMY TIRONA - Description', NULL, '2018-03-30', '2018-03-30', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:47:24', '2018-03-30 07:47:24', -1),
(505, 77, '', 'RYAN & AMY TIRONA - Description', NULL, '2018-04-13', '2018-04-13', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:47:24', '2018-03-30 07:47:24', -1),
(506, 77, '', 'RYAN & AMY TIRONA - Description', NULL, '2018-04-27', '2018-04-27', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:47:24', '2018-03-30 07:47:24', -1),
(507, 77, '', 'RYAN & AMY TIRONA - Description', NULL, '2018-05-11', '2018-05-11', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 07:47:24', '2018-03-30 07:47:24', -1),
(508, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-03-30', '2018-03-30', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(509, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-04-06', '2018-04-06', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(510, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-04-13', '2018-04-13', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(511, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-04-20', '2018-04-20', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(512, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-04-27', '2018-04-27', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(513, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-05-04', '2018-05-04', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(514, 78, '76', 'RYAN & AMY TIRONA - Description', NULL, '2018-05-11', '2018-05-11', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 08:39:52', '2018-03-30 08:39:52', -1),
(515, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-04-01', '2018-04-01', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(516, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-04-08', '2018-04-08', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(517, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-04-15', '2018-04-15', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(518, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-04-22', '2018-04-22', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(519, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-04-29', '2018-04-29', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(520, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-05-06', '2018-05-06', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(521, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-05-13', '2018-05-13', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(522, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-05-20', '2018-05-20', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(523, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-05-27', '2018-05-27', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(524, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-06-03', '2018-06-03', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(525, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-06-10', '2018-06-10', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(526, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-06-17', '2018-06-17', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(527, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-06-24', '2018-06-24', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(528, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-07-01', '2018-07-01', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(529, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-07-08', '2018-07-08', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(530, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-07-15', '2018-07-15', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(531, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-07-22', '2018-07-22', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(532, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-07-29', '2018-07-29', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(533, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-08-05', '2018-08-05', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(534, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-08-12', '2018-08-12', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(535, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-08-19', '2018-08-19', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(536, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-08-26', '2018-08-26', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(537, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-09-02', '2018-09-02', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(538, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-09-09', '2018-09-09', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(539, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-09-16', '2018-09-16', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(540, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-09-23', '2018-09-23', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(541, 79, '76', 'RYAN & AMY TIRONA - Windstorm due to Tornado', NULL, '2018-09-30', '2018-09-30', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:02:44', '2018-03-30 09:02:44', -1),
(542, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-05-01', '2018-05-01', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(543, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-05-15', '2018-05-15', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(544, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-05-29', '2018-05-29', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(545, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-06-12', '2018-06-12', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(546, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-06-26', '2018-06-26', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(547, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-07-10', '2018-07-10', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(548, 80, '78', 'Ram Laxman - Loss Caused by other than Pollutant Hazard - Slip and Fall', NULL, '2018-07-24', '2018-07-24', NULL, NULL, 0, 1, NULL, NULL, '2018-03-30 09:11:03', '2018-03-30 09:11:03', -1),
(549, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-03-31', '2018-03-31', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(550, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-04-07', '2018-04-07', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(551, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-04-14', '2018-04-14', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(552, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-04-21', '2018-04-21', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(553, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-04-28', '2018-04-28', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(554, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-05-05', '2018-05-05', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(555, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-05-12', '2018-05-12', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(556, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-05-19', '2018-05-19', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(557, 73, '90,89', 'DAVID  STRINGFELLOW & SARA TINDALE - Windstorm due to Tornado', NULL, '2018-05-26', '2018-05-26', '09:27:00', '15:28:00', 0, 1, NULL, NULL, '2018-03-30 14:57:22', '2018-03-30 14:57:22', -1),
(558, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-03-31', '2018-03-31', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(559, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-04-07', '2018-04-07', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(560, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-04-14', '2018-04-14', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(561, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-04-21', '2018-04-21', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(562, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-04-28', '2018-04-28', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(563, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-05-05', '2018-05-05', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(564, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-05-12', '2018-05-12', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(565, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-05-19', '2018-05-19', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(566, 75, '97,81,89,92', 'KAREN A SHERWOOD - Fence Damage', NULL, '2018-05-26', '2018-05-26', '10:38:00', '17:00:00', 0, 1, NULL, NULL, '2018-03-30 15:01:33', '2018-03-30 15:01:33', -1),
(567, 82, '98', 'JUSTIN WHITWORTH - Description', NULL, '2018-04-01', '2018-04-01', '00:00:00', '24:00:00', 0, 1, NULL, NULL, '2018-03-30 15:39:25', '2018-03-30 15:39:25', -1),
(569, 83, '104', 'H Shah - Dishwasher Leak', NULL, '2018-03-30', '2018-03-30', '06:05:00', '22:05:00', 0, 1, NULL, NULL, '2018-03-30 18:54:07', '2018-03-30 18:54:07', -1),
(570, 83, '104,99', 'H Shah - Dishwasher Leak', NULL, '2018-03-30', '2018-03-30', '06:05:00', '22:05:00', 0, 1, NULL, NULL, '2018-03-30 18:56:29', '2018-03-30 18:56:29', -1),
(572, 84, '104', 'S G Parikh - Water Damage (accidental discharge or overflow) due to Plumbing Systems', NULL, '2018-03-30', '2018-03-30', '07:36:00', '23:36:00', 0, 1, NULL, NULL, '2018-03-30 21:14:41', '2018-03-30 21:14:41', -1),
(573, 84, '104,105,99', 'S G Parikh - Water Damage (accidental discharge or overflow) due to Plumbing Systems', NULL, '2018-03-30', '2018-03-30', '07:36:00', '23:36:00', 0, 1, NULL, NULL, '2018-03-30 21:25:35', '2018-03-30 21:25:35', -1);

-- --------------------------------------------------------

--
-- Table structure for table `visits_services`
--

CREATE TABLE IF NOT EXISTS `visits_services` (
  `visit_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_name` text,
  `service_description` text,
  `quantity` int(11) DEFAULT NULL,
  `cost` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`visit_service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=576 ;

--
-- Dumping data for table `visits_services`
--

INSERT INTO `visits_services` (`visit_service_id`, `visit_id`, `service_id`, `service_name`, `service_description`, `quantity`, `cost`) VALUES
(79, 86, NULL, NULL, NULL, 1, 0.00),
(81, 88, NULL, NULL, NULL, 1, 0.00),
(82, 89, NULL, 'Test', NULL, 1, 50.00),
(83, 90, NULL, 'Test', NULL, 1, 50.00),
(84, 91, NULL, 'Test', NULL, 1, 50.00),
(85, 92, NULL, 'Test', NULL, 1, 50.00),
(86, 93, NULL, 'Test', NULL, 1, 50.00),
(87, 94, NULL, 'Test', NULL, 1, 50.00),
(88, 95, NULL, 'Test', NULL, 1, 50.00),
(89, 96, NULL, 'Test', NULL, 1, 50.00),
(90, 97, NULL, 'Test', NULL, 1, 50.00),
(91, 98, NULL, 'Test', NULL, 1, 50.00),
(92, 99, NULL, 'Test', NULL, 1, 50.00),
(93, 100, NULL, 'Test', NULL, 1, 50.00),
(94, 101, NULL, 'Test', NULL, 1, 50.00),
(95, 102, NULL, 'Test', NULL, 1, 50.00),
(96, 103, NULL, 'Test', NULL, 1, 50.00),
(97, 104, NULL, 'Test', NULL, 1, 50.00),
(98, 105, NULL, 'Test', NULL, 1, 50.00),
(99, 106, NULL, 'Test', NULL, 1, 50.00),
(100, 107, NULL, 'Test', NULL, 1, 50.00),
(101, 108, NULL, 'Test', NULL, 1, 50.00),
(102, 109, NULL, 'Test', NULL, 1, 50.00),
(108, 115, 1, 'Service 1', 'Service 1Service 1Service 1Service 1Service 1Service 1', 4, 100.00),
(109, 116, 1, 'Service 1', 'Service 1Service 1Service 1Service 1Service 1Service 1', 4, 100.00),
(110, 117, NULL, 'Test', NULL, 1, 322.00),
(111, 118, NULL, 'Test', NULL, 1, 322.00),
(112, 119, NULL, 'Test', NULL, 1, 322.00),
(113, 120, NULL, 'Test', NULL, 1, 322.00),
(114, 121, NULL, 'Test', NULL, 1, 322.00),
(115, 122, NULL, 'Test', NULL, 1, 1223.00),
(116, 123, NULL, 'Test', NULL, 1, 1223.00),
(117, 124, NULL, 'Test', NULL, 1, 1223.00),
(118, 125, NULL, 'Test', NULL, 1, 1223.00),
(119, 126, NULL, 'Test', NULL, 1, 1223.00),
(120, 127, NULL, 'Test', NULL, 1, 1223.00),
(121, 128, NULL, 'Test', NULL, 1, 1223.00),
(122, 129, NULL, 'Test', NULL, 1, 1223.00),
(123, 130, NULL, 'Test', NULL, 1, 1223.00),
(124, 131, NULL, 'Test', NULL, 1, 1223.00),
(125, 132, NULL, 'Test', NULL, 1, 1223.00),
(126, 133, NULL, 'Test', NULL, 1, 1223.00),
(127, 134, NULL, 'Test', NULL, 1, 1223.00),
(128, 135, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(129, 136, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(130, 137, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(131, 138, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(132, 139, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(133, 140, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(134, 141, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(135, 142, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(136, 143, 4, 'Test Service 1', 'Test Service 1', 12, 5000.00),
(137, 144, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(138, 145, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(139, 146, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(140, 147, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(141, 148, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(142, 149, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(143, 150, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(144, 151, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(145, 152, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(146, 153, 4, 'Test Service 1', 'Test Service 1', 121, 5000.00),
(147, 154, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(148, 155, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(149, 156, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(150, 157, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(151, 158, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(152, 159, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(153, 160, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(154, 161, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(155, 162, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(156, 163, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(157, 164, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(158, 165, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(159, 166, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(160, 167, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(161, 168, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(162, 169, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(163, 170, 4, 'Test Service 1', 'Test Service 1', 123, 5000.00),
(164, 171, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(165, 172, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(166, 173, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(167, 174, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(168, 175, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(169, 176, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(170, 177, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(171, 178, 4, 'Test Service 1', 'Test Service 1', 15, 5000.00),
(172, 179, NULL, 'Test Service 1', NULL, 1, 5000.00),
(173, 180, NULL, 'Test Service 1', NULL, 1, 5000.00),
(174, 181, NULL, 'Test Service 1', NULL, 1, 5000.00),
(175, 182, NULL, 'Test Service 1', NULL, 1, 5000.00),
(176, 183, NULL, 'Test Service 1', NULL, 1, 5000.00),
(177, 184, NULL, 'Test Service 1', NULL, 1, 5000.00),
(178, 185, NULL, 'Test Service 1', NULL, 1, 5000.00),
(179, 186, NULL, 'Test Service 1', NULL, 1, 5000.00),
(180, 187, NULL, 'Test Service 1', NULL, 0, 5000.00),
(181, 188, NULL, 'Test Service 1', NULL, 0, 5000.00),
(182, 189, NULL, 'Test Service 1', NULL, 0, 5000.00),
(183, 190, NULL, 'Test Service 1', NULL, 0, 5000.00),
(184, 191, NULL, 'Test Service 1', NULL, 0, 5000.00),
(185, 192, NULL, 'Test Service 1', NULL, 0, 5000.00),
(186, 193, NULL, 'Test Service 1', NULL, 0, 5000.00),
(187, 194, NULL, 'Test Service 1', NULL, 0, 5000.00),
(188, 199, NULL, 'asdfasdf', NULL, 1, 112.00),
(189, 200, NULL, 'asdfasdf', NULL, 1, 112.00),
(200, 211, NULL, 'Test', NULL, 1, 34444.00),
(201, 212, NULL, 'Test', NULL, 1, 34444.00),
(202, 213, NULL, 'Test', NULL, 1, 34444.00),
(203, 214, NULL, 'Test', NULL, 1, 34444.00),
(204, 215, NULL, 'Test', NULL, 1, 34444.00),
(205, 216, NULL, 'Test', NULL, 1, 34444.00),
(206, 217, NULL, 'Test', NULL, 1, 34444.00),
(207, 218, NULL, 'Test', NULL, 1, 34444.00),
(208, 219, NULL, 'Test', NULL, 1, 34444.00),
(209, 220, NULL, 'Test', NULL, 1, 34444.00),
(210, 221, NULL, 'ttt', NULL, 1, 50000.00),
(211, 222, NULL, 'ttt', NULL, 1, 50000.00),
(212, 223, NULL, 'ttt', NULL, 1, 50000.00),
(213, 224, NULL, 'ttt', NULL, 1, 50000.00),
(214, 225, NULL, 'ttt', NULL, 1, 50000.00),
(215, 226, NULL, 'ttt', NULL, 1, 50000.00),
(216, 227, NULL, 'ttt', NULL, 1, 50000.00),
(217, 228, NULL, 'ttt', NULL, 1, 50000.00),
(218, 229, NULL, 'ttt', NULL, 1, 50000.00),
(219, 230, NULL, 'ttt', NULL, 1, 50000.00),
(220, 231, NULL, 'ttt', NULL, 1, 50000.00),
(221, 232, NULL, 'ttt', NULL, 1, 50000.00),
(222, 233, NULL, 'ttt', NULL, 1, 50000.00),
(223, 234, NULL, 'ttt', NULL, 1, 50000.00),
(224, 235, NULL, 'ttt', NULL, 1, 50000.00),
(225, 236, NULL, 'ttt', NULL, 1, 50000.00),
(226, 237, NULL, 'ttt', NULL, 1, 50000.00),
(227, 238, NULL, 'tewts', NULL, 1, NULL),
(228, 239, NULL, 'test', NULL, 1, 12.00),
(230, 241, NULL, 'ㅇㅇㅇ', NULL, 1, 13.00),
(231, 242, NULL, 'aaa', NULL, 1, NULL),
(241, 252, NULL, 'test', NULL, 1, 12.00),
(242, 253, NULL, 'test', NULL, 1, 12.00),
(243, 254, NULL, 'test', NULL, 1, 12.00),
(244, 255, NULL, 'test', NULL, 1, 12.00),
(245, 256, NULL, 'test', NULL, 1, 12.00),
(246, 257, NULL, 'test', NULL, 1, 12.00),
(247, 258, NULL, 'test', NULL, 1, 12.00),
(248, 259, NULL, 'test', NULL, 1, 12.00),
(249, 260, NULL, 'test', NULL, 1, 12.00),
(250, 261, NULL, 'asdf', NULL, 1, 232323.00),
(251, 262, NULL, 'asdf', NULL, 1, 232323.00),
(252, 263, NULL, 'asdf', NULL, 1, 232323.00),
(253, 264, NULL, 'asdf', NULL, 1, 232323.00),
(254, 265, NULL, 'asdf', NULL, 1, 232323.00),
(255, 266, NULL, 'asdf', NULL, 1, 232323.00),
(256, 267, NULL, 'asdf', NULL, 1, 232323.00),
(257, 268, NULL, 'asdf', NULL, 1, 232323.00),
(258, 269, NULL, 'asdf', NULL, 1, 232323.00),
(259, 270, NULL, 'asdf', NULL, 1, 232323.00),
(260, 271, NULL, 'asdf', NULL, 1, 232323.00),
(261, 272, NULL, 'asdf', NULL, 1, 232323.00),
(262, 273, NULL, 'asdf', NULL, 1, 232323.00),
(263, 274, NULL, 'asdf', NULL, 1, 232323.00),
(264, 275, NULL, 'asdf', NULL, 1, 232323.00),
(265, 276, NULL, 'asdf', NULL, 1, 232323.00),
(266, 277, NULL, NULL, NULL, 1, 0.00),
(267, 278, NULL, '123213', NULL, 1, NULL),
(268, 279, NULL, 'testestsetsetsetsetsetset', NULL, 1, 123123.00),
(269, 280, NULL, 'testestsetsetsetsetsetset', NULL, 1, 123123.00),
(270, 281, NULL, 'serve', NULL, 1, 13.00),
(271, 282, NULL, NULL, NULL, 1, 0.00),
(272, 283, NULL, NULL, NULL, 1, 0.00),
(273, 284, NULL, NULL, NULL, 1, 0.00),
(274, 285, NULL, NULL, NULL, 1, 0.00),
(275, 286, NULL, NULL, NULL, 1, 0.00),
(276, 287, NULL, NULL, NULL, 1, 0.00),
(277, 288, NULL, NULL, NULL, 1, 0.00),
(278, 289, NULL, 'Yrdy', NULL, 1, 2323.00),
(279, 290, NULL, 'Yrdy', NULL, 1, 2323.00),
(280, 291, NULL, 'Yrdy', NULL, 1, 2323.00),
(281, 292, NULL, 'Yrdy', NULL, 1, 2323.00),
(282, 293, NULL, 'Yrdy', NULL, 1, 2323.00),
(283, 294, NULL, 'Yrdy', NULL, 1, 2323.00),
(284, 295, NULL, 'Yrdy', NULL, 1, 2323.00),
(285, 296, NULL, 'Yrdy', NULL, 1, 2323.00),
(286, 297, NULL, NULL, NULL, 1, 0.00),
(287, 298, NULL, NULL, NULL, 1, 0.00),
(288, 299, NULL, NULL, NULL, 1, 0.00),
(289, 300, NULL, 'Test Service 1', NULL, 1, 5000.00),
(290, 301, NULL, 'Test Service 1', NULL, 1, 5000.00),
(291, 302, NULL, 'Test Service 1', NULL, 1, 5000.00),
(292, 303, NULL, 'Test Service 1', NULL, 1, 5000.00),
(293, 304, NULL, 'Test Service 1', NULL, 1, 5000.00),
(294, 305, NULL, 'Test Service 1', NULL, 1, 5000.00),
(295, 306, NULL, 'Test Service 1', NULL, 1, 5000.00),
(296, 307, NULL, 'Test Service 1', NULL, 1, 5000.00),
(297, 308, NULL, 'test service 12', NULL, 1, 300.00),
(298, 309, NULL, 'test service 12', NULL, 1, 300.00),
(299, 310, NULL, 'test service 12', NULL, 1, 300.00),
(300, 311, NULL, 'test service 12', NULL, 1, 300.00),
(301, 312, NULL, 'test service 12', NULL, 1, 300.00),
(302, 313, NULL, 'test service 12', NULL, 1, 300.00),
(303, 314, NULL, 'test service 12', NULL, 1, 300.00),
(304, 315, NULL, 'test service 12', NULL, 1, 300.00),
(305, 316, NULL, 'test service 12', NULL, 1, 300.00),
(306, 317, NULL, 'test service 12', NULL, 1, 300.00),
(307, 318, NULL, 'test service 12', NULL, 1, 300.00),
(308, 319, NULL, 'test service 12', NULL, 1, 300.00),
(309, 320, NULL, 'test service 12', NULL, 1, 300.00),
(310, 321, NULL, 'test service 12', NULL, 1, 300.00),
(311, 322, NULL, 'test service 12', NULL, 1, 300.00),
(312, 323, NULL, 'test service 12', NULL, 1, 300.00),
(313, 324, NULL, NULL, NULL, 1, 0.00),
(314, 326, NULL, 'Test', NULL, 1, 500.00),
(315, 327, NULL, 'Test', NULL, 1, 500.00),
(316, 328, NULL, 'Test', NULL, 1, 500.00),
(317, 329, NULL, 'Test', NULL, 1, 500.00),
(318, 330, NULL, 'Test', NULL, 1, 500.00),
(319, 331, NULL, 'Test', NULL, 1, 500.00),
(320, 332, NULL, 'Test', NULL, 1, 500.00),
(321, 333, NULL, 'Test', NULL, 1, 500.00),
(322, 334, NULL, 'Test', NULL, 1, 500.00),
(323, 335, NULL, 'Test', NULL, 1, 500.00),
(324, 336, NULL, 'Test', NULL, 1, 500.00),
(325, 337, NULL, 'Test', NULL, 1, 500.00),
(326, 338, NULL, 'Test', NULL, 1, 500.00),
(327, 339, NULL, 'Test', NULL, 1, 500.00),
(328, 340, NULL, 'Test', NULL, 1, 500.00),
(329, 341, NULL, 'Test', NULL, 1, 500.00),
(330, 342, NULL, 'Test', NULL, 1, 500.00),
(331, 343, NULL, NULL, NULL, 1, 0.00),
(332, 344, NULL, NULL, NULL, 1, 0.00),
(333, 345, NULL, 'Test', NULL, 1, 455.00),
(334, 346, NULL, NULL, NULL, 1, 0.00),
(335, 347, NULL, NULL, NULL, 1, 0.00),
(336, 348, NULL, NULL, NULL, 1, 0.00),
(337, 349, NULL, NULL, NULL, 1, 0.00),
(338, 350, NULL, NULL, NULL, 1, 0.00),
(339, 351, NULL, NULL, NULL, 1, 0.00),
(340, 352, NULL, NULL, NULL, 1, 0.00),
(341, 353, NULL, NULL, NULL, 1, 0.00),
(342, 354, NULL, NULL, NULL, 1, 0.00),
(343, 355, NULL, NULL, NULL, 1, 0.00),
(344, 356, NULL, NULL, NULL, 1, 0.00),
(345, 357, NULL, 'asdf', NULL, 1, NULL),
(346, 358, NULL, 'asdf', NULL, 1, NULL),
(347, 359, NULL, 'asdf', NULL, 1, NULL),
(348, 360, NULL, 'asdf', NULL, 1, NULL),
(349, 361, NULL, 'asdf', NULL, 1, NULL),
(350, 362, NULL, 'asdf', NULL, 1, NULL),
(351, 363, NULL, 'asdf', NULL, 1, NULL),
(352, 364, NULL, 'asdf', NULL, 1, NULL),
(353, 365, NULL, 'asdf', NULL, 1, NULL),
(354, 366, NULL, 'asdf', NULL, 1, NULL),
(355, 367, NULL, NULL, NULL, 1, 120.00),
(356, 368, NULL, NULL, NULL, 1, 120.00),
(357, 369, NULL, NULL, NULL, 1, 120.00),
(358, 370, NULL, NULL, NULL, 1, 120.00),
(359, 371, NULL, NULL, NULL, 1, 120.00),
(360, 372, NULL, NULL, NULL, 1, 120.00),
(361, 373, NULL, NULL, NULL, 1, 120.00),
(362, 374, NULL, NULL, NULL, 1, 120.00),
(363, 375, NULL, NULL, NULL, 1, 120.00),
(364, 376, NULL, NULL, NULL, 1, 120.00),
(365, 377, NULL, NULL, NULL, 1, 0.00),
(366, 378, NULL, NULL, NULL, 1, 0.00),
(367, 379, NULL, NULL, NULL, 1, 0.00),
(368, 380, NULL, NULL, NULL, 1, 0.00),
(369, 381, NULL, NULL, NULL, 1, 0.00),
(370, 382, NULL, NULL, NULL, 1, 0.00),
(371, 383, NULL, NULL, NULL, 1, 0.00),
(372, 384, NULL, NULL, NULL, 1, 0.00),
(373, 385, NULL, NULL, NULL, 1, 0.00),
(374, 386, NULL, NULL, NULL, 1, 0.00),
(375, 387, NULL, NULL, NULL, 1, 0.00),
(376, 388, NULL, NULL, NULL, 1, 0.00),
(377, 389, NULL, NULL, NULL, 1, 0.00),
(378, 390, NULL, NULL, NULL, 1, 0.00),
(379, 391, 6, 'walter podolsky', 'service2', 1, 320.00),
(380, 391, 5, 'walter podolsky', 'sevice1', 1, 130.00),
(381, 392, NULL, NULL, NULL, 1, 0.00),
(382, 393, NULL, NULL, NULL, 1, 0.00),
(383, 394, NULL, NULL, NULL, 1, 0.00),
(384, 395, NULL, NULL, NULL, 1, 0.00),
(385, 396, NULL, NULL, NULL, 1, 0.00),
(386, 397, NULL, NULL, NULL, 1, 0.00),
(387, 398, NULL, NULL, NULL, 1, 0.00),
(388, 399, NULL, NULL, NULL, 1, 0.00),
(389, 400, NULL, NULL, NULL, 1, 0.00),
(390, 401, NULL, 'test', NULL, 1, 5000.00),
(391, 402, NULL, 'test', NULL, 1, 5000.00),
(392, 403, NULL, 'test', NULL, 1, 5000.00),
(393, 404, NULL, 'test', NULL, 1, 5000.00),
(394, 405, NULL, 'test', NULL, 1, 5000.00),
(395, 406, NULL, 'test', NULL, 1, 5000.00),
(396, 407, NULL, 'test', NULL, 1, 5000.00),
(397, 408, NULL, 'test', NULL, 1, 5000.00),
(398, 409, NULL, 'test', NULL, 1, 5000.00),
(399, 410, NULL, 'test', NULL, 1, 5000.00),
(400, 411, NULL, NULL, NULL, 1, 0.00),
(401, 412, NULL, 'Test', NULL, 1, 122332.00),
(402, 413, NULL, 'Test', NULL, 1, 122332.00),
(403, 414, NULL, 'Test', NULL, 1, 122332.00),
(404, 415, NULL, 'Test', NULL, 1, 122332.00),
(405, 416, NULL, 'Test', NULL, 1, 122332.00),
(406, 417, NULL, 'Test', NULL, 1, 122332.00),
(407, 418, NULL, 'Test', NULL, 1, 122332.00),
(408, 419, NULL, 'Test', NULL, 1, 122332.00),
(409, 420, NULL, 'Test', NULL, 1, 122332.00),
(410, 421, NULL, 'Test', NULL, 1, 122332.00),
(411, 422, NULL, 'Test', NULL, 1, 122332.00),
(412, 423, NULL, NULL, NULL, 1, 2343434.00),
(413, 424, NULL, NULL, NULL, 1, 2343434.00),
(414, 425, NULL, NULL, NULL, 1, 2343434.00),
(415, 426, NULL, NULL, NULL, 1, 2343434.00),
(416, 427, NULL, NULL, NULL, 1, 2343434.00),
(417, 428, NULL, NULL, NULL, 1, 2343434.00),
(418, 429, NULL, NULL, NULL, 1, 2343434.00),
(419, 430, NULL, NULL, NULL, 1, 2343434.00),
(420, 431, NULL, NULL, NULL, 1, 2343434.00),
(421, 432, NULL, NULL, NULL, 1, 2343434.00),
(422, 433, NULL, NULL, NULL, 1, 2343434.00),
(423, 434, NULL, NULL, NULL, 1, 2343434.00),
(424, 435, NULL, NULL, NULL, 1, 0.00),
(425, 436, NULL, NULL, NULL, 1, 0.00),
(427, 438, NULL, NULL, NULL, 1, 0.00),
(428, 439, NULL, NULL, NULL, 1, 0.00),
(429, 440, NULL, NULL, NULL, 1, 0.00),
(430, 441, NULL, NULL, NULL, 1, 0.00),
(431, 442, NULL, NULL, NULL, 1, 0.00),
(432, 443, NULL, NULL, NULL, 1, 0.00),
(433, 444, NULL, NULL, NULL, 1, 0.00),
(434, 445, NULL, NULL, NULL, 1, 0.00),
(435, 446, NULL, NULL, NULL, 1, 0.00),
(436, 447, NULL, NULL, NULL, 1, 0.00),
(437, 448, NULL, NULL, NULL, 1, 0.00),
(438, 449, NULL, NULL, NULL, 1, 0.00),
(439, 450, NULL, NULL, NULL, 1, 0.00),
(440, 451, NULL, NULL, NULL, 1, 0.00),
(441, 452, NULL, NULL, NULL, 1, 0.00),
(442, 453, NULL, NULL, NULL, 1, 0.00),
(443, 454, NULL, NULL, NULL, 1, 0.00),
(444, 455, NULL, NULL, NULL, 1, 0.00),
(445, 456, NULL, NULL, NULL, 1, 0.00),
(446, 457, NULL, NULL, NULL, 1, 0.00),
(447, 458, NULL, NULL, NULL, 1, 0.00),
(448, 459, NULL, NULL, NULL, 1, 0.00),
(449, 460, NULL, NULL, NULL, 1, 0.00),
(450, 461, NULL, NULL, NULL, 1, 0.00),
(451, 462, NULL, NULL, NULL, 1, 0.00),
(452, 463, NULL, NULL, NULL, 1, 0.00),
(453, 464, NULL, NULL, NULL, 1, 0.00),
(454, 465, NULL, NULL, NULL, 1, 0.00),
(455, 466, NULL, NULL, NULL, 1, 0.00),
(456, 467, NULL, NULL, NULL, 1, 0.00),
(457, 468, NULL, NULL, NULL, 1, 0.00),
(458, 469, NULL, NULL, NULL, 1, 0.00),
(459, 470, NULL, NULL, NULL, 1, 0.00),
(460, 471, NULL, NULL, NULL, 1, 0.00),
(461, 472, NULL, NULL, NULL, 1, 0.00),
(462, 473, NULL, NULL, NULL, 1, 0.00),
(463, 474, NULL, NULL, NULL, 1, 0.00),
(464, 475, NULL, NULL, NULL, 1, 0.00),
(465, 476, NULL, NULL, NULL, 1, 0.00),
(466, 477, NULL, NULL, NULL, 1, 0.00),
(467, 478, NULL, NULL, NULL, 1, 0.00),
(468, 479, NULL, NULL, NULL, 1, 0.00),
(469, 480, NULL, NULL, NULL, 1, 0.00),
(470, 481, NULL, NULL, NULL, 1, 0.00),
(471, 482, NULL, NULL, NULL, 1, 0.00),
(472, 483, NULL, NULL, NULL, 1, 0.00),
(473, 484, NULL, NULL, NULL, 1, 0.00),
(474, 485, NULL, NULL, NULL, 1, 0.00),
(475, 486, NULL, NULL, NULL, 1, 0.00),
(476, 487, NULL, NULL, NULL, 1, 0.00),
(477, 488, NULL, NULL, NULL, 1, 0.00),
(478, 489, NULL, NULL, NULL, 1, 0.00),
(479, 490, NULL, NULL, NULL, 1, 0.00),
(480, 491, NULL, NULL, NULL, 1, 0.00),
(481, 492, NULL, NULL, NULL, 1, 0.00),
(483, 494, NULL, NULL, NULL, 1, 0.00),
(484, 494, NULL, NULL, NULL, 1, 0.00),
(485, 495, NULL, NULL, NULL, 1, 0.00),
(486, 496, NULL, NULL, NULL, 1, 0.00),
(487, 497, NULL, NULL, NULL, 1, 0.00),
(488, 498, NULL, NULL, NULL, 1, 0.00),
(489, 499, NULL, NULL, NULL, 1, 0.00),
(490, 500, NULL, NULL, NULL, 1, 0.00),
(491, 501, NULL, NULL, NULL, 1, 0.00),
(492, 502, NULL, NULL, NULL, 1, 0.00),
(493, 503, NULL, NULL, NULL, 1, 0.00),
(494, 504, NULL, 'AAA', 'price', 1, 25.00),
(495, 505, NULL, 'AAA', 'price', 1, 25.00),
(496, 506, NULL, 'AAA', 'price', 1, 25.00),
(497, 507, NULL, 'AAA', 'price', 1, 25.00),
(498, 508, NULL, NULL, NULL, 1, 0.00),
(499, 509, NULL, NULL, NULL, 1, 0.00),
(500, 510, NULL, NULL, NULL, 1, 0.00),
(501, 511, NULL, NULL, NULL, 1, 0.00),
(502, 512, NULL, NULL, NULL, 1, 0.00),
(503, 513, NULL, NULL, NULL, 1, 0.00),
(504, 514, NULL, NULL, NULL, 1, 0.00),
(505, 515, NULL, NULL, NULL, 1, 0.00),
(506, 516, NULL, NULL, NULL, 1, 0.00),
(507, 517, NULL, NULL, NULL, 1, 0.00),
(508, 518, NULL, NULL, NULL, 1, 0.00),
(509, 519, NULL, NULL, NULL, 1, 0.00),
(510, 520, NULL, NULL, NULL, 1, 0.00),
(511, 521, NULL, NULL, NULL, 1, 0.00),
(512, 522, NULL, NULL, NULL, 1, 0.00),
(513, 523, NULL, NULL, NULL, 1, 0.00),
(514, 524, NULL, NULL, NULL, 1, 0.00),
(515, 525, NULL, NULL, NULL, 1, 0.00),
(516, 526, NULL, NULL, NULL, 1, 0.00),
(517, 527, NULL, NULL, NULL, 1, 0.00),
(518, 528, NULL, NULL, NULL, 1, 0.00),
(519, 529, NULL, NULL, NULL, 1, 0.00),
(520, 530, NULL, NULL, NULL, 1, 0.00),
(521, 531, NULL, NULL, NULL, 1, 0.00),
(522, 532, NULL, NULL, NULL, 1, 0.00),
(523, 533, NULL, NULL, NULL, 1, 0.00),
(524, 534, NULL, NULL, NULL, 1, 0.00),
(525, 535, NULL, NULL, NULL, 1, 0.00),
(526, 536, NULL, NULL, NULL, 1, 0.00),
(527, 537, NULL, NULL, NULL, 1, 0.00),
(528, 538, NULL, NULL, NULL, 1, 0.00),
(529, 539, NULL, NULL, NULL, 1, 0.00),
(530, 540, NULL, NULL, NULL, 1, 0.00),
(531, 541, NULL, NULL, NULL, 1, 0.00),
(532, 542, NULL, NULL, NULL, 1, 0.00),
(533, 543, NULL, NULL, NULL, 1, 0.00),
(534, 544, NULL, NULL, NULL, 1, 0.00),
(535, 545, NULL, NULL, NULL, 1, 0.00),
(536, 546, NULL, NULL, NULL, 1, 0.00),
(537, 547, NULL, NULL, NULL, 1, 0.00),
(538, 548, NULL, NULL, NULL, 1, 0.00),
(539, 549, NULL, NULL, NULL, 1, 0.00),
(540, 549, NULL, NULL, NULL, 1, 0.00),
(541, 550, NULL, NULL, NULL, 1, 0.00),
(542, 550, NULL, NULL, NULL, 1, 0.00),
(543, 551, NULL, NULL, NULL, 1, 0.00),
(544, 551, NULL, NULL, NULL, 1, 0.00),
(545, 552, NULL, NULL, NULL, 1, 0.00),
(546, 552, NULL, NULL, NULL, 1, 0.00),
(547, 553, NULL, NULL, NULL, 1, 0.00),
(548, 553, NULL, NULL, NULL, 1, 0.00),
(549, 554, NULL, NULL, NULL, 1, 0.00),
(550, 554, NULL, NULL, NULL, 1, 0.00),
(551, 555, NULL, NULL, NULL, 1, 0.00),
(552, 555, NULL, NULL, NULL, 1, 0.00),
(553, 556, NULL, NULL, NULL, 1, 0.00),
(554, 556, NULL, NULL, NULL, 1, 0.00),
(555, 557, NULL, NULL, NULL, 1, 0.00),
(556, 557, NULL, NULL, NULL, 1, 0.00),
(557, 558, NULL, NULL, NULL, 1, 0.00),
(558, 558, NULL, NULL, NULL, 1, 0.00),
(559, 559, NULL, NULL, NULL, 1, 0.00),
(560, 559, NULL, NULL, NULL, 1, 0.00),
(561, 560, NULL, NULL, NULL, 1, 0.00),
(562, 560, NULL, NULL, NULL, 1, 0.00),
(563, 561, NULL, NULL, NULL, 1, 0.00),
(564, 561, NULL, NULL, NULL, 1, 0.00),
(565, 562, NULL, NULL, NULL, 1, 0.00),
(566, 562, NULL, NULL, NULL, 1, 0.00),
(567, 563, NULL, NULL, NULL, 1, 0.00),
(568, 563, NULL, NULL, NULL, 1, 0.00),
(569, 564, NULL, NULL, NULL, 1, 0.00),
(570, 564, NULL, NULL, NULL, 1, 0.00),
(571, 565, NULL, NULL, NULL, 1, 0.00),
(572, 565, NULL, NULL, NULL, 1, 0.00),
(573, 566, NULL, NULL, NULL, 1, 0.00),
(574, 566, NULL, NULL, NULL, 1, 0.00),
(575, 567, NULL, NULL, NULL, 1, 0.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
