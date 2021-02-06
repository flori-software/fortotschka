-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Jul 2020 um 19:42
-- Server-Version: 5.7.25
-- PHP-Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `usr_web934_1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `abschluesse`
--

CREATE TABLE `abschluesse` (
  `ID` int(11) NOT NULL,
  `id_jahr` int(11) NOT NULL,
  `eigenkapital` double NOT NULL,
  `ergebnis` double NOT NULL,
  `fremdkapital` double NOT NULL,
  `kapital` double NOT NULL,
  `summe_ertrag` double NOT NULL,
  `summe_aufwand` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `abschluesse`
--

INSERT INTO `abschluesse` (`ID`, `id_jahr`, `eigenkapital`, `ergebnis`, `fremdkapital`, `kapital`, `summe_ertrag`, `summe_aufwand`) VALUES
(3, 3, 9074.39, 6879.02, 0, 9074.39, 10555.62, 3676.6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `abschluesse_konten`
--

CREATE TABLE `abschluesse_konten` (
  `ID` int(11) NOT NULL,
  `art` varchar(20) NOT NULL,
  `id_abschluss` int(11) NOT NULL,
  `nr_konto` varchar(20) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `saldo_anfang` double NOT NULL,
  `bewegung` double NOT NULL,
  `saldo_ende` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `abschluesse_konten`
--

INSERT INTO `abschluesse_konten` (`ID`, `art`, `id_abschluss`, `nr_konto`, `bezeichnung`, `saldo_anfang`, `bewegung`, `saldo_ende`) VALUES
(39, 'aktiva', 3, '1100', 'Sparkasse Coburg', 911.02, 4862.62, 5773.64),
(40, 'aktiva', 3, '1110', 'VR-Bank Coburg', 163.1, 95, 258.1),
(41, 'aktiva', 3, '1120', 'VR-Bank Cob Tagesgeld', 0.29, 0, 0.29),
(42, 'aktiva', 3, '1130', 'Bamberger Bank RÃ¼cklagen', 1700, 0, 1700),
(43, 'aktiva', 3, '1140', 'Bamberger Bank Verein', -579.04, 1921.4, 1342.36),
(44, 'ertrag', 3, '3000', 'MitgliedsbeitrÃ¤ge', 0, 4827.5, 4827.5),
(45, 'ertrag', 3, '3010', 'Ertr. wirtsch. TÃ¤tigkeit', 0, 297, 297),
(46, 'ertrag', 3, '3020', 'Spenden', 0, 5431.12, 5431.12),
(47, 'ertrag', 3, '3030', 'FÃ¶rdergelder', 0, 0, 0),
(48, 'ertrag', 3, '3040', 'Zins- und andere KapitalertrÃ¤ge', 0, 0, 0),
(49, 'ertrag', 3, '3050', 'sonst. ErtrÃ¤ge', 0, 0, 0),
(50, 'aufwand', 3, '4000', 'FÃ¶rderung gemeinnÃ¼tziger Organisationen', 0, 3200, 3200),
(51, 'aufwand', 3, '4010', 'Nebenkosten des Geldverkehrs', 0, 286.6, 286.6),
(52, 'aufwand', 3, '4020', 'GebÃ¼hren fÃ¼r Dienstleistungen und Lizenzen', 0, 30, 30),
(53, 'aufwand', 3, '4030', 'BÃ¼romaterial', 0, 0, 0),
(54, 'aufwand', 3, '4040', 'Porto', 0, 0, 0),
(55, 'aufwand', 3, '4050', 'Reisekosten', 0, 0, 0),
(56, 'aufwand', 3, '4060', 'Spesen', 0, 0, 0),
(57, 'aufwand', 3, '4070', 'RÃ¼ckerstattungen der MitgliedsbeitrÃ¤ge', 0, 160, 160);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anfangssalden`
--

