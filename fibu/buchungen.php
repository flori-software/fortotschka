<?php

include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
include "klassen/datev_format.php";
echo '<script src="klassen/tools_v2.js"></script>';

// Funktionalität
$aktion          = GetMyVar("aktion", "");
$aktion_formular = "buchung_speichern";
$ich             = new ich;


switch ($aktion) {
    case 'buchung_speichern':
        $buchung = new buchung;
        $buchung->formular_lesen();
        echo 'Buchungssatz gespeichert<p>';
        // Damit das Eingabeformular nach dem Speichern einer Buchung wieder leer wird, wird die Variable $buchung hier zurückgesetzt
        $buchung = new buchung;
    break;
    
    case 'buchung_bearbeiten':
        $buchung = new buchung;
        $buchung->ID = $_GET["id"];
        echo 'Übergebene ID der Buchung ist '.$buchung->ID.'<br>';
        $buchung->lesen();
        $aktion_formular = "bearbeitete_buchung_speichern&id=".$buchung->ID;
    break;

    case 'bearbeitete_buchung_speichern':
        $buchung = new buchung;
        $buchung->ID = $_GET["id"];
        $buchung->formular_lesen("bearbeiten");
        echo 'Buchungssatz gespeichert<p>';
        // Damit das Eingabeformular nach dem Speichern einer Buchung wieder leer wird, wird die Variable $buchung hier zurückgesetzt
        $buchung = new buchung;
    break;

    case 'buchung_loeschen':
        $buchung = new buchung;
        $buchung->ID = $_GET["id"];
        $buchung->loeschen();
    break;

    case 'jahr_aktivieren':
        $jahr = new jahr($_GET["id"]);
    break;

    case 'exporteinstellungen_speichern':
        echo 'Speichere DATEV Einstellungen<br>';
        $ich->datev_beginn_wirtschaftsjahr = $_POST["beginn_wirtschaftsjahr"] ?? "2023-11-01";
        $ich->datev_kontenrahmen           = $_POST["kontenrahmen"] ?? "SKR03";
        $ich->datev_beraternummer          = $_POST["beraternummer"] ?? 1;
        $ich->datev_mandantennummer        = $_POST["mandantennummer"] ?? 1;
        $ich->datev_konto_forderungen      = $_POST["konto_forderungen"] ?? 0;
        $ich->datev_gegenkonto_aufwand     = $_POST["gegenkonto_aufwand"] ?? 0;
        $ich->datev_einstellungen_speichern();
    break;


        
        
}

echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();
echo 'Jahre gelesen<p>';

$alle_benutzer = Benutzer::namen_aller_benutzer();

