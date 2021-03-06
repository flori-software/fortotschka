<?php

include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
echo '<script src="klassen/tools.js"></script>';

// Funktionalität
$aktion          = GetMyVar("aktion", "");
$aktion_formular = "buchung_speichern";

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
}

echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();
echo 'Jahre gelesen<p>';

$alle_benutzer = Benutzer::namen_aller_benutzer();

foreach($jahre as $jahr) {
    echo '<a href="buchungen.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
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
