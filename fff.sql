-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 nov 2019 om 14:26
-- Serverversie: 10.1.29-MariaDB
-- PHP-versie: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fff`
--
CREATE DATABASE IF NOT EXISTS `fff` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fff`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `address`
--

CREATE TABLE `address` (
  `addressID` int(11) NOT NULL,
  `address_klantID` int(11) NOT NULL,
  `straat` varchar(254) NOT NULL,
  `huisnummer` varchar(10) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `woonplaats` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `address`
--

INSERT INTO `address` (`addressID`, `address_klantID`, `straat`, `huisnummer`, `postcode`, `woonplaats`) VALUES
(1, 1, 'Oostermaatweg', '10', '7671RN', 'Vriezenveen'),
(2, 2, 'Achterweg', '2', '8999AB', 'Vriezenveen'),
(3, 3, 'wegstraat', '2', '2121PO', 'Almelo'),
(4, 4, 'Dieka', '2', '7674AB', 'Hoge Hexel'),
(5, 5, 'Wegboer', '21', '8989PO', 'Vriezenveen'),
(6, 6, 'teststraat', '2', '7671RN', 'Vriezenveen'),
(7, 7, 'Welhaak', '41', '7672AB', 'Vriezenveen'),
(8, 8, 'Karelstraat', '2', '7671RN', 'Vriezenveen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `categorieID` int(11) NOT NULL,
  `categorieType` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`categorieID`, `categorieType`) VALUES
(1, 'Te Koop'),
(2, 'Te Huur');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `klantID` int(11) NOT NULL,
  `naam` varchar(254) NOT NULL,
  `tussenvoegsel` varchar(254) DEFAULT NULL,
  `achternaam` varchar(254) NOT NULL,
  `email` text NOT NULL,
  `korting` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`klantID`, `naam`, `tussenvoegsel`, `achternaam`, `email`, `korting`) VALUES
