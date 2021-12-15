<?php
session_start();
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";
include "klassen/c3po.php";

$member = new Benutzer;
if(isset($_GET["id"])) {
    $member->ID = $_GET["id"];
}
else {
    $member->ID = $_SESSION["id_benutzer"];
}
$member->get_benutzerdaten();


if(isset($_GET["aktion"])) {
    $aktion = $_GET["aktion"];
}
else {
    $aktion = 0;
}

if($aktion === "bearbeiten") {
    $member->formular_benutzerdaten_lesen();
}

if($aktion === "neuer_benutzer") {
    $benutzername = $_POST["benutzername"];
    $passwort     = $_POST["passwort"];
    $passwort2    = $_POST["passwort2"];
    if($benutzername != "" && $passwort == $passwort2) {
        Benutzer::neuen_speichern($benutzername, $passwort);
    }
    elseif($benutzername == "") {
        echo "Es muss ein Benutzername eingegeben werden, um einen neuen Benutzer zu speichern.<p>";
    }
    else {
        echo "Die eingegebenen Passw&ouml;rter waren nicht identisch.<p>";
    }
}

if($aktion === "benutzerdaten_zeigen") {
    // Die oeben gelesenen Daten des eingeloggten Benutzers werden jetzt mit den Daten des ausgewählten Benutzers überschrieben
    $member->get_benutzerdaten();
}


echo '<form action="mein_konto.php?aktion=bearbeiten&id='.$member->ID.'" method="POST">';

echo '<input name="benutzername" id="benutzername" placeholder="Benutzername" value="'.$member->benutzername.'" style="width: 70%; background-color: '.$input_hintergrundfarbe.';"><br>
<input name="vorname" id="vorname" placeholder="Vorname" value="'.$member->vorname.'" style="width: 28%; background-color: '.$input_hintergrundfarbe.';">&nbsp;
<input name="nachname" id="nachname" placeholder="Nachname" value="'.$member->nachname.'" style="width: 28%; background-color: '.$input_hintergrundfarbe.';"><br>
<input name="strasse" id="strasse" placeholder="Strasse" style="width: 70%; background-color: '.$input_hintergrundfarbe.';" value="'.$member->kontakt->strasse.'"><br>
<input name="plz" id="plz" placeholder="PLZ" style="width: 15%; background-color: '.$input_hintergrundfarbe.';" value="'.$member->kontakt->plz.'">&nbsp;
<input name="ort" id="ort" placeholder="Ort" style="width: 53%; background-color: '.$input_hintergrundfarbe.';" value="'.$member->kontakt->ort.'"><br>';

echo '<input type="tel" name="telefonnummer" placeholder="Festnetztelefon" value="'.$member->kontakt->telefonnummer.'" style="width: 34%;">&nbsp;
<input type="tel" name="mobil" placeholder="Mobiltelefon" value="'.$member->kontakt->mobil.'" style="width: 34%;">&nbsp;
<input type="email" name="email" id="email" placeholder="Email" value="'.$member->kontakt->email.'" style="width: 34%; background-color: '.$input_hintergrundfarbe.';"><br>
<input type="password" name="passwort" id="passwort" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="Passwort">&nbsp;
<input type="password" name="passwort2" id="passwort2" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="Passwort wiederholen"><br>';
if($_SESSION["admin"] == 1) {
    echo '<input type="checkbox" style="padding: 5px; border-radius: 2px; width: 20px;" name="admin" value="1" ';
    if($member->admin == 1) {echo " checked";}
    echo '> <span style="font-size: 20px; font-weight: lighter;">Admin</span><br>';
}

echo '
<input name="iban" placeholder="IBAN" value="'.$member->iban.'"> &nbsp;
<input name="bic" placeholder="BIC"  value="'.$member->bic.'">  <br> 
<input name="mandatsreferenznummer" placeholder="Mandatsreferenz" value="'.$member->mandatsreferenznummer.'" > <br> 
<input name="monatsbeitrag" placeholder="Monatsbeitrag" value="'.$member->monatsbeitrag.'" > <br> 



<table border="0">
<tr> 
<td> <input name="januar" type="checkbox" value="1"';
checkbox($member->monate[1]);  
echo '> Januar </td>    
<td> <input name="juli" type="checkbox" value="1"';
checkbox($member->monate[7]); 
echo '> Juli  </td>
</tr>

<tr> 
<td> <input name="februar" type="checkbox" value="1"';
checkbox($member->monate[2]);  
echo'> Februar </td>    
<td> <input name="august" type="checkbox" value="1" '; 
checkbox($member->monate[8]); 
echo '> August</td>
</tr>

<tr> 
<td> <input name="maerz" type="checkbox" value="1" ';
checkbox($member->monate[3]);
echo '> M&aumlrz </td>    
<td> <input name="september" type="checkbox" value="1" '; 
checkbox($member->monate[9]); 
echo '> September </td>
</tr>

<tr>
<td> <input name="april" type="checkbox" value="1" '; 
checkbox($member->monate[4]); 
echo '> April </td>        
<td> <input name="oktober" type="checkbox" value="1" '; 
checkbox($member->monate[10]);
echo '> Oktober </td>
</tr>

