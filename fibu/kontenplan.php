<?php
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";

$aktion=GetMyVar("aktion", "nix");

if ($aktion == "jahr_anlegen") {
    $jahr = new jahr(); 
    $jahr->speichern();
    echo "Gesch&auml;ftsjahr angelegt<p>";
}

if($aktion == "konto_anlegen") {
    $konto = new konto;
    $konto->speichern();
    echo "Konto angelegt<p>";
}

if($aktion == "jahr_aktivieren") {
    $jahr = new jahr($_GET["id"]);
}

echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();
echo 'Jahre gelesen<p>';
foreach($jahre as $jahr) {
    echo '<a href="kontenplan.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
if(isset($_SESSION["jahr"])) {
    echo ' - aktives Gesch&auml;ftsjahr ist '.$_SESSION["jahr"].'<br>';   

    echo '<form action="kontenplan.php?aktion=jahr_anlegen" method="POST" >
    Von:&nbsp;<input type="date" name="datum_von">
    &nbsp;Bis:&nbsp;<input type="date" name="datum_bis">&nbsp;
    <input name="jahr" placeholder="Jahr">&nbsp;
    <input type="submit" value="Gesch&auml;ftsjahr anlegen"> <br> <hr>
    </form>


    Kontenplan<p>
    <form action="kontenplan.php?aktion=konto_anlegen" method="POST">
    <input name="nr" placeholder="Nummer"   > <br> 
    <input name="bezeichnung" placeholder="Bezeichnung" size="100"   > <br> 

    <select name="art">
    <option value="aktiva">Aktiva</option> 
    <option value="passiva">Passiva </option>
    <option value="aufwand">Aufwand </option>
    <option value="ertrag">Ertrag </option>


    </select> 

    <input name="saldo_anfang" placeholder="Anfangssaldo">
    <input type="submit" value="Konto speichern"> 

    </form>
    <table>
    <tr>';

    $kontenarten = Array("Aktiva", "Passiva", "Ertrag", "Aufwand");
    foreach ($kontenarten as $art) {
        echo '<td><div style="background-color: burlywood; border-radius: 20px; padding: 10px;">'.$art.'<br>';
        $konten = konto::lesen_ueberischt_kontenart($art);
        echo '<table>';
        $gesamtwert_seite_anfang  = 0;
        $gesamtwert_seite_aktuell = 0;
        foreach ($konten as $konto) {
            echo '<tr><td>'.$konto->nr.'</td><td>'.$konto->bezeichnung.'</td><td>'.zahl_de($konto->saldo_anfang).'</td></tr>';
            $gesamtwert_seite_anfang += $konto->saldo_anfang;
        }
        echo '<tr><td colspan="6"><hr></td></tr>
        <tr><td colspan="2"><td>'.zahl_de($gesamtwert_seite_anfang).'</td></tr>
        </table>
        </div></td>';

    }
    echo '</tr>
    </table>';
}

include "page_end.php";
?>