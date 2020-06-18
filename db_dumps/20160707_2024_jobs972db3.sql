-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql.jobs972.com
-- Generation Time: Jul 07, 2016 at 10:24 AM
-- Server version: 5.6.25-log
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobs972db3`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `name_eng` varchar(200) DEFAULT NULL,
  `name_heb` varchar(200) DEFAULT NULL,
  `createdt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifydt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `name`, `name_eng`, `name_heb`, `createdt`, `modifydt`) VALUES
(1, 'CONTACT_US', 'Contact Us', NULL, '2016-06-19 13:30:26', '2016-06-19 13:30:26'),
(2, 'NEW_USER_REGISTERED', 'User Registered', NULL, '2016-06-29 14:04:13', '2016-06-29 14:04:13'),
(3, 'USER_LOGIN', 'User Login', NULL, '2016-07-02 07:41:33', '2016-07-02 07:41:33'),
(4, 'USER_DETAILS_CHANGE', 'User Details Changed', NULL, '2016-07-07 05:23:37', '2016-07-07 05:23:37'),
(5, 'USER_EMAIL_VERIFIED', 'User Email Was Verified', NULL, '2016-07-07 09:45:26', '2016-07-07 09:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `businesslog`
--

CREATE TABLE `businesslog` (
  `id` int(11) NOT NULL,
  `datex` datetime NOT NULL,
  `alert_id` int(11) NOT NULL,
  `principal_id` int(11) NOT NULL,
  `ip_addr` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `the_info` varchar(4000) NOT NULL,
  `the_info_user_en` varchar(4000) DEFAULT NULL,
  `the_info_user_he` varchar(4000) DEFAULT NULL,
  `the_page` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businesslog`
--

INSERT INTO `businesslog` (`id`, `datex`, `alert_id`, `principal_id`, `ip_addr`, `email`, `the_info`, `the_info_user_en`, `the_info_user_he`, `the_page`) VALUES
(1, '2016-06-19 23:27:24', 0, 0, '85.250.131.106', 'dasdasf@fdgdsg.ru', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:27:24</b><br/>Имя отправителя сообщения: <b>qwerqewr</b><br/>Фамилия отправителя сообщения: <b>qwerqwer</b><br/>Email отправителя сообщения: <b>dasdasf@fdgdsg.ru</b><br/>Тема сообщения: <b>rqwerqwer</b><br/>Сообщение: <b>rqwerqwerqw</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', '', '', ''),
(2, '2016-06-19 23:31:10', 0, 0, '85.250.131.106', 'adsffadsf@fafads.com', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:31:10</b><br/>Имя отправителя сообщения: <b>qew</b><br/>Фамилия отправителя сообщения: <b>adsfads</b><br/>Email отправителя сообщения: <b>adsffadsf@fafads.com</b><br/>Тема сообщения: <b>dasfasdfasdf</b><br/>Сообщение: <b>asdfasdfasdf</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', '', '', 'contactus.php'),
(3, '2016-06-19 23:32:34', 0, 0, '85.250.131.106', 'qwerqewr@dfdasf.com', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:32:34</b><br/>Имя отправителя сообщения: <b>werewr</b><br/>Фамилия отправителя сообщения: <b>qewrqewr</b><br/>Email отправителя сообщения: <b>qwerqewr@dfdasf.com</b><br/>Тема сообщения: <b>qwerqewr</b><br/>Сообщение: <b>asdfasfasdf</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', '', '', 'contactus.php'),
(4, '2016-06-19 23:32:56', 0, 0, '85.250.131.106', 'asdfasd@dssss.com', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:32:56</b><br/>Имя отправителя сообщения: <b>asdfasdfdasf</b><br/>Фамилия отправителя сообщения: <b>dwerdasfdasfs</b><br/>Email отправителя сообщения: <b>asdfasd@dssss.com</b><br/>Тема сообщения: <b>fasdfasf</b><br/>Сообщение: <b>asdfdasf</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', '', '', 'contactus.php'),
(5, '2016-06-30 00:25:06', 2, 0, '85.250.131.106', 'test3@test4.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 00:25:06</b><br/> \nUser Firstname: <b>Test1</b><br/>\nUser Lastname: <b>Test2</b><br/>\nEmail: <b>test3@test4.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(6, '2016-06-30 00:39:31', 2, 0, '85.250.131.106', 'sdfdsf@dffaasf.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 00:39:31</b><br/> \nUser Firstname: <b>dffsdfds</b><br/>\nUser Lastname: <b>sdfdsfsdf</b><br/>\nEmail: <b>sdfdsf@dffaasf.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(7, '2016-06-30 00:50:51', 2, 0, '85.250.131.106', 'dasfadsf@dffasdf.cm', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 00:50:51</b><br/> \nUser Firstname: <b>dfafdsf</b><br/>\nUser Lastname: <b>asdfasf</b><br/>\nEmail: <b>dasfadsf@dffasdf.cm</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(8, '2016-06-30 01:42:43', 2, 0, '85.250.131.106', 'sfasdf@dsfdasf.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 01:42:43</b><br/> \nUser Firstname: <b>dfgttttt</b><br/>\nUser Lastname: <b>sdfgsdfg</b><br/>\nEmail: <b>sfasdf@dsfdasf.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(9, '2016-06-30 01:44:06', 2, 0, '85.250.131.106', 'erwtewr@dsafdas.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 01:44:06</b><br/> \nUser Firstname: <b>rewtwert</b><br/>\nUser Lastname: <b>ewrtwert</b><br/>\nEmail: <b>erwtewr@dsafdas.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(10, '2016-06-30 01:46:36', 2, 0, '85.250.131.106', 'erwtewdr@dsafdas.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 01:46:36</b><br/> \nUser Firstname: <b>rewtwert</b><br/>\nUser Lastname: <b>ewrtwert</b><br/>\nEmail: <b>erwtewdr@dsafdas.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(11, '2016-06-30 01:47:00', 2, 0, '85.250.131.106', 'asdfa@dsfasfadsf.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>30-06-2016 01:47:00</b><br/> \nUser Firstname: <b>asdfasdf</b><br/>\nUser Lastname: <b>asdfasdf</b><br/>\nEmail: <b>asdfa@dsfasfadsf.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(12, '2016-07-02 16:16:44', 2, 0, '85.250.131.106', 'myemail@somehere.net', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>02-07-2016 16:16:44</b><br/> \nUser Firstname: <b>MyName</b><br/>\nUser Lastname: <b>MyLastName</b><br/>\nEmail: <b>myemail@somehere.net</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(13, '2016-07-02 16:17:52', 2, 0, '85.250.131.106', 'dsfas@dsfasdf.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>02-07-2016 16:17:52</b><br/> \nUser Firstname: <b>11213</b><br/>\nUser Lastname: <b>23434</b><br/>\nEmail: <b>dsfas@dsfasdf.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(14, '2016-07-02 17:48:08', 2, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>02-07-2016 17:48:08</b><br/> \nUser Firstname: <b>MyFirstName</b><br/>\nUser Lastname: <b>MyLastName</b><br/>\nEmail: <b>myemail@no.com</b><br/><br/>\n<br/>Regards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(15, '2016-07-02 17:49:12', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:49:12</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(16, '2016-07-02 17:49:23', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:49:23</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(17, '2016-07-02 17:50:12', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:50:12</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(18, '2016-07-02 17:51:19', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:51:19</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(19, '2016-07-02 17:52:23', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:52:23</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(20, '2016-07-02 17:53:10', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:53:10</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(21, '2016-07-02 17:53:53', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:53:53</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(22, '2016-07-02 17:55:57', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 17:55:57</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(23, '2016-07-02 18:06:47', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:06:47</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(24, '2016-07-02 18:13:07', 3, 0, '85.250.161.14', '', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:13:07</b><br/> \nEmail: <b></b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(25, '2016-07-02 18:14:48', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:14:48</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(26, '2016-07-02 18:18:19', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:18:19</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(27, '2016-07-02 18:47:15', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:47:15</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(28, '2016-07-02 18:49:17', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:49:17</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(29, '2016-07-02 18:53:37', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 18:53:37</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(30, '2016-07-02 19:01:53', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 19:01:53</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(31, '2016-07-02 19:06:59', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 19:06:59</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(32, '2016-07-02 19:14:45', 3, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 19:14:45</b><br/> \nEmail: <b>myemail@no.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '', '', ''),
(33, '2016-07-02 19:54:25', 1, 0, '85.250.161.14', 'myemail@no.com', '<html><body>Hello, Jobs972!<br/><br/>You have a new message from the contact page of the Jobs972!<br/><br/>The date of the message: <b>02-07-2016 19:54:25</b><br/>The first name of the sender: <b>1111</b><br/>The last name of the sender: <b>22222</b><br/>Email of the sender: <b>myemail@no.com</b><br/>The subject of the message: <b>333333</b><br/>The message: <b>eeeeeeeee</b><br/><br/>Regards,  <br/>Administrator.</body></html>', '<html><body>The Contact Us message sent from the Jobs972!<br/><br/>The date of the message: <b>02-07-2016 19:54:25</b><br/>The first name of the sender: <b>1111</b><br/>The last name of the sender: <b>22222</b><br/>Email of the sender: <b>myemail@no.com</b><br/>The subject of the message: <b>333333</b><br/>The message: <b>eeeeeeeee</b><br/><br/></body></html>', NULL, 'contactus.php'),
(34, '2016-07-02 22:20:07', 2, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>02-07-2016 22:20:07</b><br/> \nUser Firstname: <b>Dmitry</b><br/>\nUser Lastname: <b>Romanoff</b><br/>\nEmail: <b>dmr@yandex.ru</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', NULL, NULL, ''),
(35, '2016-07-02 22:21:31', 3, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 22:21:31</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', NULL, NULL, ''),
(36, '2016-07-02 22:26:44', 3, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLoging Date: <b>02-07-2016 22:26:44</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', NULL, NULL, ''),
(37, '2016-07-02 22:29:52', 3, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 22:29:52</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In on the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 22:29:52</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/></body></html>', NULL, ''),
(38, '2016-07-02 22:32:02', 3, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In on the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 22:32:02</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In on the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 22:32:02</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(39, '2016-07-02 22:36:57', 3, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 22:36:57</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 22:36:57</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(40, '2016-07-02 22:40:59', 2, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>02-07-2016 22:40:59</b><br/> \nUser Firstname: <b>Dmitry</b><br/>\nUser Lastname: <b>Romanoff</b><br/>\nEmail: <b>dmr@yahoo.com</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Registered the Jobs972.com!<br/>\nCreation Date: <b>02-07-2016 22:40:59</b><br/> \nUser Firstname: <b>Dmitry</b><br/>\nUser Lastname: <b>Romanoff</b><br/>\nEmail: <b>dmr@yahoo.com</b><br/>\nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(41, '2016-07-02 22:41:15', 3, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 22:41:15</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 22:41:15</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(42, '2016-07-02 22:45:51', 3, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 22:45:51</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 22:45:51</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(43, '2016-07-02 22:46:30', 1, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972!<br/><br/>You have a new message from the contact page of the Jobs972!<br/><br/>The date of the message: <b>02-07-2016 22:46:30</b><br/>The first name of the sender: <b>Dmitry</b><br/>The last name of the sender: <b>Romanoff</b><br/>Email of the sender: <b>dmr@yahoo.com</b><br/>The subject of the message: <b>Subj</b><br/>The message: <b>My message | my message!!!!</b><br/><br/>Regards,  <br/>Administrator.</body></html>', '<html><body>The Contact Us message sent from the Jobs972!<br/><br/>The date of the message: <b>02-07-2016 22:46:30</b><br/>The first name of the sender: <b>Dmitry</b><br/>The last name of the sender: <b>Romanoff</b><br/>Email of the sender: <b>dmr@yahoo.com</b><br/>The subject of the message: <b>Subj</b><br/>The message: <b>My message | my message!!!!</b><br/></body></html>', NULL, 'contactus.php'),
(44, '2016-07-02 22:50:14', 1, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972!<br/><br/>\nYou have a new message from the contact page of the Jobs972!<br/><br/>\nThe date of the message: <b>02-07-2016 22:50:14</b><br/>\nThe first name of the sender: <b>Dmitry</b><br/>\nThe last name of the sender: <b>Romanoff</b><br/>\nEmail of the sender: <b>dmr@yahoo.com</b><br/>\nThe subject of the message: <b>Subj</b><br/>\nThe message: <b>Message   Message !!!</b><br/><br/>\nRegards,  <br/>\nAdministrator.</body></html>', '<html><body>\nThe Contact Us message sent from the Jobs972.com!<br/>\nThe Date of the Message: <b>02-07-2016 22:50:14</b><br/>\nThe First Name of the Sender: <b>Dmitry</b><br/>\nThe Last Name of the Sender: <b>Romanoff</b><br/>\nEmail of the sender: <b>dmr@yahoo.com</b><br/>\nThe Subject of the Message: <b>Subj</b><br/>\nIP Address: <b>Subj</b><br/>\nThe Message: <b>85.250.161.14</b><br/></body></html>', NULL, 'contactus.php'),
(45, '2016-07-02 22:53:06', 1, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972.com!<br/><br/>\nYou have a new message from the contact page of the Jobs972.com!<br/><br/>\nThe date of the Message: <b>02-07-2016 22:53:06</b><br/>\nThe first name of the Sender: <b>Dmitry</b><br/>\nThe last name of the Sender: <b>Romanoff</b><br/>\nEmail of the Sender: <b>dmr@yahoo.com</b><br/>\nThe Subject of the Message: <b>Subj Subj</b><br/>\nThe Message: <b>My message | My message | My message </b><br/><br/>\nRegards,  <br/>\nAdministrator.</body></html>', '<html><body>\nThe Contact Us message sent from the Jobs972.com!<br/>\nThe Date of the Message: <b>02-07-2016 22:53:06</b><br/>\nThe First Name of the Sender: <b>Dmitry</b><br/>\nThe Last Name of the Sender: <b>Romanoff</b><br/>\nEmail of the sender: <b>dmr@yahoo.com</b><br/>\nThe Subject of the Message: <b>Subj Subj</b><br/>\nThe Message: <b>My message | My message | My message </b><br/>\nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, 'contactus.php'),
(46, '2016-07-02 23:04:00', 3, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 23:04:00</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 23:04:00</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(47, '2016-07-02 23:04:12', 3, 0, '85.250.161.14', 'dmr@yahoo.com', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 23:04:12</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 23:04:12</b><br/> \nEmail: <b>dmr@yahoo.com</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(48, '2016-07-02 23:23:20', 3, 0, '85.250.161.14', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>02-07-2016 23:23:20</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/>\nIP Address: <b>85.250.161.14</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>02-07-2016 23:23:20</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/> \nIP Address: <b>85.250.161.14</b><br/></body></html>', NULL, ''),
(49, '2016-07-07 13:04:32', 3, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>07-07-2016 13:04:32</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>07-07-2016 13:04:32</b><br/> \nEmail: <b>dmr@yandex.ru</b><br/> \nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(50, '2016-07-07 15:22:12', 2, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:22:12</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Password</b><br/>\nAttribute New Value: <b>12345</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:22:12</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Password</b><br/>\nAttribute New Value: <b>12345</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(51, '2016-07-07 15:29:06', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:29:06</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Password</b><br/>\nAttribute New Value: <b>123456</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:29:06</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Password</b><br/>\nAttribute New Value: <b>123456</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(52, '2016-07-07 15:38:11', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:38:11</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Ivan</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:38:11</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Ivan</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(53, '2016-07-07 15:40:15', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:40:15</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:40:15</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(54, '2016-07-07 15:47:43', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:47:43</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff2</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:47:43</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff2</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(55, '2016-07-07 15:47:55', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:47:55</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:47:55</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(56, '2016-07-07 15:51:47', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 15:51:47</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff2</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 15:51:47</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff2</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(57, '2016-07-07 16:01:24', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 16:01:24</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 16:01:24</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Lastname</b><br/>\nAttribute New Value: <b>Romanoff</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(58, '2016-07-07 16:40:29', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 16:40:29</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>0</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 16:40:29</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>0</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(59, '2016-07-07 16:57:39', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 16:57:39</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry2</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 16:57:39</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry2</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(60, '2016-07-07 16:57:51', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 16:57:51</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 16:57:51</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(61, '2016-07-07 17:06:31', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 17:06:31</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>1</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 17:06:31</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>1</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(62, '2016-07-07 17:07:40', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 17:07:40</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry2</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 17:07:40</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry2</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(63, '2016-07-07 17:08:01', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 17:08:01</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>0</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 17:08:01</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>0</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(64, '2016-07-07 17:08:11', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 17:08:11</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 17:08:11</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Firstname</b><br/>\nAttribute New Value: <b>Dmitry</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(65, '2016-07-07 17:08:27', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 17:08:27</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>1</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 17:08:27</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Profile_Status</b><br/>\nAttribute New Value: <b>1</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(66, '2016-07-07 18:06:31', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:06:31</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>City</b><br/>\nAttribute New Value: <b>Moscow</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:06:31</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>City</b><br/>\nAttribute New Value: <b>Moscow</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(67, '2016-07-07 18:06:44', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:06:44</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>City</b><br/>\nAttribute New Value: <b>Tel-Aviv</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:06:44</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>City</b><br/>\nAttribute New Value: <b>Tel-Aviv</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(68, '2016-07-07 18:21:03', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:21:03</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Mobile</b><br/>\nAttribute New Value: <b>12345</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:21:03</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Mobile</b><br/>\nAttribute New Value: <b>12345</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(69, '2016-07-07 18:47:39', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:47:39</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>LinkedInURL</b><br/>\nAttribute New Value: <b>http://mylinkedin.com</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:47:39</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>LinkedInURL</b><br/>\nAttribute New Value: <b>http://mylinkedin.com</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(70, '2016-07-07 18:51:22', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:51:22</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Positions</b><br/>\nAttribute New Value: <b>CTO, VP R&D, Head of Data</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:51:22</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Positions</b><br/>\nAttribute New Value: <b>CTO, VP R&D, Head of Data</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(71, '2016-07-07 18:57:27', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:57:27</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Is_Citizen</b><br/>\nAttribute New Value: <b>0</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:57:27</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Is_Citizen</b><br/>\nAttribute New Value: <b>0</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(72, '2016-07-07 18:57:36', 4, 0, '85.250.134.114', 'dmr@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 18:57:36</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Is_Citizen</b><br/>\nAttribute New Value: <b>1</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 18:57:36</b><br/> \nUser Email: <b>dmr@yandex.ru</b><br/>\nAttribute Change: <b>Is_Citizen</b><br/>\nAttribute New Value: <b>1</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(73, '2016-07-07 19:25:55', 2, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nA new user was registered on the Jobs972.com!<br/><br/> \nCreation Date: <b>07-07-2016 19:25:55</b><br/> \nUser Firstname: <b>Dod</b><br/>\nUser Lastname: <b>Huenson</b><br/>\nEmail: <b>dod.huenson@yandex.ru</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Registered the Jobs972.com!<br/>\nCreation Date: <b>07-07-2016 19:25:55</b><br/> \nUser Firstname: <b>Dod</b><br/>\nUser Lastname: <b>Huenson</b><br/>\nEmail: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(74, '2016-07-07 19:26:55', 3, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Logged In the Jobs972.com!<br/><br/> \nLogin Date: <b>07-07-2016 19:26:55</b><br/> \nEmail: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Logged In the Jobs972.com!<br/>\nLogin Date: <b>07-07-2016 19:26:55</b><br/> \nEmail: <b>dod.huenson@yandex.ru</b><br/> \nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(75, '2016-07-07 19:54:31', 5, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Email Was Successfully Verified on the Jobs972.com!<br/><br/> \nVerify Date: <b>07-07-2016 19:54:31</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Email Was Successfully Verified on the Jobs972.com!<br/>\nVerify Date: <b>07-07-2016 19:54:31</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(76, '2016-07-07 20:01:10', 5, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Email Was Successfully Verified on the Jobs972.com!<br/><br/> \nVerify Date: <b>07-07-2016 20:01:10</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Email Was Successfully Verified on the Jobs972.com!<br/>\nVerify Date: <b>07-07-2016 20:01:10</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(77, '2016-07-07 20:09:57', 5, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Email Was Successfully Verified on the Jobs972.com!<br/><br/> \nVerify Date: <b>07-07-2016 20:09:57</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Email Was Successfully Verified on the Jobs972.com!<br/>\nVerify Date: <b>07-07-2016 20:09:57</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(78, '2016-07-07 20:11:00', 4, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 20:11:00</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>City</b><br/>\nAttribute New Value: <b>Bat Yam</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 20:11:00</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>City</b><br/>\nAttribute New Value: <b>Bat Yam</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(79, '2016-07-07 20:11:13', 4, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 20:11:13</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>Mobile</b><br/>\nAttribute New Value: <b>972-03-539-02-12</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 20:11:13</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>Mobile</b><br/>\nAttribute New Value: <b>972-03-539-02-12</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(80, '2016-07-07 20:11:35', 4, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 20:11:35</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>Positions</b><br/>\nAttribute New Value: <b>Software Engineer C++/C#/.NET & Other</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 20:11:35</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>Positions</b><br/>\nAttribute New Value: <b>Software Engineer C++/C#/.NET & Other</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, ''),
(81, '2016-07-07 20:20:49', 4, 0, '85.250.134.114', 'dod.huenson@yandex.ru', '<html><body>Hello, Jobs972.com!<br/><br/> \nUser Details Change on the Jobs972.com!<br/><br/> \nModify Date: <b>07-07-2016 20:20:49</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>LinkedInURL</b><br/>\nAttribute New Value: <b>somewhere...</b><br/>\nIP Address: <b>85.250.134.114</b><br/><br/>\nRegards,  <br/> \nAdministrator.</body></html>', '<html><body> \nUser Details Change on the Jobs972.com!<br/>\nModify Date: <b>07-07-2016 20:20:49</b><br/> \nUser Email: <b>dod.huenson@yandex.ru</b><br/>\nAttribute Change: <b>LinkedInURL</b><br/>\nAttribute New Value: <b>somewhere...</b><br/>\nIP Address: <b>85.250.134.114</b><br/></body></html>', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_name_heb` varchar(100) NOT NULL,
  `cat_ord` int(11) NOT NULL,
  `n_pos` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `cat_name_heb`, `cat_ord`, `n_pos`) VALUES
(1, 'Administration', 'אדמיניסטרציה', 1, 0),
(2, 'Internet', 'אינטרנט', 2, 0),
(3, 'Insurance', 'ביטוח', 3, 0),
(4, 'Senior / Management', 'בכירים / ניהול', 4, 0),
(5, 'Professionals', 'בעלי מקצוע', 5, 0),
(6, 'Training / Teaching', 'הדרכה / הוראה', 6, 0),
(7, 'QA Hitech', 'הייטק-QA', 7, 0),
(8, 'High-Tech Hardware', 'הייטק-חומרה', 8, 0),
(9, 'High-Tech General', 'הייטק-כללי', 9, 0),
(10, 'High-Tech Software', 'הייטק-תוכנה', 10, 0),
(11, 'Engineering', 'הנדסה', 11, 0),
(12, 'General', 'כללי', 12, 0),
(13, 'Finance', 'כספים', 13, 0),
(14, 'Logistics / Forwarding', 'לוגיסטיקה / שילוח', 14, 0),
(15, 'Science / Biotech', 'מדעים / ביוטק', 15, 0),
(16, 'Sales', 'מכירות', 16, 0),
(17, 'Restaurant / Tourism', 'מסעדנות / תיירות', 17, 0),
(18, 'Human Resources', 'משאבי אנוש', 18, 0),
(19, 'Work from home', 'עבודה מהבית', 19, 0),
(20, 'Design', 'עיצוב', 20, 0),
(21, 'Attorney', 'עריכת דין', 21, 0),
(22, 'Advertising / Media', 'פרסום / מדיה', 22, 0),
(23, 'Vehicle / Transport', 'רכב / תחבורה', 23, 0),
(24, 'Medical / Health', 'רפואה / בריאות', 24, 0),
(25, 'Marketing', 'שיווק', 25, 0),
(26, 'Customer Service', 'שירות לקוחות', 26, 0),
(27, 'Keeping / Security', 'שמירה / אבטחה', 26, 0),
(28, 'Industry / Manufacturing', 'תעשיה / ייצור', 28, 0);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_he` varchar(100) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name_en`, `name_he`, `status`) VALUES
(4, 'Akko', 'עכו', '1'),
(5, 'Afula', 'עפולה', '1'),
(6, 'Arad', 'ערד', '1'),
(7, 'Ariel', 'אריאל', '1'),
(8, 'Ashdod', 'אשדוד', '1'),
(9, 'Ashkelon', 'אשקלון', '1'),
(10, 'Bat Yam', 'בת ים', '1'),
(11, 'Beer Sheva', 'באר שבע', '1'),
(12, 'Beit Shean', 'בית שאן', '1'),
(13, 'Beit Shemesh', 'בית שמש', '1'),
(14, 'Beitar Illit', 'ביתר עילית', '1'),
(15, 'Bnei Brak', 'בני ברק', '1'),
(16, 'Dimona', 'דימונה', '1'),
(17, 'Eilat', 'אילת', '1'),
(18, 'Elad', 'אלעד', '1'),
(19, 'Givat Shmuel', 'גבעת שמואל', '1'),
(20, 'Givatayim', 'גבעתיים', '1'),
(21, 'Hadera', 'חדרה', '1'),
(22, 'Haifa', 'חיפה', '1'),
(23, 'Herzliya', 'הרצליה', '1'),
(24, 'Hod HaSharon', 'הוד השרון', '1'),
(25, 'Holon', 'חולון', '1'),
(26, 'Jerusalem', 'ירושלים', '1'),
(27, 'Carmiel', 'כרמיאל', '1'),
(28, 'Yokneam', 'יקנעם', '1'),
(29, 'Yehud', 'יהוד-מונוסון', '1'),
(30, 'Yavne', 'יבנה', '1'),
(31, 'Tirat Carmel', 'טירת כרמל', '1'),
(32, 'Tira', 'טירה', '1'),
(33, 'Tiberias', 'טבריה', '1'),
(34, 'Tel Aviv', 'תל אביב', '1'),
(35, 'Tamra', 'טמרה', '1'),
(36, 'Shfaram', 'שפרעם', '1'),
(37, 'Sderot', 'שדרות', '1'),
(38, 'Kfar Saba', 'כפר סבא', '1'),
(39, 'Kfar Yona', 'כפר יונה', '1'),
(40, 'Kiryat Ata', 'קריית אתא', '1'),
(41, 'Kiryat Bialik', 'קריית ביאליק', '1'),
(42, 'Kiryat Gat', 'קריית גת', '1'),
(43, 'Kiryat Malakhi', 'קריית מלאכי', '1'),
(44, 'Kiryat Motzkin', 'קריית מוצקין', '1'),
(45, 'Kiryat Ono', 'קריית אונו', '1'),
(46, 'Kiryat Shmona', 'קריית שמונה', '1'),
(47, 'Kiryat Yam', 'קריית ים', '1'),
(48, 'Lod', 'לוד', '1'),
(49, 'Maale Adumim', 'מעלה אדומים', '1'),
(50, 'Migdal HaEmek', 'מגדל העמק', '1'),
(51, 'Modiin Illit', 'מודיעין עילית', '1'),
(52, 'Modiin-Maccabim-Reut', 'מודיעין-מכבים-רעות', '1'),
(53, 'Nahariya', 'נהריה', '1'),
(54, 'Nazareth', 'נצרת', '1'),
(55, 'Nazareth Illit', 'נצרת עילית', '1'),
(56, 'Nesher', 'נשר', '1'),
(57, 'Ness Ziona', 'נס ציונה', '1'),
(58, 'Netanya', 'נתניה', '1'),
(59, 'Netivot', 'נתיבות', '1'),
(60, 'Ofakim', 'אופקים', '1'),
(61, 'Or Akiva', 'אור עקיבא', '1'),
(62, 'Or Yehuda', 'אור יהודה', '1'),
(63, 'Petah Tikva', 'פתח תקווה', '1'),
(64, 'Raanana', 'רעננה', '1'),
(65, 'Rahat', 'רהט', '1'),
(66, 'Ramat Gan', 'רמת גן', '1'),
(67, 'Sakhnin', 'סחנין', '1'),
(68, 'Zefat', 'צפת', '1'),
(69, 'Rosh HaAyin', 'ראש העין', '1'),
(70, 'Rishon LeZion', 'ראשון לציון', '1'),
(71, 'Rehovot', 'רחובות', '1'),
(72, 'Ramla', 'רמלה', '1'),
(73, 'Ramat HaSharon', 'רמת השרון', '1'),
(74, '--', '--', '1');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `createdt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifydt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `the_name` varchar(100) NOT NULL,
  `placement_id` int(11) NOT NULL,
  `photo_logo` varchar(200) NOT NULL,
  `website` varchar(100) NOT NULL,
  `num_people` varchar(20) NOT NULL,
  `the_descrip` text NOT NULL,
  `the_descrip_heb` text NOT NULL,
  `address` varchar(2000) NOT NULL,
  `address_heb` varchar(200) NOT NULL,
  `phone_1` varchar(20) NOT NULL,
  `fax_1` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `nviews` int(11) NOT NULL DEFAULT '0',
  `num_positions` int(11) NOT NULL DEFAULT '0',
  `industry` varchar(100) NOT NULL,
  `c_type` varchar(100) NOT NULL,
  `founded` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `createdt`, `modifydt`, `the_name`, `placement_id`, `photo_logo`, `website`, `num_people`, `the_descrip`, `the_descrip_heb`, `address`, `address_heb`, `phone_1`, `fax_1`, `status`, `nviews`, `num_positions`, `industry`, `c_type`, `founded`) VALUES
(1, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 'DNAmarketingltd', 34, '', 'http://dnamarketingltd.com', '34', 'DNA Marketing LTD was established in order to provide marketing solutions to relocation companies in the US.\r\nOur wide network of Agents, Moving companies, warehouses and employees allow us to provide a wide range of services all over the US 24/7 in a cost effective way.\r\n\r\nWe select each moving company very carefully to ensure all companies operate at the highest level of service, professionalism, and accountability. Each company is independently owned and run, with all of the appropriate licensing. With dedication to providing the customer with a trustworthy and excellent moving experience, we offer a high-end moving service to each customer—and we constantly deliver.', '', 'Hashmonaim 113, Tel-Aviv', '', '077-456-0089', '03-9008639', '1', 25, 0, '', '', ''),
(4, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 'Ewave', 64, '', 'http://ewave.co.il', '0', '', 'eWave היא ספקית מובילה של פתרונות תוכנה ואינטגרציה, המתמחה בפיתוח ובהטמעת מערכות eBusiness שמטרתן יצירת ערך עסקי אמיתי ללקוח. eWave מספקת שירותים כוללים ליישום אסטרטגיה דיגיטאלית, החל ממתן ייעוץ לגיבוש האסטרטגיה ועד למימושה באמצעות פלטפורמות, כלים ויישומים משלימים. מחלקת הייעוץ האסטרטגי וחווית המשתמש (UX) מייעצת ללקוחותינו כיצד לרתום את המדיה הדיגיטאלית לטובת יעדיהם העסקיים, מסייעת להבין את צרכי המשתמשים ומתרגמת את האסטרטגיה למתווה פעולה מעשי. חטיבות הפיתוח מיישמות את האסטרטגיה, מאפיינות ומפתחות מערכות בארכיטקטורות SOA ו-BPM, תוך שימוש בטכנולוגיות Java, .NET ו-PHP. החברה היא שותפה עסקית של יצרני התוכנה המובילים בעולם: Microsoft, Oracle ו-IBM.', '', 'סניף רעננה - רח\' ירושלים 34  (בניין גמלא B, קומה 2)', '09-9543040', '09-9545070', '1', 17, 0, '', '', ''),
(5, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 'Taptica', 34, '', 'http://www.taptica.com', '51-200', 'Taptica is a global end-to-end mobile advertising platform that helps the world’s top brands reach their most valuable users with the widest range of traffic sources available today, including social. Our proprietary technology leverages big data, and combined with state-of-the-art machine learning, enables quality media targeting at scale. Taptica creates a single arena in which brands can scale and engage more relevantly with mobile audiences, staying ahead of the competition. We work with more than 450 advertisers including Amazon, Disney, Facebook, Twitter, OpenTable, Expedia, Lyft and Zynga. Taptica is headquartered in Israel with offices in San Francisco, New York, Boston and Beijing. Taptica Ltd. is traded on the London Stock Exchange (AIM: TAP).', '', 'HaHashmonaim Street 21, Tel Aviv-Yafo, Israel', '', '', '', '1', 24, 0, '', '', '2011'),
(6, '2016-06-24 00:00:00', '2016-06-24 00:00:00', 'Investing.com', 74, '', 'http://www.investing.com', '', 'Investing.com the world\'s fastest growing financial portal, currently ranking in the industry\'s top 5 sites globally, is looking for a full-time Financial Content Writer to develop and create daily, strategic commentary about the U.S. and global financial markets with a regular focus on equities.', '', '', '', '', '', '1', 13, 0, '', '', ''),
(7, '2016-06-24 00:00:00', '2016-06-24 00:00:00', 'Infinity Labs', 66, '', 'http://infinitylabs.co.il/', '51-200', 'Infinity Labs R&D is a Knowledge Center specializing in Software R&D, specifically of software technologies related to Pervasive Computing. \r\nAside from developing its own Intellectual Property (IP), Infinity Labs R&D shares its knowledge and expertise through services such as training, coaching, consulting, research and development. Whether it be parallel computing, open source, cyber-security, mobile, distributed systems, event-driven architectures, real-time/embedded, web,or cloud computing Infinity Labs R&D’s experts are there to ensure your success. \r\nInfinity Labs R&D’s technical R&D team consists of leaders in their respective fields. With an eye towards tomorrow’s technology, as well as solid real-world experience to back them up, Infinity Labs R&D researchers and consultants quickly provide high quality technical yet practical solutions. \r\nUtilizing the proprietary C.R.E.A.T.E. Learning Spiral, Infinity Labs R&D  has developed a unique and revolutionary 28 week training program for transforming Computer Science and STEM graduates into top-tier software developers who are as capable, if not better, than developers with 3+ years experience.', 'Infinity Labs R&D מבית Matrix היא חברת מחקר ופיתוח המפעילה מאז 2014 תכנית הכשרה מהפכנית בתחום ההייטק. התכנית מאפשרת לכם, בוגרים מצטיינים בתחומי מדעי המחשב, המדעים המדויקים, בוגרי הנדסה ופקולטות נוספות, להשתלב בהצלחה בתפקידי הנדסה ופיתוח משמעותיים בשוק ההייטק, כשבידיכם יתרון משמעותי בשוק העבודה התחרותי. מידי שנה, אנו מגייסים מתוך אלפי מועמדים כ- 250 בוגרי מדעי המחשב ומדעים מדויקים מצטיינים ללא ניסיון לתכנית. Infinity Labs הינה השיטה המקורית והמוכחת להכשרת עובדי הייטק.', 'Ze\'ev Jabotinsky 1 Ramat Gan, Tel Aviv District Israel', 'דרך זאב ז\'בוטינסקי 1, רמת גן', '03-5176663', '', '1', 4, 0, 'Computer Software', 'Educational', '2014'),
(8, '2016-06-24 13:57:08', '2016-06-24 13:57:08', 'Inneractive', 63, '', 'http://inner-active.com/', '51-200', 'Inneractive is an independent automated mobile ad marketplace focused on powering native and video ads. The company\'s mission is to empower mobile publishers to maximize the full potential of their properties by providing powerful technologies for buying and selling mobile ads. The Inneractive programmatic platform is comprised of a mobile Supply Side Platform (SSP), a Private Marketplace and an Open Ad Exchange that combine RTB with native and video ad solutions. Inneractive is headquartered in Tel Aviv with offices in San Francisco, New York and London.', '', '17 HAMEFALSIM ST. PETACH TIKVA 4951447, P. O. BOX 3102', '', '+972 73 7073800', '', '1', 7, 0, 'Marketing and Advertising', 'Privately Held', '2007'),
(9, '2016-06-24 14:28:26', '2016-06-24 14:28:26', 'Imonomy', 34, '', 'http://imonomy.com/', '51-200', 'imonomy offers an innovative in-image advertising solution that helps publishers to monetize their web & mobile sites and generate an incremental revenue stream. Our product displays dynamic and relevant ads on the most engaging parts of any site, the images.\r\n\r\nFounded in 2012, imonomy has developed a sophisticated algorithm that guarantees relevant ads by leveraging contextual semantic analysis, Big Data analytics, and consumer behaviors. Further, the company has designed cutting edge technology that transforms the way ads are displayed, helping publishers to maximize their sites’ monetization potential . \r\n\r\nPublishers that use imonomy successfully fulfill the demands  of both their users and advertisers. Users enjoy a much better ad experience on sites, while advertisers benefit from higher viewability and increased engagement rates, leading to higher CTRs.   \r\n\r\nimonomy is active worldwide and has helped over 13,000 publishers to monetize their sites. There are over 20 billion impressions on over 800 million images monetized by imonomy.', '', 'HaUmanim 10 Tel Aviv, Israel', '', '', '', '1', 7, 0, 'Internet', 'Privately Held', '2012'),
(10, '2016-06-24 16:25:50', '2016-06-24 16:25:50', 'Toyga', 34, '', 'http://www.toyga.co.il', '201-500', 'Founded in 2008, TOYGA is a world renowned CFD trading firm (currencies, stocks, commodities, and indices), and is one of the leading online trading companies in the world, primarily due to its commitment to technological innovation.\r\nTOYGA works with an international clientele, located in various countries worldwide. The company employs over 450 Israeli employees across 2 local branches, with head offices located in Tel-Aviv, and a second branch located in the northern city of Haifa.\r\nAt TOYGA\'s core is its technology division, Hexagon, and is one of the largest trading software developers in the financial industry. Overall, TOYGA has over 12 different departments, with diverse roles and opportunities for advancement.\r\nThe company provides fully funded training programs for new employees, custom tailored for each position. Additionally, we offer employee development and managerial training programs. \r\nOver the years, TOYGA has grown to become a leader in the financial industry, turning great ideas into even greater products, services, and customer experiences.', '', 'Tel-Aviv Tel aviv, Israel', '', '', '', '1', 6, 0, 'Financial Services', 'Privately Held', '2008');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `createdt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifydt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `principal_id` int(11) NOT NULL,
  `pos_title` varchar(60) NOT NULL,
  `pos_title_heb` varchar(60) NOT NULL,
  `company_id` int(11) NOT NULL,
  `pos_desc` text NOT NULL,
  `pos_desc_heb` text NOT NULL,
  `nviews` int(11) DEFAULT '0',
  `napply` int(11) NOT NULL DEFAULT '0',
  `pos_priority` int(11) NOT NULL DEFAULT '0',
  `cat_1` int(11) DEFAULT NULL,
  `s_cat_1` int(11) DEFAULT NULL,
  `cat_2` int(11) DEFAULT NULL,
  `s_cat_2` int(11) DEFAULT NULL,
  `cat_3` int(11) DEFAULT NULL,
  `s_cat_3` int(11) DEFAULT NULL,
  `cat_4` int(11) DEFAULT NULL,
  `s_cat_4` int(11) DEFAULT NULL,
  `cat_5` int(11) DEFAULT NULL,
  `s_cat_5` int(11) DEFAULT NULL,
  `pos_status` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `createdt`, `modifydt`, `principal_id`, `pos_title`, `pos_title_heb`, `company_id`, `pos_desc`, `pos_desc_heb`, `nviews`, `napply`, `pos_priority`, `cat_1`, `s_cat_1`, `cat_2`, `s_cat_2`, `cat_3`, `s_cat_3`, `cat_4`, `s_cat_4`, `cat_5`, `s_cat_5`, `pos_status`) VALUES
