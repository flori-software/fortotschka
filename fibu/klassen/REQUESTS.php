<?php
include "FUNCTIONS.php";
include "klassen_fibu.php";
include "klasse_personen.php";

$aktion = $_GET["aktion"];
#echo "Übermitelte Aktion ist ".$aktion."<br>";
switch ($aktion) {
    case 'konto_finden':
        $nr_konto    = $_GET["nr_konto"];
        #echo "Nr Konto ist ".$nr_konto."<br>";
        $soll_haben  = $_GET["soll_haben"];
        $id_konto    = gesuchtes_feld($nr_konto, "kontenplan", "nr", "ID");
        $bezeichnung = gesuchtes_feld($nr_konto, "kontenplan", "nr", "bezeichnung");
        echo $nr_konto."#".$soll_haben."#".$id_konto."#".$bezeichnung;
    break;
}


?>