<tr>
<td> <input name="mai" type="checkbox" value="1"';
checkbox($member->monate[5]); 
echo '> Mai </td>             
<td> <input name="november" type="checkbox" value="1"'; 
checkbox($member->monate[11]); 
echo '> November </td>
</tr>
 
<tr> 
<td> <input name="juni" type="checkbox" value="1" '; 
checkbox($member->monate[6]); 
echo '> Juni </td>        
<td> <input name="dezember" type="checkbox" value="1" '; 
checkbox($member->monate[12]); 
echo '> Dezember </td>
</tr>

</table> 


';



echo '<input style="background-color: moccasin;" type="submit" value="Daten &auml;ndern" id="speichern"></form>';	

echo '<table border="0">';


echo '</tr>';
if($_SESSION["admin"] == 1) {
    echo '<tr><td colspan="3"><input style="background-color: moccasin;" type="submit" value="Gekaufte Artikel speichern" id="speichern"></td></tr>';
}
echo '</form>';
// ADMINISTRATORBEREICH

echo '</table>';
echo '<hr><form action="mein_konto.php?aktion=neuer_benutzer" method="POST">
<span style="font-size: 20px; font-weight: lighter;">Neuer Benutzer:</span><br>
<input name="benutzername" id="benutzername" placeholder="Benutzername / username" style="width: 70%; background-color: '.$input_hintergrundfarbe.';"><br>
<input type="password" name="passwort" id="passwort" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="Passwort / password">&nbsp;
<input type="password" name="passwort2" id="passwort2" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="repeat password"><br>
<input style="background-color: moccasin;" type="submit" value="Neuen Benutzer Speichern" id="speichern"></form>
<hr>
<span style="font-size: 20px; font-weight: lighter;">Registrierte Benutzer:</span><br>';
$members = Benutzer::namen_aller_benutzer();
$gezeigte_mitglieder = 0;
echo '<table border="0">';
foreach ($members as $member) {
    if($gezeigte_mitglieder == 0) {echo '<tr>';}
    echo '<td><div style="background-color: firebrick; color: white; height: 20px; border-radius: 10px; padding: 5px; width: auto; whitespace: nowrap;" onclick="benutzerdaten_zeigen('.$member->ID.')">'.$member->benutzername.'</div></td>';
    $gezeigte_mitglieder++;
    if($gezeigte_mitglieder == 8) {
        echo '</tr>';
        $gezeigte_mitglieder = 0;
    }
}
echo '</table><p>';

// Übersicht über die monatlichen Lastschriften
echo '<p><a href="mein_konto.php?anzeige_mitglieder=alle">Alle Mitglieder zeigen</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mein_konto.php">Nur Mitglieder mit Einzugsdaten</a></p>';
$anzeige_mitglieder = $_GET["anzeige_mitglieder"] ?? "";

echo '<table rules="all">
<tr><td style="width: ">Mitglied</td><td>IBAN</td><td style="width: 100px;">Januar</td><td style="width: 100px;">Februar</td>
<td style="width: 100px;">M&auml;rz</td><td style="width: 100px;">April</td><td style="width: 100px;">Mai</td>
<td style="width: 100px;">Juni</td><td style="width: 100px;">Juli</td><td style="width: 100px;">August</td>
<td style="width: 100px;">September</td><td style="width: 100px;">Oktober</td><td style="width: 100px;">November</td><td style="width: 100px;">Dezember</td></tr>';
$summen_pro_monat = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

// Anzeige der Beiträge des jeweiligen Mitglieds
foreach($members as $member) {
    if($member->einzugsdaten_vorhanden() == true || $anzeige_mitglieder == "alle") {
        echo '<tr id="zeile_weiss"><td>'.$member->benutzername.'</td><td>'.$member->iban.'</td>';
        $summe_mitglied = 0;
        for($cnt = 1; $cnt <=12; $cnt++) {
            echo '<td>';
            if($member->monate[$cnt] == 1) {
                echo zahl_de($member->monatsbeitrag);
                $summen_pro_monat[$cnt] += $member->monatsbeitrag;
                $summe_mitglied         += $member->monatsbeitrag;
            }
            echo '</td>';
        }
        echo '<td style="font-weight: bold;">'.$summe_mitglied.'</td></tr>';
    } 
}
// Anzeige der Summen pro Monat
$jahressumme = 0;
echo '<tr><td></td><td></td>';
for($cnt = 1; $cnt <=12; $cnt++) {
    echo '<td style="font-weight: bold;">';
    echo zahl_de($summen_pro_monat[$cnt]);
    $jahressumme += $summen_pro_monat[$cnt];
    echo '</td>';
}
echo '<td style="font-weight: bold; font-size: 14px;">'.zahl_de($jahressumme).'</td></tr>';

echo '</table>';

include "page_end.php";

?>
<script>
function benutzerdaten_zeigen(id) {
    window.location.href = "mein_konto.php?aktion=benutzerdaten_zeigen&id=" + id;
}
</script>