foreach($jahre as $jahr) {
    echo '<a href="buchungen.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
// An dieser Stelle folgt eine Checkbox mit dem Label "Export" - wenn sie angeklickt wird, wird das darauffolgende DIV-Element eingeblendet (welches standardsmäßig ausgeblendet ist) und in dem wir dann Einstellungen für den Export der Daten vornehmen können

$ich->get_datev_einstellungen();

echo '<br><input type="checkbox" id="export" onclick="bereich_durch_checkbox_ein_ausblenden(\'export\', \'export_einstellungen\')">Export';
echo '<div id="export_einstellungen" style="display: none; background-color: lightgray; border-radius: 10px; padding: 10px;">
<form action="buchungen.php?aktion=exporteinstellungen_speichern" method="POST">
<table>
<tr><td>Beginn Wirtschaftsjahr</td><td>Kontenrahmen</td><td>Beraternummer</td><td>Mandantennummer</td><td>Konto Forderungen</td></tr>
<tr>
<td><input type="date" name="beginn_wirtschaftsjahr" value="'.$ich->datev_beginn_wirtschaftsjahr.'"></td>
<td><select name="kontenrahmen">';
$namen_kontenrahmen = Array("SKR 03", "SKR 04", "SKR 45 soziale Einrichtungen nach PBV", "SKR 49");
$kontenrahmen = Array("SKR03", "SKR04", "SKR45", "SKR49");
multidropdown($namen_kontenrahmen, $kontenrahmen, $ich->datev_kontenrahmen);
echo '</select></td>
<td><input type="number" name="beraternummer" value="'.$ich->datev_beraternummer.'"></td>
<td><input type="number" name="mandantennummer" value="'.$ich->datev_mandantennummer.'"></td>
<td><input type="number" name="konto_forderungen" value="'.$ich->datev_konto_forderungen.'"></td>
</tr>
<tr>
<td colspan="4"></td>
<td>Gegenkonto Aufwand</td>
</tr>
<tr>
<td colspan="4"></td>
<td><input type="number" name="gegenkonto_aufwand" value="'.$ich->datev_gegenkonto_aufwand.'"></td>
</tr>
</table>
<input type="submit" value="Einstellungen speichern">
</form>
<hr>
<form action="datev_export.php" target="_blank" method="POST">';
// Zwei Radiobuttons mit den LAbeln 'Alel nicht exportierten Buchungen' und 'Buchungen zwischen den folgenden Nr.:', anschließend zwei inputfelder für die Buchungsnummern
echo '<input type="radio" name="export" value="nicht_exportiert" checked>Alle nicht exportierten Buchungen<br>
<input type="radio" name="export" value="buchungsnummern">Buchungen zwischen den folgenden Nr.:<br>
<input type="number" name="buchungsnummer_von" value="0"><br>
<input type="number" name="buchungsnummer_bis" value="0"><br>';
echo '<input type="submit" value="Exportieren">
</div>';


if(isset($_SESSION["jahr"])) {
    echo ' - aktives Gesch&auml;ftsjahr ist '.$_SESSION["jahr"].'<br>'; 
    echo 'Buchungen&nbsp;
    <img src="pics/neu.png" id="neue_buchung"
    onmouseover="f_change_pic(\'neue_buchung\', \'pics/neu_selected.png\')"
    onmouseout="f_change_pic(\'neue_buchung\', \'pics/neu.png\')"
    onclick="eingabeformular_ein_ausblenden(1)"><p>';
    if(strpos($aktion_formular, "bearbeitete_buchung_speichern") > -1) {
        $display = "";
    } else {
        $display = "display: none;";
    }
    echo '<div id="eingabe_buchung" style="background-color: gold; border-radius: 20px; padding: 15px; z-index: 2; position: absolute; top: 400px; '.$display.'">
    <img src="pics/wegblendkreuz.png" style="position: relative; top: 0px; left: 0px;" onclick="eingabeformular_ein_ausblenden(0)">
    <form action="buchungen.php?aktion='.$aktion_formular.'" method="POST">
    <table>
    <tr><td>Datum</td><td>Kommentar</td></tr>
    <tr><td><input type="date" name="datum" style="font-size: 14px;" value="'.$buchung->datum.'"></td>
    <td><input name="kommentar" size="40" value="'.$buchung->kommentar.'"></td><td><input type="submit" value="Buchungssatz speichern"></td></tr></table>
    <table><tr><td>Soll</td><td>Haben</td><td>Kommentar</td><td>Kre- oder Debitor</td><td>Summe</td></tr>';
    for($cnt = 0; $cnt < 20; $cnt++) {
        echo '<tr id="zeile'.$cnt.'"';
        if($cnt > 0 && !isset($buchung->teilbuchungen[$cnt])) {echo 'style="display: none;"';}
        echo '><td><select name="id_konto_soll'.$cnt.'">';
        databasedropdown_filtered_2("kontenplan", "nr", "bezeichnung", $buchung->teilbuchungen[$cnt]->id_konto_soll, "aktiv", 1);
        echo '</select></td><td><select name="id_konto_haben'.$cnt.'">';
        databasedropdown_filtered_2("kontenplan", "nr", "bezeichnung", $buchung->teilbuchungen[$cnt]->id_konto_haben, "aktiv", 1);
        echo '</select></td>
        <td><input size="40" name="kommentar'.$cnt.'" value="'.$buchung->teilbuchungen[$cnt]->kommentar.'"></td>
        <td><select name="id_deb_kred'.$cnt.'">
        <option value="">--</option>';
        dropdown_array_personenobjekte($alle_benutzer, $buchung->teilbuchungen[$cnt]->id_deb_kred, "Debitoren", "debitoren");
        echo '</select></td>
        <td><input type="number" step="0.01" name="summe'.$cnt.'" value="'.$buchung->teilbuchungen[$cnt]->summe.'"></td>
        <td><img src="pics/neu.png" id="neue_buchung"
        onmouseover="f_change_pic(\'neue_buchung\', \'pics/neu_selected.png\')"
        onmouseout="f_change_pic(\'neue_buchung\', \'pics/neu.png\')"
        onclick="naechste_zeile_einblenden('.$cnt.')"></td></tr>';
    }
    echo '</table></form></div>';

    $buchungen = buchung::lesen_alle($jahr->datum_von, $jahr->datum_bis);

    $backgroundcolor = "antiquewhite";
    foreach ($buchungen as $key=>$buchung) {
        if($backgroundcolor == "antiquewhite") {
            $backgroundcolor = "navajowhite";
        } else {
            $backgroundcolor = "antiquewhite";
        }
        echo '<div style="background-color:'.$backgroundcolor.'; border-radius: 10px; padding: 10px;"><table rules="all">
        <tr class="zeile_orange" style="font-size: 16px; color: firebrick;">
        <td>Nr. '.$buchung->ID.'</td><td style="width: 15%;">'.date_to_datum($buchung->datum).'</td>
        <td style="width: 40%;">'.$buchung->kommentar.'</td>
        <td>';
        if($buchung->exportiert == 1) {
            echo '<span style="color: black;">exportiert</span>';
        } else {
            echo 'nicht exportiert';
        }
        echo '</td><td>';
        if($buchung->gesperrt == 0) {
            echo '<a href="buchungen.php?aktion=buchung_bearbeiten&id='.$buchung->ID.'"><img src="pics/stift.png" id="stift'.$key.'"
            onmouseover="f_change_pic(\'stift'.$key.'\', \'pics/stift_selected.png\')"
            onmouseout="f_change_pic(\'stift'.$key.'\', \'pics/stift.png\')"></a>&nbsp;
            <img src="pics/loeschen.png" id="loeschen'.$key.'"
            onmouseover="f_change_pic(\'loeschen'.$key.'\', \'pics/loeschen_selected.png\')"
            onmouseout="f_change_pic(\'loeschen'.$key.'\', \'pics/loeschen.png\')"
            onclick="buchung_loeschen('.$buchung->ID.')">&nbsp;';
        }
        echo '</td></tr></table>
        <table rules="all" style="font-size: 14px;">
        <tr><th>Soll</th><th>Haben</th><th>Kommentar</th><th>Debitor</th><th>Summe</th></tr>';
        $buchungskonten = Array();
        foreach ($buchung->teilbuchungen as $teilbuchung) {
            // Die Zeile mit der Teilbuchung wird dargestellt
            $konto_soll  = gesuchter_wert($teilbuchung->id_konto_soll, "kontenplan", "nr")." ".gesuchter_wert($teilbuchung->id_konto_soll, "kontenplan", "bezeichnung");
            $konto_haben = gesuchter_wert($teilbuchung->id_konto_haben, "kontenplan", "nr")." ".gesuchter_wert($teilbuchung->id_konto_haben, "kontenplan", "bezeichnung");
            $de_kreditor = gesuchter_wert($teilbuchung->id_deb_kred, "Benutzer", "benutzername");
            echo '<tr class="zeile_orange" style="color: gray;">
            <td>'.$konto_soll.'</td><td>'.$konto_haben.'</td><td>'.$teilbuchung->kommentar.'</td><td>'.$de_kreditor.'</td><td style="color: blue;">'.zahl_de($teilbuchung->summe).'</td>
            </tr>';

            // Die Umsätze werden in Cluster sortiert um am Ende eine Zusammenfassung der Buchung anzuzeigen
            if($teilbuchung->id_konto_soll  > 0) {$buchungskonten["soll"][$konto_soll] += $teilbuchung->summe;}
            if($teilbuchung->id_konto_haben > 0) {$buchungskonten["haben"][$konto_haben] += $teilbuchung->summe;}
        }
        echo '</table><br>
        <table rules="all" style="font-weight: bold;">
        <tr><td>Konto</td><td>Soll</td><td>Haben</td></tr>';
        
        foreach($buchungskonten["soll"] as $key=>$zahl) {
            echo '<tr><td>'.$key.'</td><td>'.zahl_de($zahl).'</td><td></td></tr>';
        }
        
        foreach($buchungskonten["haben"] as $key=>$zahl) {
            echo '<tr><td>'.$key.'</td><td></td><td>'.zahl_de($zahl).'</td></tr>';
        }
        
        echo '</table>';
        echo '</div>';
    }
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

function buchung_loeschen(id) {
    if(confirm("Soll diese Buchung dauerhaft entfernt werden?")) {
        window.location.href = "buchungen.php?aktion=buchung_loeschen&id=" + id;
    }
}

function naechste_zeile_einblenden(cnt) {
    cnt++;
    $("#zeile" + cnt).fadeIn("slow");
}
</script>
