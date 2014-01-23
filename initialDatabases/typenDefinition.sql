-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. Jan 2014 um 14:15
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
-- Tabellenstruktur für Tabelle `typenDefinition`
--

CREATE TABLE IF NOT EXISTS `typenDefinition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reihenfolge` int(3) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `typ` varchar(100) DEFAULT NULL,
  `spaltenbreite` varchar(100) NOT NULL DEFAULT '6,12',
  `beschreibung` varchar(100) DEFAULT NULL,
  `eingabeFormular` tinyint(1) DEFAULT NULL,
  `ergebnisListe` tinyint(1) DEFAULT '0',
  `suchwert` varchar(200) NOT NULL,
  `eingabewert` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `reihenfolge` (`reihenfolge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Daten für Tabelle `typenDefinition`
--

INSERT INTO `typenDefinition` (`id`, `reihenfolge`, `name`, `typ`, `spaltenbreite`, `beschreibung`, `eingabeFormular`, `ergebnisListe`, `suchwert`, `eingabewert`) VALUES
(1, 50, 'id', 'zahl', '', 'ID', 0, 0, '%', '4'),
(5, 99, 'editStatus', 'einstellung', '', 'Einstellungsparameter', NULL, 0, '0', ''),
(6, 99, 'startPage', 'einstellung', '', 'Startseite', NULL, 0, '0', ''),
(8, 99, 'maxEintraege', 'einstellung', '', 'Maximale Anzahl der Einträge pro Seite', NULL, 0, '10', ''),
(9, 99, 'sortierung', 'einstellung', '', 'Sortierung der Ergebnisliste', NULL, 0, 'Speicherdatum', ''),
(10, 99, 'sortierfolge', 'einstellung', '', 'Sortierung, aufsteigend ist 1, absteigend 0', NULL, 0, '0', ''),
(12, 99, 'fileupload', 'einstellung', '', 'Soll ein file upgeloaded werden?', NULL, 0, '0', '0'),
(13, 51, 'Speicherdatum', 'datum', '', 'Speicherdatum', 0, 0, '%', '05.12.2013'),
(14, 99, 'datumFormat', 'einstellung', '', 'Format des Datums [d -> Tag] [m -> Monat] [Y -> Jahr] [H -> Stunden] [i -> minuten] [s -> Sekunden]', 0, 0, 'd.m.Y', ''),
(21, 1, 'beschreibung', 'text', '10,10', 'Beschreibung', 1, 1, '%', 'Böhnse Onkelz'),
(22, 3, 'tag', 'auswahl', '9,12', 'Tag', 1, 1, '%', '2'),
(23, 0, 'url', 'url', '2,2', 'URL', 1, 1, '%', 'http://onkelz.de'),
(24, 4, 'favorit', 'auswahl', '3,12', 'Favorit', 1, 1, '%', '0'),
(25, 99, 'tabellenNameKurz', 'einstellung', '', 'Name der Tabelle der angezeigt werden soll', 0, 0, 'Bookmarks', ''),
(26, 99, 'tabellenNameLang', 'einstellung', '', 'langer Anzeigename der Tabelle', 0, 0, 'Bookmark-Verwaltung', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
