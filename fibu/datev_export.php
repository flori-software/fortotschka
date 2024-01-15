<?php
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
include "klassen/datev_format.php";

$buchungen = Array();
if($_POST["export"] == "nicht_exportiert") {
    $buchungen = buchung::lesen_alle(nicht_exportierte: 1);
} else {
    $buchungen = buchung::lesen_alle(nr_von: $_POST["buchungsnummer_von"], nr_bis: $_POST["buchungsnummer_bis"]);
}
buchung::datev_export($buchungen);


?>