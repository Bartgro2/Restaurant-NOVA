-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Gegenereerd op: 08 jan 2025 om 12:31
-- Serverversie: 10.4.32-MariaDB-1:10.4.32+maria~ubu2004
-- PHP-versie: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_nova`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `adressen`
--

CREATE TABLE `adressen` (
  `adres_id` int(11) NOT NULL,
  `woonplaats` varchar(100) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `huisnummer` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `adressen`
--

INSERT INTO `adressen` (`adres_id`, `woonplaats`, `postcode`, `huisnummer`) VALUES
(26, 'Denemarken', '1562 J', '3'),
(27, 'g', '1014 BK', '2'),
(28, 'Haar', '1014 BK', '3'),
(29, 'g', '1562 JK', '1'),
(30, 'Haarlem', '1562 JK', '2'),
(34, 'Zaandijk', '1562 Jg', '3'),
(35, 'g', '1014 BK', '2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorieen`
--

CREATE TABLE `categorieen` (
  `categorie_id` int(11) NOT NULL,
  `naam` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categorieen`
--

INSERT INTO `categorieen` (`categorie_id`, `naam`) VALUES
(1, 'food'),
(7, 'drinks'),
(9, 'aa');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `gebruiker_id` int(11) NOT NULL,
  `adres_id` int(11) DEFAULT NULL,
  `voornaam` varchar(50) NOT NULL DEFAULT '',
  `tussenvoegsel` varchar(50) DEFAULT NULL,
  `achternaam` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL,
  `gebruikersnaam` varchar(50) DEFAULT NULL,
  `wachtwoord` varchar(100) DEFAULT NULL,
  `rol` enum('admin','directeur','manager','medewerker','klant') DEFAULT 'klant'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruiker_id`, `adres_id`, `voornaam`, `tussenvoegsel`, `achternaam`, `email`, `gebruikersnaam`, `wachtwoord`, `rol`) VALUES
(24, 28, 'jip', '', 'style', 'jib@admin.com', 'jib', '$2y$10$YXE9rMoxJ9/i0BGUa8yP6uhvBVvxnTDk9yKsjI7BvmOZ/o1r3Psnm', 'admin'),
(26, 30, 'bart', '', 'groothuysen', 'bart@a.com', 'bart', '$2y$10$kNMugt/E1LIBq0SFAHVgOOGGH1tNevq0GDXPxJWvZ0q2Xw0MT2THK', 'admin'),
(29, NULL, 'jerome', 'van de', 'vries', 'jerome@vries.com', 'jerome', NULL, 'klant'),
(30, NULL, 'arend', '', 'jan', 'hendriks@plip', NULL, NULL, 'klant'),
(38, 34, 'ben', '', 'a', 'ben@dit.com', 'benjanman', '$2y$10$XtIxZv9jwbDAdNSUVhT3zONJEsrPMH.xCu01IPlWnaxkqYOjoQzfO', 'manager'),
(39, NULL, 'ab', 'a', 'd', 'AB@A.COM', NULL, NULL, 'klant'),
(40, 35, 'ben', 'van', 'a', 'ben@van.com', 'ben12', '$2y$10$UQ6TafbiqsXQP6WsqlW.4egz9HnWNRBDdED2VGIBL.MimOq7x4jHS', 'klant');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menugangen`
--

CREATE TABLE `menugangen` (
  `menugang_id` int(11) NOT NULL,
  `naam` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `menugangen`
--

INSERT INTO `menugangen` (`menugang_id`, `naam`) VALUES
(8, 'nagerecht'),
(9, 'dessert'),
(10, 'hoofdgerecht'),
(11, 'voorgerecht');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `product_id` int(11) NOT NULL,
  `menugang_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `naam` varchar(200) NOT NULL,
  `beschrijving` varchar(200) NOT NULL,
  `inkoopprijs` decimal(5,2) NOT NULL,
  `verkoopprijs` decimal(5,2) NOT NULL,
  `vega` tinyint(1) DEFAULT NULL,
  `aantal_voorraad` int(11) NOT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`product_id`, `menugang_id`, `categorie_id`, `naam`, `beschrijving`, `inkoopprijs`, `verkoopprijs`, `vega`, `aantal_voorraad`, `image`) VALUES
