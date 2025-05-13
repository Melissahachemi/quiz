-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: my_quiz
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'m','Musique'),(2,'f','Film'),(3,'s','Sport'),(4,'l','Livre');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `friendship_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`friend_id`),
  KEY `friend_id` (`friend_id`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_stats`
--

DROP TABLE IF EXISTS `game_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game_stats` (
  `user_id` int NOT NULL,
  `total_score` int NOT NULL DEFAULT '0',
  `games_played` int NOT NULL DEFAULT '0',
  `best_topic` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `best_topic_score` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `game_stats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_stats`
--

LOCK TABLES `game_stats` WRITE;
/*!40000 ALTER TABLE `game_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reponse1` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reponse2` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reponse3` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reponse4` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bonne_reponse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `categorie` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `audio_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */
INSERT INTO `questions` VALUES (1,'Qui chante \"Shape of You\" ?','Ed Sheeran','Justin Bieber','Shawn Mendes','Ariana Grande','Ed Sheeran','m',NULL),(2,'Quel artiste a chanté \"Alors on danse\" ?','Stromae','Indila','Vitaa','Maître Gims','Stromae','m',NULL),(3,'Quel est ce morceau ?','Blinding Lights','Starboy','Save Your Tears','In Your Eyes','Blinding Lights','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(4,'Quel est le titre de la chanson chantée par Rihanna, qui commence par \"We found love in a hopeless place\" ?','Diamonds','Work','We Found Love','Umbrella','We Found Love','m',NULL),(5,'Qui a chanté \"Je te promets\" ?','Johnny Hallyday','Michel Sardou','Jean-Jacques Goldman','Vitaa','Johnny Hallyday','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(6,'Quel groupe a interprété \"Bohemian Rhapsody\" ?','The Beatles','Queen','The Rolling Stones','AC/DC','Queen','m',NULL),(7,'Quel est l’artiste ayant chanté \"Imagine\" ?','Elton John','John Lennon','Paul McCartney','Ringo Starr','John Lennon','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(8,'Quel est le titre de la chanson qui commence par \"I want to hold your hand\" ?','Let it be','Hey Jude','I want to hold your hand','Yesterday','I want to hold your hand','m',NULL),(9,'Quel est le nom du groupe ayant chanté \"Smells Like Teen Spirit\" ?','Nirvana','Metallica','Red Hot Chili Peppers','Pearl Jam','Nirvana','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(10,'Qui a chanté \"Like a Prayer\" ?','Madonna','Lady Gaga','Britney Spears','Kylie Minogue','Madonna','m',NULL),(11,'Quel est le titre de la chanson de Michael Jackson sortie en 1982 ?','Billie Jean','Thriller','Beat it','Bad','Billie Jean','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(12,'Quel est le nom du groupe qui a interprété \"Take on Me\" ?','A-ha','Duran Duran','The Cure','Depeche Mode','A-ha','m',NULL),(13,'Quel est le titre de la chanson interprétée par The Weeknd et qui a été un énorme succès en 2020 ?','Blinding Lights','Starboy','Can’t Feel My Face','Heartless','Blinding Lights','m',NULL),(14,'Quel est le nom de la chanson de Lady Gaga qui a marqué sa première grande victoire en 2009 ?','Poker Face','Bad Romance','Alejandro','Just Dance','Poker Face','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(15,'Qui a chanté \"Rolling in the Deep\" ?','Adele','Rihanna','Shakira','Beyoncé','Adele','m',NULL),(16,'Quel est le nom du groupe qui a interprété \"Sweet Child O’ Mine\" ?','AC/DC','Guns N’ Roses','Led Zeppelin','Metallica','Guns N’ Roses','m',NULL),(17,'Quelle chanson a été chantée par Elton John dans le film \"Le Roi Lion\" ?','Can You Feel the Love Tonight','Rocket Man','Your Song','Goodbye Yellow Brick Road','Can You Feel the Love Tonight','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(18,'Quel est le nom de la chanson de Nirvana qui a été un énorme succès en 1991 ?','Smells Like Teen Spirit','Come As You Are','Lithium','Heart-Shaped Box','Smells Like Teen Spirit','m',NULL),(19,'Quel artiste a chanté \"Viva La Vida\" ?','Coldplay','U2','Radiohead','Muse','Coldplay','m',NULL),(20,'Qui a chanté \"I Will Always Love You\" ?','Whitney Houston','Mariah Carey','Celine Dion','Adele','Whitney Houston','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(21,'Quel est le titre de la chanson de David Bowie qui est devenue un hymne à l’espace ?','Space Oddity','Heroes','Ziggy Stardust','Rebel Rebel','Space Oddity','m',NULL),(22,'Quel est le nom du groupe ayant interprété \"Under Pressure\" ?','The Police','Queen and David Bowie','The Rolling Stones','Led Zeppelin','Queen and David Bowie','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(23,'Quel est le titre de la chanson de Mariah Carey qui est devenue un classique de Noël ?','All I Want for Christmas Is You','We Belong Together','Hero','Fantasy','All I Want for Christmas Is You','m',NULL),(24,'Quel est le titre du premier album de Michael Jackson ?','Off the Wall','Thriller','Bad','Dangerous','Off the Wall','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(25,'Quel est le titre de la chanson interprétée par Justin Timberlake \"Can’t Stop the Feeling\" ?','Can’t Stop the Feeling','SexyBack','Mirrors','Cry Me a River','Can’t Stop the Feeling','m',NULL),(26,'Quel est le titre de la chanson \"Je danse le Mia\" ?','IAM','Nekfeu','Orelsan','Lunatic','IAM','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(27,'Qui est l’artiste de \"La Vie en Rose\" ?','Jacques Brel','Édith Piaf','Charles Aznavour','Barbara','Édith Piaf','m',NULL),(28,'Quel est le nom du groupe ayant chanté \"Smoke on the Water\" ?','Deep Purple','Black Sabbath','Led Zeppelin','AC/DC','Deep Purple','m',NULL),(29,'Qui chante \"Ain’t No Mountain High Enough\" ?','Aretha Franklin','Diana Ross','Whitney Houston','Celine Dion','Diana Ross','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(30,'Quel est le titre de la chanson de Céline Dion qui a été chantée dans le film \"Titanic\" ?','My Heart Will Go On','The Power of Love','It’s All Coming Back to Me Now','Because You Loved Me','My Heart Will Go On','m',NULL),(31,'Quel artiste est connu pour son album \"25\" ?','Adele','Ed Sheeran','Sam Smith','Taylor Swift','Adele','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(32,'Quel groupe a chanté \"Hey Jude\" ?','The Rolling Stones','The Beatles','The Who','Led Zeppelin','The Beatles','m',NULL),(33,'Quel est le nom de la chanson de Madonna qui a fait sa renommée dans les années 80 ?','Like a Virgin','Holiday','La Isla Bonita','Like a Prayer','Like a Virgin','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(34,'Quel est le titre de la chanson interprétée par David Bowie et Mick Jagger, sortie en 1985 ?','Dancing in the Street','Let’s Dance','Space Oddity','Starman','Dancing in the Street','m',NULL),(35,'Quel groupe a chanté \"Under the Bridge\" ?','Red Hot Chili Peppers','Nirvana','Foo Fighters','Linkin Park','Red Hot Chili Peppers','m',NULL),(36,'Quel est le titre du morceau iconique de Bob Marley ?','One Love','No Woman No Cry','Buffalo Soldier','Redemption Song','No Woman No Cry','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(37,'Quel artiste a chanté \"Rolling in the Deep\" ?','Adele','Rihanna','Shakira','Beyoncé','Adele','m',NULL),(38,'Quel est le titre de la chanson interprétée par Beyoncé et Jay-Z ?','Crazy in Love','Irreplaceable','Run the World','Single Ladies','Crazy in Love','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(39,'Quel est le titre de la chanson chantée par Edith Piaf, qui parle d’amour perdu ?','Non, je ne regrette rien','La Vie en Rose','Milord','Hymne à l’amour','Non, je ne regrette rien','m',NULL),(40,'Quel est le nom du groupe qui a chanté \"Wake Me Up\" ?','Ava Max','Ed Sheeran','Avicii','Martin Garrix','Avicii','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(41,'Quel est le titre de la chanson de Bruno Mars qui commence par \"Oh, her eyes, her eyes\" ?','Just the Way You Are','Uptown Funk','Grenade','Locked Out of Heaven','Just the Way You Are','m',NULL),(42,'Qui a chanté \"Happy\" ?','Pharrell Williams','Justin Timberlake','Usher','Chris Brown','Pharrell Williams','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(43,'Quel est le titre de la chanson \"Unchained Melody\" chantée par The Righteous Brothers ?','Unchained Melody','You’ve Lost That Lovin’ Feelin’','Stand By Me','Only You','Unchained Melody','m',NULL),(44,'Quel est le titre de la chanson \"Poker Face\" chantée par Lady Gaga ?','Poker Face','Bad Romance','Alejandro','Just Dance','Poker Face','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(45,'Quel groupe a chanté \"Smells Like Teen Spirit\" ?','Nirvana','Pearl Jam','Metallica','Soundgarden','Nirvana','m',NULL),(46,'Quel est le titre de la chanson d’Elvis Presley qui commence par \"Wise men say\" ?','Jailhouse Rock','Hound Dog','Love Me Tender','Can’t Help Falling in Love','Can’t Help Falling in Love','m',NULL),(47,'Qui chante \"Bohemian Rhapsody\" ?','The Rolling Stones','Led Zeppelin','Queen','The Beatles','Queen','m',NULL),(48,'Qui a chanté \"Single Ladies (Put a Ring on It)\" ?','Beyoncé','Rihanna','Alicia Keys','Shakira','Beyoncé','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(49,'Quel groupe a chanté \"Sweet Child O’ Mine\" ?','Led Zeppelin','AC/DC','Queen','Guns N’ Roses','Guns N’ Roses','m',NULL),(50,'Quel est le titre de la chanson de Whitney Houston qui a été chantée dans le film \"The Bodyguard\" ?','I Will Always Love You','I Have Nothing','Greatest Love of All','Run to You','I Will Always Love You','m',NULL),(51,'Quel est le titre du morceau \"Uptown Funk\" chanté par Mark Ronson et Bruno Mars ?','Uptown Funk','24K Magic','Locked Out of Heaven','Just the Way You Are','Uptown Funk','m',NULL),(52,'Quel est le titre de la chanson de Shakira qui a été un succès international ?','Hips Don’t Lie','Waka Waka','La Tortura','Whenever, Wherever','Hips Don’t Lie','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(53,'Quel est le nom de la chanson d’Adele qui a remporté plusieurs Grammy Awards en 2012 ?','Someone Like You','Rolling in the Deep','Set Fire to the Rain','Chasing Pavements','Rolling in the Deep','m',NULL),(54,'Quel est le nom du groupe ayant chanté \"Take Me to Church\" ?','Hozier','Sam Smith','Ed Sheeran','Adele','Hozier','m','https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'),(55,'Dans \'Gilmore Girls\', comment s\'appelle la ville où vivent Lorelai et Rory ?','Star Hollow','Stars Hollow','Small Hollow','Hollow Stars','Stars Hollow','f',NULL),(56,'Quel est le métier de Lorelai Gilmore ?','Journaliste','Chef cuisinier','Gérante d\'hôtel','Professeure','Gérante d\'hôtel','f',NULL),(57,'Avec quel personnage Rory a-t-elle sa première relation amoureuse ?','Dean','Jess','Logan','Tristan','Dean','f',NULL),(58,'Comment s\'appelle le café préféré de Lorelai dans \'Gilmore Girls\' ?','Coffee Corner','Luke\'s Diner','Stars Café','Hollow Coffee','Luke\'s Diner','f',NULL),(59,'Quel est le rêve de Rory Gilmore ?','Être médecin','Être journaliste','Être avocate','Être actrice','Être journaliste','f',NULL),(60,'Dans \'Brooklyn Nine-Nine\', quel est le surnom d\'Amy Santiago donné par Jake ?','Ames','Captain','Santi','Queen','Ames','f',NULL),(61,'Quel est le passe-temps favori de Terry dans \'Brooklyn Nine-Nine\' ?','Musculation','Cuisine','Course à pied','Écriture','Musculation','f',NULL),(62,'Quel est l’animal fétiche du capitaine Holt ?','Chien','Perroquet','Chat','Cheval','Chat','f',NULL),(63,'Qui est Gina Linetti ?','Détective','Secrétaire','Procureur','Avocate','Secrétaire','f',NULL),(64,'Dans quel service travaille Rosa Diaz ?','Cybercriminalité','Homicide','Stupéfiants','Criminalité financière','Homicide','f',NULL),(65,'Dans \'Interstellar\', quelle est la planète d\'origine du personnage de Cooper ?','Mars','Terre','Titan','Saturne','Terre','f',NULL),(66,'Quel est le nom du robot compagnon de Cooper ?','TARS','R2D2','HAL','SIRI','TARS','f',NULL),(67,'Qui a réalisé \'Interstellar\' ?','Steven Spielberg','James Cameron','Christopher Nolan','Denis Villeneuve','Christopher Nolan','f',NULL),(68,'Dans \'Stranger Things\', comment s\'appelle la dimension parallèle ?','The Dark Side','The Underworld','The Upside Down','The Beyond','The Upside Down','f',NULL),(69,'Comment s\'appelle la jeune fille aux pouvoirs télékinésiques ?','Nancy','Eleven','Max','Robin','Eleven','f',NULL),(70,'Quelle est la passion de Dustin dans \'Stranger Things\' ?','Mathématiques','Chimie','D&D (Donjons & Dragons)','Athlétisme','D&D (Donjons & Dragons)','f',NULL),(71,'Quel est le prénom du frère de Monica dans \'Friends\' ?','Ross','Chandler','Joey','Gunther','Ross','f',NULL),(72,'Quel est le métier de Ross ?','Acteur','Paleontologue','Cuisinier','Banquier','Paleontologue','f',NULL),(73,'Quel est le nom du café préféré des personnages ?','Central Park','Coffee Place','Central Perk','Park Café','Central Perk','f',NULL),(74,'Qui est célèbre pour la réplique \'We were on a break!\' ?','Joey','Ross','Chandler','Rachel','Ross','f',NULL),(75,'Dans \'The Office\', qui est le Regional Manager ?','Dwight Schrute','Michael Scott','Jim Halpert','Andy Bernard','Michael Scott','f',NULL),(76,'Quel est le surnom de la société dans \'The Office\' ?','Dunder Muffin','Dunder Mifflin','Dunder Muffon','Dunder Mufflon','Dunder Mifflin','f',NULL),(77,'Qui est le meilleur vendeur de l\'équipe ?','Jim','Pam','Dwight','Stanley','Dwight','f',NULL),(78,'Dans \'Harry Potter\', quel est le prénom du professeur Dumbledore ?','Albus','Severus','Sirius','Gellert','Albus','f',NULL),(79,'Quel est l\'objet permettant de revenir dans le temps dans Harry Potter ?','Portoloin','Retourneur de Temps','Baguette du Temps','Pendule magique','Retourneur de Temps','f',NULL),(80,'Qui est l\'elfe de maison des Malefoy ?','Dobby','Kreacher','Winky','Hokey','Dobby','f',NULL),(81,'Qui forge les Anneaux du Pouvoir dans \'Le Seigneur des Anneaux\' ?','Elfes','Sauron','Nains','Hommes','Sauron','f',NULL),(82,'Quel est le nom complet de Frodon ?','Frodon Baggins','Frodon Took','Frodon Gamgee','Frodon Brandybuck','Frodon Baggins','f',NULL),(83,'Qui est le porteur du second anneau (après Isildur) ?','Aragorn','Gollum','Bilbon','Frodon','Aragorn','f',NULL),(84,'Dans Star Wars, qui est le père de Luke ?','Obi-Wan Kenobi','Anakin Skywalker','Yoda','Mace Windu','Anakin Skywalker','f',NULL),(85,'Comment s\'appelle la planète d\'origine de Chewbacca ?','Endor','Kashyyyk','Tatooine','Naboo','Kashyyyk','f',NULL),(86,'Quel est le pouvoir principal de la Force ?','Téléportation','Télékinésie','Vol','Invisibilité','Télékinésie','f',NULL),(87,'Qui est la Mère des Dragons dans \'Game of Thrones\' ?','Sansa Stark','Cersei Lannister','Daenerys Targaryen','Arya Stark','Daenerys Targaryen','f',NULL),(88,'Quel est le nom de l’épée de Jon Snow ?','Winterfell','Longclaw','Icebreaker','Dragonfang','Longclaw','f',NULL),(89,'Qui tue le Roi de la Nuit ?','Arya Stark','Jon Snow','Daenerys','Bran Stark','Arya Stark','f',NULL),(90,'Dans \'The Big Bang Theory\', que fait Sheldon pour se calmer ?','Il chante','Il compte','Il frappe trois fois','Il danse','Il frappe trois fois','f',NULL),(91,'Quel est le métier de Penny ?','Infirmière','Serveuse','Chanteuse','Ingénieure','Serveuse','f',NULL),(92,'Dans \'Breaking Bad\', quel est le métier de Walter White ?','Médecin','Avocat','Professeur de chimie','Pharmacien','Professeur de chimie','f',NULL),(93,'Quel est le surnom de Walter dans le milieu ?','Heisenberg','Fring','Gus','Jesse','Heisenberg','f',NULL),(94,'Dans \'How I Met Your Mother\', comment s\'appelle le bar favori ?','Paddy\'s Pub','MacLaren\'s Pub','Moe\'s Tavern','Central Perk','MacLaren\'s Pub','f',NULL),(95,'Quel est le métier de Barney Stinson ?','Avocat','Banquier','On ne sait pas vraiment','Médecin','On ne sait pas vraiment','f',NULL),(96,'Dans \'Peaky Blinders\', qui est le chef de la famille Shelby ?','Arthur','Tommy','John','Michael','Tommy','f',NULL),(97,'Quel est le business légal de Tommy ?','Bars','Mines de charbon','Paris sportifs','Textiles','Bars','f',NULL),(98,'Dans \'Doctor Who\', que signifie \'TARDIS\' ?','Time and Relative Dimension in Space','Total And Real Dream In Space','Travel Around Real Dimensions In Space','Time And Rotation Dimension In Space','Time and Relative Dimension in Space','f',NULL),(99,'Combien de cœurs possède le Docteur ?','1','2','3','4','2','f',NULL),(100,'Dans \'Inception\', qu\'est-ce qu\'un totem ?','Objet pour contrôler un rêve','Objet pour réveiller quelqu\'un','Objet pour savoir si on rêve','Objet pour voyager dans le temps','Objet pour savoir si on rêve','f',NULL),(101,'Qui joue le rôle principal dans \'Inception\' ?','Brad Pitt','Leonardo DiCaprio','Matt Damon','Christian Bale','Leonardo DiCaprio','f',NULL),(102,'Dans \'The Mandalorian\', quel est le surnom du petit personnage vert ?','Baby Yoda','Little Jedi','The Child','Tiny Master','Baby Yoda','f',NULL),(103,'Quel est le vrai nom du Mandalorian ?','Din Djarin','Boba Fett','Han Solo','Luke Skywalker','Din Djarin','f',NULL),(104,'Dans \'Riverdale\', qui est le chef de gang \'Southside Serpents\' ?','Archie','Jughead','Veronica','Betty','Jughead','f',NULL),(105,'Qui détient le record du monde du 100 mètres ?','Usain Bolt','Carl Lewis','Michael Johnson','Tyson Gay','Usain Bolt','s',NULL),(106,'Quel pays a remporté la Coupe du Monde de Football 2018 ?','Brésil','Allemagne','France','Argentine','France','s',NULL),(107,'Combien de joueurs y a-t-il dans une équipe de football ?','10','11','12','9','11','s',NULL),(108,'Quel joueur de tennis a remporté le plus de titres du Grand Chelem ?','Roger Federer','Rafael Nadal','Novak Djokovic','Pete Sampras','Roger Federer','s',NULL),(109,'Dans quelle ville se déroule le tournoi de tennis de Wimbledon ?','Paris','New York','Londres','Melbourne','Londres','s',NULL),(110,'Combien de points faut-il pour gagner un set au tennis ?','4','5','6','7','6','s',NULL),(111,'Qui a remporté la médaille d\'or en basketball aux JO de 2008 ?','France','Espagne','USA','Argentine','USA','s',NULL),(112,'Quel sport est pratiqué dans les Jeux Olympiques d\'hiver et utilise des pistes de neige ?','Ski','Football','Basketball','Natation','Ski','s',NULL),(113,'Quel joueur est surnommé \'King James\' en NBA ?','Michael Jordan','LeBron James','Kobe Bryant','Stephen Curry','LeBron James','s',NULL),(114,'Quel est le plus grand stade de football au monde ?','Camp Nou','Maracanã','Old Trafford','Rungrado 1er mai','Rungrado 1er mai','s',NULL),(115,'Quel est le sport d\'équipe joué avec un ballon ovale ?','Football','Rugby','Basketball','Handball','Rugby','s',NULL),(116,'Quel est le record du monde du marathon pour un homme ?','2h00min','2h02min','2h05min','2h07min','2h00min','s',NULL),(117,'Quel pays a remporté la Coupe du Monde de Rugby 2019 ?','Nouvelle-Zélande','Afrique du Sud','Angleterre','Pays de Galles','Afrique du Sud','s',NULL),(118,'Quel boxeur est surnommé \'The Greatest\' ?','Mike Tyson','Muhammad Ali','Sugar Ray Leonard','Floyd Mayweather','Muhammad Ali','s',NULL),(119,'Dans quel sport utilise-t-on une planche et une voile ?','Surf','Vélo','Windsurf','Kitesurf','Windsurf','s',NULL),(120,'Quel est le surnom de l’équipe nationale de football du Brésil ?','La Roja','Les Bleus','Les Azzurri','La Seleção','La Seleção','s',NULL),(121,'Quel sport est pratiqué dans le Tour de France ?','Football','Basketball','Cyclisme','Athlétisme','Cyclisme','s',NULL),(122,'Quel joueur de football a remporté le plus de Ballons d\'Or ?','Lionel Messi','Cristiano Ronaldo','Michel Platini','Zinedine Zidane','Lionel Messi','s',NULL),(123,'Combien de joueurs y a-t-il sur le terrain dans une équipe de rugby ?','13','14','15','16','15','s',NULL),(124,'Quel est le pays d\'origine du judo ?','Chine','Corée','Japon','Thaïlande','Japon','s',NULL),(125,'Quel pays a organisé les Jeux Olympiques d\'été en 2016 ?','France','Brésil','États-Unis','Royaume-Uni','Brésil','s',NULL),(126,'Quel joueur de football a marqué le plus de buts en Coupe du Monde ?','Ronaldo','Miroslav Klose','Lionel Messi','Pele','Miroslav Klose','s',NULL),(127,'Quel est le sport national du Canada ?','Hockey sur glace','Football','Basketball','Lacrosse','Hockey sur glace','s',NULL),(128,'Quel est le record du monde du saut en hauteur ?','2m50','2m40','2m45','2m35','2m45','s',NULL),(129,'Dans quel sport utilise-t-on un cheval et un mallet ?','Football','Basketball','Polo','Handball','Polo','s',NULL),(130,'Quel est le pays d\'origine du football américain ?','Canada','Angleterre','États-Unis','Brésil','États-Unis','s',NULL),(131,'Qui est le plus titré en Formule 1 ?','Alain Prost','Ayrton Senna','Michael Schumacher','Lewis Hamilton','Michael Schumacher','s',NULL),(132,'Quel est le nom du tournoi de tennis joué en Australie ?','French Open','Australian Open','US Open','Wimbledon','Australian Open','s',NULL),(133,'Quel sport est pratiqué au Winter X Games ?','Ski','Surf','Snowboard','Patinage artistique','Snowboard','s',NULL),(134,'Qui a remporté la Coupe du Monde de Football 2014 ?','Brésil','Allemagne','Argentine','France','Allemagne','s',NULL),(135,'Quel joueur est surnommé \'La Pioche\' en football ?','Paul Pogba','Kante','Blaise Matuidi','N\'Golo Kante','Paul Pogba','s',NULL),(136,'Quel sport se joue avec un volant et une raquette ?','Tennis','Badminton','Squash','Ping-pong','Badminton','s',NULL),(137,'Combien de joueurs dans une équipe de basketball ?','5','6','7','8','5','s',NULL),(138,'Quel est le pays qui a remporté le plus de fois la Coupe d\'Afrique des Nations ?','Cameroun','Algérie','Egypte','Nigeria','Egypte','s',NULL),(139,'Quel est le nom du championnat de football professionnel en Angleterre ?','Serie A','Ligue 1','Bundesliga','Premier League','Premier League','s',NULL),(140,'Dans quelle ville se trouve le stade Maracanã ?','Sao Paulo','Rio de Janeiro','Brasilia','Belo Horizonte','Rio de Janeiro','s',NULL),(141,'Quel est le surnom de l’équipe nationale de football d\'Allemagne ?','Les Diables Rouges','Les Bleus','Die Mannschaft','Les Azzurri','Die Mannschaft','s',NULL),(142,'Qui est le plus grand buteur de l’histoire de la Ligue 1 ?','Thierry Henry','Zlatan Ibrahimović','Jean-Pierre Papin','David Trezeguet','Zlatan Ibrahimović','s',NULL),(143,'Quel joueur de rugby a remporté le plus de Tournois des Six Nations ?','Sergio Parisse','Jonny Wilkinson','Brian O\'Driscoll','Ronan O\'Gara','Ronan O\'Gara','s',NULL),(144,'Quel est le nom du tournoi de golf le plus prestigieux ?','Open de France','The Masters','US Open','British Open','The Masters','s',NULL),(145,'Quel est le nom de l’équipe de football de la capitale espagnole ?','FC Barcelone','Real Madrid','Atlético Madrid','Valence CF','Real Madrid','s',NULL),(146,'Quel est le sport le plus populaire au monde ?','Basketball','Football','Tennis','Cricket','Football','s',NULL),(147,'Quel sport est pratiqué dans la NFL ?','Rugby','Football américain','Football','Basketball','Football américain','s',NULL),(148,'Quel sport se pratique sur un terrain vert avec un club et une balle ?','Baseball','Football','Golf','Tennis','Golf','s',NULL),(149,'Dans quel pays a eu lieu la Coupe du Monde de Rugby 2015 ?','France','Angleterre','Afrique du Sud','Nouvelle-Zélande','Angleterre','s',NULL),(150,'Quel joueur a remporté le plus de titres en NBA ?','Michael Jordan','Kobe Bryant','LeBron James','Bill Russell','Bill Russell','s',NULL),(151,'Qui est l’entraîneur le plus titré en Premier League ?','Jose Mourinho','Sir Alex Ferguson','Arsène Wenger','Pep Guardiola','Sir Alex Ferguson','s',NULL),(152,'Quel est le sport pratiqué dans le Tournoi des Six Nations ?','Football','Rugby','Cyclisme','Baseball','Rugby','s',NULL),(153,'Quel est le nom de l’équipe de football d’Italie ?','Naples','AS Roma','Juventus','AC Milan','Juventus','s',NULL),(154,'Quel est le plus grand tournoi de tennis sur terre battue ?','US Open','Australian Open','Roland Garros','Wimbledon','Roland Garros','s',NULL),(155,'Quel joueur de football a remporté le plus de Champions League ?','Cristiano Ronaldo','Lionel Messi','Paolo Maldini','Raul','Cristiano Ronaldo','s',NULL),(156,'Dans quel pays se déroule la Coupe du Monde de Football 2022 ?','Qatar','Russie','Brésil','France','Qatar','s',NULL),(157,'Qui est l\'auteur de \'Le Petit Prince\' ?','Victor Hugo','Antoine de Saint-Exupéry','Albert Camus','Jean de La Fontaine','Antoine de Saint-Exupéry','l',NULL),(158,'Quel est le prénom du détective Holmes ?','William','James','Sherlock','Arthur','Sherlock','l',NULL),(159,'Dans \'Harry Potter\', quelle maison a un blaireau comme symbole ?','Gryffondor','Serdaigle','Poufsouffle','Serpentard','Poufsouffle','l',NULL),(160,'Qui a écrit \'1984\' ?','Aldous Huxley','George Orwell','Ray Bradbury','Isaac Asimov','George Orwell','l',NULL),(161,'Dans \'Le Seigneur des Anneaux\', qui détruit l\'Anneau Unique ?','Gandalf','Aragorn','Frodo','Sam','Frodo','l',NULL),(162,'Quel livre commence par \'Toutes les familles heureuses se ressemblent\' ?','Anna Karénine','Les Misérables','Jane Eyre','Crime et Châtiment','Anna Karénine','l',NULL),(163,'Dans \'Hunger Games\', quel est le nom de l\'héroïne ?','Prim','Katniss','Gale','Effie','Katniss','l',NULL),(164,'Quel auteur a écrit \'L\'Alchimiste\' ?','Gabriel Garcia Marquez','Paulo Coelho','Jorge Luis Borges','Mario Vargas Llosa','Paulo Coelho','l',NULL),(165,'Dans \'Le Monde de Narnia\', qui trouve l\'armoire magique ?','Lucy','Peter','Susan','Edmund','Lucy','l',NULL),(166,'Quel est le nom du sorcier ennemi de Harry Potter ?','Dumbledore','Voldemort','Sirius Black','Hagrid','Voldemort','l',NULL),(167,'Qui a écrit \'Les Misérables\' ?','Émile Zola','Gustave Flaubert','Victor Hugo','Honoré de Balzac','Victor Hugo','l',NULL),(168,'Dans \'Percy Jackson\', Percy est fils de quel dieu ?','Zeus','Hadès','Hermès','Poséidon','Poséidon','l',NULL),(169,'Quel roman commence par \'Appelez-moi Ismaël\' ?','Moby Dick','Le Vieil Homme et la Mer','Germinal','Voyage au centre de la Terre','Moby Dick','l',NULL),(170,'Dans \'Orgueil et Préjugés\', qui est l\'héroïne ?','Elizabeth Bennet','Jane Eyre','Emma Woodhouse','Catherine Earnshaw','Elizabeth Bennet','l',NULL),(171,'Quelle est la créature mythique dans \'Eragon\' ?','Dragon','Griffon','Phénix','Hydre','Dragon','l',NULL),(172,'Quel livre est une dystopie écrite par Suzanne Collins ?','Divergente','Hunger Games','Le Labyrinthe','Matched','Hunger Games','l',NULL),(173,'Qui est l\'auteur de \'Jane Eyre\' ?','Charlotte Brontë','Emily Brontë','Jane Austen','Louisa May Alcott','Charlotte Brontë','l',NULL),(174,'Dans \'Twilight\', comment s\'appelle la ville où habite Bella ?','Seattle','Forks','Port Angeles','Phoenix','Forks','l',NULL),(175,'Quel est le métier de Robert Langdon dans les romans de Dan Brown ?','Journaliste','Professeur de symbologie','Archéologue','Politicien','Professeur de symbologie','l',NULL),(176,'Dans \'Game of Thrones\' (livre), quel est le nom du loup de Jon Snow ?','Ghost','Nymeria','Summer','Grey Wind','Ghost','l',NULL),(177,'Quel est le vrai nom de Mark Twain ?','Samuel Clemens','Lewis Carroll','Charles Dickens','Herman Melville','Samuel Clemens','l',NULL),(178,'Dans \'Charlie et la Chocolaterie\', qui est le propriétaire de l\'usine ?','Charlie','Mr. Salt','Willy Wonka','Mike Teavee','Willy Wonka','l',NULL),(179,'Qui a écrit \'Les Fleurs du Mal\' ?','Arthur Rimbaud','Paul Verlaine','Charles Baudelaire','Alfred de Musset','Charles Baudelaire','l',NULL),(180,'Dans \'Le Hobbit\', quel est le prénom du personnage principal ?','Frodo','Bilbo','Gollum','Thorin','Bilbo','l',NULL),(181,'Dans quel livre trouve-t-on le personnage Big Brother ?','1984','Le Meilleur des Mondes','Fahrenheit 451','La Ferme des Animaux','1984','l',NULL),(182,'Dans \'Harry Potter\', qui est le directeur de Poudlard au début ?','Voldemort','Dumbledore','McGonagall','Hagrid','Dumbledore','l',NULL),(183,'Quel livre raconte l’histoire d’un garçon nommé Santiago ?','L\'Alchimiste','Le Petit Prince','Le Vieil Homme et la Mer','L\'île au trésor','L\'Alchimiste','l',NULL),(184,'Qui a écrit \'Le Seigneur des Anneaux\' ?','J.R.R. Tolkien','George R.R. Martin','C.S. Lewis','Philip Pullman','J.R.R. Tolkien','l',NULL),(185,'Dans \'Les Misérables\', quel est le nom de l\'inspecteur qui poursuit Jean Valjean ?','Javert','Lecoq','Valjean','Fauchelevent','Javert','l',NULL),(186,'Dans \'L\'Étranger\' d\'Albert Camus, quel est le nom du personnage principal ?','Meursault','L\'Étranger','Pablo','Raskolnikov','Meursault','l',NULL),(187,'Qui a écrit \'Les Fleurs du Mal\' ?','Paul Verlaine','Arthur Rimbaud','Charles Baudelaire','Emile Zola','Charles Baudelaire','l',NULL),(188,'Dans \'Alice au Pays des Merveilles\', qui est le premier personnage que rencontre Alice ?','Le Chat de Cheshire','Le Lapin Blanc','Le Lièvre de Mars','La Reine de Coeur','Le Lapin Blanc','l',NULL),(189,'Qui est l\'auteur de \'1984\' ?','Aldous Huxley','George Orwell','Ray Bradbury','Isaac Asimov','George Orwell','l',NULL),(190,'Dans \'Le Grand Gatsby\', quel est le prénom de Daisy Buchanan ?','Elizabeth','Lily','Daisy','Marilyn','Daisy','l',NULL),(191,'Dans \'Les Misérables\', qui est la mère de Cosette ?','Fantine','Éponine','Marie','Aline','Fantine','l',NULL),(192,'Dans \'Moby Dick\', quel est le nom du capitaine ?','Ahab','Nemo','Hook','Jules','Ahab','l',NULL),(193,'Dans \'La Peste\', quel est le nom du médecin qui lutte contre l\'épidémie ?','Bernard Rieux','Raymond Rambert','Jean Tarrou','Joseph Grand','Bernard Rieux','l',NULL),(194,'Dans \'Frankenstein\', quel est le nom du scientifique qui crée le monstre ?','Victor Frankenstein','John Frankenstein','Henry Jekyll','Edward Hyde','Victor Frankenstein','l',NULL),(195,'Qui a écrit \'Les Misérables\' ?','Victor Hugo','Émile Zola','Honoré de Balzac','Stendhal','Victor Hugo','l',NULL),(196,'Dans \'La Recherche du Temps Perdu\', quel est le nom du narrateur ?','Marcel','Proust','Barthes','Sartre','Marcel','l',NULL),(197,'Quel est le nom du héros dans \'Robinson Crusoé\' ?','Robinson','Crusoé','Pirate','Sailor','Robinson','l',NULL),(198,'Dans \'Germinal\', quel est le nom du protagoniste principal ?','Étienne Lantier','Jean Valjean','Jean Valérie','Germinal','Étienne Lantier','l',NULL),(199,'Dans \'La Métamorphose\' de Kafka, quel est l\'animal dans lequel Gregor Samsa se transforme ?','Une mouche','Une fourmi','Un scarabée','Une abeille','Un scarabée','l',NULL),(200,'Qui a écrit \'Crime et Châtiment\' ?','Lev Tolstoï','Fiodor Dostoïevski','Anton Tchekhov','Maxime Gorki','Fiodor Dostoïevski','l',NULL),(201,'Dans \'Anna Karénine\', quel est le nom de l\'époux d\'Anna ?','Vronski','Karenine','Levin','Stepan','Karenine','l',NULL),(202,'Dans \'Le Comte de Monte-Cristo\', quel est le nom du héros ?','Edmond Dantès','Monte Cristo','Ali Baba','Zorro','Edmond Dantès','l',NULL),(203,'Quel est le nom du loup de Jon Snow dans \'Game of Thrones\' ?','Ghost','Nymeria','Summer','Grey Wind','Ghost','l',NULL),(204,'Qui a écrit \'Le Nom de la Rose\' ?','Dan Brown','Umberto Eco','John Grisham','Stephen King','Umberto Eco','l',NULL);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `score` int NOT NULL,
  `quiz_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Bio` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'meli','meli@gmail.com','$2y$10$pDwMU7umoE7XdDq1iS7aWeyy70glJj6NMeXSnjEaCFJk2jRvIV20K','2025-05-04 19:00:50',NULL),(2,'alice','alice@gmail.com','$2y$10$TZNAD6KyOESwVIN5p80DYuiY2R6lqAUMTwQAMhzjpjwEWVuM.1bqK','2025-05-04 20:54:36',NULL);
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

-- Dump completed on 2025-05-05 10:42:17

 CREATE TABLE `chat_messages` (   `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,   `sender_id` INT(11) UNSIGNED NOT NULL,
  `receiver_id` INT(11) UNSIGNED NOT NULL,   `message` TEXT NOT NULL,   `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP );

