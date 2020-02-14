
CREATE TABLE `abschluesse` (
  `ID` int(11) NOT NULL,
  `id_jahr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `abschluesse`
  ADD PRIMARY KEY (`ID`);
  
ALTER TABLE `abschluesse`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `abschluesse` ADD `eigenkapital` DOUBLE NOT NULL AFTER `id_jahr`, ADD `ergebnis` DOUBLE NOT NULL AFTER `eigenkapital`;


CREATE TABLE `abschluesse_konten` (
  `ID` int(11) NOT NULL,
  `id_abschluss` int(11) NOT NULL,
  `id_konto` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `saldo_anfang` double NOT NULL,
  `bewegung` double NOT NULL,
  `saldo_ende` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `abschluesse_konten`
  ADD PRIMARY KEY (`ID`);
  
ALTER TABLE `abschluesse_konten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
