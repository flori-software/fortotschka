<?php
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
echo '<script src="klassen/tools.js"></script>';

echo 'Spendenbescheinigungen<p>';


echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();


$alle_benutzer = Benutzer::namen_aller_benutzer();

foreach($jahre as $jahr) {
    echo '<a href="buchungen.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
if(isset($_SESSION["jahr"])) {
    echo ' - aktives Gesch&auml;ftsjahr ist '.$_SESSION["jahr"].'<br>'; 
    spendenquittung::anzeige_offene_teilbuchungen();
}

include "page_end.php";
?>