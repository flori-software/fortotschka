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
    $buchung->speichern();
}

// Formular
$alle_benutzer = Benutzer::namen_aller_benutzer();

echo 'Buchungen<p>
<form action="buchungen.php?aktion=buchung_speichern" method="POST">
<table>
<tr><td>Datum</td><td>Soll</td><td>Haben</td><td>Beschreibung des Umsatzes</td><td>Summe</td><td>Debitor</td></tr>
<tr><td><input type="date" name="datum" style="font-size: 14px;"></td>
<td><input name="soll" id="soll_nr" size="6" onchange="konto_finden(\'soll\')"><input type="hidden" id="soll"></td>
<td><input name="haben" id="haben_nr" size="6" onchange="konto_finden(\'haben\')"><input type="hidden" id="haben"></td>
<td><input name="kommentar" size="40"></td>
<td><input name="summe"></td>
<td>';

echo '<select name="debitor">';

dropdown_array_personenobjekte($alle_benutzer, 0, "Debitoren", "debitoren");
echo '</select></td></tr>
<tr><td></td><td><div id="kontobezeichnung_soll"></div></td><td><div id="kontobezeichnung_haben"></div></td>
<td colspan="2"></td><td><input type="submit" value="Buchungssatz speichern"></td></tr>
</table></form><hr>';



include "page_end.php";
?>
<script>
function konto_finden(soll_haben) {
    var nr_konto = document.getElementById(soll_haben + "_nr").value;
    mein_link = "klassen/REQUESTS.php?aktion=konto_finden&nr_konto=" + nr_konto + "&soll_haben=" + soll_haben;
    console.log(mein_link);
    resOb = erzXHRObjekt();
    resOb.open('get', mein_link, false);
    resOb.onreadystatechange = konto_anzeigen;
    resOb.send(null);
}

function konto_anzeigen() {
    if(resOb.readyState == 4) {
        myArray=new Array;
        myText=resOb.responseText;
        console.log(myText);
        myArray=myText.split("#");
        
        var nr_konto    = myArray[0];
        var soll_haben  = myArray[1];
        var id_konto    = myArray[2];
        var bezeichnung = myArray[3];

        document.getElementById(soll_haben).value = id_konto;
        document.getElementById("kontobezeichnung_" + soll_haben).innerHTML = bezeichnung;
    }
}
</script>