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
    $spendenquittungen = spendenquittung::lese_daten_offene_teilbuchungen();

    foreach($spendenquittungen as $spendenquittung) {
        echo '<div style="background-color: firebrick; color: white; height: 25px; border-radius: 5px; padding: 3px; font-size: 14px;">'.
        $spendenquittung->debitor->nachname.", ".$spendenquittung->debitor->vorname.'</div>';
        echo '<table rules="all"><tr><td>Datum</td><td>Kommentar</td><td>Summe</td></tr>';
        foreach($spendenquittung->teilbuchungen as $teilbuchung) {
            echo '<tr><td>'.date_to_datum($teilbuchung->datum).'</td><td>'.$teilbuchung->kommentar_hauptbuchung.'</td><td>'.zahl_de($teilbuchung->summe).'</td></tr>';
        }
        echo '<tr><td colspan="2"></td><td>'.zahl_de($spendenquittung->summe).'</td></tr></table><p>';
    }
}

include "page_end.php";
?>