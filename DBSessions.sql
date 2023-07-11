-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sessions
CREATE DATABASE IF NOT EXISTS `sessions` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sessions`;

-- Listage de la structure de table sessions. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.category : ~0 rows (environ)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Bureautique'),
	(2, 'Développement web'),
	(3, 'Webdesign'),
	(4, 'Vente');

-- Listage de la structure de table sessions. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table sessions.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230711084640', '2023-07-11 08:47:36', 515);

-- Listage de la structure de table sessions. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.formation : ~0 rows (environ)
INSERT INTO `formation` (`id`, `name`) VALUES
	(1, 'Dev web');

-- Listage de la structure de table sessions. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table sessions. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_category_id` int DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C2426289C6D9730` (`module_category_id`),
  CONSTRAINT `FK_C2426289C6D9730` FOREIGN KEY (`module_category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.module : ~0 rows (environ)
INSERT INTO `module` (`id`, `module_category_id`, `name`) VALUES
	(1, 2, 'HTML'),
	(2, 2, 'CSS'),
	(3, 2, 'SQL'),
	(4, 2, 'PHP'),
	(5, 1, 'Word'),
	(6, 1, 'Powerpoint'),
	(7, 3, 'Figma'),
	(8, 3, 'Lightroom'),
	(9, 4, 'Technique de vente'),
	(10, 4, 'E-commerce');

-- Listage de la structure de table sessions. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int DEFAULT NULL,
  `session_id` int DEFAULT NULL,
  `duration` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.programme : ~0 rows (environ)
INSERT INTO `programme` (`id`, `module_id`, `session_id`, `duration`) VALUES
	(1, 3, 1, 2),
	(2, 4, 1, 1),
	(3, 3, 1, 1);

-- Listage de la structure de table sessions. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_formation_id` int DEFAULT NULL,
  `session_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_place` int NOT NULL,
  `start_session` date NOT NULL,
  `end_session` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D49C9D95AF` (`session_formation_id`),
  CONSTRAINT `FK_D044D5D49C9D95AF` FOREIGN KEY (`session_formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.session : ~0 rows (environ)
INSERT INTO `session` (`id`, `session_formation_id`, `session_name`, `nb_place`, `start_session`, `end_session`) VALUES
	(1, 1, 'Dev web 2.0', 9, '2023-07-11', '2023-07-21');

-- Listage de la structure de table sessions. session_user
CREATE TABLE IF NOT EXISTS `session_user` (
  `session_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  KEY `IDX_4BE2D663613FECDF` (`session_id`),
  KEY `IDX_4BE2D663A76ED395` (`user_id`),
  CONSTRAINT `FK_4BE2D663613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4BE2D663A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.session_user : ~0 rows (environ)
INSERT INTO `session_user` (`session_id`, `user_id`) VALUES
	(1, 1),
	(1, 3),
	(1, 4);

-- Listage de la structure de table sessions. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessions.user : ~0 rows (environ)
INSERT INTO `user` (`id`, `first_name`, `last_name`, `sex`, `email`, `phone_number`, `city`, `birthday`) VALUES
	(1, 'Julien', 'Léger', 'Masculin', 'julien@exemple.com', '0666666666', 'Strasbourg', '1987-04-20'),
	(2, 'Clément', 'Jeaisy', 'Masculin', 'clement@exemple.com', '0655555555', 'Paris', '1994-04-14'),
	(3, 'Martin', 'Matin', 'Non Binaire', 'matin@exemple.com', '0644444444', 'Dax', '1966-11-06'),
	(4, 'Séverine', 'Toyti', 'Feminin', 'severine@exemple.com', '0645842549', 'Lille', '1999-03-26'),
	(5, 'Alexandre', 'Tiep', 'Masculin', 'alexandre@exemple.com', '0678487554', 'Brest', '1977-01-04'),
	(6, 'Manon', 'Faegre', 'Feminin', 'manon@alexandre.com', '0678187827', 'Marseille', '1982-05-18'),
	(7, 'Nicolas', 'Heori', 'Non Binaire', 'nicolas@bloublou.com', '0708828945', 'Lyon', '1939-02-05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
