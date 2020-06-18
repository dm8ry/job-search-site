-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: mysql.jobs972.com
-- Generation Time: Jun 19, 2016 at 03:31 PM
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
  `createdt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifydt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `name`, `createdt`, `modifydt`) VALUES
(1, 'CONTACT_US', '2016-06-19 13:30:26', '2016-06-19 13:30:26');

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
  `the_page` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businesslog`
--

INSERT INTO `businesslog` (`id`, `datex`, `alert_id`, `principal_id`, `ip_addr`, `email`, `the_info`, `the_page`) VALUES
(1, '2016-06-19 23:27:24', 0, 0, '85.250.131.106', 'dasdasf@fdgdsg.ru', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:27:24</b><br/>Имя отправителя сообщения: <b>qwerqewr</b><br/>Фамилия отправителя сообщения: <b>qwerqwer</b><br/>Email отправителя сообщения: <b>dasdasf@fdgdsg.ru</b><br/>Тема сообщения: <b>rqwerqwer</b><br/>Сообщение: <b>rqwerqwerqw</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', ''),
(2, '2016-06-19 23:31:10', 0, 0, '85.250.131.106', 'adsffadsf@fafads.com', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:31:10</b><br/>Имя отправителя сообщения: <b>qew</b><br/>Фамилия отправителя сообщения: <b>adsfads</b><br/>Email отправителя сообщения: <b>adsffadsf@fafads.com</b><br/>Тема сообщения: <b>dasfasdfasdf</b><br/>Сообщение: <b>asdfasdfasdf</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', 'contactus.php'),
(3, '2016-06-19 23:32:34', 0, 0, '85.250.131.106', 'qwerqewr@dfdasf.com', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:32:34</b><br/>Имя отправителя сообщения: <b>werewr</b><br/>Фамилия отправителя сообщения: <b>qewrqewr</b><br/>Email отправителя сообщения: <b>qwerqewr@dfdasf.com</b><br/>Тема сообщения: <b>qwerqewr</b><br/>Сообщение: <b>asdfasfasdf</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', 'contactus.php'),
(4, '2016-06-19 23:32:56', 0, 0, '85.250.131.106', 'asdfasd@dssss.com', '<html><body>Здравствуйте, Jobs972!<br/><br/>Вам отправлено сообщение с контактной страницы сайта Jobs972!<br/><br/>Дата отправки сообщения: <b>19-06-2016 23:32:56</b><br/>Имя отправителя сообщения: <b>asdfasdfdasf</b><br/>Фамилия отправителя сообщения: <b>dwerdasfdasfs</b><br/>Email отправителя сообщения: <b>asdfasd@dssss.com</b><br/>Тема сообщения: <b>fasdfasf</b><br/>Сообщение: <b>asdfdasf</b><br/><br/>С уважением,  <br/>Администрация.</body></html>', 'contactus.php');

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
  `createdt` datetime NOT NULL,
  `modifydt` datetime NOT NULL,
  `the_name` varchar(100) NOT NULL,
  `placement_id` int(11) NOT NULL,
  `photo_logo` varchar(200) NOT NULL,
  `website` varchar(100) NOT NULL,
  `num_people` int(11) NOT NULL,
  `the_descrip` text NOT NULL,
  `the_descrip_heb` text NOT NULL,
  `address` varchar(2000) NOT NULL,
  `address_heb` varchar(200) NOT NULL,
  `phone_1` varchar(20) NOT NULL,
  `fax_1` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `nviews` int(11) NOT NULL,
  `num_positions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `createdt`, `modifydt`, `the_name`, `placement_id`, `photo_logo`, `website`, `num_people`, `the_descrip`, `the_descrip_heb`, `address`, `address_heb`, `phone_1`, `fax_1`, `status`, `nviews`, `num_positions`) VALUES
(1, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 'DNAmarketingltd', 34, '', 'http://dnamarketingltd.com', 34, 'DNA Marketing LTD was established in order to provide marketing solutions to relocation companies in the US.\r\nOur wide network of Agents, Moving companies, warehouses and employees allow us to provide a wide range of services all over the US 24/7 in a cost effective way.\r\n\r\nWe select each moving company very carefully to ensure all companies operate at the highest level of service, professionalism, and accountability. Each company is independently owned and run, with all of the appropriate licensing. With dedication to providing the customer with a trustworthy and excellent moving experience, we offer a high-end moving service to each customer—and we constantly deliver.', '', 'Hashmonaim 113, Tel-Aviv', '', '077-456-0089', '03-9008639', '1', 8, 0),
(3, '2016-06-18 00:00:00', '2016-06-18 00:00:00', '-', 74, '', '', 0, '', '', '', '', '', '', '1', 0, 0),
(4, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 'ewave', 74, '', 'http://ewave.co.il', 0, '', 'eWave היא ספקית מובילה של פתרונות תוכנה ואינטגרציה, המתמחה בפיתוח ובהטמעת מערכות eBusiness שמטרתן יצירת ערך עסקי אמיתי ללקוח. eWave מספקת שירותים כוללים ליישום אסטרטגיה דיגיטאלית, החל ממתן ייעוץ לגיבוש האסטרטגיה ועד למימושה באמצעות פלטפורמות, כלים ויישומים משלימים. מחלקת הייעוץ האסטרטגי וחווית המשתמש (UX) מייעצת ללקוחותינו כיצד לרתום את המדיה הדיגיטאלית לטובת יעדיהם העסקיים, מסייעת להבין את צרכי המשתמשים ומתרגמת את האסטרטגיה למתווה פעולה מעשי. חטיבות הפיתוח מיישמות את האסטרטגיה, מאפיינות ומפתחות מערכות בארכיטקטורות SOA ו-BPM, תוך שימוש בטכנולוגיות Java, .NET ו-PHP. החברה היא שותפה עסקית של יצרני התוכנה המובילים בעולם: Microsoft, Oracle ו-IBM.', '', 'סניף רעננה - רח\' ירושלים 34  (בניין גמלא B, קומה 2)', '09-9543040', '09-9545070', '1', 3, 0),
(5, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 'Taptica', 34, '', 'http://www.taptica.com', 0, 'We provide data-focused marketing solutions that drive execution and powerful brand insight in mobile by leveraging video, social, native, and display to reach the most valuable users for every app, service, and brand.\r\n\r\nWe also work with over 50,000 supply and publishing partners worldwide including Mopub, Millenial Media, Appnexus, and Rubicon.', '', 'Tel-Aviv', '', '', '', '1', 7, 0);

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
  `company_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `pos_desc` text NOT NULL,
  `nviews` int(11) DEFAULT '0',
  `napply` int(11) NOT NULL DEFAULT '0',
  `pos_priority` int(11) NOT NULL DEFAULT '0',
  `pos_status` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `createdt`, `modifydt`, `principal_id`, `pos_title`, `company_id`, `location_id`, `pos_desc`, `nviews`, `napply`, `pos_priority`, `pos_status`) VALUES
(1, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 0, 'English Speaker', 1, 34, 'Attention English Speakers of Tel-Aviv! Our office is looking to hire sales representatives! Our company provides relocation services to US based clients Shifts are in the evening (based on US time zone) Send an email and attach your resume to our HR Manager', 0, 0, 0, '1'),
(3, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 0, 'Full-Stack Developer', 4, 74, 'We are looking for a Full-Stack Developer with a focus on web and technology such as: JS, Angular Typescript, React\r\n\r\nGood knowledge in JS and Angular development (+HTML5, CSS3)\r\nDeveloping in C# under IIS\r\nWorking with MS SQL', 0, 0, 0, '1'),
(4, '2016-06-18 00:00:00', '2016-06-18 00:00:00', 0, 'Back-end Java Developer', 5, 34, 'We are looking for a Back-end Java Developer skilled in a highly dynamic web interface development to join our social platform development team. Our social R&D team develops our social ads platform, adding both new infrastructures and new functionalities, working closely with world leading social networks. Development includes taking a feature spec, designing a solution, and implementing the feature end-to-end, DB to UI.\r\n\r\n-4-5 years of proven experience in Java development\r\n-Highly experienced with, application servers, databases, Spring, and Hibernate\r\n-Great understanding in MVC and REST\r\n-Knowledge in – JavaScript, JQuery, CSS, HTML, Bootstrap, Angular – big advantage\r\n-Team player with positive “can do” attitude\r\n-Full time position in Tel-Aviv', 0, 0, 0, '1'),
(5, '2016-06-18 08:43:45', '2016-06-18 08:43:45', 0, 'Front-End Web application developer', 5, 34, 'This role is for a Front-End Web application developer experienced in building interfaces to rich Internet applications.\r\nWe are looking for an individual skilled in highly dynamic web interface development (HTML, JavaScript, AJAX, jQuery) to join our front-end development team.\r\n\r\n-Highly skilled at front-end engineering using Object-Oriented JavaScript, various JavaScript libraries and micro frameworks (jQuery, Angular, Prototype, Dojo, Backbone, YUI), HTML and CSS\r\n-Well versed in software engineering principles, frameworks and technologies\r\n-Excellent communication skills\r\n-Self-directed team player who thrives in a continually changing environment', 0, 0, 0, '1');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `businesslog`
--
ALTER TABLE `businesslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
