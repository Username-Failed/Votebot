-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 04. 05 2017 kl. 09:40:23
-- Serverversion: 10.1.21-MariaDB
-- PHP-version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `votesystem`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `voting_rounds`
--

CREATE TABLE `voting_rounds` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8_danish_ci NOT NULL,
  `average` float DEFAULT NULL,
  `in_progress` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci ROW_FORMAT=COMPACT;

--
-- Data dump for tabellen `voting_rounds`
--

INSERT INTO `voting_rounds` (`id`, `name`, `average`, `in_progress`) VALUES
(2, 'test', NULL, 1);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `voting_rounds`
--
ALTER TABLE `voting_rounds`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `voting_rounds`
--
ALTER TABLE `voting_rounds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
