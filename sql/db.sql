-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 10 Cze 2017, 19:56
-- Wersja serwera: 5.6.36
-- Wersja PHP: 7.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pol`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `characters`
--

CREATE TABLE `characters` (
  `char_id` int(12) UNSIGNED DEFAULT NULL,
  `char_name` varchar(150) DEFAULT NULL,
  `char_title` varchar(150) DEFAULT NULL,
  `char_race` varchar(150) DEFAULT NULL,
  `char_body` varchar(10) NOT NULL,
  `char_female` int(2) UNSIGNED DEFAULT NULL,
  `char_bodyhue` int(3) UNSIGNED DEFAULT NULL,
  `char_public` int(1) UNSIGNED DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `characters`
--

INSERT INTO `characters` (`char_id`, `char_name`, `char_title`, `char_race`, `char_body`, `char_female`, `char_bodyhue`, `char_public`) VALUES
(950, 'Rissica', '', 'Elf', '606', 1, 33673, 0),
(9051, 'Kiba', '', 'Human', '401', 1, 33770, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `characters_layers`
--

CREATE TABLE `characters_layers` (
  `char_id` int(12) UNSIGNED DEFAULT NULL,
  `layer_id` int(3) UNSIGNED DEFAULT NULL,
  `item_id` int(12) UNSIGNED DEFAULT NULL,
  `item_hue` int(3) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `characters_layers`
--

INSERT INTO `characters_layers` (`char_id`, `layer_id`, `item_id`, `item_hue`) VALUES
(950, 0, 12661, 495),
(950, 1, 12227, 227),
(950, 2, 12228, 0),
(950, 3, 12230, 0),
(950, 4, 12218, 1317),
(950, 5, 3834, 0),
(950, 6, 11118, 0),
(950, 99, 12224, 57),
(9051, 0, 5903, 1735),
(9051, 1, 8059, 176),
(9051, 2, 5398, 279),
(9051, 3, 5062, 0),
(9051, 4, 7939, 1302),
(9051, 5, 3834, 0),
(9051, 6, 5912, 0),
(9051, 99, 8253, 1102);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD UNIQUE KEY `char_id_2` (`char_id`),
  ADD KEY `char_id` (`char_id`);

--
-- Indexes for table `characters_layers`
--
ALTER TABLE `characters_layers`
  ADD KEY `charid` (`char_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
