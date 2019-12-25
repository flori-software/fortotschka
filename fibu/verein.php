<?php
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";

$ich = new ich;

$aktion = GetMyVar("aktion", "");
if($aktion == "speichern") {
    $ich->formular_lesen();
    $ich->bearbeiten();
}

echo '<form action="verein.php?aktion=speichern" method="POST">
<input name="vereinsname" size="60" placeholder="Vereinsname" value="'.$ich->vereinsname.'"><br>
<input name="adresszeile" size="60" placeholder="Adresszeile" value="'.$ich->adresszeile.'"><br>
<input name="strasse" size="60" placeholder="Strasse" value="'.$ich->strasse.'"><br>
<input name="plz" size="20" placeholder="PLZ" value="'.$ich->plz.'">&nbsp;&nbsp;
<input name="ort" size="55" placeholder="Ort" value="'.$ich->ort.'"><br>
<input name="telefonnummer" size="60" placeholder="Telefonnummer" value="'.$ich->telefonnummer.'"><br>
<input name="email" size="60" placeholder="e-mail" value="'.$ich->email.'"><br>
<textarea name="vorstand" placeholder="Vorstand" rows="5" cols="40">'.$ich->vorstand.'</textarea><br>
<textarea name="freistellungsbescheid_vom" placeholder="Text mit dem Verweis auf den letzten Freistellungsbescheid" rows="5" cols="40">'.$ich->freistellungsbescheid_vom.'</textarea><br>
<br><input type="submit" value="Vereinsdaten &auml;ndern">
</form>';






?>