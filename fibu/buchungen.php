<?php

include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
echo '<script src="klassen/tools.js"></script>';
// Funktionalität
$aktion = GetMyVar("aktion", "");
if($aktion == "buchung_speichern") {
    echo 'Aktion Buchung speichern<br>';
    $buchung = new buchung;
    echo 'Objekt BUCHUNG gebildet <br>';
    $buchung->formular_lesen();
    echo 'Speichern zu Ende<p>';
} else {
    echo 'Keine Aktion erkannt<br>';
}

// Formular
$alle_benutzer = Benutzer::namen_aller_benutzer();
#print_r($alle_benutzer);

echo 'Buchungen<p>
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
    <td><input type="number" name="summe'.$cnt.'"></td></tr>';
}
echo '</table></form><hr>';



include "page_end.php";
?>
