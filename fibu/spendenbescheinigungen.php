<?php
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
echo '<script src="klassen/tools_v2.js"></script>
<style>

.alle_spendenquittungen {
    background-color: darksalmon;
    font-size: 20px;
    width: 600px;
    padding: 10px;
    border-radius: 5px;
}    

.debitor {
    background-color: peachpuff;
    height: 25px;
    border-radius: 5px;
    padding: 3px;
    font-size: 14px;
}
 
</style>';

$aktion = GetMyVar("aktion", "");

if($aktion == "erstellen_fuer_alle_mandanten") {
    $spendenquittungen = spendenquittung::lese_daten_offene_teilbuchungen();
    spendenquittung::spendenquittungen_erstellen($spendenquittungen);
} elseif($aktion == "einzelbescheinigung") {
    $id_debitor = $_GET["id_debitor"];
    $spendenquittungen = spendenquittung::lese_daten_offene_teilbuchungen($id_debitor); // Zu erwarten ist ein Array mit einem einzigen Element - dem Cluster mit der Spendenquittung des Debitors
    spendenquittung::spendenquittungen_erstellen($spendenquittungen);
}



echo 'Spendenbescheinigungen<p>';


echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();


$alle_benutzer = Benutzer::namen_aller_benutzer();

foreach($jahre as $jahr) {
    echo '<a href="buchungen.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
if(isset($_SESSION["jahr"])) {
    echo ' - aktives Gesch&auml;ftsjahr ist '.$_SESSION["jahr"].'<br>'; 

    // ANZEIGE ALLER SPENDEN FÜR DIE BISHER KEINE SPENDENQUITTUNG ERSTELLT WURDE

    echo '<a href="spendenbescheinigungen.php?aktion=erstellen_fuer_alle_mandanten"><div class="alle_spendenquittungen">Spendenquittungen f&uuml;r alle Debitoren erstellen</div></a><p>';
    $spendenquittungen = spendenquittung::lese_daten_offene_teilbuchungen();

    foreach($spendenquittungen as $spendenquittung) {
        echo '<div class="debitor">'.
        $spendenquittung->debitor->nachname.", ".$spendenquittung->debitor->vorname.'
        <a href="spendenbescheinigungen.php?aktion=einzelbescheinigung&id_debitor='.$spendenquittung->debitor->ID.'"><span style="position: absolute; left: 300px;">Spendenbescheinigung erstellen</span></a></div>';
        echo '<table rules="all"><tr><td>Datum</td><td>Kommentar</td><td>Summe</td></tr>';
        foreach($spendenquittung->teilbuchungen as $teilbuchung) {
            echo '<tr><td>'.date_to_datum($teilbuchung->datum).'</td><td>'.$teilbuchung->kommentar_hauptbuchung.'</td><td>'.zahl_de($teilbuchung->summe).'</td></tr>';
        }
        echo '<tr><td colspan="2"></td><td>'.zahl_de($spendenquittung->summe).'</td></tr></table><p>';
    }

    // ANZEIGE ALLER BISHER ERSTELLTEN SPENDENQUITTUNGEN
    $spendenquittungen = spendenquittung::uebersicht_alle_spendenquittungen();
    echo '<p class="my_title">Bisher erstellte Spendenquittungen: </p>
    <table rules="all"><tr style="background-color: yellow;"><td>Datum</td><td>Nr. Spendenquittung</td><td>Spender</td><td>Summe</td></tr>';
    
    foreach($spendenquittungen as $spendenquittung) {
        echo '<tr style="background-color: white;"><td>'.$spendenquittung->datum.'</td><td>'.$spendenquittung->nr_spendenquittung.'</td><td>'.$spendenquittung->debitor.'</td><td>'.zahl_de($spendenquittung->summe).'</td>
        <td>&nbsp;<a href="spendenbescheinigung_zeigen.php?id='.$spendenquittung->ID.'"><img src="pics/monitor.png" id="monitor'.$spendenquittung->nr_spendenquittung.'" 
        onmouseover="f_change_pic(\'monitor'.$spendenquittung->nr_spendenquittung.'\', \'pics/monitor_selected.png\')"
        onmouseout="f_change_pic(\'monitor'.$spendenquittung->nr_spendenquittung.'\', \'pics/monitor.png\')"></a>&nbsp;</td></tr>';
    }
    echo '</table>';
}

include "page_end.php";
?>