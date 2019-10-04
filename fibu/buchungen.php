<?php

include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
echo '<script src="klassen/tools.js"></script>';

// Funktionalität
$aktion = GetMyVar("aktion", "");
if($aktion == "buchung_speichern") {
    $buchung = new buchung;
    $buchung->formular_lesen();
    echo 'Speichern zu Ende<p>';
}

// Formular
$alle_benutzer = Benutzer::namen_aller_benutzer();
#print_r($alle_benutzer);
if($aktion == "jahr_aktivieren") {
    $jahr = new jahr($_GET["id"]);
}

echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();
echo 'Jahre gelesen<p>';



foreach($jahre as $jahr) {
    echo '<a href="buchungen.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
if(isset($_SESSION["jahr"])) {
    echo 'Buchungen&nbsp;
    <img src="pics/neu.png" id="neue_buchung"
    onmouseover="f_change_pic(\'neue_buchung\', \'pics/neu_selected.png\')"
    onmouseout="f_change_pic(\'neue_buchung\', \'pics/neu.png\')"
    onclick="eingabeformular_ein_ausblenden(1)"><p>';
    
    $buchungen = buchung::lesen_alle();
    foreach ($buchungen as $buchung) {
        echo '<table rules="all">
        <tr class="zeile_orange" style="font-size: 16px;">
        <td style="width: 15%;">'.date_to_datum($buchung->datum).'</td>
        <td style="width: 40%;">'.$buchung->kommentar.'</td>
        <td>
        
        </td>
        </tr>
        </table>';
    }
    
    echo '<div id="eingabe_buchung" style="background-color: gold; border-radius: 20px; padding: 15px; z-index: 2; display: none;">
    <img src="pics/wegblendkreuz.png" style="position: relative; top: 0px; left: 0px;" onclick="eingabeformular_ein_ausblenden(0)">
    <form action="buchungen.php?aktion=buchung_speichern" method="POST">
    <table>
    <tr><td>Datum</td><td>Kommentar</td></tr>
    <tr><td><input type="date" name="datum" style="font-size: 14px;"></td>
    <td><input name="kommentar" size="40"></td><td><input type="submit" value="Buchungssatz speichern"></td></tr></table>
    <table><tr><td>Soll</td><td>Haben</td><td>Kommentar</td><td>Kre- oder Debitor</td><td>Summe</td></tr>';
    for($cnt = 0; $cnt < 20; $cnt++) {
        echo '<tr><td><select name="id_konto_soll'.$cnt.'">';
        databasedropdown_filtered_2("kontenplan", "nr", "bezeichnung", 0, "aktiv", 1);
        echo '</select></td><td><select name="id_konto_haben'.$cnt.'">';
        databasedropdown_filtered_2("kontenplan", "nr", "bezeichnung", 0, "aktiv", 1);
        echo '</select></td>
        <td><input size="40" name="kommentar'.$cnt.'"></td>
        <td><select name="id_deb_kred'.$cnt.'">
        <option value="">--</option>';
        dropdown_array_personenobjekte($alle_benutzer, 0, "Debitoren", "debitoren");
        echo '</select></td>
        <td><input type="number" step="0.01" name="summe'.$cnt.'"></td></tr>';
    }
    echo '</table></form></div><hr>';
}
include "page_end.php";
?>
<script>
$(document).ready(function(){
    $("#eingabe_buchung").draggable({});
})
function eingabeformular_ein_ausblenden(zustand) {
    if(zustand == 0) {
        $("#eingabe_buchung").fadeOut("slow");
    } else {
        $("#eingabe_buchung").fadeIn("slow");
    }
}
</script>
