-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for skivor_ab
DROP DATABASE IF EXISTS `skivor_ab`;
CREATE DATABASE IF NOT EXISTS `skivor_ab` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `skivor_ab`;

-- Dumping structure for table skivor_ab.albums
DROP TABLE IF EXISTS `albums`;
CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `rating` tinyint(5) NOT NULL DEFAULT 0,
  `release_date` date NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `import_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table skivor_ab.albums: ~1 rows (approximately)
DELETE FROM `albums`;
INSERT INTO `albums` (`id`, `artist_id`, `name`, `rating`, `release_date`, `img`, `import_date`) VALUES
	(2, 2, 'Nevermind', 7, '1991-09-24', 'https://upload.wikimedia.org/wikipedia/en/b/b7/NirvanaNevermindalbumcover.jpg', '2024-04-16 20:21:00');

-- Dumping structure for view skivor_ab.albums_display
DROP VIEW IF EXISTS `albums_display`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `albums_display` (
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`artist` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`rating` TINYINT(5) NOT NULL,
	`release_date` DATE NOT NULL,
	`id` INT(11) NOT NULL,
	`artist_id` INT(11) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for table skivor_ab.artists
DROP TABLE IF EXISTS `artists`;
CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `genre` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table skivor_ab.artists: ~2 rows (approximately)
DELETE FROM `artists`;
INSERT INTO `artists` (`id`, `name`, `genre`) VALUES
	(1, 'Iron Maiden', 'Rock'),
	(2, 'Nirvana', 'Grunge');

-- Dumping structure for view skivor_ab.artist_names
DROP VIEW IF EXISTS `artist_names`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `artist_names` (
	`id` INT(11) NOT NULL,
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table skivor_ab.songs
DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL DEFAULT 0,
  `artist_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `duration` time NOT NULL DEFAULT '00:00:00',
  `release_year` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table skivor_ab.songs: ~19 rows (approximately)
DELETE FROM `songs`;
INSERT INTO `songs` (`id`, `album_id`, `artist_id`, `name`, `duration`, `release_year`) VALUES
	(1, 1, 1, 'Prowler', '00:03:56', '1980'),
	(2, 1, 1, 'Remember Tomorrow', '00:05:30', '1980'),
	(3, 1, 1, 'Running Free', '00:03:22', '1980'),
	(4, 1, 1, 'Phantom of the Opera', '00:07:02', '1980'),
	(5, 1, 1, 'Transylvania (instrumental)', '00:04:09', '1980'),
	(6, 1, 1, 'Strange World', '00:05:43', '1980'),
	(7, 1, 1, 'Charlotte the Harlot', '00:04:14', '1980'),
	(8, 1, 1, 'Iron Maiden', '00:03:43', '1980'),
	(9, 2, 2, 'Smells Like Teen Spirit', '00:05:01', '1991'),
	(10, 2, 2, 'In Bloom (LP version)', '00:04:15', '1991'),
	(11, 2, 2, 'Come as You Are', '00:03:39', '1991'),
	(12, 2, 2, 'Breed', '00:03:04', '1991'),
	(13, 2, 2, 'Lithium', '00:04:17', '1991'),
	(14, 2, 2, 'Polly', '00:02:57', '1991'),
	(15, 2, 2, 'Territorial Pissings', '00:02:23', '1991'),
	(16, 2, 2, 'Drain You', '00:03:44', '1991'),
	(17, 2, 2, 'Lounge Act', '00:02:37', '1991'),
	(18, 2, 2, 'Stay Away', '00:03:32', '1991'),
	(19, 2, 2, 'On a Plain', '00:03:16', '1991');

-- Dumping structure for view skivor_ab.start
DROP VIEW IF EXISTS `start`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `start` (
	`id` INT(11) NOT NULL,
	`img` VARCHAR(100) NULL COLLATE 'utf8mb4_general_ci',
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`artist` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`YEAR` INT(4) NULL,
	`MONTH` INT(2) NULL,
	`DAY` INT(2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view skivor_ab.start_songs
DROP VIEW IF EXISTS `start_songs`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `start_songs` (
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`duration` TIME NOT NULL
) ENGINE=MyISAM;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `albums_display`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `albums_display` AS SELECT 
		albums.name, artists.name AS artist, albums.rating, albums.release_date, albums.id AS id, artists.id AS artist_id
	FROM 
		albums
	INNER JOIN 
		artists
	ON 
		albums.artist_id = artists.id ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `artist_names`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `artist_names` AS SELECT id, name FROM artists ORDER BY NAME ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `start`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `start` AS SELECT
		albums.id,
		albums.img,
		albums.name,
		artists.name AS artist,
		YEAR(albums.release_date) AS YEAR,
		MONTH(albums.release_date) AS MONTH,
		DAY(albums.release_date) AS DAY
	FROM
		artists
	INNER JOIN
		albums
	on
		artists.id = albums.artist_id
	WHERE
		albums.id in
			(SELECT * FROM (SELECT id
				FROM albums
			ORDER by
				import_date DESC
			LIMIT 
				1
			) AS id) ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `start_songs`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `start_songs` AS SELECT 
		songs.name, 
		songs.duration
	FROM
		songs
	INNER JOIN
		start
	on
		songs.album_id IN (SELECT id FROM start) ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
