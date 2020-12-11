-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 dec 2020 om 14:45
-- Serverversie: 10.4.10-MariaDB
-- PHP-versie: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elabs`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `docent`
--

CREATE TABLE `docent` (
  `docentID` int(11) NOT NULL,
  `docentNaam` varchar(255) NOT NULL,
  `docentEmail` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `docent`
--

INSERT INTO `docent` (`docentID`, `docentNaam`, `docentEmail`, `wachtwoord`) VALUES
(1, 'Gerjan van Oenen', 'gerjan.van.oenen@nhlstenden.com', 'eenwachtwoord');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `labjournaal`
--

CREATE TABLE `labjournaal` (
  `labjournaalID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `docentID` int(11) NOT NULL,
  `labjournaalTitel` varchar(255) NOT NULL,
  `experimentDatum` date NOT NULL,
  `experimentBeginDatum` date NOT NULL,
  `experimentEindDatum` date NOT NULL,
  `logboek` text NOT NULL,
  `observaties` text NOT NULL,
  `weeggegevens` text NOT NULL,
  `afbeelding` longblob NOT NULL,
  `figuur` varchar(255) NOT NULL,
  `afbeeldingBron` varchar(255) NOT NULL,
  `bijlageLogboek` longblob NOT NULL,
  `bijlageObservaties` longblob NOT NULL,
  `bijlageWeeggegevens` longblob NOT NULL,
  `vakken` varchar(6) NOT NULL,
  `uitvoerders` varchar(255) NOT NULL,
  `veiligheid` longblob NOT NULL,
  `hypothse` text NOT NULL,
  `materialen` text NOT NULL,
  `methode` text NOT NULL,
  `meetresultaten` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `labjournaal`
--

INSERT INTO `labjournaal` (`labjournaalID`, `studentID`, `docentID`, `labjournaalTitel`, `experimentDatum`, `experimentBeginDatum`, `experimentEindDatum`, `logboek`, `observaties`, `weeggegevens`, `afbeelding`, `figuur`, `afbeeldingBron`, `bijlageLogboek`, `bijlageObservaties`, `bijlageWeeggegevens`, `vakken`, `uitvoerders`, `veiligheid`, `hypothse`, `materialen`, `methode`, `meetresultaten`) VALUES
(3, 1, 1, 'Labjournaal1', '2020-10-01', '0000-00-00', '0000-00-00', 'Logboek1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, 1, 1, 'Labjournaal2', '0000-00-00', '0000-00-00', '0000-00-00', 'Logboek2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(18, 1, 1, 'Labjournaal3', '0000-00-00', '0000-00-00', '0000-00-00', 'Logboek3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(19, 1, 1, 'Labjournaa4', '0000-00-00', '0000-00-00', '0000-00-00', 'Logboek4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(20, 1, 1, 'Labjournaal5', '0000-00-00', '0000-00-00', '0000-00-00', 'Logboek5', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `protocol`
--

CREATE TABLE `protocol` (
  `protocolID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `uploadDatum` date NOT NULL,
  `protocol` longblob NOT NULL,
  `vakken` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `readonly`
--

CREATE TABLE `readonly` (
  `studentID` int(11) NOT NULL,
  `labjournaalID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `studentNummer` int(11) NOT NULL,
  `studentNaam` varchar(255) NOT NULL,
  `studentEmail` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `beveiligingsVraag1` varchar(255) NOT NULL,
  `beveiligingsVraag2` varchar(255) NOT NULL,
  `beveiligingsVraag3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `student`
--

INSERT INTO `student` (`studentID`, `studentNummer`, `studentNaam`, `studentEmail`, `wachtwoord`, `beveiligingsVraag1`, `beveiligingsVraag2`, `beveiligingsVraag3`) VALUES
(1, 1234567, 'Mike Verschuur', 'mike.verschuur@student.nhlstenden.com', 'test', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voorbereiding`
--

CREATE TABLE `voorbereiding` (
  `voorbereidingID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `voorbereidingTitel` varchar(255) NOT NULL,
  `voorbereidingDatum` date NOT NULL,
  `materialen` text NOT NULL,
  `methode` text NOT NULL,
  `hypothese` text NOT NULL,
  `instellingenApparaten` text NOT NULL,
  `voorbereidendeVragen` text NOT NULL,
  `veiligheid` text NOT NULL,
  `vakken` varchar(6) NOT NULL,
  `uitvoerders` varchar(255) NOT NULL,
  `uitvoeringsDatum` date NOT NULL,
  `theorie` longblob NOT NULL,
  `benodigdeFormules` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `docent`
--
ALTER TABLE `docent`
  ADD PRIMARY KEY (`docentID`);

--
-- Indexen voor tabel `labjournaal`
--
ALTER TABLE `labjournaal`
  ADD PRIMARY KEY (`labjournaalID`),
  ADD KEY `FK_student_labjournaal` (`studentID`),
  ADD KEY `FK_docent_labjournaal` (`docentID`);

--
-- Indexen voor tabel `protocol`
--
ALTER TABLE `protocol`
  ADD PRIMARY KEY (`protocolID`),
  ADD KEY `FK_student_protocol` (`studentID`);

--
-- Indexen voor tabel `readonly`
--
ALTER TABLE `readonly`
  ADD PRIMARY KEY (`labjournaalID`,`studentID`) USING BTREE,
  ADD KEY `FK_student_readonly` (`studentID`);

--
-- Indexen voor tabel `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexen voor tabel `voorbereiding`
--
ALTER TABLE `voorbereiding`
  ADD PRIMARY KEY (`voorbereidingID`),
  ADD KEY `FK_student_voorbereiding` (`studentID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `docent`
--
ALTER TABLE `docent`
  MODIFY `docentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `labjournaal`
--
ALTER TABLE `labjournaal`
  MODIFY `labjournaalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT voor een tabel `protocol`
--
ALTER TABLE `protocol`
  MODIFY `protocolID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `student`
--
ALTER TABLE `student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `voorbereiding`
--
ALTER TABLE `voorbereiding`
  MODIFY `voorbereidingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `labjournaal`
--
ALTER TABLE `labjournaal`
  ADD CONSTRAINT `FK_docent_labjournaal` FOREIGN KEY (`docentID`) REFERENCES `docent` (`docentID`),
  ADD CONSTRAINT `FK_student_labjournaal` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Beperkingen voor tabel `protocol`
--
ALTER TABLE `protocol`
  ADD CONSTRAINT `FK_student_protocol` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Beperkingen voor tabel `readonly`
--
ALTER TABLE `readonly`
  ADD CONSTRAINT `FK_Labjournaal_readonly` FOREIGN KEY (`labjournaalID`) REFERENCES `labjournaal` (`labjournaalID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_student_readonly` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `voorbereiding`
--
ALTER TABLE `voorbereiding`
  ADD CONSTRAINT `FK_student_voorbereiding` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
