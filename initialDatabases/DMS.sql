-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. Jan 2014 um 14:17
-- Server Version: 5.5.31-0+wheezy1-log
-- PHP-Version: 5.4.4-14+deb7u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `bookmark2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `DMS`
--

CREATE TABLE IF NOT EXISTS `DMS` (
  `id` int(11) NOT NULL,
  `Speicherdatum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `url` text COLLATE utf8_bin NOT NULL,
  `beschreibung` varchar(200) COLLATE utf8_bin NOT NULL,
  `tag` varchar(150) COLLATE utf8_bin NOT NULL,
  `favorit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `Speicherdatum` (`Speicherdatum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `DMS`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
