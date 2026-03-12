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
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1);
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `content_creator_credentials` VALUES (2,'345345345','akowalska@mail.com','2026-02-08 22:27:13'),(29,'13123123','joanna@mail.com','2026-02-08 22:07:29'),(83,'1231213123123','zur.zur@mail.com','2026-02-24 16:21:47'),(86,'123456789','marys.misiewi@gmail.com','2026-02-24 22:19:17'),(88,'23891389112','PENIS@synka.jajek','2026-02-24 22:49:04'),(93,'1243368658','koko@koko','2026-03-10 12:37:21');
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
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_creators`
--

LOCK TABLES `content_creators` WRITE;
/*!40000 ALTER TABLE `content_creators` DISABLE KEYS */;
INSERT INTO `content_creators` VALUES (2,3,1),(29,1,1),(83,2,1),(86,17,1),(88,18,1),(93,22,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (369,1,161),(368,1,162),(373,1,165),(366,2,160),(365,2,161),(367,2,162),(374,2,165),(371,3,161),(372,3,165);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_images`
--

DROP TABLE IF EXISTS `post_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_images_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_images`
--

LOCK TABLES `post_images` WRITE;
/*!40000 ALTER TABLE `post_images` DISABLE KEYS */;
INSERT INTO `post_images` VALUES (46,160,'img_29_160_0.jpg'),(47,161,'img_29_161_0.jpg'),(48,162,'img_83_162_0.jpg'),(49,162,'img_83_162_1.jpg'),(50,165,'img_2_165_0.jpg');
/*!40000 ALTER TABLE `post_images` ENABLE KEYS */;
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
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `content_creator_id` (`content_creator_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`content_creator_id`) REFERENCES `content_creators` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (160,29,'W miniony weekend miałem okazję odwiedzić Budapeszt, stolicę Węgier, i muszę przyznać, że to miasto zrobiło na mnie ogromne wrażenie. Już sama podróż pociągiem była przyjemnością – krajobrazy wzdłuż Dunaju zachwycały zielenią i malowniczymi wioskami, które mijałem po drodze. Budapeszt, będący połączeniem dwóch historycznych miast – Buda i Pest, oferuje niesamowite kontrasty: z jednej strony historyczne zamki i wzgórza, z drugiej nowoczesne ulice i tętniące życiem place.\r\n\r\nPierwszego dnia postanowiłem zwiedzać Budę, zaczynając od słynnego Wzgórza Zamkowego. Spacer wzdłuż brukowanych uliczek był jak podróż w czasie – stara architektura, kolorowe kamienice i przepiękne widoki na Pest. Najbardziej zachwycił mnie Zamek Królewski, który niegdyś był rezydencją węgierskich królów. Chociaż zamek był odbudowywany wielokrotnie, nadal można poczuć jego historyczny charakter. Z jego tarasów rozpościera się niesamowita panorama na Most Łańcuchowy i rozległą panoramę miasta.\r\n\r\nNastępnie odwiedziłem Kościół Macieja, który zachwyca bogactwem detali i barokowym wnętrzem. Warto wspiąć się na wieżę kościoła – widok na Dunaj i panoramę miasta jest po prostu spektakularny. Spacer po wzgórzu zakończyłem w Twierdzy Rybackiej, która sama w sobie jest pięknym zabytkiem, a przy tym oferuje jedne z najlepszych punktów widokowych w całym Budapeszcie.\r\n\r\nPo południu zeszedłem na stronę Pest, by poczuć tętno współczesnego miasta. Moje kroki skierowały się w stronę Parlamentu Węgierskiego, jednego z najbardziej imponujących budynków w Europie. Jego neogotycka architektura i ogromne kopuły robią wrażenie, a spacer wzdłuż Dunaju pozwala podziwiać go w pełnej okazałości. Następnie udałem się na Plac Bohaterów, gdzie pomniki i kolumny przypominają o historii Węgier i bohaterach narodowych. Spacer po pobliskim Parku Miejskim był miłym przerywnikiem po intensywnym zwiedzaniu.\r\n\r\nWieczorem postanowiłem spróbować węgierskiej kuchni. W małej, klimatycznej restauracji zamówiłem gulasz i tradycyjne węgierskie pierogi. Smak był niesamowity – aromatyczne przyprawy, delikatne mięso i świeży chleb sprawiły, że poczułem prawdziwy charakter tego regionu. Po kolacji nie mogłem odmówić sobie spaceru wzdłuż Mostu Łańcuchowego, który nocą jest pięknie oświetlony i odbija się w wodach Dunaju niczym w lustrze.\r\n\r\nDrugiego dnia postawiłem na relaks i zwiedzanie mniej znanych zakątków miasta. Odwiedziłem Baseny Termalne Széchenyi, które są jednym z symboli Budapesztu. Spędzenie kilku godzin w gorących, mineralnych wodach było niezwykle relaksujące, a sam kompleks robi ogromne wrażenie swoim rozmachem i architekturą. Następnie wybrałem się na spacer po Váci utca, głównej ulicy handlowej, pełnej sklepów, kawiarni i restauracji. To miejsce idealne na zakup pamiątek i obserwowanie miejskiego życia.\r\n\r\nNie mogłem też pominąć Wielkiej Hali Targowej, gdzie lokalni sprzedawcy oferują węgierskie wędliny, przyprawy, paprykę i rękodzieło. Spróbowałem kilku tradycyjnych przysmaków, a kolorowe stoiska i zapachy sprawiły, że poczułem się jak prawdziwy turysta w sercu miasta.\r\n\r\nNa koniec wycieczki zdecydowałem się na rejs po Dunaju, który był doskonałym podsumowaniem całego wyjazdu. Widok miasta o zachodzie słońca – Most Łańcuchowy, Zamek Królewski i Parlament odbijające się w wodzie – był absolutnie magiczny. Budapeszt okazał się miastem pełnym kontrastów, gdzie historia spotyka się z nowoczesnością, a kultura i architektura zachwycają na każdym kroku.\r\n\r\nPodsumowując, Budapeszt to miejsce, które koniecznie trzeba odwiedzić. Niezależnie od tego, czy interesuje Cię historia, architektura, gastronomia, czy relaks w termach – każdy znajdzie tu coś dla siebie. Wycieczka ta pozostawiła we mnie niezapomniane wspomnienia i zdecydowanie planuję wrócić, aby odkryć kolejne zakątki tego fascynującego miasta.','2026-03-12 23:06:01',0),(161,29,'# Wycieczka do Hiszpanii – podróż pełna słońca, kultury i niezapomnianych wrażeń\r\n\r\nHiszpania od lat znajduje się w czołówce najchętniej odwiedzanych krajów w Europie. Nic dziwnego – oferuje piękne plaże, wyjątkową kulturę, pyszną kuchnię oraz wiele historycznych miast. Podczas mojej wycieczki do Hiszpanii miałem okazję zobaczyć wiele niezwykłych miejsc, spróbować lokalnych potraw i poczuć prawdziwy klimat tego kraju. Była to podróż, która na długo pozostanie w mojej pamięci.\r\n\r\nJuż pierwszego dnia po przylocie można było poczuć zupełnie inną atmosferę niż w Polsce. Ciepłe powietrze, intensywne słońce oraz charakterystyczna architektura sprawiają, że od razu wiadomo, że jest się w kraju południowej Europy. Ludzie wydają się bardziej spokojni, uśmiechnięci i otwarci. Spacerując po ulicach, można usłyszeć głośne rozmowy w kawiarniach, muzykę dochodzącą z restauracji oraz zobaczyć kolorowe budynki z balkonami pełnymi kwiatów.\r\n\r\nJednym z najciekawszych miast, które odwiedziłem, była Barcelona. To miejsce znane jest z niezwykłej architektury oraz artystycznej atmosfery. Największe wrażenie zrobiła na mnie słynna bazylika Sagrada Familia. Jest to ogromna świątynia zaprojektowana przez Antoniego Gaudíego, która do dziś jest w trakcie budowy. Jej niezwykłe wieże i detale architektoniczne sprawiają, że wygląda jak coś z innego świata. Oprócz tego w Barcelonie można zobaczyć także Park Güell, w którym znajdują się kolorowe mozaiki, tarasy widokowe i fantazyjne konstrukcje.\r\n\r\nOczywiście wycieczka do Hiszpanii to nie tylko zwiedzanie zabytków, ale także odpoczynek. Barcelona leży nad Morzem Śródziemnym, dlatego po całym dniu zwiedzania można udać się na plażę. Ciepła woda, miękki piasek i widok zachodzącego słońca tworzą idealne warunki do relaksu. Plaże są pełne turystów, ale również mieszkańców, którzy spędzają tam czas z rodziną lub przyjaciółmi.\r\n\r\nNie można również zapomnieć o hiszpańskiej kuchni, która jest jedną z największych atrakcji tego kraju. Podczas podróży miałem okazję spróbować wielu tradycyjnych potraw. Jedną z najbardziej znanych jest paella – danie z ryżu, owoców morza, kurczaka oraz warzyw. Bardzo popularne są także tapas, czyli małe przekąski podawane w barach. Mogą to być oliwki, sery, kawałki chleba z pomidorami, a także różne rodzaje mięs. Jedzenie w Hiszpanii to nie tylko posiłek, ale także sposób spędzania czasu z innymi ludźmi.\r\n\r\nPodczas wycieczki zauważyłem również, że Hiszpanie bardzo cenią sobie życie towarzyskie. Wieczorami ulice miast są pełne ludzi, którzy spotykają się w restauracjach, spacerują lub słuchają muzyki ulicznych artystów. Atmosfera jest bardzo żywa i przyjazna. Dzięki temu nawet jako turysta można poczuć się częścią tej wyjątkowej kultury.\r\n\r\nPodsumowując, wycieczka do Hiszpanii była niezwykle ciekawym doświadczeniem. Ten kraj oferuje wiele atrakcji – od pięknych miast i zabytków, przez wspaniałe plaże, aż po wyjątkową kuchnię i kulturę. Każdy, kto zdecyduje się odwiedzić Hiszpanię, z pewnością znajdzie tam coś dla siebie. Jest to miejsce, do którego chce się wracać, ponieważ za każdym razem można odkryć coś nowego i jeszcze lepiej poznać jego niezwykły klimat.','2026-03-12 23:09:13',0),(162,83,'# Meksyk – podróż do krainy kolorów, smaków i niezwykłej historii\r\n\r\nPodróż do Meksyku była jedną z najbardziej ekscytujących przygód, jakie miałem okazję przeżyć. Ten kraj kojarzy się wielu osobom z pięknymi plażami, ostrą kuchnią i starożytnymi piramidami. W rzeczywistości Meksyk oferuje znacznie więcej – niezwykłą kulturę, przyjaznych ludzi oraz krajobrazy, które potrafią zachwycić każdego podróżnika. Już od pierwszego dnia można poczuć, że jest to miejsce pełne energii i życia.\r\n\r\nPo przylocie do Meksyku od razu uderza zupełnie inny klimat niż w Europie. Ciepłe powietrze, palmy, kolorowe budynki i głośne ulice sprawiają, że człowiek czuje się jak w zupełnie innym świecie. Na każdym kroku można spotkać małe stragany z jedzeniem, lokalne sklepy z rękodziełem oraz muzyków grających tradycyjne melodie. Meksyk jest krajem bardzo żywym, w którym kultura i tradycja są obecne niemal wszędzie.\r\n\r\nJednym z najciekawszych miejsc, które miałem okazję odwiedzić, było starożytne miasto Chichén Itzá. Jest to jedno z najsłynniejszych stanowisk archeologicznych w Meksyku i jedno z nowych siedmiu cudów świata. Najbardziej charakterystyczną budowlą jest ogromna piramida Kukulkana. Kiedy stoi się przed nią, trudno uwierzyć, że została zbudowana setki lat temu przez cywilizację Majów. Spacerując po tym miejscu można poczuć prawdziwą historię i wyobrazić sobie, jak wyglądało życie dawnych mieszkańców tych terenów.\r\n\r\nOczywiście Meksyk to także raj dla osób, które lubią odpoczywać nad wodą. Wiele miejscowości położonych jest nad Morzem Karaibskim lub Oceanem Spokojnym. Jednym z takich miejsc jest Cancún, znane z długich, białych plaż i turkusowej wody. Plaże są naprawdę piękne i idealne do odpoczynku po intensywnym zwiedzaniu. Można tam pływać, nurkować lub po prostu leżeć na piasku i podziwiać widok oceanu.\r\n\r\nPodczas podróży nie można pominąć meksykańskiej kuchni, która jest jedną z najbardziej rozpoznawalnych na świecie. Najbardziej znane potrawy to oczywiście tacos, burrito oraz quesadilla. W wielu miejscach można kupić świeże tortille przygotowywane na miejscu, do których dodaje się mięso, warzywa, sosy i przyprawy. Smaki są bardzo intensywne i często dość ostre, ale właśnie to sprawia, że jedzenie w Meksyku jest tak wyjątkowe. Do posiłku często podaje się także świeże owoce lub napoje przygotowane z tropikalnych składników.\r\n\r\nPodczas pobytu zauważyłem również, jak ważna dla Meksykanów jest ich kultura i tradycja. W wielu miastach można zobaczyć kolorowe murale, tradycyjne stroje oraz różnego rodzaju festiwale. Muzyka i taniec są częścią codziennego życia. Ludzie często spotykają się na placach miejskich, rozmawiają, jedzą i słuchają muzyki. Atmosfera jest bardzo radosna i otwarta.\r\n\r\nPodsumowując, Meksyk to kraj, który potrafi zachwycić na wiele sposobów. Piękne plaże, starożytne zabytki, wyjątkowa kuchnia oraz niezwykle żywa kultura sprawiają, że jest to miejsce warte odwiedzenia. Podróż do Meksyku pozwala nie tylko odpocząć, ale także poznać fascynującą historię i tradycje tego regionu świata. Jest to zdecydowanie jedna z tych podróży, które zostają w pamięci na bardzo długo.','2026-03-12 23:10:48',0),(165,2,'# Wycieczka do Finlandii – podróż do krainy jezior i natury\r\n\r\nWycieczka do Finlandii była zupełnie innym doświadczeniem niż podróże do krajów południowej Europy. Ten skandynawski kraj słynie przede wszystkim z niezwykłej przyrody, ogromnej liczby jezior oraz spokojnej atmosfery. Finlandia jest często nazywana „krainą tysiąca jezior”, choć w rzeczywistości jest ich tam ponad 180 tysięcy. Podróż do tego miejsca pozwala odpocząć od hałasu dużych miast i poczuć prawdziwą bliskość natury.\r\n\r\nJuż po przylocie można zauważyć, że Finlandia różni się od wielu innych krajów Europy. Miasta są bardzo czyste i dobrze zorganizowane, a ludzie wydają się spokojni i uprzejmi. Ulice nie są tak zatłoczone jak w dużych metropoliach, a w wielu miejscach można zobaczyć lasy i jeziora znajdujące się bardzo blisko zabudowań. To sprawia, że nawet w mieście można poczuć kontakt z naturą.\r\n\r\nJednym z pierwszych miejsc, które odwiedziłem, była stolica kraju – Helsinki. Jest to nowoczesne miasto położone nad Morzem Bałtyckim. W centrum znajduje się wiele ciekawych budynków, muzeów oraz parków. Szczególnie interesująca jest Katedra w Helsinkach, która jest jednym z najbardziej rozpoznawalnych symboli miasta. Jej biała fasada i zielone kopuły robią ogromne wrażenie, zwłaszcza gdy patrzy się na nią z głównego placu.\r\n\r\nPodczas wycieczki do Finlandii największe wrażenie zrobiła na mnie jednak przyroda. Ogromne lasy, czyste jeziora i świeże powietrze sprawiają, że jest to idealne miejsce dla osób, które lubią spokój i aktywny wypoczynek. W wielu regionach można wynająć małe drewniane domki nad jeziorem i spędzić czas z dala od cywilizacji. Popularne jest tam wędkowanie, pływanie łódką oraz spacery po lesie.\r\n\r\nFinlandia słynie również z sauny, która jest bardzo ważnym elementem tamtejszej kultury. W kraju liczącym około 5,5 miliona mieszkańców znajduje się ponad 3 miliony saun. Dla Finów jest to miejsce relaksu i spotkań z rodziną lub przyjaciółmi. Podczas mojej wycieczki również miałem okazję spróbować tej tradycji. Najpierw spędza się kilka minut w gorącej saunie, a następnie wychodzi na zewnątrz, aby ochłodzić się na świeżym powietrzu lub nawet wskoczyć do zimnej wody.\r\n\r\nCiekawym regionem Finlandii jest także Laponia, położona na północy kraju. To miejsce znane jest przede wszystkim z niezwykłych zimowych krajobrazów oraz związków z legendą o Świętym Mikołaju. W zimie można tam zobaczyć zorzę polarną, która jest jednym z najpiękniejszych zjawisk naturalnych na świecie. Zielone i fioletowe światła pojawiające się na nocnym niebie tworzą naprawdę niesamowity widok.\r\n\r\nPodczas podróży warto również spróbować lokalnej kuchni. W Finlandii popularne są potrawy z ryb, zwłaszcza łososia, a także dania z dziczyzny. Często podaje się także różne rodzaje chleba, ziemniaki oraz jagody, które rosną w tamtejszych lasach. Smaki są zazwyczaj proste, ale bardzo naturalne i świeże.\r\n\r\nPodsumowując, wycieczka do Finlandii była niezwykle ciekawym doświadczeniem. Ten kraj zachwyca przede wszystkim swoją przyrodą, spokojem oraz wyjątkową kulturą. Jest to idealne miejsce dla osób, które chcą odpocząć od codziennego pośpiechu i spędzić czas w otoczeniu natury. Finlandia pokazuje, że podróżowanie nie musi zawsze oznaczać tłumów turystów i wielkich miast – czasem najpiękniejsze są miejsca ciche i pełne naturalnego uroku.','2026-03-12 23:13:58',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Joanna','Stolczyk','ST.olec','$2y$10$vfpbFcJfbOu4nGpUpfaxv.DWlKKUwT7WG9hI9cVqRD.LaTvgZOzca'),(2,'Szymon','Mącipała','zurek','$2y$10$9f4r/ZXVl63cIJBqypHt.u3cYfMxMH.szfOvQKJVQCRwmyUNElQR6'),(3,'Anna','Kowalska','akowalska','$2y$10$WS.6oDkFJxEv7nfI0cmhwemnlAmM96WxMb8t1GyIbQxyQ7EBohSrS'),(17,'marysia','misi','marysia.mm','$2y$10$RvinD1/.7QljN04EZDbwjO2Ob9KKKmYP.D9UVZ6oEZPpV9eYefGXi'),(18,'Kiktor','Kogut','koko','$2y$10$A49wxtZmjJKhsa5e33Xjl.ZohhnEiZI5mpzrZ/hLfleVCVYhl4N0u'),(22,'Jeffrey','Epstein','epstein','$2y$10$8bgnMD1e5oSwUxFYEY17ouTLWLfvj9Dz/mJnmai6uIjLBU9EkC.v2');
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

-- Dump completed on 2026-03-12 23:30:22
