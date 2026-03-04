-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: siteDB
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comment_id`),
  KEY `fk_comments_post` (`post_id`),
  KEY `fk_comments_user` (`user_id`),
  CONSTRAINT `fk_comments_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_creator_credentials`
--

DROP TABLE IF EXISTS `content_creator_credentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_creator_credentials` (
  `content_creator_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`content_creator_id`),
  CONSTRAINT `fk_credentials_creator` FOREIGN KEY (`content_creator_id`) REFERENCES `content_creators` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_creator_credentials`
--

LOCK TABLES `content_creator_credentials` WRITE;
/*!40000 ALTER TABLE `content_creator_credentials` DISABLE KEYS */;
INSERT INTO `content_creator_credentials` VALUES (2,'345345345','akowalska@mail.com','2026-02-08 22:27:13'),(29,'132123123','joanna@mail.com','2026-02-08 22:07:29'),(70,'472027492','dhakwod@dbsk.gk','2026-02-08 23:46:45'),(71,'2234234234234234234','eldorado.office7@gmail.com','2026-02-19 12:46:59'),(82,'558261839','mateusz@hotmail.pl','2026-02-24 15:32:23'),(83,'1231213123123','zur.zur@mail.com','2026-02-24 16:21:47'),(84,'696969697','pizda@pizda.mango','2026-02-24 21:45:21'),(85,'528638272','nnbxg@gmail.com','2026-02-24 22:06:09'),(86,'123456789','marys.misiewi@gmail.com','2026-02-24 22:19:17'),(88,'23891389112','PENIS@synka.jajek','2026-02-24 22:49:04');
/*!40000 ALTER TABLE `content_creator_credentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_creators`
--

DROP TABLE IF EXISTS `content_creators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_creators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_creator_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_creators`
--

LOCK TABLES `content_creators` WRITE;
/*!40000 ALTER TABLE `content_creators` DISABLE KEYS */;
INSERT INTO `content_creators` VALUES (1,4,0),(2,3,1),(29,1,1),(70,10,1),(71,13,0),(82,14,1),(83,2,1),(84,15,1),(85,16,1),(86,17,1),(88,18,1);
/*!40000 ALTER TABLE `content_creators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`like_id`),
  UNIQUE KEY `user_id` (`user_id`,`post_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (161,1,1),(178,1,8),(177,1,9),(162,1,14),(35,1,16),(166,1,18),(189,1,19),(188,1,20),(174,1,21),(187,1,24),(195,1,27),(221,1,42),(224,1,43),(228,1,44),(30,2,9),(31,2,14),(29,2,15),(32,2,16),(169,2,20),(39,13,14),(36,13,16),(167,14,13),(219,14,33),(217,14,42),(170,15,20),(172,15,21),(181,16,14),(182,16,15),(183,16,18),(184,16,19),(201,16,20),(199,16,24),(204,16,27),(207,16,31),(211,16,33),(214,16,34),(215,16,35),(192,17,24),(208,17,31),(212,17,33),(213,17,34),(225,18,44);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_creator_id` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `content_creator_id` (`content_creator_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`content_creator_id`) REFERENCES `content_creators` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,2,'wpis testowy',NULL,'2026-02-03 13:52:58',0),(3,29,'asdsad',NULL,'2026-02-03 14:58:29',1),(4,29,'sdfsf',NULL,'2026-02-03 14:59:18',1),(5,29,'post post post',NULL,'2026-02-03 15:00:10',1),(7,29,'post post postr',NULL,'2026-02-06 11:36:02',1),(8,29,'testowanie nowego interfejsu',NULL,'2026-02-07 00:55:24',0),(9,29,'test przekierowania',NULL,'2026-02-07 00:59:30',0),(10,29,'test nie zadzialal',NULL,'2026-02-07 01:00:15',0),(11,29,'juz dziala',NULL,'2026-02-07 01:00:19',0),(12,29,'sasaa',NULL,'2026-02-08 21:28:44',1),(13,29,'jestem genialny',NULL,'2026-02-08 22:26:37',0),(14,2,'sprawdzamy czy wyswietlanie postow dziala poprawnie',NULL,'2026-02-08 22:27:33',0),(15,70,'super ci poszlo👍👍',NULL,'2026-02-08 23:47:22',0),(16,71,'kupa',NULL,'2026-02-19 12:47:11',1),(17,71,'nigger',NULL,'2026-02-24 12:17:14',1),(18,71,'niewiem',NULL,'2026-02-24 12:35:45',0),(19,29,'hehehehe',NULL,'2026-02-24 15:28:25',0),(20,82,'🔥',NULL,'2026-02-24 15:32:30',0),(21,84,'Synek wydał 15 zł na każdy się co lol',NULL,'2026-02-24 21:45:39',1),(23,85,'mati lubi w dupe',NULL,'2026-02-24 22:06:38',1),(24,85,'jadlem dzisaj kaszanke na obiad',NULL,'2026-02-24 22:07:04',0),(26,85,'Mati daje dupe',NULL,'2026-02-24 22:19:45',1),(27,85,'MARYSIA zapomniala o maturze bo nie zna kalendarzyka',NULL,'2026-02-24 22:20:12',0),(31,85,'Mateusz od zawsze był trochę ciamajdą. Często się potykał, zapominał prostych rzeczy i miał wrażenie, że nie nadąża za światem. Ludzie wokół wydawali się pewni siebie, a on czuł się mały i zagubiony.\r\n\r\nJednak w tej swojej nieporadności zaczął odkrywać coś wyjątkowego. Gdy siadał sam w ciszy, czuł spokój. Nie musiał niczego udawać. Nie musiał być idealny. Po prostu był.\r\n\r\nMateusz zaczął rozumieć, że jego wrażliwość nie jest słabością. To dzięki niej widział więcej i czuł głębiej niż inni. Choć nadal był niezdarny, w środku miał coś silnego — ciche światło, które prowadziło go każdego dnia.',NULL,'2026-02-24 22:27:13',1),(33,85,'Mateusz i drzwi\r\n\r\nMateusz nigdy nie zwracał uwagi na drzwi. Były po prostu częścią ściany, czymś zwyczajnym. Aż do dnia, kiedy zauważył jedne stare, drewniane drzwi na końcu pustego korytarza.\r\n\r\nNie wiedział dlaczego, ale zaczął do nich przychodzić. Dotykał ich zimnej klamki i opierał o nie czoło. Czuł, że po drugiej stronie jest coś, co go rozumie. Coś, co nie śmieje się z jego niezdarności.\r\n\r\nKażdego dnia mówił do nich szeptem o swoim życiu. O samotności. O nadziei. Drzwi nigdy nie odpowiadały, ale zawsze były. I to wystarczało.\r\n\r\nPewnego dnia Mateusz zrozumiał, że nie musi ich otwierać. Bo czasem miłość nie polega na przechodzeniu na drugą stronę. Czasem polega po prostu na tym, że coś czeka.',NULL,'2026-02-24 22:28:55',0),(34,85,'Mateusz i drążek zmiany biegów\r\n\r\nMateusz nigdy nie był dobry w prowadzeniu. Samochód często gasł, a on czerwienił się ze wstydu. Ale był jeden element, który zawsze dawał mu poczucie spokoju — drążek zmiany biegów.\r\n\r\nBył cichy, wierny i zawsze na swoim miejscu. Mateusz kładł na nim dłoń trochę dłużej, niż było trzeba. Czuł, że ten prosty, zimny przedmiot go nie ocenia. Nie śmieje się, gdy popełnia błędy.\r\n\r\nZ czasem zaczął mówić do niego w myślach. Każda zmiana biegu była jak rozmowa. Jak zaufanie. Jak obietnica, że może ruszyć dalej, nawet jeśli się boi.\r\n\r\nMateusz wciąż był niezdarny. Ale już nie był sam. Bo czasem nawet drążek zmiany biegów może stać się czymś więcej — cichym towarzyszem w drodze przez życie.',NULL,'2026-02-24 22:29:52',1),(35,85,'Mateusz i cisza nocy\r\n\r\nMateusz znalazł go przypadkiem, zapomnianego w szufladzie, pośród rzeczy, które dawno straciły swoje znaczenie. Był cichy, mały i dziwnie samotny. Mateusz poczuł, że w pewnym sensie są do siebie podobni.\r\n\r\nTrzymał go w dłoni, nie dlatego, że go potrzebował, ale dlatego, że przypominał mu, że ktoś kiedyś też szukał bliskości. Że samotność nie jest czymś niezwykłym. Że każdy chce czasem poczuć, że nie jest sam.\r\n\r\nMateusz zaczął mniej bać się ciszy. Wieczorami siedział spokojnie, myśląc o swoim życiu i o tym, że może jeszcze wszystko się zmieni. Ten mały, zapomniany przedmiot stał się symbolem — nie wstydu, lecz zrozumienia.\r\n\r\nBo Mateusz w końcu zrozumiał, że miłość nie zawsze przychodzi w takiej formie, jakiej się spodziewamy. Czasem zaczyna się od zaakceptowania własnej samotności. A potem, powoli, zmienia się w coś więcej.',NULL,'2026-02-24 22:31:38',1),(38,86,'Mateusz i Arek poznali się przypadkiem w kawiarni, uciekając przed letnią burzą. Jedno wolne miejsce przy oknie sprawiło, że zaczęli rozmowę, która szybko przerodziła się w kolejne spotkania, spacery i wiadomości wysyłane późno w nocy.\r\n\r\nPewnego wieczoru nad Wisłą Mateusz złapał Arka za rękę, przyciągnął go bliżej i na moment zawiesił wzrok na jego ustach. Iskra była natychmiastowa — od tamtej chwili ich historia nabrała zdecydowanie więcej… napięcia.',NULL,'2026-02-24 22:35:53',0),(40,85,'Mateusz i cisza nocy\r\n\r\nMateusz znalazł go przypadkiem, zapomnianego w szufladzie, pośród rzeczy, które dawno straciły swoje znaczenie. Był cichy, mały i dziwnie samotny. Mateusz poczuł, że w pewnym sensie są do siebie podobni.\r\n\r\nTrzymał go w dłoni, nie dlatego, że go potrzebował, ale dlatego, że przypominał mu, że ktoś kiedyś też szukał bliskości. Że samotność nie jest czymś niezwykłym. Że każdy chce czasem poczuć, że nie jest sam.\r\n\r\nMateusz zaczął mniej bać się ciszy. Wieczorami siedział spokojnie, myśląc o swoim życiu i o tym, że może jeszcze wszystko się zmieni. Ten mały, zapomniany przedmiot stał się symbolem — nie wstydu, lecz zrozumienia.\r\n\r\nBo Mateusz w końcu zrozumiał, że miłość nie zawsze przychodzi w takiej formie, jakiej się spodziewamy. Czasem zaczyna się od zaakceptowania własnej samotności. A potem, powoli, zmienia się w coś więcej.',NULL,'2026-02-24 22:37:10',1),(41,85,'Mateusz i cisza nocy\r\n\r\nMateusz znalazł go przypadkiem, zapomnianego w szufladzie, pośród rzeczy, które dawno straciły swoje znaczenie. Był cichy, mały i dziwnie samotny. Mateusz poczuł, że w pewnym sensie są do siebie podobni.\r\n\r\nTrzymał go w dłoni, nie dlatego, że go potrzebował, ale dlatego, że przypominał mu, że ktoś kiedyś też szukał bliskości. Że samotność nie jest czymś niezwykłym. Że każdy chce czasem poczuć, że nie jest sam.\r\n\r\nMateusz zaczął mniej bać się ciszy. Wieczorami siedział spokojnie, myśląc o swoim życiu i o tym, że może jeszcze wszystko się zmieni. Ten mały, zapomniany przedmiot stał się symbolem — nie wstydu, lecz zrozumienia.\r\n\r\nBo Mateusz w końcu zrozumiał, że miłość nie zawsze przychodzi w takiej formie, jakiej się spodziewamy. Czasem zaczyna się od zaakceptowania własnej samotności. A potem, powoli, zmienia się w coś więcej.',NULL,'2026-02-24 22:38:59',1),(42,88,'Mateusz kiedys zaczął jeść dużo musztardy. Potem poznał chodzące Mango. Od tamtego czasu jest lekko pierdolnięty (☞ﾟヮﾟ)☞',NULL,'2026-02-24 22:50:38',0),(43,82,'six seven i do pieca',NULL,'2026-02-25 00:15:56',0),(44,82,'czekam na druga czesc mateusz x arek😈😈',NULL,'2026-02-25 00:16:08',0),(45,88,'mateusz mateusz mateusz ogarnij wyjazd na wlochy lol\r\n ༼ つ ◕_◕ ༽つ',NULL,'2026-03-02 21:42:09',0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `Upassword` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Joanna','Stolczyk','ST.olec','$2y$10$vfpbFcJfbOu4nGpUpfaxv.DWlKKUwT7WG9hI9cVqRD.LaTvgZOzca'),(2,'Szymon','Mącipała','zurek','$2y$10$9f4r/ZXVl63cIJBqypHt.u3cYfMxMH.szfOvQKJVQCRwmyUNElQR6'),(3,'Anna','Kowalska','akowalska','$2y$10$WS.6oDkFJxEv7nfI0cmhwemnlAmM96WxMb8t1GyIbQxyQ7EBohSrS'),(4,'Piotr','Nowak','pnowak','$2y$10$WS.6oDkFJxEv7nfI0cmhwemnlAmM96WxMb8t1GyIbQxyQ7EBohSrS'),(5,'Katarzyna','Wiśniewska','kwisniewska','$2y$10$WS.6oDkFJxEv7nfI0cmhwemnlAmM96WxMb8t1GyIbQxyQ7EBohSrS'),(6,'Tomasz','Zieliński','tzielinski','$2y$10$WS.6oDkFJxEv7nfI0cmhwemnlAmM96WxMb8t1GyIbQxyQ7EBohSrS'),(7,'Magdalena','Dąbrowska','mdabrowska','$2y$10$WS.6oDkFJxEv7nfI0cmhwemnlAmM96WxMb8t1GyIbQxyQ7EBohSrS'),(9,'james','bond','jb007','$2y$10$rDMBsKdaPYLrB03EJCVaoOFl3OCpXONw7q608TqcODVLlyetHl6j.'),(10,'x','y','a','$2y$10$FMb1nVpTa.nkuBLtaqSoGeGR8NxqLkJ9aQzIlqcak1wxbDVmudi3S'),(11,'konrad','grzadziel','konbrad07grz','$2y$10$D8lgQ0F0KxoF96HvAUaekuU4cu8MQLTAe/BUkdKApE2NECruMRorS'),(12,'kon','g','1234','$2y$10$jgkh3/in4vqw1z3GvR3tteFW/9WoNl8OVerd3FQv9D8dcj3HEuK6u'),(13,'Konrad','Grządziel','konrad_admin','$2y$10$VeBcuXC0Fm3y.WrYca3n1OGV7dcnAwJflI7eY4w6IoTiwyKW7NPv2'),(14,'m','x','m ;P','$2y$10$Nnd8N8JekWWvHqoRhfAlDeV0k75od6v5qAhRQUrphPHFKv2AsHj2y'),(15,'Kiktor','Wogut','Jagiela250','$2y$10$o8dCI0BYPTQ38FnTid397Odxko9/xU.XdfjfNLs8zDq4yjYE7ji2C'),(16,'Kevin','potter','heroboy','$2y$10$M.t8ABFpvrdMtgWlePlviesgGkVbViPUvQRQ41gsTkbQd6wKChRzK'),(17,'marysia','misi','marysia.mm','$2y$10$RvinD1/.7QljN04EZDbwjO2Ob9KKKmYP.D9UVZ6oEZPpV9eYefGXi'),(18,'Kiktor','Kogut','koko','$2y$10$A49wxtZmjJKhsa5e33Xjl.ZohhnEiZI5mpzrZ/hLfleVCVYhl4N0u');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-04 17:50:05