CREATE TABLE `anfangssalden` (
  `ID` int(11) NOT NULL,
  `id_konto` int(11) NOT NULL,
  `id_jahr` int(11) NOT NULL,
  `anfangssaldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `anfangssalden`
--

INSERT INTO `anfangssalden` (`ID`, `id_konto`, `id_jahr`, `anfangssaldo`) VALUES
(7, 11, 3, 0),
(8, 12, 3, 0),
(9, 13, 3, 0),
(10, 14, 3, 0),
(11, 15, 3, 911.02),
(12, 16, 3, 163.1),
(13, 17, 3, 0.29),
(14, 18, 3, 1700),
(15, 19, 3, -579.04),
(16, 20, 3, 0),
(17, 21, 3, 0),
(18, 22, 3, 0),
(19, 23, 3, 0),
(20, 24, 3, 0),
(21, 25, 3, 0),
(22, 26, 3, 0),
(23, 27, 3, 0),
(24, 28, 3, 0),
(25, 29, 3, 0),
(26, 30, 3, 0),
(27, 31, 3, 0),
(28, 32, 3, 0),
(29, 33, 3, 0),
(49, 15, 5, 5773.64),
(50, 16, 5, 173.1),
(51, 17, 5, 0.29),
(52, 18, 5, 1700),
(53, 19, 5, 1342.36),
(54, 20, 5, 0),
(55, 21, 5, 0),
(56, 22, 5, 0),
(57, 23, 5, 0),
(58, 24, 5, 0),
(59, 25, 5, 0),
(60, 26, 5, 0),
(61, 27, 5, 0),
(62, 28, 5, 0),
(63, 29, 5, 0),
(64, 30, 5, 0),
(65, 31, 5, 0),
(66, 32, 5, 0),
(67, 33, 5, 0),
(68, 15, 6, 5773.64),
(69, 16, 6, 258.1),
(70, 17, 6, 0.29),
(71, 18, 6, 1700),
(72, 19, 6, 1342.36),
(73, 20, 6, 0),
(74, 21, 6, 0),
(75, 22, 6, 0),
(76, 23, 6, 0),
(77, 24, 6, 0),
(78, 25, 6, 0),
(79, 26, 6, 0),
(80, 27, 6, 0),
(81, 28, 6, 0),
(82, 29, 6, 0),
(83, 30, 6, 0),
(84, 31, 6, 0),
(85, 32, 6, 0),
(86, 33, 6, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Benutzer`
--

CREATE TABLE `Benutzer` (
  `ID` int(11) NOT NULL,
  `benutzername` varchar(255) NOT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `plz` varchar(255) DEFAULT NULL,
  `ort` varchar(255) DEFAULT NULL,
  `telefonnummer` varchar(255) DEFAULT NULL,
  `mobil` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `passwort` varchar(255) NOT NULL,
  `monat1` tinyint(4) DEFAULT NULL,
  `monat2` tinyint(4) DEFAULT NULL,
  `monat3` tinyint(4) DEFAULT NULL,
  `monat4` tinyint(4) DEFAULT NULL,
  `monat5` tinyint(4) DEFAULT NULL,
  `monat6` tinyint(4) DEFAULT NULL,
  `monat7` tinyint(4) DEFAULT NULL,
  `monat8` tinyint(4) DEFAULT NULL,
  `monat9` tinyint(4) DEFAULT NULL,
  `monat10` tinyint(4) DEFAULT NULL,
  `monat11` tinyint(4) DEFAULT NULL,
  `monat12` tinyint(4) DEFAULT NULL,
  `iban` varchar(100) DEFAULT NULL,
  `bic` varchar(100) DEFAULT NULL,
  `jahresbeitrag` double DEFAULT NULL,
  `monatsbeitrag` double DEFAULT NULL,
  `mandatsreferenznummer` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Benutzer`
--

INSERT INTO `Benutzer` (`ID`, `benutzername`, `nachname`, `vorname`, `strasse`, `plz`, `ort`, `telefonnummer`, `mobil`, `email`, `admin`, `passwort`, `monat1`, `monat2`, `monat3`, `monat4`, `monat5`, `monat6`, `monat7`, `monat8`, `monat9`, `monat10`, `monat11`, `monat12`, `iban`, `bic`, `jahresbeitrag`, `monatsbeitrag`, `mandatsreferenznummer`) VALUES
(1, 'Arek', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713', '3216872', 'arek@budoclips.de', 0, 'Florentina1', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE 123456789000', 'BYLADEM1COB', 0, 0, '546878fdfs'),
(3, 'Daishi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(4, 'Tom Hollander', 'Hollander', 'Tom', 'An der Breite 7', '31855', 'GroÃŸ Berkel', '', '', '', 0, 'test', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE32120300001010977401', 'BYLADEM1001', 12, 12, '20140101-AP-10'),
(5, 'DietelJannika', 'Jannika', 'Dietel', 'FuchshÃ¼gel 41', '95126', 'Schwarzenbach an der Saale', '', '', 'jannika.dietel@gmail.com', 0, 'test456', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 'DE46 7806 0896 0006 7023 50 ', '', 80, 20, '20192504-JD-01'),
(6, 'EngelhardtChristian', 'Engelhardt', 'Christian', 'Rotheimer Str. 25', '35398', 'Giessen', '', '', 'christian.engelhardt@mail.de', 0, 'chris123456', 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'DE71 5135 0025 0005 1580 87', '', 80, 40, '20190424-CE-01'),
(7, 'Sebastian Triebel', 'Triebel', 'Sebastian', 'JenaerstraÃŸe 9', '96486', 'Lautertal', '', '015229385656', 's.triebel@gmx.de', 0, 'Loon23', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE53783600000007138164', 'GENODEF1COS', 120, 10, '20141219-AP-01'),
(8, 'Franz Aschenbrenner', 'Aschenbrenner', 'Franz', '', '', '', '', '', 'aschenbrenner.franz@gmx.net', 0, 'pawfud-bysfyn-0wesfI', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE65783600000000914428', 'GENODEF1COS', 30, 7, '20140101-AP-01'),
(9, 'Bruisch, Johanna', 'Bruisch', 'Johanna', 'Ortsstr. 40a', '98646', 'Dingsleben', '', '', 'johanna.bruisch@googlemail.com', 0, 'vorfow-pornak-pYrku9', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE72840948145005133157', 'GENODEF1SHL', 120, 10, '20140101-AP-03'),
(10, 'Burkard, Stefanie', 'Burkard', 'Stefanie', '', '', '', '', '', '', 0, 'Zokwuf-xikxa3-gyxmik', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE15793501010000753715', 'BYLADEM1KSW', 12, 12, '0050907090D7935010100007537150'),
(11, 'Dillinger, Katrin', 'Dillinger', 'Katrin', 'End 16', '96231', 'Bad Staffelstein', '', '', 'dillinger.katrin@web.de', 0, 'bowpIz-zyckuf-1dibze', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE38783500000092704709', 'BYLADEM1COB', 60, 5, '20140101-AP-04'),
(12, 'Enes, Steffen', 'Enes', 'Steffen', '', '', '', '', '', '', 0, 'wajvo8-kasbut-hoMmoh', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE38546512400004947990', 'MALADE51DKH', 60, 5, '20140101-AP-05'),
(13, 'Fleischer, Jessica', 'Fleischer', 'Jessica', 'LettenbÃ¼hl 13', '74420', 'Oberrot', '079773460570', '017696722085', 'jessicaeisentraut@gmx.de', 0, 'DiePrÃ¼ferin', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE32622901100204976006', 'GENODES1SHA', 25, 0, '20140101-JE-01'),
(14, 'Fleischmann, Martin', 'Fleischmann', 'Martin', 'Waldbuch 1', '96364', 'Marktrodach', '', '0160-8941196', 'meatman81@web.de', 0, 'tugfy6-xibNyg-sakqux', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 'DE35773616000001011715', 'GENODEF1KC1', 60, 15, '0050907090D7736160000010117150'),
(15, 'Freydorf, Christoph', 'Freydorf', 'Christoph', 'Pforzheimer Str. 69', '76275', 'Ettlingen', '', '', '', 0, 'tymkyb-kiJzi0-zazhaj', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 'DE30600908000001631707', 'GENODEF1S02', 60, 15, '20190119-AP-01'),
(16, 'Friedrich, Birgitt', 'Friedrich', 'Birgitt', 'Joh.-K.-Drissler-Str. 22', '76593', 'Gernsbach', '+49 7224 657246', '', 'BUFriedrich@web.de', 0, 'tezfib-7bymwE-wavvyt', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE62620916000046073000', 'GENODES1VMN', 120, 10, '20140101-AP-07'),
(17, 'Geray, Armin', 'Geray', 'Armin', '', '', '', '', '0177 5530509', 'a.geray@web.de', 0, 'sajvyw-decfof-8bywbU', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE90300209001008901663', 'CMCIDEDD', 40, 10, '20141219-FD-02'),
(18, 'Ing. BÃ¼ro Haas & Holler', 'Ing. BÃ¼ro Haas & Holler', '', 'Schmaedelstr. 22', '81245', 'MÃ¼nchen', '', '', '', 0, 'ryvmij-1rojsi-zEnfoq', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE32710200720003369285', 'HYVEDEMM410', 600, 50, '20140101-AP-09'),
(19, 'Hesse, Elisabeth', 'Hesse', 'Elisabeth', '', '', '', '', '', 'elisabethhe@gmx.de', 0, 'gimsUb-4vavse-borfaz', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE90781615750002517612', 'GENODEF1WSS', 12, 12, '20140101-AP-99'),
(20, 'Koch, Julia', 'Koch', 'Julia', 'Berliner Weg 8', '96489', 'NiederfÃ¼llbach', '', '', 'julia.koch1@web.de', 0, 'Mydrev-denkut-vynpo5', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE28674500481001470275', 'SOLADES1MOS', 120, 10, '20140101-AP-11'),
(21, 'Kranert, Andrea', 'Kranert', 'Andrea', 'Harthstr. 11', '96052', 'Bamberg', '', '', 'andrea.kranert@gmx.de', 0, 'zemqA9-zavbek-kyppib', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE96660908000007930879', 'GENODE61BBB', 240, 20, '20140101-AP-12'),
(22, 'Leybold, Lisa', 'Leybold', 'Lisa', 'Hohe Str. 18', '96450', 'Coburg', '09561 358023', '', 'ergo-lisa@web.de', 0, 'capta7-mypkAf-patqaj', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 'DE15783500000040213282', 'BYLADEM1COB', 40, 10, '20141219-FD-01'),
(23, 'Mellert, Georg', 'Mellert', 'Georg', 'Am SchieÃŸstand 43', '96450', 'Coburg', '', '', 'georg.mellert@googlemail.com', 0, 'Vegsej-fazbo0-vojhyd', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE09440100460283115462', 'PBNKDEFF440', 120, 10, '20140101-AP-13'),
(24, 'Nakajima, Michael Daishiro', 'Nakajima', 'Michael Daishiro', 'Brunnenberg 14', '74749', 'Rosenberg', '', '', '', 0, 'tepdod-gorroC-qogca2', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE88200411330692683600', 'COBADEHD001', 240, 20, '20140101-AP-14'),
(25, 'Naser, Markus', 'Naser', 'Markus', 'Wolfsau 7', '91583', 'Diebach', '', '01605217489', 'markus.naser@t-online.de', 0, 'jerduz-kYpkit-0mepje', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'DE47765600600001401696', 'GENODEF1ANS', 240, 240, '0050907090D7606960100014016960'),
(26, 'Rabeler, Dr. Alice', 'Rabeler', 'Dr. Alice', 'Kaesenstr. 23', '50677', 'KÃ¶ln', '', '', 'alice.rabeler@ulb.uni-bonn.de', 0, 'rywxer-Gefryg-cighe1', 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 'DE33440100460202044467', 'PBNKDEFF440', 120, 60, '20140101-AP-15'),
(27, 'Six, Nicolas', 'Six', 'Nicolas', 'Morrestr. 14', '74722', 'Buchen', '', '0176/2179929', 'Nicolas.Six@web.de', 0, 'bumtaj-xebxAh-7cyhra', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 'DE50674600410020187808', 'GENODE61MOS', 180, 45, '0050907090D6746004100201878080'),
(28, 'Ãœn Calo', 'Ãœn', 'Calo', 'Schleifanger 4', '96450', 'Coburg', '09561 94606', '0151 16143220', '', 0, 'taqSoj-jydbiz-5cagcy', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'DE78783500000009472945', 'BYLADEM1COB', 102, 8, '20140205-AP-01'),
(29, 'Werchan, Ruben', 'Werchan', 'Ruben', 'KoelhoffstraÃŸe 1', '50676', 'KÃ¶ln', '', '0176 25576776', 'ruben.werchan@me.com', 0, 'ziZwas-nyzxu6-tevqoz', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'DE41120300001010597290', 'BYLADEM1001', 25, 25, '20140203-RW-01'),
(30, 'Hollander, Anja', 'Hollander', 'Anja', 'An der Breite 7', '31855', 'GroÃŸ Berkel', '', '', 'tb.anja@t-online.de', 0, 'Bohemef+09', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, '', '', 0, 0, ''),
(31, 'Wagner, Johannes', 'Wagner', 'Johannes', 'Burgstall 16', '96268', 'Mitwitz', '', '', '', 0, 'asdfgh123456', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(32, 'Seuffert, Martin', 'Seuffert', 'Martin', 'Stofflerhof 1', '78247', 'Hilzingen', '', '', 'mseuffert@freenet.de', 0, 'MSpotdfkrk856223', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(33, 'Poerzgen, Yvonne', 'PÃ¶rzgen', 'Yvonne', '', '', '', '', '', 'yvonne.poerzgen@web.de', 0, 'YPngieowpf956621', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(34, 'Stenzel, Ute', 'Stenzel', 'Ute', 'QuerstraÃŸe 7', '96450', 'Coburg', '', '', 'ute.stenzel@vsj.de', 0, 'USmgireoqd254907', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(35, 'Fichtner, Albert', 'Fichtner', 'Albert', '', '', '', '', '', '', 0, 'AFmymxnczr301799', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(36, 'Viegelahn, Christian', 'Viegelahn', 'Christian', 'nicht notwendig, keine Quittung', '', '', '', '', 'c.viegelahn@gmx.de', 0, 'CVpwoeutzg132649', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(37, 'Renninger, Ines', 'Renninger', 'Ines', '', '', '', '', '', 'Ines.Renninger@gmx.net', 0, 'IRqpalxmyn147852', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(38, 'Wagner, Holger', 'Wagner', 'Holger', '', '', '', '', '', 'holger.wagner@web.de', 0, 'HWrfvbgtuz963214', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(39, 'Hammerschmitt, Markus', 'Hammerschmitt', 'Markus', '', '', '', '', '', '', 0, 'MHwertioza852369', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(40, 'Schweibold, Robert', 'Schweibold', 'Robert', '', '', '', '', '', '', 0, 'RSbvcfghjk456987', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(41, 'Schmidt, Barbara', 'Schmidt', 'Barbara', '', '', '', '', '', 'baschmidt@web.de', 0, 'BSpokmnjiu147458', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(42, 'Stenzel, Bastian', 'Stenzel', 'Bastian', '', '', '', '', '', 'bastian.stenzel@gmx.de', 0, 'BSgfderttg987456', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(43, 'Dang, Fu Hai', 'Dang', 'Fu-Hai', '', '', '', '', '', 'menos.krande@yahoo.de', 0, 'FDplmxaqrg852963', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(44, 'Keil, Norbert', 'Keil', 'Norbert', '', '', '', '', '', '', 0, 'NKzjmefbsx139746', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(45, 'Fischer, Dr. Dietrich', 'Dr. Fischer', 'Dietrich', '', '', '', '', '', 'DGF-Fischer@gmx.de', 0, 'DFefbuhvoi842655', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(46, 'Kraft, Jana', 'Kraft', 'Jana', '', '', '', '', '', '', 0, 'JKjfueorpr951357', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(47, 'Wohlfromm, Michael', 'Wohlfromm', 'Michael', 'Beiersdorfer StraÃŸe 2', '96450', 'Coburg', '', '', 'michael_wohlfromm@gmx.de', 0, 'MWjunkhizm595751', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(48, '', '', '', '', '', '', '', '', '', 0, 'JWafdsaewq302010', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(49, 'Klose, Stefan', 'Klose', 'Stefan', '', '', '', '', '', '', 0, 'SKplmoiuzz908076', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(50, 'Bill, Sonja', 'Bill', 'Sonja', 'PlettenbergstraÃŸe 50', '70186', 'Stuttgart', '', '', 'sonjabill@googlemail.com', 0, 'SBmniopgfd690420', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(51, 'Wagner, Peter', 'Wagner', 'Peter', '', '', '', '', '', 'pj-wagner@arcor.de', 0, 'PWminubzvt951544', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(52, 'Quentin, Anna', 'Quentin', 'Anna', '', '', '', '', '', 'AnnaQuentin@web.de', 0, 'AQkdeoedjf464426', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(53, 'Bill, Elisabeth', 'Bill', 'Elisabeth', '', '', '', '', '', 'elisabethbill@web.de', 0, 'EBjejpfjpa471825', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(54, 'PÃ¼rner, Helmut', 'PÃ¼rner', 'Dr. Helmut', 'Marienstr. 37', '95643', 'Tirschenreuth', '', '', '', 0, 'wsad5213', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, ''),
(55, 'Heine, Axel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'wsad5213', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buchungen`
--

CREATE TABLE `buchungen` (
  `ID` int(11) NOT NULL,
  `datum` date NOT NULL,
  `kommentar` varchar(255) NOT NULL,
  `id_jahr` int(11) NOT NULL,
  `gesperrt` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buchungen`
--

INSERT INTO `buchungen` (`ID`, `datum`, `kommentar`, `id_jahr`, `gesperrt`) VALUES
(1, '2019-01-17', 'Spende an Protoieria Tulcea - Nothilfefond', 0, 0),
(2, '2019-01-21', 'Beitrag Florentina und A. Paluszek', 3, 1),
(3, '2019-01-22', 'Sammellastschrift Januar', 3, 1),
(4, '2019-01-30', 'Sammellastschrift Nr. 2 Januar', 3, 1),
(5, '2019-02-01', 'BankgebÃ¼hren', 3, 1),
(6, '2019-02-15', 'Sammellastschrift Februar', 3, 1),
(7, '2019-02-15', 'Sammellastschrift Februar versehentlich erneut eingezogen', 3, 1),
(8, '2019-02-18', 'RÃ¼ckerstattung der versehentlich eingezogenen MitgliedsbeitrÃ¤ge', 3, 1),
(9, '2019-03-01', 'BankgebÃ¼hren', 3, 1),
(10, '2019-03-04', 'Rechnung 2018-062 von Diakonie Hochfranken irrtÃ¼mlich an flori-software UG bezahlt statt an Fortotschka e.V. - hier von flori-software UG an Fortotschka e.V. weitergeleitet', 3, 1),
(11, '2019-03-04', 'Mitgliedsbeitrag Florentina und Arkadiusz Paluszek', 3, 1),
(12, '2019-03-04', 'Sammellastschrift MÃ¤rz', 3, 1),
(13, '2019-03-15', 'Spende Haas & Holler fÃ¼r das Nothilfebudget in Orhei', 3, 1),
(14, '2019-03-18', 'Nothilfefond fÃ¼r den Verein "Christliche Philantropie" in Orhei / Rep. Moldawien', 3, 1),
(15, '2019-04-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(16, '2019-04-01', 'Sammellastschrift April', 3, 1),
(17, '2019-04-16', 'Mitgliedsbeitrag Paluszek', 3, 1),
(18, '2019-04-25', 'Mitgliedsbeitrag Paluszek', 3, 1),
(20, '2019-05-02', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(21, '2019-05-13', 'Spende an Protoieria Tulcea - Nothilfefond', 3, 1),
(22, '2019-05-13', 'Nothilfefond fÃ¼r den Verein "Christliche Philantropie" in Orhei / Rep. Moldawien', 3, 1),
(23, '2019-05-13', 'GebÃ¼hr AuslandsÃ¼berweisungen', 3, 1),
(24, '2019-05-17', 'Spende Amazon smile', 3, 1),
(25, '2019-06-03', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(26, '2019-07-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(27, '2019-07-12', 'Spende Jana Kraft', 3, 1),
(28, '2019-07-22', 'StandgebÃ¼hren Bamberg Landesjustizkasse', 3, 1),
(29, '2019-07-29', 'Spende Arek', 3, 1),
(30, '2019-08-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(31, '2019-08-26', 'RÃ¼cklastschrift', 3, 1),
(32, '2019-09-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(33, '2019-09-17', 'Spende Tom', 3, 1),
(34, '2019-09-19', 'Spende', 3, 1),
(35, '2019-10-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(36, '2019-10-09', 'Spende Tom', 3, 1),
(37, '2019-10-14', 'Spende', 3, 1),
(38, '2019-10-14', 'Mitgliedsbeitrag Paluszek', 3, 1),
(39, '2019-11-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(40, '2019-11-04', 'Spende Arek', 3, 1),
(41, '2019-12-01', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(42, '2019-12-02', 'Mitgliedsbeitrag Paluszek', 3, 1),
(43, '2019-04-02', 'StandgebÃ¼hr', 3, 1),
(44, '2019-01-02', 'Mitgliedsbeitrag', 3, 1),
(45, '2019-01-31', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(46, '2019-02-06', 'Spende', 3, 1),
(47, '2019-02-07', 'Spende', 3, 1),
(48, '2019-02-28', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(49, '2019-03-29', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(50, '2019-04-30', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(51, '2019-05-31', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(52, '2019-06-28', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(53, '2019-07-02', 'Spende', 3, 1),
(54, '2019-07-31', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(55, '2019-08-30', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(56, '2019-09-30', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(57, '2019-10-01', 'Mitgliedsbeitrag', 3, 1),
(58, '2019-10-08', 'Mitgliedsbeitrag', 3, 1),
(60, '2019-10-09', 'RÃ¼cklastschrift', 3, 1),
(61, '2019-10-31', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(62, '2019-11-07', 'Spende', 3, 1),
(63, '2019-11-29', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(64, '2019-01-21', 'Mitgliedsbeitrag', 3, 1),
(65, '2019-02-20', 'Mitgliedsbeitrag', 3, 1),
(66, '2019-03-20', 'Mitgliedsbeitrag', 3, 1),
(67, '2019-03-29', 'Auslagen', 3, 1),
(68, '2019-04-23', 'Mitgliedsbeitrag', 3, 1),
(69, '2019-05-20', 'Mitgliedsbeitrag', 3, 1),
(70, '2019-06-21', 'Mitgliedsbeitrag', 3, 1),
(71, '2019-06-28', 'Auslagen', 3, 1),
(72, '2019-07-22', 'Mitgliedsbeitrag', 3, 1),
(73, '2019-08-20', 'Mitgliedsbeitrag', 3, 1),
(74, '2019-09-20', 'Mitgliedsbeitrag', 3, 1),
(75, '2019-09-30', 'Auslagen', 3, 1),
(76, '2019-10-21', 'Mitgliedsbeitrag', 3, 1),
(77, '2019-11-20', 'Mitgliedsbeitrag', 3, 1),
(78, '2019-05-02', 'Sammellastschrift Mai', 3, 1),
(79, '2019-06-03', 'Sammellastschrift Juni', 3, 1),
(80, '2019-07-01', 'Sammellastschrift Juli', 3, 1),
(81, '2019-08-21', 'Sammellastschrift August', 3, 1),
(83, '2019-09-06', 'Sammellastschrift September', 3, 1),
(84, '2019-10-04', 'Sammellastschrift Oktober', 3, 1),
(85, '2019-11-06', 'Sammellastschrift November', 3, 1),
(86, '2019-11-19', 'Nothilfefond fÃ¼r den Verein Christliche Philantropie in Orhei / Rep. Moldawien', 3, 1),
(87, '2019-11-25', 'Mitgliedsbeitrag', 3, 1),
(88, '2019-12-20', 'Sammellastschrift Dezember', 3, 1),
(89, '2019-12-20', 'Mitgliedsbeitrag', 3, 1),
(90, '2019-12-23', 'Spende', 3, 1),
(91, '2019-12-30', 'Mitgliedsbeitrag Paluszek', 3, 1),
(92, '2019-12-30', 'KontofÃ¼hrungsgebÃ¼hren', 3, 1),
(93, '2019-10-04', 'Sammellastschrift Oktober 2', 3, 1),
(94, '2019-12-23', 'Spende Martin Seuffert', 3, 1),
(95, '2019-12-23', 'Spende Axel Heine', 3, 1),
(96, '2019-12-23', 'Spende Helmut PÃ¼rner', 3, 1),
(97, '2019-12-30', 'KontofÃ¼hrungsgebÃ¼hren ', 3, 1),
(98, '2020-01-03', 'Sammellastschrift Januar', 6, 0),
(99, '2020-01-14', 'Spende Nothilfefonds', 6, 0),
(100, '2020-01-20', 'Mitgliedsbeitrag', 6, 0),
(101, '2020-02-03', 'KontofÃ¼hrungsgebÃ¼hren', 6, 0),
(102, '2020-02-04', 'Mitgliedsbeitrag', 6, 0),
(103, '2020-02-04', 'Spende Pater Stark', 6, 0),
(104, '2020-02-17', 'Spende Nothilfefonds', 6, 0),
(105, '2020-02-18', 'Sammellastschrift Februar', 6, 0),
(106, '2020-02-18', 'Mitgliedsbeitrag', 6, 0),
(107, '2020-02-20', 'Mitgliedsbeitrag', 6, 0),
(108, '2020-02-04', 'AuflÃ¶sung Konto', 6, 0),
(109, '2019-12-19', 'Spende Daishiro Nakajima', 3, 1),
(110, '2019-12-30', 'Kontoabschluss', 3, 1),
(111, '2020-02-28', 'KontofÃ¼hrungsgebÃ¼hren', 6, 0),
(112, '2020-03-04', 'Sammellastschrift MÃ¤rz', 6, 0),
(113, '2020-03-17', 'Landesjustizkasse Bamberg', 6, 0),
(114, '2020-03-19', 'Stiftung Fliege', 6, 0),
(115, '2020-03-20', 'Mitgliedsbeitrag', 6, 0),
(116, '2020-03-31', 'KontofÃ¼hrungsgebÃ¼hren', 6, 0),
(117, '2020-04-07', 'Spende fÃ¼r Bau des Sozialzentrums', 6, 0),
(118, '2020-04-14', 'Nothilfefond fÃ¼r den Verein "Christliche Philantropie" in Orhei / Rep. Moldawien', 6, 0),
(119, '2020-04-15', 'Mitgliedsbeitrag', 6, 0),
(120, '2020-04-20', 'Mitgliedsbeitrag', 6, 0),
(121, '2020-04-30', 'KontofÃ¼hrungsgebÃ¼hren', 6, 0),
(122, '2020-05-04', 'Spende', 6, 0),
(123, '2020-05-04', 'Mitgliedsbeitrag', 6, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ich`
--

CREATE TABLE `ich` (
  `ID` int(11) NOT NULL,
  `vereinsname` varchar(255) DEFAULT NULL,
  `adresszeile` varchar(255) DEFAULT NULL,
  `strasse` varchar(255) NOT NULL,
  `plz` varchar(10) NOT NULL,
  `ort` varchar(100) NOT NULL,
  `telefonnummer` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `vorstand` text,
  `freistellungsbescheid_vom` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ich`
--

INSERT INTO `ich` (`ID`, `vereinsname`, `adresszeile`, `strasse`, `plz`, `ort`, `telefonnummer`, `email`, `vorstand`, `freistellungsbescheid_vom`) VALUES
(1, 'Fortotschka e.V.', 'Fortotschka e.V., Neustadter Str. 48, 96487 Dörfles-Esbach', 'Neustadter Str. 48', '96487', 'Dörfles-Esbach', '0160 1712819', 't.hollander@fortotschka.de', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `jahr`
--

CREATE TABLE `jahr` (
  `ID` int(11) NOT NULL,
  `jahr` varchar(20) NOT NULL,
  `datum_von` date DEFAULT NULL,
  `datum_bis` date DEFAULT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `jahr`
--

INSERT INTO `jahr` (`ID`, `jahr`, `datum_von`, `datum_bis`, `aktiv`) VALUES
(3, '2019', '2019-01-01', '2019-12-31', 1),
(6, '2020', '2020-01-01', '2020-12-31', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kontenplan`
--

CREATE TABLE `kontenplan` (
  `ID` int(11) NOT NULL,
  `nr` varchar(10) NOT NULL,
  `bezeichnung` varchar(50) NOT NULL,
  `art` varchar(10) NOT NULL,
  `aktiv` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `kontenplan`
--

INSERT INTO `kontenplan` (`ID`, `nr`, `bezeichnung`, `art`, `aktiv`) VALUES
(15, '1100', 'Sparkasse Coburg', 'aktiva', 1),
(16, '1110', 'VR-Bank Coburg', 'aktiva', 1),
(17, '1120', 'VR-Bank Cob Tagesgeld', 'aktiva', 1),
(18, '1130', 'Bamberger Bank RÃ¼cklagen', 'aktiva', 1),
(19, '1140', 'Bamberger Bank Verein', 'aktiva', 1),
(20, '3000', 'MitgliedsbeitrÃ¤ge', 'ertrag', 1),
(21, '3010', 'Ertr. wirtsch. TÃ¤tigkeit', 'ertrag', 1),
(22, '3020', 'Spenden', 'ertrag', 1),
(23, '3030', 'FÃ¶rdergelder', 'ertrag', 1),
(24, '3040', 'Zins- und andere KapitalertrÃ¤ge', 'ertrag', 1),
(25, '3050', 'sonst. ErtrÃ¤ge', 'ertrag', 1),
(26, '4000', 'FÃ¶rderung gemeinnÃ¼tziger Organisationen', 'aufwand', 1),
(27, '4010', 'Nebenkosten des Geldverkehrs', 'aufwand', 1),
(28, '4020', 'GebÃ¼hren fÃ¼r Dienstleistungen und Lizenzen', 'aufwand', 1),
(29, '4030', 'BÃ¼romaterial', 'aufwand', 1),
(30, '4040', 'Porto', 'aufwand', 1),
(31, '4050', 'Reisekosten', 'aufwand', 1),
(32, '4060', 'Spesen', 'aufwand', 1),
(33, '4070', 'RÃ¼ckerstattungen der MitgliedsbeitrÃ¤ge', 'aufwand', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spendenquittungen`
--

CREATE TABLE `spendenquittungen` (
  `ID` int(11) NOT NULL,
  `nr_spendenquittung` varchar(100) DEFAULT NULL,
  `id_benutzer` int(11) NOT NULL,
  `summe` double NOT NULL,
  `datum` date NOT NULL,
  `freistellung_vom` text,
  `vorstand` text,
  `absender_nachname` varchar(255) DEFAULT NULL,
  `absender_vorname` varchar(255) DEFAULT NULL,
  `absender_strasse` varchar(255) DEFAULT NULL,
  `absender_plz` varchar(255) DEFAULT NULL,
  `absender_ort` varchar(255) DEFAULT NULL,
  `absender_telefonnummer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `spendenquittungen`
--

INSERT INTO `spendenquittungen` (`ID`, `nr_spendenquittung`, `id_benutzer`, `summe`, `datum`, `freistellung_vom`, `vorstand`, `absender_nachname`, `absender_vorname`, `absender_strasse`, `absender_plz`, `absender_ort`, `absender_telefonnummer`) VALUES
(1, '2020_1', 1, 1430, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(2, '2020_2', 27, 180, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(3, '2020_3', 28, 102, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(4, '2020_4', 7, 64.5, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(5, '2020_5', 24, 290, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(6, '2020_6', 23, 120, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(7, '2020_7', 22, 40, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(8, '2020_8', 21, 240, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(9, '2020_9', 20, 120, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(10, '2020_10', 18, 2650, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(11, '2020_11', 17, 40, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(12, '2020_12', 16, 120, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(13, '2020_13', 12, 60, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(14, '2020_14', 11, 60, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(15, '2020_15', 9, 120, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(16, '2020_16', 14, 72, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(17, '2020_17', 15, 87, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(18, '2020_18', 10, 12, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(19, '2020_19', 19, 12, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(20, '2020_20', 29, 25, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(21, '2020_21', 13, 25, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(22, '2020_22', 8, 30, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(23, '2020_23', 26, 120, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(24, '2020_24', 4, 898.12, '2020-02-07', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(25, '2020_25', 43, 60, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(26, '2020_26', 44, 240, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(27, '2020_27', 45, 125, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(28, '2020_28', 50, 0, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(29, '2020_29', 51, 25, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(30, '2020_30', 52, 30, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(31, '2020_31', 53, 50, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(32, '2020_32', 49, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(33, '2020_33', 31, 25, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(34, '2020_34', 47, 100, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(35, '2020_35', 46, 100, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(36, '2020_36', 5, 20, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(37, '2020_37', 6, 20, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(38, '2020_38', 25, 240, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(39, '2020_39', 42, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(40, '2020_40', 15, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(41, '2020_41', 41, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(42, '2020_42', 14, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(43, '2020_43', 40, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(44, '2020_44', 39, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(45, '2020_45', 38, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(46, '2020_46', 37, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(47, '2020_47', 36, 12, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(48, '2020_48', 35, 25, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(49, '2020_49', 34, 50, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(50, '2020_50', 33, 80, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(51, '2020_51', 32, 100, '2020-02-28', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(52, '2020_52', 32, 750, '2020-03-14', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(53, '2020_53', 54, 250, '2020-03-14', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713'),
(54, '2020_54', 55, 100, '2020-03-14', 'Wir sind wegen Förderung des Völkerverständigungsgedankens durch Bescheinigung des Finanzamtes Coburg, StNr. 212/108/30739, vom 21.08.2019 als gemeinnützig anerkannt.', '1. Vorsitzender: Arkadiusz Paluszek, 2. Vorsitzender: Tom Hollander, Kassenwartin: Anja Hollander', 'Paluszek', 'Arkadiusz', 'Neustadter Srt. 48', '96487', 'DÃ¶rfles-Esbach', '2134321684713');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teilbuchungen`
--

CREATE TABLE `teilbuchungen` (
  `ID` int(11) NOT NULL,
  `id_buchung` int(11) NOT NULL,
  `kommentar` varchar(255) DEFAULT NULL,
  `id_deb_kred` int(11) DEFAULT NULL,
  `id_konto_soll` int(11) NOT NULL,
  `id_konto_haben` int(11) NOT NULL,
  `summe` double NOT NULL,
  `nr_spendenquittung` varchar(255) DEFAULT '0',
  `gesperrt` tinyint(4) NOT NULL DEFAULT '0',
  `id_jahr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teilbuchungen`
--

INSERT INTO `teilbuchungen` (`ID`, `id_buchung`, `kommentar`, `id_deb_kred`, `id_konto_soll`, `id_konto_haben`, `summe`, `nr_spendenquittung`, `gesperrt`, `id_jahr`) VALUES
(2, 2, '', 1, 15, 20, 50, '2020_1', 1, 3),
(3, 3, 'Beitrag Nicolas Six', 27, 15, 20, 45, '2020_2', 1, 3),
(4, 3, 'Beitrag Ãœn Calo', 28, 15, 20, 8.5, '2020_3', 1, 3),
(5, 3, 'Beitrag Sebastian Triebel ', 7, 15, 20, 10, '2020_4', 1, 3),
(6, 3, 'Beitrag M.D. Nakajima', 24, 15, 20, 20, '2020_5', 1, 3),
(7, 3, 'Beitrag Georg Mellert', 23, 15, 20, 10, '2020_6', 1, 3),
(8, 3, 'Beitrag Lisa Leybold', 22, 15, 20, 10, '2020_7', 1, 3),
(9, 3, 'Beitrag A. Kranert', 21, 15, 20, 20, '2020_8', 1, 3),
(10, 3, 'Beitrag Koch Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(11, 3, 'Beitrag Ing.BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(12, 3, 'Beitrag Armin Geray', 17, 15, 20, 10, '2020_11', 1, 3),
(13, 3, 'Beitrag Birgit Friedrich', 16, 15, 20, 10, '2020_12', 1, 3),
(14, 3, 'Beitrag Steffen Enes', 12, 15, 20, 5, '2020_13', 1, 3),
(15, 3, 'Beitrag K.Dillinger', 11, 15, 20, 5, '2020_14', 1, 3),
(16, 3, 'Beitrag Johanna Bruisch', 9, 15, 20, 10, '2020_15', 1, 3),
(17, 4, 'Beitrag Martin Fleischmann', 14, 15, 20, 15, '2020_16', 1, 3),
(18, 4, 'Beitrag Christian Freydorf', 15, 15, 20, 15, '2020_17', 1, 3),
(47, 7, 'Beitrag Ing.BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(48, 7, 'Beitrag Johanna Bruisch', 9, 15, 20, 10, '2020_15', 1, 3),
(49, 7, 'Beitrag Stefanie Burkard', 10, 15, 20, 12, '2020_18', 1, 3),
(50, 7, 'Beitrag Katrin Dillinger', 11, 15, 20, 5, '2020_14', 1, 3),
(51, 7, 'Beitrag Enes Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(52, 7, 'Beitrag Birgit Friedrich', 16, 15, 20, 10, '2020_12', 1, 3),
(53, 7, 'Beitrag Elisabeth Hesse', 19, 15, 20, 12, '2020_19', 1, 3),
(54, 7, 'Beitrag Koch Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(55, 7, 'Beitrag Andrea Kranert', 21, 15, 20, 20, '2020_8', 1, 3),
(56, 7, 'Beitrag Georg Mellert', 23, 15, 20, 10, '2020_6', 1, 3),
(57, 7, 'Beitrag M.D. Nakajima', 24, 15, 20, 20, '2020_5', 1, 3),
(58, 7, 'Beitrag Sebastian Triebel', 7, 15, 20, 10, '2020_4', 1, 3),
(59, 7, 'Beitrag Calo Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(60, 6, 'Beitrag Ing.BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(61, 6, 'Beitrag Johanna Bruisch', 9, 15, 20, 10, '2020_15', 1, 3),
(62, 6, 'Beitrag Stefanie Burkard', 10, 15, 20, 12, '2020_18', 1, 3),
(63, 6, 'Beitrag Katrin Dillinger', 11, 15, 20, 5, '2020_14', 1, 3),
(64, 6, 'Beitrag Enes Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(65, 6, 'Beitrag Birgit Friedrich', 16, 15, 20, 10, '2020_12', 1, 3),
(66, 6, 'Beitrag Elisabeth Hesse', 19, 15, 20, 12, '2020_19', 1, 3),
(67, 6, 'Beitrag Koch Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(68, 6, 'Beitrag Andrea Kranert', 21, 15, 20, 20, '2020_8', 1, 3),
(69, 6, 'Beitrag Georg Mellert', 23, 15, 20, 10, '2020_6', 1, 3),
(70, 6, 'Beitrag M.D. Nakajima', 24, 15, 20, 20, '2020_5', 1, 3),
(71, 6, 'Beitrag Sebastian Triebel', 7, 15, 20, 10, '2020_4', 1, 3),
(72, 6, 'Beitrag Calo Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(73, 8, 'Calo Ãœn', 28, 33, 15, 8.5, '2020_3', 1, 3),
(74, 8, 'Sebastian Triebel', 7, 33, 15, 10, '2020_4', 1, 3),
(75, 8, 'M.D. Nakajima', 24, 33, 15, 20, '2020_5', 1, 3),
(76, 8, 'Georg Mellert', 23, 33, 15, 10, '2020_6', 1, 3),
(77, 8, 'Andrea Kranert', 21, 33, 15, 20, '2020_8', 1, 3),
(78, 8, 'Julia Koch', 20, 33, 15, 10, '2020_9', 1, 3),
(79, 8, 'Elisabeth Hesse', 19, 33, 15, 12, '2020_19', 1, 3),
(80, 8, 'Birgit Friedrich', 16, 33, 15, 10, '2020_12', 1, 3),
(81, 8, 'Steffen Enes', 12, 33, 15, 5, '2020_13', 1, 3),
(82, 8, 'Katrin Dillinger', 11, 33, 15, 5, '2020_14', 1, 3),
(83, 8, 'Stefanie Burkard', 10, 33, 15, 12, '2020_18', 1, 3),
(84, 8, 'Johanna Bruisch', 9, 33, 15, 10, '2020_15', 1, 3),
(85, 9, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(86, 9, 'ZV-Entgelte', 0, 27, 15, 7.6, '0', 1, 3),
(87, 10, 'Diakonie Hochfranken ', 0, 15, 21, 297, '0', 1, 3),
(88, 11, 'Beitrag Flori und Arek Paluszek', 1, 15, 20, 300, '2020_1', 1, 3),
(89, 12, 'Beitrag Ruben Werchan', 29, 15, 20, 25, '2020_20', 1, 3),
(90, 12, 'Beitrag Calo Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(91, 12, 'Beitrag Sebastian Triebel', 7, 15, 20, 10, '2020_4', 1, 3),
(92, 12, 'Beitrag M.D. Nakajima', 24, 15, 20, 20, '2020_5', 1, 3),
(93, 12, 'Beitrag Georg Mellert', 23, 15, 20, 10, '2020_6', 1, 3),
(94, 12, 'Beitrag Andrea Kranert', 21, 15, 20, 20, '2020_8', 1, 3),
(95, 12, 'Beitrag Julia Koch', 20, 15, 20, 10, '2020_9', 1, 3),
(96, 12, 'Beitrag Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(97, 12, 'Beitrag Birgit Friedrich', 16, 15, 20, 10, '2020_12', 1, 3),
(98, 12, 'Beitrag Jessica Fleischer', 13, 15, 20, 25, '2020_21', 1, 3),
(99, 12, 'Beitrag Steffen Enes', 12, 15, 20, 5, '2020_13', 1, 3),
(100, 12, 'Beitrag Katrin Dillinger', 11, 15, 20, 5, '2020_14', 1, 3),
(101, 12, 'Beitrag Johanna Bruisch', 9, 15, 20, 10, '2020_15', 1, 3),
(102, 12, 'Beitrag Franz Aschenbrenner', 8, 15, 20, 7.5, '2020_22', 1, 3),
(104, 14, 'Spende an Chr. Philantropie', 0, 26, 15, 500, '0', 1, 3),
(105, 14, 'GebÃ¼hr AuslandsÃ¼berweisung', 0, 27, 15, 35, '0', 1, 3),
(106, 15, '', 0, 27, 15, 6.1, '0', 1, 3),
(124, 16, 'Johanna Bruisch', 9, 15, 20, 10, '2020_15', 1, 3),
(125, 16, 'Katrin Dillinger', 11, 15, 20, 5, '2020_14', 1, 3),
(126, 16, 'Steffen Enes', 12, 15, 20, 5, '2020_13', 1, 3),
(127, 16, 'Martin Fleischmann', 14, 15, 20, 15, '2020_16', 1, 3),
(128, 16, 'Christoph Freydorf', 15, 15, 20, 15, '2020_17', 1, 3),
(129, 16, 'Birgitt Friedrich', 16, 15, 20, 10, '2020_12', 1, 3),
(130, 16, 'Armin Geray', 17, 15, 20, 10, '2020_11', 1, 3),
(131, 16, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(132, 16, 'Julia Koch', 20, 15, 20, 10, '2020_9', 1, 3),
(133, 16, 'Andrea Kranert', 21, 15, 20, 20, '2020_8', 1, 3),
(134, 16, 'Lisa Leybold', 22, 15, 20, 10, '2020_7', 1, 3),
(135, 16, 'Georg Mellert', 23, 15, 20, 10, '2020_6', 1, 3),
(136, 16, 'M. D. Nakajima', 24, 15, 20, 20, '2020_5', 1, 3),
(137, 16, 'Dr. Alice Rabeler', 26, 15, 20, 60, '2020_23', 1, 3),
(138, 16, 'Nicolas Six', 27, 15, 20, 45, '2020_2', 1, 3),
(139, 16, 'Ãœn Calo', 28, 15, 20, 8.5, '2020_3', 1, 3),
(140, 16, 'Sebastian Triebel', 7, 15, 20, 10, '2020_4', 1, 3),
(141, 13, 'Spende fÃ¼r Orhei Ing.BÃ¼ro Haas', 18, 15, 22, 1000, '2020_10', 1, 3),
(142, 17, 'Arek Paluszek', 1, 15, 20, 100, '2020_1', 1, 3),
(144, 18, 'Arek Paluszek', 1, 15, 20, 550, '2020_1', 1, 3),
(148, 20, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(149, 20, 'ZV-Entgelte', 0, 27, 15, 3.8, '0', 1, 3),
(151, 22, 'christl. Philanthropie', 0, 26, 15, 1200, '0', 1, 3),
(152, 23, '', 0, 27, 15, 35, '0', 1, 3),
(153, 24, '', 0, 15, 22, 5, '0', 1, 3),
(154, 25, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(155, 25, 'ZV-Entgelte', 0, 27, 15, 2.8, '0', 1, 3),
(156, 26, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(157, 26, 'ZV-Entgelte', 0, 27, 15, 2.4, '0', 1, 3),
(159, 28, 'Landesjustizkasse Bamberg', 0, 28, 15, 10, '0', 1, 3),
(163, 31, 'RÃ¼cklastschrift Sebastian Triebel', 7, 33, 15, 15.5, '2020_4', 1, 3),
(164, 30, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(165, 30, 'ZV-Entgelte', 0, 27, 15, 3.8, '0', 1, 3),
(166, 29, '', 1, 15, 22, 50, '2020_1', 1, 3),
(167, 32, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(168, 32, 'ZV-Entgelte', 0, 27, 15, 2.6, '0', 1, 3),
(169, 33, 'Spende Tom', 4, 15, 22, 500, '2020_24', 1, 3),
(172, 35, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(173, 35, 'ZV-Entgelte', 0, 27, 15, 2.6, '0', 1, 3),
(174, 36, 'Traukollekte Tom u Anja Hollander', 4, 15, 22, 386.12, '2020_24', 1, 3),
(175, 37, 'Spende fÃ¼r Moldawien flori-software', 0, 15, 22, 590, '0', 1, 3),
(176, 38, 'Arek Paluszek', 1, 15, 20, 70, '2020_1', 1, 3),
(177, 39, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(178, 39, 'ZV-Entgelte', 0, 27, 15, 4.2, '0', 1, 3),
(179, 40, 'Spende Nothilfefond Orhei Arek', 1, 15, 22, 100, '2020_1', 1, 3),
(180, 41, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(181, 41, 'ZV-Entgelte', 0, 27, 15, 3, '0', 1, 3),
(182, 42, 'Arek Paluszek', 1, 15, 22, 40, '2020_1', 1, 3),
(183, 43, 'StandgebÃ¼hr bezahlt Arek Spende', 1, 28, 22, 20, '2020_1', 1, 3),
(197, 45, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(198, 45, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(199, 45, 'Entgelt 5. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(202, 48, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(203, 48, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(204, 48, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(205, 49, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(206, 49, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(207, 49, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(208, 50, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(209, 50, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(210, 50, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(211, 51, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(212, 51, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(213, 51, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(214, 52, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(215, 52, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(216, 52, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(218, 54, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(219, 54, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(220, 54, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(221, 55, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(222, 55, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(223, 55, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(224, 56, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(225, 56, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(226, 56, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(236, 61, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(237, 61, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(238, 61, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(240, 63, 'KontofÃ¼hrungsentgelt', 0, 27, 19, 1.95, '0', 1, 3),
(241, 63, 'Porto', 0, 27, 19, 1.35, '0', 1, 3),
(242, 63, 'Entgelt 3. Debitkarte', 0, 27, 19, 0.5, '0', 1, 3),
(247, 67, 'Auslagen', 0, 27, 16, 15, '0', 1, 3),
(251, 71, 'Auslagen', 0, 27, 16, 15, '0', 1, 3),
(255, 75, 'Auslagen', 0, 27, 16, 15, '0', 1, 3),
(258, 78, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(259, 78, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(260, 78, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(261, 78, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(262, 78, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(263, 78, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(264, 78, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(265, 78, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(266, 78, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(267, 78, 'Triebel, Sebastian', 7, 15, 20, 10, '2020_4', 1, 3),
(268, 78, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(269, 79, 'Aschenbrenner, Franz', 8, 15, 20, 7.5, '2020_22', 1, 3),
(270, 79, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(271, 79, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(272, 79, 'Steffen, Enes', 12, 15, 20, 5, '2020_13', 1, 3),
(273, 79, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(274, 79, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(275, 79, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(276, 79, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(277, 79, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(278, 79, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(279, 79, 'Triebel, Sebastian', 7, 15, 20, 10, '2020_4', 1, 3),
(280, 79, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(281, 80, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(282, 80, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(283, 80, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(284, 80, 'Fleischmann, Martin', 14, 15, 20, 15, '2020_16', 1, 3),
(285, 80, 'Freydorf, Christoph', 15, 15, 20, 15, '2020_17', 1, 3),
(286, 80, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(287, 80, 'Geray, Armin', 17, 15, 20, 10, '2020_11', 1, 3),
(288, 80, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(289, 80, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(290, 80, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(291, 80, 'Leybold, Lisa', 22, 15, 20, 10, '2020_7', 1, 3),
(292, 80, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(293, 80, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(294, 80, 'Six, Nicolas', 27, 15, 20, 45, '2020_2', 1, 3),
(295, 80, 'Triebel, Sebastian', 7, 15, 20, 10, '2020_4', 1, 3),
(296, 80, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(297, 81, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(298, 81, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(299, 81, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(300, 81, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(301, 81, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(302, 81, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(303, 81, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(304, 81, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(305, 81, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(306, 81, 'Freydorf, Christoph', 15, 15, 20, 15, '2020_17', 1, 3),
(307, 81, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(308, 81, 'Triebel, Sebastian', 7, 15, 20, 10, '2020_4', 1, 3),
(332, 83, 'Aschenbrenner, Franz', 8, 15, 20, 7.5, '2020_22', 1, 3),
(333, 83, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(334, 83, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(335, 83, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(336, 83, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(337, 83, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(338, 83, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(339, 83, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(340, 83, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(341, 83, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(342, 83, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(343, 84, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(344, 84, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(345, 84, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(346, 84, 'Fleischmann, Martin', 14, 15, 20, 15, '2020_16', 1, 3),
(347, 84, 'Freydorf, Christoph', 15, 15, 20, 15, '2020_17', 1, 3),
(348, 84, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(349, 84, 'Geray, Armin', 17, 15, 20, 10, '2020_11', 1, 3),
(350, 84, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(351, 84, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(352, 84, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(353, 84, 'Leybold, Lisa', 22, 15, 20, 10, '2020_7', 1, 3),
(354, 84, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(355, 84, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(356, 84, 'Six, Nicolas', 27, 15, 20, 45, '2020_2', 1, 3),
(357, 84, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(358, 85, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(359, 85, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(360, 85, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(361, 85, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(362, 85, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(363, 85, 'Hollander, Tom', 4, 15, 20, 12, '2020_24', 1, 3),
(364, 85, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(365, 85, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(366, 85, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(367, 85, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(368, 85, 'Rabeler, Dr. Alice', 26, 15, 20, 60, '2020_23', 1, 3),
(369, 85, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(372, 87, 'Nakajima, M.D., von Arek', 24, 15, 20, 50, '2020_5', 1, 3),
(373, 88, 'Aschenbrenner, Franz', 8, 15, 20, 7.5, '2020_22', 1, 3),
(374, 88, 'Bruisch, Johanna', 9, 15, 20, 10, '2020_15', 1, 3),
(375, 88, 'Dillinger, Katrin', 11, 15, 20, 5, '2020_14', 1, 3),
(376, 88, 'Enes, Steffen', 12, 15, 20, 5, '2020_13', 1, 3),
(377, 88, 'Friedrich, Birgitt', 16, 15, 20, 10, '2020_12', 1, 3),
(378, 88, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 50, '2020_10', 1, 3),
(379, 88, 'Koch, Julia', 20, 15, 20, 10, '2020_9', 1, 3),
(380, 88, 'Kranert, Andrea', 21, 15, 20, 20, '2020_8', 1, 3),
(381, 88, 'Mellert, Georg', 23, 15, 20, 10, '2020_6', 1, 3),
(382, 88, 'Nakajima, M.D.', 24, 15, 20, 20, '2020_5', 1, 3),
(383, 88, 'Calo, Ãœn', 28, 15, 20, 8.5, '2020_3', 1, 3),
(385, 90, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 22, 1000, '2020_10', 1, 3),
(386, 91, 'Arek Paluszek', 1, 15, 20, 150, '2020_1', 1, 3),
(387, 92, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(388, 92, 'ZV-Entgelte', 0, 27, 15, 3, '0', 1, 3),
(394, 5, 'Pauschalen', 0, 27, 15, 2.5, '0', 1, 3),
(395, 5, 'ZV-Entgelte', 0, 27, 15, 3.6, '0', 1, 3),
(396, 21, 'Spende fÃ¼r Cosmina', 0, 26, 15, 500, '0', 1, 3),
(397, 86, 'christl Philanthropie', 0, 26, 15, 500, '0', 1, 3),
(398, 86, 'Auslandszahlungsverkehr', 0, 27, 15, 35, '0', 1, 3),
(399, 1, 'Tulcea erste Ãœberweisung', 0, 26, 15, 500, '0', 1, 3),
(413, 89, 'Fu Hai Dang', 43, 15, 20, 5, '2020_25', 1, 3),
(414, 77, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(415, 64, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(416, 46, 'Keil, Norbert', 44, 19, 22, 80, '2020_26', 1, 3),
(417, 47, 'Fischer, Dr. Dietrich', 45, 19, 22, 100, '2020_27', 1, 3),
(418, 65, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(419, 66, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(420, 68, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(421, 69, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(422, 70, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(423, 62, 'Keil, Norbert', 44, 19, 22, 80, '2020_26', 1, 3),
(424, 76, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(425, 60, 'Bill, Sonja, fehlerhafte IBAN', 50, 33, 19, 12, '2020_28', 1, 3),
(426, 60, 'RÃ¼ckÃ¼berweisung', 0, 27, 19, 3, '0', 1, 3),
(427, 58, 'Bill, Sonja', 50, 19, 20, 12, '2020_28', 1, 3),
(428, 58, 'Wagner, Peter', 51, 19, 20, 25, '2020_29', 1, 3),
(429, 58, 'Fischer, Dr. Dieter', 45, 19, 20, 25, '2020_27', 1, 3),
(430, 58, 'Quentin, Anna', 52, 19, 20, 30, '2020_30', 1, 3),
(431, 58, 'Bill, Elisabeth', 53, 19, 20, 50, '2020_31', 1, 3),
(432, 57, 'Klose, Stefan', 49, 19, 20, 12, '2020_32', 1, 3),
(433, 57, 'Wagner, Johannes', 31, 19, 20, 25, '2020_33', 1, 3),
(434, 74, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(435, 34, 'jÃ¤hrl. Spende Michael Wohlfromm', 47, 15, 22, 100, '2020_34', 1, 3),
(436, 73, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(437, 72, 'Fu Hai Dang', 43, 16, 20, 5, '2020_25', 1, 3),
(438, 27, 'Jana Kraft', 46, 15, 22, 100, '2020_35', 1, 3),
(439, 53, 'Keil, Norbert', 44, 19, 22, 80, '2020_26', 1, 3),
(440, 93, 'Dietel, Jannika', 5, 15, 20, 20, '2020_36', 1, 3),
(441, 93, 'Engelhardt, Christian', 6, 15, 20, 20, '2020_37', 1, 3),
(442, 93, 'Naser, Markus', 25, 15, 20, 240, '2020_38', 1, 3),
(443, 44, 'Stenzel, Bastian', 42, 19, 20, 12, '2020_39', 1, 3),
(444, 44, 'Freydorf, Christoph', 15, 19, 20, 12, '2020_40', 1, 3),
(445, 44, 'Schmidt, Barbara', 41, 19, 20, 12, '2020_41', 1, 3),
(446, 44, 'Fleischmann, Martin', 14, 19, 20, 12, '2020_42', 1, 3),
(447, 44, 'Schweibold, Robert', 40, 19, 20, 12, '2020_43', 1, 3),
(448, 44, 'Hammerschmitt, Markus', 39, 19, 20, 12, '2020_44', 1, 3),
(449, 44, 'Wagner, Holger', 38, 19, 20, 12, '2020_45', 1, 3),
(450, 44, 'Renninger, Ines', 37, 19, 20, 12, '2020_46', 1, 3),
(451, 44, 'Viegelahn, Christian', 36, 19, 20, 12, '2020_47', 1, 3),
(452, 44, 'Fichtner, Albert', 35, 19, 20, 25, '2020_48', 1, 3),
(453, 44, 'Stenzel, Ute', 34, 19, 20, 50, '2020_49', 1, 3),
(454, 44, 'Poerzgen, Yvonne', 33, 19, 20, 80, '2020_50', 1, 3),
(455, 44, 'Seuffert, Martin, Jahresbeitrag', 32, 19, 20, 100, '2020_51', 1, 3),
(456, 94, 'Spende Martin Seuffert', 32, 19, 22, 750, '2020_52', 1, 3),
(459, 97, 'KontofÃ¼hrungsgebÃ¼hren', 0, 27, 19, 3.8, '0', 1, 3),
(460, 96, 'Spende Helmut PÃ¼rner', 54, 19, 22, 250, '2020_53', 1, 3),
(461, 95, 'Spende Axel Heine', 55, 19, 22, 100, '2020_54', 1, 3),
(463, 98, 'Bruisch, Johanna', 9, 15, 20, 10, '0', 0, 6),
(464, 98, 'Dillinger, Katrin', 11, 15, 20, 5, '0', 0, 6),
(465, 98, 'Enes, Steffen', 12, 15, 20, 5, '0', 0, 6),
(466, 98, 'Friedrich, Birgit', 16, 15, 20, 10, '0', 0, 6),
(467, 98, 'Geray, Armin', 17, 15, 20, 10, '0', 0, 6),
(468, 98, 'Haas u Holler', 18, 15, 20, 50, '0', 0, 6),
(469, 98, 'Koch, Julia', 20, 15, 20, 10, '0', 0, 6),
(470, 98, 'Kranert, Andrea', 21, 15, 20, 20, '0', 0, 6),
(471, 98, 'Leybold, Lisa', 22, 15, 20, 10, '0', 0, 6),
(472, 98, 'mellert, georg', 23, 15, 20, 10, '0', 0, 6),
(473, 98, 'Daishi', 24, 15, 20, 20, '0', 0, 6),
(474, 98, 'Ãœn Calo', 28, 15, 20, 8.5, '0', 0, 6),
(475, 98, 'six, nicolas', 27, 15, 20, 45, '0', 0, 6),
(476, 98, 'Dietel, Jannika', 5, 15, 20, 20, '0', 0, 6),
(477, 98, 'fleischmann, martin', 14, 15, 20, 15, '0', 0, 6),
(478, 98, 'freydorf, christoph', 15, 15, 20, 15, '0', 0, 6),
(482, 100, 'Fu Hai Dang', 43, 15, 20, 5, '0', 0, 6),
(483, 101, 'Grundpreis', 0, 27, 15, 2.5, '0', 0, 6),
(484, 101, 'Zahlungsverkehr', 0, 27, 15, 3.6, '0', 0, 6),
(485, 102, 'Fischer, Dietrich', 45, 15, 20, 100, '0', 0, 6),
(486, 103, 'Pater Richard Stark lt. Kooperationsvertrag', 0, 26, 15, 1200, '0', 0, 6),
(487, 103, 'Auslandszahlungsverkehr', 0, 27, 15, 35, '0', 0, 6),
(488, 99, 'OBSTEASCA AS. UMANITARA  FILANTROPIA CRESTINA', 0, 26, 15, 1200, '0', 0, 6),
(489, 99, 'Auslandszahlungsverkehr', 0, 27, 15, 35, '0', 0, 6),
(491, 104, 'OBSTEASCA AS. UMANITARA  FILANTROPIA CRESTINA', 0, 26, 15, 2000, '0', 0, 6),
(492, 104, 'Auslandszahlungsverkehr', 0, 27, 15, 35, '0', 0, 6),
(495, 107, 'Fu Hai Dang', 43, 15, 20, 5, '0', 0, 6),
(496, 105, 'Bruisch, Johanna', 9, 15, 20, 10, '0', 0, 6),
(497, 105, 'Burkard, Stefanie', 10, 15, 20, 12, '0', 0, 6),
(498, 105, 'Dillinger, Katrin', 11, 15, 20, 5, '0', 0, 6),
(499, 105, 'enes, Steffen', 12, 15, 20, 5, '0', 0, 6),
(500, 105, 'friedrich, birgit', 16, 15, 20, 10, '0', 0, 6),
(501, 105, 'hesse, elisabeth', 19, 15, 20, 12, '0', 0, 6),
(502, 105, 'haas u holler', 18, 15, 20, 50, '0', 0, 6),
(503, 105, 'koch, julia', 20, 15, 20, 10, '0', 0, 6),
(504, 105, 'kranert, andrea', 21, 15, 20, 20, '0', 0, 6),
(505, 105, 'mellert, georg', 23, 15, 20, 10, '0', 0, 6),
(506, 105, 'Daishi', 24, 15, 20, 20, '0', 0, 6),
(507, 105, 'Ãœn Calo', 28, 15, 20, 8.5, '0', 0, 6),
(512, 108, 'AuflÃ¶sung konto VR Bank Coburg', 0, 25, 16, 248.39, '0', 0, 6),
(513, 108, '', 0, 15, 25, 248.39, '0', 0, 6),
(514, 109, 'Spende Daishiro Nakajima', 24, 16, 22, 100, '0', 1, 3),
(515, 110, 'Kontoabschluss', 0, 27, 16, 15, '0', 1, 3),
(516, 106, 'Arek und Florentina', 1, 15, 20, 850, '0', 0, 6),
(517, 111, 'Grundpreis', 0, 27, 15, 2.5, '0', 0, 6),
(518, 111, 'Zahlungsverkehr', 0, 27, 15, 3.6, '0', 0, 6),
(519, 112, 'Aschenbrenner, Franz', 8, 15, 20, 7.5, '0', 0, 6),
(520, 112, 'Bruisch, Johanna', 9, 15, 20, 10, '0', 0, 6),
(521, 112, 'Dillinger, Katrin', 11, 15, 20, 5, '0', 0, 6),
(522, 112, 'Enes, Steffen', 12, 15, 20, 5, '0', 0, 6),
(523, 112, 'Fleischer, Jessica', 13, 15, 20, 25, '0', 0, 6),
(524, 112, 'Friedrich, Birgitt', 16, 15, 20, 10, '0', 0, 6),
(525, 112, 'Ing. BÃ¼ro Haas u. Holler', 18, 15, 20, 50, '0', 0, 6),
(526, 112, 'Koch, Julia', 20, 15, 20, 10, '0', 0, 6),
(527, 112, 'Kranert, Andrea', 21, 15, 20, 20, '0', 0, 6),
(528, 112, 'Mellert, Georg', 23, 15, 20, 10, '0', 0, 6),
(529, 112, 'Nakajima, M. D.', 24, 15, 20, 20, '0', 0, 6),
(530, 112, 'Calo, Ãœn', 28, 15, 20, 8.5, '0', 0, 6),
(531, 112, 'Ruben, Werchan', 29, 15, 20, 25, '0', 0, 6),
(532, 112, 'Engelhardt, Christian', 6, 15, 20, 20, '0', 0, 6),
(534, 114, 'Nachtunterkunft Moldawien', 0, 15, 23, 3000, '0', 0, 6),
(535, 115, 'Fu Hai Dang', 43, 15, 20, 5, '0', 0, 6),
(536, 116, 'KontofÃ¼hrungsentgelt', 0, 27, 15, 2.5, '0', 0, 6),
(537, 116, 'ZV-Entgelte', 0, 27, 15, 3.4, '0', 0, 6),
(539, 117, 'Sozialzentrum', 0, 26, 15, 1000, '0', 0, 6),
(540, 117, 'Auslandszahlungsverkehr', 0, 27, 15, 35, '0', 0, 6),
(541, 118, 'christl. Philanthropie', 0, 26, 15, 900, '0', 0, 6),
(542, 118, 'Auslandszahlungsverkehr', 0, 27, 15, 35, '0', 0, 6),
(544, 119, 'Ing. BÃ¼ro Haas & Holler', 18, 15, 20, 500, '0', 0, 6),
(545, 120, 'Fu Hai Dang', 43, 15, 20, 5, '0', 0, 6),
(546, 121, 'KontofÃ¼hrungsentgelt', 0, 27, 15, 2.5, '0', 0, 6),
(547, 121, 'Zahlungsverkehr', 0, 27, 15, 0.8, '0', 0, 6),
(548, 122, 'amazon smile', 0, 15, 22, 5, '0', 0, 6),
(549, 123, 'Arek Paluszek', 1, 15, 20, 560, '0', 0, 6),
(550, 113, 'VorstandsÃ¤nderung', 0, 28, 15, 50, '0', 0, 6);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `abschluesse`
--
ALTER TABLE `abschluesse`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `abschluesse_konten`
--
ALTER TABLE `abschluesse_konten`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `anfangssalden`
--
ALTER TABLE `anfangssalden`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `Benutzer`
--
ALTER TABLE `Benutzer`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `buchungen`
--
ALTER TABLE `buchungen`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `ich`
--
ALTER TABLE `ich`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `jahr`
--
ALTER TABLE `jahr`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `kontenplan`
--
ALTER TABLE `kontenplan`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `spendenquittungen`
--
ALTER TABLE `spendenquittungen`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `teilbuchungen`
--
ALTER TABLE `teilbuchungen`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `abschluesse`
--
ALTER TABLE `abschluesse`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `abschluesse_konten`
--
ALTER TABLE `abschluesse_konten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT für Tabelle `anfangssalden`
--
ALTER TABLE `anfangssalden`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT für Tabelle `Benutzer`
--
ALTER TABLE `Benutzer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT für Tabelle `buchungen`
--
ALTER TABLE `buchungen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT für Tabelle `jahr`
--
ALTER TABLE `jahr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `kontenplan`
--
ALTER TABLE `kontenplan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT für Tabelle `spendenquittungen`
--
ALTER TABLE `spendenquittungen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT für Tabelle `teilbuchungen`
--
ALTER TABLE `teilbuchungen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=551;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