(1, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 0, 'English Speaker', '', 1, 'Attention English Speakers of Tel-Aviv! Our office is looking to hire sales representatives! Our company provides relocation services to US based clients Shifts are in the evening (based on US time zone) Send an email and attach your resume to our HR Manager', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(3, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 0, 'Full-Stack Developer', '', 4, 'We are looking for a Full-Stack Developer with a focus on web and technology such as: JS, Angular Typescript, React\r\n\r\nGood knowledge in JS and Angular development (+HTML5, CSS3)\r\nDeveloping in C# under IIS\r\nWorking with MS SQL', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(4, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 0, 'Back-end Java Developer', '', 5, 'We are looking for a Back-end Java Developer skilled in a highly dynamic web interface development to join our social platform development team. Our social R&D team develops our social ads platform, adding both new infrastructures and new functionalities, working closely with world leading social networks. Development includes taking a feature spec, designing a solution, and implementing the feature end-to-end, DB to UI.\r\n\r\n-4-5 years of proven experience in Java development\r\n-Highly experienced with, application servers, databases, Spring, and Hibernate\r\n-Great understanding in MVC and REST\r\n-Knowledge in – JavaScript, JQuery, CSS, HTML, Bootstrap, Angular – big advantage\r\n-Team player with positive “can do” attitude\r\n-Full time position in Tel-Aviv', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(5, '2016-06-18 08:43:45', '2016-06-18 08:43:45', 0, 'Front-End Web application developer', '', 5, 'This role is for a Front-End Web application developer experienced in building interfaces to rich Internet applications.\r\nWe are looking for an individual skilled in highly dynamic web interface development (HTML, JavaScript, AJAX, jQuery) to join our front-end development team.\r\n\r\n-Highly skilled at front-end engineering using Object-Oriented JavaScript, various JavaScript libraries and micro frameworks (jQuery, Angular, Prototype, Dojo, Backbone, YUI), HTML and CSS\r\n-Well versed in software engineering principles, frameworks and technologies\r\n-Excellent communication skills\r\n-Self-directed team player who thrives in a continually changing environment', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(6, '2016-06-24 08:25:31', '2016-06-24 08:25:31', 0, 'Financial Content Writer - English', '', 6, '• Excellent, proven, written and verbal communication skills in American English (at mother tongue level) – MUST\r\n• Understanding and appreciation of U.S. equity/financial markets – Must\r\n• Understanding and appreciation of global financial markets (Currency/Commodity/Indices as well as Equities) – Major Advantage\r\n• Previous financial or business reporting and/or writing experience – Strong Advantage\r\n• Past Trading experience – Major advantage\r\n• Knowledge of Technical Analysis - Major advantage\r\n• Degree in journalism, English or communications, or degree in business, management or finance – Advantage\r\n• Ability to work both independently and as part of a team\r\nFor immediate consideration please forward your resume as well as 5 relevant financial writing samples. Please note that no CVs will be considered without appropriate writing samples.', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(7, '2016-06-24 13:49:33', '2016-06-24 13:49:33', 0, 'Technology Mentors', '', 7, 'We are looking for technology mentors who love technology, love code and enjoy mixing it with people by leading, mentoring and guiding.\r\nIn this position, you will do hands-on guidance of highly motivated and talented groups of junior Java developers. Through personal leadership you will introduce them to Java technologies, show them hands-on coding, review their design and code, and lead them towards towards working full stack solutions.\r\nYou are also expected to constantly learn and adapt new technologies as well as expand your technical horizons.\r\nIf you love technology, coding and people - this is the place for you.\r\nTechnical skills:\r\nExcellent Java programming and Object Oriented design - Must\r\nExperience with Java backend technologies - Must\r\nBuilding micro services with Spring - Recommended\r\nExperience with either SQL or NoSQL databases - Must\r\nExperience with ORM, JPA, Hibernate - Recommended\r\nFrontEnd technologies e.g., HTML, JavaScript, Angular - an advantage\r\nDeployment with AWS, Docker, OpenStack - an advantage\r\nBig Data technologies e.g., Hadoop, Spark, ELK - kind of cool\r\nProven record:\r\n10+ years experience as hands-on Java engineer - Must\r\nLeading software engineers as either a team lead or technical lead or developer consultant - Must\r\nSoft skills:\r\nExcellent communication skills - Must\r\nExcellent social and inter-personal skills - Must\r\nPositive approach in guiding, leading and mentoring as a team lead and player – Must', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(8, '2016-06-24 14:00:31', '2016-06-24 14:00:31', 0, 'Backend Group Manager', '', 8, 'The Inneractive R&D team is looking for a hands-on, strong and experienced Backend Group Manager. The Backend Group Manager will be part of a team of out-of-the-box thinkers who create disruptive, industry-leading mobile ad technology in a young, highly-energetic, dynamic environment. They will take a major role in defining the next generation of mobile advertising and ad-tech solutions. The ideal candidate is an autodidact with the ability to lead, is independent and passionate about staying on top of latest technologies.\r\n\r\nBackend Group Manager will lead the Big Data and Server teams, reporting directly to VP R&D.\r\n\r\n4+ years experience as an HO Server Team Leader/ Group Manager\r\nAt least 7 years Java experience working in high throughput and large scale distributed web environment, involving scaling and performance challenges\r\nScala/Akka experience – a strong advantage\r\nStrong experience with Java multi-threaded, high-concurrent server development\r\nExperience with SQL databases and the ability to craft queries\r\nExperience with JVM tuning and performance analysis\r\nExperience with high concurrent event-streaming over elastic cloud – an advantage\r\nKnowledge with distributed in-memory architecture involving multi-level cache, serialization etc. – an advantage\r\nSmart, interdisciplinary, fast learner and a team player\r\nBachelor\'s Degree in Computer Science (or equivalent), or a veteran of a technological army unit\r\n', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(9, '2016-06-24 14:06:25', '2016-06-24 14:06:25', 0, 'Bookkeeper', '', 8, 'Inneractive is looking for an experienced, skilled, independent and responsible bookkeeper with experience of working in a US companies to join our finance team to be accountable for the US bookkeeping. Maintains records of financial transactions, establishing accounts and posting transactions in addition to conduct collection from customer and function as a flights coordinator.\r\n\r\n·        Implement an internal bookkeeping of the US company accounts\r\n\r\n·        Record day to day of the US financial transactions and complete the posting process\r\n\r\n·        US Bank account reconciliation and payments\r\n\r\n·        US AR/AP reconciliation\r\n\r\n·        US employees\' reimbursement\r\n\r\n·        collection activities to maximize and advance cash receipts\r\n\r\n·        Issue collection letters to overdue accounts\r\n\r\n·        Maintain accurate records about the customer payment status\r\n\r\n·        Weekly Aging Report preparation\r\n\r\n·        Flights coordinator- establish flights system according to travel policies\r\n\r\n\r\n·        2 years\' minimum experience as a bookkeeper in a US company\r\n\r\n·        Experience in working with US institutions\r\n\r\n·        Solid understanding of basic bookkeeping and accounting payable/receivable principles\r\n\r\n·        Experience in collection - Big advantage\r\n\r\n·        QuickBooks - Big advantage\r\n\r\n·        Strong knowledge in excel\r\n\r\n·        High English level\r\n\r\n·        Assertiveness\r\n\r\n·        Team player\r\n', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(10, '2016-06-24 14:09:16', '2016-06-24 14:09:16', 0, 'Full Stack Developer', '', 8, 'Inneractive is looking for a highly experienced and capable Full Stack Developer.  If you are a fast learner, outside the box thinker and eager to have an impact, your place is with us. Your responsibilities will include design and development of Inneractives’ next generation solutions.\r\n\r\nThis is a great opportunity to join our R&D Team which deals with the latest and greatest technologies and build advanced systems using the state-of-the-art JavaScript technologies.\r\n\r\n·        2+ years of software development\r\n\r\n·        Expert in OO JavaScript & Vanilla JS\r\n\r\n·        Experience with JS frameworks (AngularJS/Express), NodeJS\r\n\r\n·        Experience in Mobile Web (Android/iPhone)\r\n\r\n·        Knowledge in ES6, ES7- Significant advantage\r\n\r\n·        Experience with mobile devices (IOS/Android) - Significant advantage\r\n\r\n·        HTML 5 - JavaScript API\'s, Canvas, Video, Audio - Significant advantage\r\n\r\n·        Strong knowledge in HTML5 & CSS3\r\n\r\n·        Fast learner, team player in nature, patient and adaptive to changes, self-driven developer\r\n\r\n·        Creative thinker with excellent communication skills\r\n\r\n·        Ability to work independently\r\n\r\n·        BA\\BSc in Computer Science or equivalent - Advantage\r\n', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1'),
(11, '2016-06-24 14:16:47', '2016-06-24 14:16:47', 0, 'Senior Java/Scala Developer', '', 8, 'The Inneractive R&D team is looking for a talented and experienced Server Developer. The developer will take part in engineering a high concurrent real-time serving platform with the ability to collect, stream and process extreme amounts of data. The candidate should bring with him a broad set of technology skills to be able to design and build robust solutions for server and data problems and learn quickly as the platform grows.\r\n\r\nAt least 4 years\' Java experience working in high throughput and large scale distributed web environment, involving scaling and performance challenges\r\nBachelor\'s Degree in Computer Science (or equivalent), or a veteran of a technological army unit\r\nStrong experience with Java multi-threaded, high-concurrent server development\r\nNeed to know the way around SQL databases and can comfortably craft queries\r\nExperience with JVM tuning and performance analysis\r\nScala/Akka experience – a strong advantage\r\nExperience with high concurrent event-streaming over elastic cloud – an advantage\r\nKnowledge with distributed in-memory architecture involving multi-level cache, serialization, etc.\' – an advantage\r\nSmart, interdisciplinary, fast learner and a team player', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(12, '2016-06-24 14:29:25', '2016-06-24 14:29:25', 0, 'Head of Customer Acquisition', '', 9, 'We are looking for a Head of Customer Acquisition! Responsibilities include: Lead, plan and execute imonomy’s efforts to attract, maintain and optimize premium web publishers.\r\nPlay an important role in the company’s success by managing our media sales team and by helping our clients achieving their goals.\r\n\r\nRequirements:\r\n\r\nExperience as a Team leader / head of sales from internet / media companies.\r\nExperience with display (Mobile/Video -advantage).\r\nExcellent negotiation & problem solving skills.\r\nEnglish – mother tongue / excellent.\r\nOther languages: advantage.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(13, '2016-06-24 14:31:41', '2016-06-24 14:31:41', 0, 'Demand Business Development', '', 9, 'We are looking for a professional Demand Business Development. Responsible for Hunting, negotiating,\r\nsigning and managing the relationships with new and existing advertiser and Generating new sales leads.\r\n\r\nRequirements:\r\n\r\n2 years in sales role from internet / media companies.\r\nUnderstanding the online advertising ecosystem.\r\nWorking with ad-exchanges, DSP & direct advertisers.\r\nExcellent English.\r\nCreative thinking.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(14, '2016-06-24 14:34:13', '2016-06-24 14:34:13', 0, 'Media Buyer', '', 9, 'We are looking for a relentless Media Buyers to join our business development team.\r\nResponsibilities include: Hunting, negotiating, signing and managing the relationships with new and existing clients.\r\nGenerating new sales leads and over all thinking out side the BOX.\r\n\r\nRequirements:\r\n\r\n1+ years in Sales role.\r\nExcellent english – Other languages: advantage.\r\nGerman as a mother tongue.\r\nInternet / media companies experience – Big Advantage.\r\nInternet savvy & Well Organized.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(15, '2016-06-24 14:36:45', '2016-06-24 14:36:45', 0, 'QA Engineer', '', 9, 'Our successful start-up, Imonomy is looking for for a QA.\r\n\r\nRequirement: \r\n4-5 years of experience in manual testing \r\nExperience in Client/Server and Web testing. \r\nExperience in Writing STP, STD and STR documents \r\nFamiliarity and experience with SQL \r\nExperience working in an Agile/Scrum- advantage \r\nExperience working around Linux / Unix- advantage', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(16, '2016-06-24 14:40:36', '2016-06-24 14:40:36', 0, 'Business Analyst', '', 9, 'We are looking for an analyst who can turn numbers into stories.\r\n\r\nRequirements:\r\n\r\nBA/BS Degree in Business/Statistics/ Economics/ Industrial Engineering & Management.\r\nStrong analytical background.\r\nExcellent knowledge in Excel.\r\nInternet savvy.\r\nCommunicating clearly and effectively, both orally and in writing.\r\nBeing able to learn new skills and information on your own.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(17, '2016-06-24 16:18:46', '2016-06-24 16:18:46', 0, 'Full Stack Web Developer – Full Time', '', 9, 'We are looking for a Full Stack Web Developer for our exciting business development team.\r\n\r\nRequirements:\r\n\r\n1-2 years experience with JavaScript.\r\nHTML.\r\nCSS.\r\nAjax.\r\njQuery.\r\nPython – Advantage.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(18, '2016-06-24 16:20:01', '2016-06-24 16:20:01', 0, 'Supply side Account manager', '', 9, 'We are looking for a Supply Side Account manager for our exciting business development team.\r\nResponsible for Managing all aspects of the relationship with existing supply side clients, building long\r\nterm relationships and generate new sales/leads, expanding our market research and competitor\r\nanalysis to help take our strategy to the next level, communicating clearly and effectively, both orally\r\nand in writing and maintaining constructive and productive personal relationships with our partners.\r\n\r\nRequirements:\r\n\r\nEnglish – speaking & writing at mother tongue / excellent level.\r\nOther languages: French/German BIG advantage\r\nsales and service oriented.\r\nWell-spoken and excellent writing.\r\nHigh personal relationships skills.\r\nWell Organized.\r\nInternet savvy.\r\nGood self-learning abilities.\r\nAssertive.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(19, '2016-06-24 16:27:56', '2016-06-24 16:27:56', 0, 'QA Automation Engineer', '', 10, 'Come start your NEW career in Platform QA Automation!\r\n\r\nHexagon Technologies is looking for a QA Automation Engineer to join our amazing team. The candidate will join as an automation developer\r\n\r\nHere at hexagon the QA automation team works in hand in hand with the development team to ensure maximum quality and minimum turnaround time. Our goal is to reach true continuous integration with zero escaped bugs.\r\n\r\nThere is about 20%-25% manual testing, and our moto is if it can be automated it should be automated.\r\n\r\nWe are looking for someone who is passionate about automated testing.\r\n\r\nResponsibilities:\r\n\r\nDesigning and developing automated tests for server side components.\r\nWriting and analyzing load tests.\r\nMaintaining and improving existing testing infrastructure.\r\nAnalyzing test results.\r\nEnd to end testing of two critical platform systems.\r\nDesigning and developing tests.\r\nRequirements:\r\n\r\nAt least 1 year hands on experience developing in an O.O (C# preferred) language or relevant studies.\r\nExperience with working with relational databases\r\n1 year testing experience – advantage\r\nKnowledge of multi-tier web applications\r\nHighly self-motivated, independent and ability to work under pressure\r\nStrong proficiency in examining, investigating and solving dynamic problems with ability to think “out-of-the-box”, and develop creative solutions.\r\nExperience with the following an advantage – Jenkins, Git, Jira, ZeroMQ, Redis, NodeJS, JMeter, visual studio test framework.', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(20, '2016-06-24 16:31:11', '2016-06-24 16:31:11', 0, 'Senior UI/UX Designer - Web & Mobile', '', 10, 'We are seeking for a talented and highly motivated Senior UI/UX designer who is passionate about solving complex problems and creating smart, beautiful and polished products.\r\n\r\nThe designer is part of a team that revolutionizes the way people trade on financial tools and would work closely with product managers and software engineers.\r\n\r\n \r\n\r\nResponsibilities:\r\n\r\n \r\n\r\nCollaborate with product managers and software developers to define, design, and deliver cutting edge products for both web and mobile\r\nAbility to take ownership of a project from first ink drop to the last pixel and effectively communicate conceptual ideas and design rationale\r\nCollaborate with cross-functional teams to produce elegant, unique design solutions\r\n \r\n\r\nRequirements:\r\n\r\n \r\n\r\n3-5 years of experience designing flows, experiences, and UI for killer consumer facing web & mobile applications – from concept to production (preferred experience in ecommerce / gaming / gambling) – must\r\nExperience with responsive web design for screen, mobile and tablet; Very strong knowledge of mobile design patterns and guidelines for both Android and iOS\r\nMust have a solid understanding of user-centered design principles, careful attention to detail, and be able to see the big picture\r\nA skilled problem solver, able to understand highly complex problems and deliver elegantly simple solutions\r\nExperience working closely with product managers and software engineers in an Agile environment with the ability to juggle multiple projects while effectively managing timelines and expectations\r\nHighly self-motivated, autodidact and well organised.\r\nExcellent interpersonal and communication skills – be a team player.\r\nHigh level of verbal and written English\r\nA Bachelor of Design in Visual Communication or Interactive Design from a leading design school\r\nAll applicants MUST provide a link to viewable portfolio or samples of recent work, highlighting mobile design examples of projects that got released', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(21, '2016-06-24 16:32:50', '2016-06-24 16:32:50', 0, 'Sales Representative', '', 10, 'TOYGA, the industry’s leading online trading company is hiring hot-shot sales representatives.\r\nWe offer a rewarding and young work environment, in addition to corporate stability and further career growth.\r\n\r\nThe position includes:\r\n\r\nInternational sales\r\nFull time working hours\r\nHigh base salary + commissions\r\nIdeal candidates should be dynamically flexible and have excellent communication skills, with a hunger for success and strong attention to detail.\r\n\r\nJob Responsibilities\r\n\r\nEnglish/French/Russian/Arabic – mother tongue level – MUST\r\n\r\nBasic understanding of financial/ capital markets – an advantage\r\n\r\nAbility to work well individually and as part of a team\r\n\r\nCapable of multitasking, and working under-pressure\r\n\r\nPrevious sales experience – an advantage.\r\n\r\nLocation: Tel Aviv\r\n\r\nFull professional training will be provided', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(22, '2016-06-24 16:34:35', '2016-06-24 16:34:35', 0, 'Affiliate Manager', '', 10, 'A regulated Online Financial Trading Company is looking for an experienced Affiliate Manager to join our Marketing team.\r\nResponsibilities:\r\n\r\n· Identify, recruit and negotiate with new affiliates\r\n\r\n· Building and maintaining existing partners’ relations.\r\n\r\n· Maximize Affiliate’s profits while encouraging the broadening of their activities with us. \r\n\r\n· Maximize profits while encouraging the broadening of their activities with us. \r\n\r\n· Managing existing affiliates and reactivating lapsed affiliates\r\n\r\nRequirements\r\n\r\n·At least 2 years hands on experience as an affiliate manager in financial markets\r\n\r\n·High negotiations skills\r\n\r\n·Experience working with goals and meeting them\r\n\r\n·Management experience – Advantage\r\n\r\n·Result driven\r\n\r\n·Native or fluent English –a must', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(23, '2016-06-24 16:38:31', '2016-06-24 16:38:31', 0, 'Sales- English speakers', '', 10, 'Come and join our one of a kind department, enjoy great people, and a highly stable working place!\r\nWe have a leading team of moneymakers, making the highest salaries in the industry – so if you want to make a lot of money, and get paid the highest bonuses – you belong with us!\r\nWe are a very profitable company that takes care of her employees – amazing office space, “happy hour”, company trips\r\nand much much more!\r\n\r\nRequirenments :\r\nNative/Fluent English – a must!\r\nSales orientation – a must!\r\nAvailability for 5 shifts a week – a must!\r\nFull position in Tel-Aviv', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(24, '2016-06-24 16:51:46', '2016-06-24 16:51:46', 0, 'Sales- French Speakers', '', 10, 'Come and join our one of a kind department, enjoy great people, and a highly stable working place!\r\nWe have a leading team of moneymakers, making the highest salaries in the industry – so if you want to make a lot of money, and get paid the highest bonuses – you belong with us!\r\nWe are a very profitable company that takes care of her employees – amazing office space, “happy hour”, company trips\r\nand much much more!\r\n\r\nRequirenments:\r\nNative/Fluent French- a must!\r\nSales orientation – a must!\r\nAvailability for 5 shifts a week – a must!\r\nFull position in Tel-Aviv', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `principals`
--

CREATE TABLE `principals` (
  `id` int(11) NOT NULL,
  `princ_email` varchar(100) NOT NULL,
  `princ_firstname` varchar(100) NOT NULL,
  `princ_lastname` varchar(100) NOT NULL,
  `createdt` datetime NOT NULL,
  `modifydt` datetime NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `principals`
--

INSERT INTO `principals` (`id`, `princ_email`, `princ_firstname`, `princ_lastname`, `createdt`, `modifydt`, `role`, `status`) VALUES
(0, 'contact@jobs972.com', 'System', 'System', '2016-06-19 00:00:00', '2016-06-19 00:00:00', 'System', '1');

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_path` varchar(300) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `subcat_name` varchar(100) NOT NULL,
  `subcat_name_heb` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `subcat_name`, `subcat_name_heb`, `cat_id`) VALUES
(1, 'Back Office', 'בק אופיס', 1),
(2, 'Secretary / The English', 'מזכיר/ה אנגלית', 1),
(3, 'Senior Secretary', 'מזכיר/ה בכיר/ה', 1),
(4, 'Secretary / The Hebrew', 'מזכיר/ה עברית', 1),
(5, 'A Legal Secretary', 'מזכירה משפטית', 1),
(6, 'Medical Secretary', 'מזכירה רפואית', 1),
(7, 'Administrative Director', 'מנהל/ת אדמינסטרטיבית', 1),
(8, 'Office Manager', 'מנהל/ת משרד', 1),
(9, 'Operator', 'מרכזן/ית', 1),
(10, 'Personal Assistant', 'עוזר/ת אישי/ת', 1),
(11, 'Clerk', 'פקיד/ה', 1),
(12, 'Affiliate Manager', 'Affiliate Manager', 2),
(13, 'Web Marketing', 'Web Marketing', 2),
(14, 'Webmaster', 'Webmaster', 2),
(15, 'Content Writer', 'כתיבת תוכן', 2),
(16, 'SEM / PPC Specialist', 'מומחה SEM / PPC', 2),
(17, 'SEO Expert', 'מומחה SEO', 2),
(18, 'UI / UX Expert', 'מומחה UI / UX', 2),
(19, 'Online Media Selling', 'מכירת מדיה באינטרנט', 2),
(20, 'Site Manager', 'מנהל אתר', 2),
(21, 'Flash / Flex Designer', 'מעצב Flash / Flex', 2),
(22, 'Web Developer', 'מפתח WEB', 2),
(23, 'E-commerce', 'סחר אלקטרוני', 2),
(24, 'Web Design', 'עיצוב אתרים', 2),
(25, 'Media Buying', 'רכש מדיה', 2),
(26, 'Insurance Sales People', 'אנשי מכירות ביטוח', 3),
(27, 'Actuary', 'אקטואר', 3),
(28, 'Insurance - Management', 'ביטוח - ניהול', 3),
(29, 'Back-Office / Staff Member', 'בק-אופיס / איש צוות', 3),
(30, 'Underwriter', 'חתם', 3),
(31, 'Pension Consultant', 'יועץ פנסיוני', 3),
(32, 'Customer Portfolio Manager', 'מנהל תיקי לקוחות', 3),
(33, 'Claims Eliminator', 'מסלק תביעות', 3),
(34, 'Financial inspector', 'מפקח פיננסי', 3),
(35, 'Insurance Agent', 'סוכן ביטוח', 3),
(36, 'Insurance Clerk', 'פקיד/ת ביטוח', 3),
(37, 'Referent', 'רפרנט', 3),
(38, 'Insurance Customer Service', 'שירות לקוחות ביטוח', 3),
(39, 'Appraiser', 'שמאי', 3),
(40, 'Senior General', 'בכירים כללי', 4),
(41, 'Business Development Manager', 'מנהל פיתוח עסקי', 4),
(42, 'Manufacturing Director', 'מנהל/ת ייצור', 4),
(43, 'Director of Finance', 'מנהל/ת כספים', 4),
(44, 'Sales Manager', 'מנהל/ת מכירות', 4),
(45, 'Purchasing Manager', 'מנהל/ת רכש', 4),
(46, 'Director of Marketing', 'מנהל/ת שיווק', 4),
(47, 'Operations Manager', 'מנהל/ת תפעול', 4),
(48, 'CEO', 'מנכ"ל', 4),
(49, 'Chief Financial Officer', 'סמנכ"ל כספים', 4),
(50, 'Vice President of Sales', 'סמנכ"ל מכירות', 4),
(51, 'VP of Human Resources', 'סמנכ"ל משאבי אנוש', 4),
(52, 'Vice President of Development', 'סמנכ"ל פיתוח', 4),
(53, 'VP Business Development', 'סמנכ"ל פיתוח עסקי', 4),
(54, 'Vice President of Marketing', 'סמנכ"ל שיווק', 4),
(55, 'Chief Operating Officer', 'סמנכ"ל תפעול', 4),
(56, 'Maintenance', 'אחזקה', 5),
(57, 'Other', 'אחר', 5),
(58, 'Plumbing', 'אינסטלציה', 5),
(59, 'Gardening and Agriculture', 'גינון וחקלאות', 5),
(60, 'Firearms', 'זגגות', 5),
(61, 'Electrician', 'חשמלאי', 5),
(62, 'Technician', 'טכנאי', 5),
(63, 'Air Conditioning', 'מיזוג אוויר', 5),
(64, 'Foreman', 'מנהל עבודה', 5),
(65, 'Installers', 'מתקינים', 5),
(66, 'Carpentry', 'נגרות', 5),
(67, 'Construction Workers', 'עובדי בניין', 5),
(68, 'Gypsum Workers', 'עובדי גבס', 5),
(69, 'Painter', 'צבעים', 5),
(70, 'Welders / Locksmiths', 'רתכים / מסגרים', 5),
(71, 'Sewing / and Pattern Making', 'תפירה / תדמיתנות', 5),
(72, 'Gardeners', 'גננים/ות', 6),
(73, 'Training', 'הדרכה', 6),
(74, 'Sports Training', 'הדרכת ספורט', 6),
(75, 'Special Education', 'חינוך מיוחד', 6),
(76, 'Child Care', 'טיפול ושמרטפות', 6),
(77, 'Counseling and Psychology', 'ייעוץ ופסיכולוגיה', 6),
(78, 'Teacher(s)', 'מורים/ות', 6),
(79, 'Lecturers', 'מרצים', 6),
(80, 'Management', 'ניהול', 6),
(81, 'Assistants', 'סייעים/ות', 6),
(82, 'Social Work', 'עבודה סוציאלית', 6),
(83, 'Configuration Control', 'אחראי בקרת תצורה', 7),
(84, 'QA', 'איש QA', 7),
(85, 'Automated Testing', 'בדיקות אוטומטיות', 7),
(86, 'Manual Testing', 'בדיקות ידניות', 7),
(87, 'Load Testing', 'בדיקת עומסים', 7),
(88, 'QA ERP / CRM ', 'בודק ERP / CRM', 7),
(89, 'QA Engineer', 'מהנדס QA', 7),
(90, 'QA Manager', 'מנהל QA', 7),
(92, 'Testing Tools Development', 'פיתוח כלי בדיקות', 7),
(93, 'QA Team Leader', 'ראש צוות QA', 7),
(94, 'Verification Development Team Leader ', 'ראש צוות אימות פיתוח', 7),
(95, 'Production Control Team Leader', 'ראש צוות בקרת תצורה', 7),
(96, 'DSP', 'DSP', 8),
(97, 'QC', 'QC', 8),
(98, 'VX Works', 'VX Works', 8),
(99, 'Electronics Engineer', 'הנדסאי אלקטרוניקה', 8),
(100, 'Verification / Validation', 'וריפיקציה / ואלידציה', 8),
(101, 'Hardware - Management', 'חומרה - ניהול', 8),
(102, 'Engineer / ASIC Engineer', 'מהנדס / הנדסאי ASIC', 8),
(103, 'Engineer / FPGA Engineer', 'מהנדס / הנדסאי FPGA', 8),
(104, 'Engineer / RF Engineer', 'מהנדס / הנדסאי RF', 8),
(105, 'Engineer / Telecommunications Engineer', 'מהנדס / הנדסאי תקשורת', 8),
(106, 'Board Design Engineer', 'מהנדס Board Design', 8),
(107, 'Optoelectronics Engineer', 'מהנדס אלקטרואופטיקה', 8),
(108, 'Electornics Engineer', 'מהנדס אלקטרוניקה', 8),
(109, 'Analog Engineer', 'מהנדס אנלוגי', 8),
(110, 'System Engineer', 'מהנדס מערכת', 8),
(111, 'Engineer VLSI Components', 'מהנדס רכיבים VLSI', 8),
(112, 'Algorithms Developer', 'מפתח/ת אלגוריתמים', 8),
(113, 'Students - Hardware', 'סטודנטים - חומרה', 8),
(114, 'Circuit Editor', 'עורך מעגלים', 8),
(115, 'Hardware Development', 'פיתוח חומרה', 8),
(116, 'DevOps', 'DevOps', 9),
(117, 'Post Sales', 'Post Sales', 9),
(118, 'Pre Sales', 'Pre Sales', 9),
(119, 'sys admin unix', 'sys admin unix', 9),
(120, 'sys admin win', 'sys admin win', 9),
(121, 'Data Security', 'אבטחת מידע', 9),
(122, 'Integrator', 'אינטגרטור', 9),
(123, 'Training / Integration', 'הדרכה / הטמעה', 9),
(124, 'Computer Technician', 'טכנאי מחשבים', 9),
(125, 'Technical Writing', 'כתיבה טכנית', 9),
(126, 'Implementer', 'מיישם', 9),
(127, 'Product Manager', 'מנהל מוצר', 9),
(128, 'High Tech Sales Manager', 'מנהל מכירות הייטק', 9),
(129, 'Head of IT', 'מנהל מערכות מידע', 9),
(130, 'Project Manager', 'מנהל פרוייקטים', 9),
(131, 'Administrator', 'מנהל רשת', 9),
(132, 'Hi-Tech Marketing Manager', 'מנהל שיווק הייטק', 9),
(133, 'Marketing Communications', 'מרקום', 9),
(134, 'General High-Tech Jobs', 'משרות הייטק כללי', 9),
(135, 'Systems Analysis', 'ניתוח מערכות', 9),
(136, 'VP Development', 'סמנכ"ל פיתוח', 9),
(137, 'Support', 'תמיכה', 9),
(138, 'Communication / Command and Control', 'תקשורת / שו"ב', 9),
(139, 'Infrastructure', 'תשתיות', 9),
(140, 'ASP.NET', 'ASP.NET', 10),
(141, 'Big Data', 'Big Data', 10),
(142, 'C#', 'C#', 10),
(143, 'C++ / C', 'C++ / C', 10),
(144, 'COBOL', 'COBOL', 10),
(145, 'DBA', 'DBA', 10),
(146, 'DevOps', 'DevOps', 10),
(147, 'ETL', 'ETL', 10),
(148, 'JAVA', 'JAVA', 10),
(149, 'LINUX / UNIX', 'LINUX / UNIX', 10),
(150, 'Mobile', 'Mobile', 10),
(151, 'MOSS', 'MOSS', 10),
(152, '.NET', '.NET', 10),
(153, 'OLAP / BI', 'OLAP / BI', 10),
(154, 'PHP', 'PHP', 10),
(155, 'Python', 'Python', 10),
(156, 'RT / Embedded', 'RT / Embedded', 10),
(157, 'Ruby on Rails', 'Ruby on Rails', 10),
(158, 'System Architect', 'ארכיטקט מערכת', 10),
(159, 'Configuration Control', 'בקרת תצורה', 10),
(160, 'Software Engineer', 'מהנדס תוכנה', 10),
(161, 'Director of Development', 'מנהל פיתוח', 10),
(162, 'Web Developer', 'מפתח WEB', 10),
(163, 'Algorithms Developer', 'מפתח/ת אלגוריתמים', 10),
(164, 'Programmer', 'מתכנת', 10),
(165, 'Flash / Flex Programmer', 'מתכנת Flash / Flex', 10),
(166, 'Students - Software', 'סטודנטים - תוכנה', 10),
(167, 'Testing Tools Development', 'פיתוח כלי בדיקות', 10),
(168, 'Team Leader', 'ראש צוות', 10),
(169, 'ERP / CRM Programmer', 'תוכניתן ERP / CRM', 10),
(170, 'Architects', 'אדריכלים', 11),
(171, 'Electronics Engineer', 'הנדסאי אלקטרוניקה', 11),
(172, 'Building Engineer', 'הנדסאי בניין', 11),
(173, 'Electrical Engineering', 'הנדסאי חשמל', 11),
(174, 'Engineer', 'הנדסאי מכונות', 11),
(175, 'Industrial Management Engineer', 'הנדסאי תעשיה וניהול', 11),
(176, 'General Engineers', 'הנדסאים כללי', 11),
(177, 'Engineering - Management', 'הנדסה - ניהול', 11),
(178, 'Aeronautical Engineer', 'מהנדס אווירונאוטיקה', 11),
(179, 'Civil Engineer', 'מהנדס אזרחי', 11),
(180, 'Quality Engineer', 'מהנדס איכות', 11),
(181, 'Electornics Engineer', 'מהנדס אלקטרוניקה', 11),
(182, 'Building Engineer', 'מהנדס בניין', 11),
(183, 'Material Engineer', 'מהנדס חומרים', 11),
(184, 'Electrical Engineer', 'מהנדס חשמל', 11),
(185, 'Chemical Engineer', 'מהנדס כימיה', 11),
(186, 'Food Engineer', 'מהנדס מזון', 11),
(187, 'Mechanical Engineer', 'מהנדס מכונות', 11),
(188, 'System Engineer', 'מהנדס מערכת', 11),
(189, 'Environmental Engineer', 'מהנדס סביבה', 11),
(190, 'Process Engineer', 'מהנדס תהליך', 11),
(191, 'Industrial Engineering and Management', 'מהנדס תעשייה וניהול', 11),
(192, 'General Engineers', 'מהנדסים כללי', 11),
(193, 'Project Manager', 'מנהל פרוייקטים', 11),
(194, 'Planer', 'פלנר', 11),
(195, 'Mechanical Design', 'תכנן מכאני', 11),
(196, 'Design and Production Supervision', 'תכנון פיקוח הייצור', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `positions` varchar(200) NOT NULL,
  `linkedin` varchar(100) NOT NULL,
  `iscitizen` char(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `verification_salt` varchar(200) NOT NULL,
  `is_verified` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `create_dt`, `modify_dt`, `firstname`, `lastname`, `mobile`, `city`, `positions`, `linkedin`, `iscitizen`, `email`, `pwd`, `status`, `verification_salt`, `is_verified`) VALUES
(1, '2016-06-30 00:25:06', '2016-06-30 00:25:06', 'Test1', 'Test2', '', '', '', '', '1', 'test3@test4.com', 'test5', 1, '18d1f082-445c-11e6-a15a-008cfa041148', '0'),
(2, '2016-06-30 00:39:31', '2016-06-30 00:39:31', 'dffsdfds', 'sdfdsfsdf', '', '', '', '', '1', 'sdfdsf@dffaasf.com', 'ewqrqwre', 1, '18d1f433-445c-11e6-a15a-008cfa041148', '0'),
(3, '2016-06-30 00:50:51', '2016-06-30 00:50:51', 'dfafdsf', 'asdfasf', '', '', '', '', '1', 'dasfadsf@dffasdf.cm', 'fasdfasdf', 1, '18d1f55d-445c-11e6-a15a-008cfa041148', '0'),
(4, '2016-06-30 01:42:43', '2016-06-30 01:42:43', 'dfgttttt', 'sdfgsdfg', '', '', '', '', '1', 'sfasdf@dsfdasf.com', 'sdfgsdfg', 1, '18d1f65d-445c-11e6-a15a-008cfa041148', '0'),
(5, '2016-06-30 01:44:06', '2016-06-30 01:44:06', 'rewtwert', 'ewrtwert', '', '', '', '', '1', 'erwtewr@dsafdas.com', 'erwtwert', 1, '18d1f759-445c-11e6-a15a-008cfa041148', '0'),
(6, '2016-06-30 01:46:36', '2016-06-30 01:46:36', 'rewtwert', 'ewrtwert', '', '', '', '', '1', 'erwtewdr@dsafdas.com', 'erwtwert', 1, '18d1f854-445c-11e6-a15a-008cfa041148', '0'),
(7, '2016-06-30 01:47:00', '2016-06-30 01:47:00', 'asdfasdf', 'asdfasdf', '', '', '', '', '1', 'asdfa@dsfasfadsf.com', 'asdfasdfdasf', 1, '18d1f953-445c-11e6-a15a-008cfa041148', '0'),
(8, '2016-07-02 16:16:44', '2016-07-02 16:16:44', 'MyName', 'MyLastName', '', '', '', '', '1', 'myemail@somehere.net', 'sadfjkal', 1, '18d1fa49-445c-11e6-a15a-008cfa041148', '0'),
(9, '2016-07-02 16:17:52', '2016-07-02 16:17:52', '11213', '23434', '', '', '', '', '1', 'dsfas@dsfasdf.com', '2343rrr', 1, '18d1fb3f-445c-11e6-a15a-008cfa041148', '0'),
(10, '2016-07-02 17:48:08', '2016-07-02 17:48:08', 'MyFirstName', 'MyLastName', '', '', '', '', '1', 'myemail@no.com', '123456', 1, '18d1fc3d-445c-11e6-a15a-008cfa041148', '0'),
(11, '2016-07-02 22:20:07', '2016-07-07 18:57:36', 'Dmitry', 'Romanoff', '12345', 'Tel-Aviv', 'CTO, VP R&D, Head of Data', 'http://mylinkedin.com', '1', 'dmr@yandex.ru', '123456', 1, '18d1fd31-445c-11e6-a15a-008cfa041148', '0'),
(12, '2016-07-02 22:40:59', '2016-07-02 22:40:59', 'Dmitry', 'Romanoff', '', '', '', '', '1', 'dmr@yahoo.com', '123456', 1, '18d1fe34-445c-11e6-a15a-008cfa041148', '0'),
(13, '2016-07-07 19:25:55', '2016-07-07 20:20:49', 'Dod', 'Huenson', '972-03-539-02-12', 'Bat Yam', 'Software Engineer C++/C#/.NET & Other', 'somewhere...', '1', 'dod.huenson@yandex.ru', '123456', 1, '7afc770b-445f-11e6-a15a-008cfa041148', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesslog`
--
ALTER TABLE `businesslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_en` (`name_en`),
  ADD UNIQUE KEY `name_he` (`name_he`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `verification_salt_2` (`verification_salt`),
  ADD KEY `verification_salt` (`verification_salt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `businesslog`
--
ALTER TABLE `businesslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