(1, 'Olaf', '', 'Krommendijk', 'olafkrommendijk11@gmail.com', 20),
(2, 'Ceko', 'van', 'Straten', 'cekogico@mailinator.com', NULL),
(3, 'Lars', 'van', 'De straat', 'lars@mail.nl', NULL),
(4, 'Bart', 'de', 'Boer', 'bart@mail.nl', NULL),
(5, 'Sarah', '', 'Test', 'Sarah@mail.nl', NULL),
(6, 'Test', 'tester', 'DeTester', 'test@mail.nl', NULL),
(7, 'Luuk', '', 'Krommendijk', 'luukkrommendijk@mail.nl', NULL),
(8, 'Karel', 'Groode', 'Groot', 'karel@mail.nl', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerker`
--

CREATE TABLE `medewerker` (
  `medewerkerID` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `wachtwoord` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `medewerker`
--

INSERT INTO `medewerker` (`medewerkerID`, `email`, `wachtwoord`) VALUES
(1, 'medewerker1@gmail.com', '$2y$10$F3bY0iOnpF.GvAL.XlUZqu0t7R9CGTb9Gq.cz1SpL9eleXJusGw8u'),
(2, 'chauffeur1@gmail.com', '$2y$10$F3bY0iOnpF.GvAL.XlUZqu0t7R9CGTb9Gq.cz1SpL9eleXJusGw8u'),
(3, 'chauffeur2@gmail.com', '$2y$10$F3bY0iOnpF.GvAL.XlUZqu0t7R9CGTb9Gq.cz1SpL9eleXJusGw8u'),
(4, 'chauffeur3@gmail.com', '$2y$10$F3bY0iOnpF.GvAL.XlUZqu0t7R9CGTb9Gq.cz1SpL9eleXJusGw8u');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orderregel`
--

CREATE TABLE `orderregel` (
  `orderRegelID` int(11) NOT NULL,
  `orderRegel_artikelID` int(11) NOT NULL,
  `orderRegel_orderID` int(11) NOT NULL,
  `bestelDatum` datetime(6) NOT NULL,
  `retourDatum` datetime(6) NOT NULL,
  `aantal` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `orderregel`
--

INSERT INTO `orderregel` (`orderRegelID`, `orderRegel_artikelID`, `orderRegel_orderID`, `bestelDatum`, `retourDatum`, `aantal`) VALUES
(1, 3, 1, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 5),
(2, 6, 1, '2019-11-13 00:00:00.000000', '2019-11-19 00:00:00.000000', 2),
(3, 7, 2, '2019-11-13 00:00:00.000000', '2019-11-26 00:00:00.000000', 1),
(4, 4, 2, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 5),
(5, 8, 3, '2019-11-13 00:00:00.000000', '2019-11-19 00:00:00.000000', 2),
(6, 6, 4, '2019-11-13 00:00:00.000000', '2019-11-21 00:00:00.000000', 1),
(7, 8, 4, '2019-11-14 00:00:00.000000', '2019-11-25 00:00:00.000000', 2),
(8, 7, 5, '2019-11-13 00:00:00.000000', '2019-11-20 00:00:00.000000', 2),
(9, 6, 6, '2019-11-13 00:00:00.000000', '2019-11-19 00:00:00.000000', 2),
(10, 6, 7, '2019-11-14 00:00:00.000000', '2019-11-27 00:00:00.000000', 1),
(11, 7, 7, '2019-11-14 00:00:00.000000', '2019-11-26 00:00:00.000000', 2),
(12, 4, 8, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 2),
(13, 8, 8, '2019-11-13 00:00:00.000000', '2019-11-20 00:00:00.000000', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `ordersID` int(11) NOT NULL,
  `orders_klantID` int(11) NOT NULL,
  `orders_addressID` int(11) NOT NULL,
  `totaalprijs` int(11) NOT NULL,
  `betaald` tinyint(1) NOT NULL DEFAULT '0',
  `bezorgen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`ordersID`, `orders_klantID`, `orders_addressID`, `totaalprijs`, `betaald`, `bezorgen`) VALUES
(1, 1, 1, 1275, 0, 1),
(2, 2, 2, 1400, 0, 1),
(3, 3, 3, 650, 0, 1),
(4, 4, 4, 1750, 1, 0),
(5, 5, 5, 1300, 1, 0),
(6, 6, 6, 1250, 0, 1),
(7, 7, 7, 3600, 0, 1),
(8, 8, 8, 690, 0, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `artikel_categorieID` int(11) NOT NULL,
  `afbeelding` text NOT NULL,
  `naam` varchar(254) NOT NULL,
  `beschrijving` mediumtext NOT NULL,
  `prijs` int(11) DEFAULT NULL,
  `prijsDag` int(11) DEFAULT NULL,
  `prijsWeek` int(11) DEFAULT NULL,
  `onderhoud` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`productID`, `artikel_categorieID`, `afbeelding`, `naam`, `beschrijving`, `prijs`, `prijsDag`, `prijsWeek`, `onderhoud`) VALUES
(3, 1, './pictures/ballonnen.jpg', 'Ballonnen', 'Prachtige ballonnen geschikt voor ieder fuifje.', 500, NULL, NULL, 0),
(4, 1, './pictures/slagroompatronen.jpg', 'slagroompatronen', 'Prachtige slagroompatronen die u bijna over voor zal kunnen gebruiken', 2000, NULL, NULL, 0),
(5, 2, './pictures/slagroomspuit.jpg', 'Slagroomspuit', 'Een prachtige slagroomspuit die u kunt gebruiken voor al uw feestelijke gelegenheden', NULL, 2000, 11000, 0),
(6, 2, './pictures/abraham.jpg', 'Abraham 50 jaar', 'Is 1 van uw familieleden 50 geworden? Huur dan deze prachtige Abraham', NULL, 10000, 65000, 0),
(7, 2, './pictures/sarah.jpg', 'Sarah', 'Is iemand uit uw familie 50 jaar geworden? huur dan deze sarah voor een klein prijsje.', NULL, 10000, 65000, 0),
(8, 2, './pictures/heliumTank.jpg', 'Heliumtank', 'Deze heliumtank is gevuld met helium om al uw ballonnen op te blazen en er een prachtig feest van te maken.', NULL, 5000, 30000, 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressID`),
  ADD KEY `klantID` (`address_klantID`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorieID`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantID`);

--
-- Indexen voor tabel `medewerker`
--
ALTER TABLE `medewerker`
  ADD PRIMARY KEY (`medewerkerID`);

--
-- Indexen voor tabel `orderregel`
--
ALTER TABLE `orderregel`
  ADD PRIMARY KEY (`orderRegelID`),
  ADD KEY `artikelID` (`orderRegel_artikelID`),
  ADD KEY `orderID` (`orderRegel_orderID`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ordersID`),
  ADD KEY `orders_klantID` (`orders_klantID`),
  ADD KEY `orders_addressID` (`orders_addressID`) USING BTREE;

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `categorieID` (`artikel_categorieID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `address`
--
ALTER TABLE `address`
  MODIFY `addressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `medewerker`
--
ALTER TABLE `medewerker`
  MODIFY `medewerkerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `orderregel`
--
ALTER TABLE `orderregel`
  MODIFY `orderRegelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `ordersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `klantID` FOREIGN KEY (`address_klantID`) REFERENCES `klant` (`klantID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `categorieID` FOREIGN KEY (`artikel_categorieID`) REFERENCES `categorie` (`categorieID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