(17, 10, 1, 'Meat Pie', 'gevuld met een smakelijke mix van pulled pork, beef of chicken, omhuld door een knapperige korst', 2.00, 2.00, 1, 1, 'Meat Pie.jpg'),
(19, 8, 1, 'Tim Tam', 'chocoladekoekjes gevuld met een romige chocoladevulling, omhuld met een laagje knapperige chocolade. ', 1.00, 2.00, 0, 3, 'Tim Tams.jpg'),
(20, 9, 1, 'Lamingtons', 'sponsgebak gedoopt in chocoladeglazuur, gerold in kokosnoot, gevuld met cakebeslag, slagroom en aardbeienjam.', 1.00, 1.00, 1, 2, 'lamington.jpg'),
(21, 8, 1, 'fairy bread', 'Kleurrijke 100s & 1000s op boterhammen met boter', 2.00, 2.00, 0, 2, 'fairy bread.png'),
(22, 9, 1, 'Pavlova', 'Luchtige meringue met vers fruit, slagroom en een vleugje abrikozenjam', 1.00, 1.00, 1, 1, 'pavlova.jpg'),
(23, 9, 1, 'ANZAC Biscuits', 'Zoet met golden syrup, knapperig met havermout, kokos en bruine suiker. Perfect bij de thee of als tussendoortje.', 1.00, 1.00, 0, 1, 'Anzac biscuits.png'),
(24, 11, 1, 'Vegemite on Toast', 'geroosterd brood besmeerd met Vegemite, een donkerbruine en zoute spread gemaakt van gistextract.', 1.00, 1.00, 0, 2, 'Vegemite on Toast.jpeg'),
(25, 11, 1, 'Chiko Rolls', 'Knapperige lentebroodjes gevuld met hartig kipgehakt, kool, wortel en selderij, gefrituurd en geserveerd met tomatensaus.', 1.00, 1.00, 1, 1, 'aussie chiko.jpg'),
(26, 10, 1, 'Kangoeroebiefstuk', 'Gegrilde kangoeroebiefstuk met rode wijnsaus, geserveerd met gebakken aardappelen en seizoensgroenten.', 10.00, 18.00, 1, 10, 'kangoeroe biefstuk.jpg'),
(27, 10, 1, 'Australische Ribeye Steak', 'Sappige ribeye steak, perfect gegrild en op smaak gebracht met Australische kruidenmix, geserveerd met knapperige aardappelwedges en een frisse salade.', 16.00, 25.00, 1, 5, 'australia ribeye steak.jpg'),
(28, 9, 1, 'Chocoladekersen Lamington Trifle', 'Luchtige chocoladebiscuit, rijke chocoladeganache, kersencompote en romige slagroom, gepresenteerd in laagjes tot een zalige trifle met een vleugje kokosrasp.', 8.00, 5.00, 1, 15, 'Choc-Cherry-Lamington-Trifle.jpg'),
(29, 10, 1, 'Gegrilde Barramundi', 'Verse barramundi filet, op de grill bereid en geserveerd met een citroenbotersaus, gesauteerde spinazie en aardappelpuree.', 15.00, 20.00, 1, 5, 'barramundi.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reserveringen`
--

CREATE TABLE `reserveringen` (
  `reservering_id` int(11) NOT NULL,
  `tafel_id` int(11) DEFAULT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reserveringen`
--

INSERT INTO `reserveringen` (`reservering_id`, `tafel_id`, `datum`, `tijd`, `gebruiker_id`) VALUES
(1, NULL, '2024-03-30', '23:55:00', 24),
(30, 4, '2024-03-30', '23:55:00', 26),
(33, NULL, '2024-03-29', '21:36:00', 30);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tafels`
--

CREATE TABLE `tafels` (
  `tafel_id` int(11) NOT NULL,
  `tafel_nummer` int(11) DEFAULT NULL,
  `aantal_personen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `tafels`
--

INSERT INTO `tafels` (`tafel_id`, `tafel_nummer`, `aantal_personen`) VALUES
(3, 5, 2),
(4, 1, 4),
(6, NULL, 2);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `adressen`
--
ALTER TABLE `adressen`
  ADD PRIMARY KEY (`adres_id`);

--
-- Indexen voor tabel `categorieen`
--
ALTER TABLE `categorieen`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`gebruiker_id`),
  ADD KEY `gebruikers_ibfk_1` (`adres_id`);

--
-- Indexen voor tabel `menugangen`
--
ALTER TABLE `menugangen`
  ADD PRIMARY KEY (`menugang_id`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `menugang_id` (`menugang_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD PRIMARY KEY (`reservering_id`),
  ADD KEY `tafel_id` (`tafel_id`),
  ADD KEY `fk_gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `tafels`
--
ALTER TABLE `tafels`
  ADD PRIMARY KEY (`tafel_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `adressen`
--
ALTER TABLE `adressen`
  MODIFY `adres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT voor een tabel `categorieen`
--
ALTER TABLE `categorieen`
  MODIFY `categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT voor een tabel `menugangen`
--
ALTER TABLE `menugangen`
  MODIFY `menugang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT voor een tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  MODIFY `reservering_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT voor een tabel `tafels`
--
ALTER TABLE `tafels`
  MODIFY `tafel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD CONSTRAINT `gebruikers_ibfk_1` FOREIGN KEY (`adres_id`) REFERENCES `adressen` (`adres_id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD CONSTRAINT `fk_menugang_id` FOREIGN KEY (`menugang_id`) REFERENCES `menugangen` (`menugang_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producten_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categorieen` (`categorie_id`);

--
-- Beperkingen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD CONSTRAINT `fk_gebruiker_id` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`gebruiker_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserveringen_ibfk_1` FOREIGN KEY (`tafel_id`) REFERENCES `tafels` (`tafel_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
