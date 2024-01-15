ALTER TABLE `ich` ADD `datev_beginn_wirtschaftsjahr` DATE NULL AFTER `freistellungsbescheid_vom`, ADD `datev_kontenrahmen` VARCHAR(255) NULL AFTER `datev_beginn_wirtschaftsjahr`, ADD `datev_beraternummer` INT NULL AFTER `datev_kontenrahmen`, ADD `datev_mandantennummer` INT NULL AFTER `datev_beraternummer`, ADD `datev_konto_forderungen` INT NULL AFTER `datev_mandantennummer`, ADD `datev_gegenkonto_aufwand` INT NULL AFTER `datev_konto_forderungen`;

ALTER TABLE `buchungen` ADD `exportiert` TINYINT NULL DEFAULT '0' AFTER `gesperrt`;