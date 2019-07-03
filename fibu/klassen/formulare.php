<?php

// FUNKTION DROP DOWN MENU

function dropdown($variable) {
	echo "<option value='' ";
		if ($variable=="") {
		echo "selected"; 
		}
	echo ">k.A.</option><option ";
		if ($variable=="ja") {
		echo "selected"; 
		}
	echo ">ja</option>
	<option ";
		if ($variable=="nein") {
		echo "selected"; 
		}
	echo ">nein</option>";

}


// 2. DROP DOWN MIT INHALTEN AUS DER DATENBANK
// Diese Funktion wird für Dropdown - Menus verwendet, deren Inhalt aus der Datenbank 
// rausgelesen wird.	
	
function databasedropdown ($tabelle,$spalte,$id_selected) {
	$abfrage=("SELECT * FROM $tabelle ORDER BY `$spalte` ASC");
	$mysqli=MyDatabase();
	echo "<option value=0 ";
	if ($id_selected==0) {
		echo "selected";
	}
	echo ">k.A.</option>";
	
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			$inhalt=$row->$spalte;
			$id_gelesen=$row->ID;
			echo "<option value='$id_gelesen' ";
			if ($id_gelesen==$id_selected) {
				echo "selected";
				}
			echo ">$inhalt</option>";
			}
		}
}

// 2B. Wie 2, allerdings kann hier nach dem Inhalt einer bestimmten Spalte gefiltert werden

function databasedropdown_filtered ($tabelle,$spalte,$id_selected,$spalte_filter,$filterkriterium) {
	$abfrage=("SELECT * FROM `$tabelle` WHERE `$spalte_filter`='$filterkriterium' ORDER BY `$spalte` ASC");
	$mysqli=MyDatabase();
	// Bei Veranstaltungsgruppen soll k.A. nicht angezeigt werden:
	
	if ($tabelle!="Veranstaltungen_gruppen") {
		echo "<option value=0 ";
		if ($id_selected==0) {
			echo "selected";
		}
		echo ">k.A.</option>";
	}
		
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			if($tabelle == "Kunden") {
				$inhalt=c3po::lesen($row->$spalte);
			}
			else {
				$inhalt=$row->$spalte;
			}
			$id_gelesen=$row->ID;
			echo "<option value='$id_gelesen' ";
			if ($id_gelesen==$id_selected) {
				echo "selected";
			}
			echo ">$inhalt</option>";
		}
	}
}

// Wie oben, aber mit der Verpflichtung eine Option zu waehlen - kein "k.A."
function databasedropdown_filtered_must ($tabelle,$spalte,$id_selected,$spalte_filter,$filterkriterium) {

	$abfrage=("SELECT * FROM `$tabelle` WHERE `$spalte_filter`='$filterkriterium' ORDER BY `$spalte` ASC");
	$mysqli=MyDatabase();		
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			$inhalt=$row->$spalte;
			$id_gelesen=$row->ID;
			echo "<option value='$id_gelesen' ";
			if ($id_gelesen==$id_selected) {
				echo "selected";
			}
			echo ">$inhalt</option>";
		}
	}
}
	
// 2C. Wie 2B, der Listeninhalt wird aber aus dem Inhalt von zwei Spalten miteinander kombiniert gestaltet

function databasedropdown_filtered_2 ($tabelle,$spalte,$spalte2,$id_selected,$spalte_filter,$filterkriterium) {
	$mysqli=MyDatabase();
	$abfrage=("SELECT * FROM `$tabelle` WHERE `$spalte_filter`='$filterkriterium' ORDER BY `$spalte` ASC");
	echo "<option value=0 ";
	if ($id_selected==0) {
		echo "selected";
	}
	echo ">k.A.</option>";

	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			$inhalt=$row->$spalte;
			$inhalt2=$row->$spalte2;
			$id_gelesen=$row->ID;
			echo "<option value='$id_gelesen' ";
			if ($id_gelesen==$id_selected) {
				echo "selected";
			}
			echo ">$inhalt $inhalt2</option>";
		}
	}
}

// 2D - Dropdownmenu nach einem vorgegebenem Abfragecode

function dropdown_query($abfrage,$spalte,$id_selected, $spalte2 = "") {
	$mysqli = MyDatabase();
	echo "<option value=0 ";
	if ($id_selected == 0) {
		echo "selected";
	}
	echo ">k.A.</option>";
	if ($result = $mysqli->query($abfrage)) {
		while ($row = $result->fetch_object()) {
			$inhalt = $row->$spalte;
			if($spalte2 != "") {
				$inhalt .= "&nbsp;".$row->$spalte2;
			}
			$id_gelesen=$row->ID;
			echo "<option value='$id_gelesen' ";
			if ($id_gelesen==$id_selected) {
				echo "selected";
			}
			echo ">$inhalt</option>";
		}
	}
}

// Kombinationsfeld, entspricht databasedropdown_filtered
// array_erlaubte_mitglieder und 2nd_filter werden benutzt, um z.B. Kunden aus der Tabelle Kunden nach dem Vorhandensein im Array
// der erlaubten Kunden zu prüfen

function combobox_filtered ($tabelle,$spalte,$id_selected,$spalte_filter,$filterkriterium, $feldname, $listenname, $feldgroesse=30, $url_basiclevel="", $function_to_run="", $array_erlaubte_mitglieder = Array()) {
	// Der 1. Teil schafft die Liste für das Drop-Down-Menu und füht einen Inhalt in das Textfeld ein
	$mysqli=MyDatabase();
	$abfrage = "SELECT * FROM `$tabelle` WHERE `$spalte_filter`='$filterkriterium' ORDER BY `$spalte` ASC";
	$abfrage2 = "SELECT * FROM `$tabelle` WHERE `ID`='$id_selected'";
	// Prüfung, ob bereits ein Inhalt ausgewählt ist
	if ($result = $mysqli->query($abfrage2)) {
		while ($row = $result->fetch_object()) {
			$inhalt = $row->$spalte;
		}
	}
	else {
	$inhalt = "";
	}
	// Wenn eine Liste erlaubter mitglieder übergeben wurde, muss das Array zur Weitergabe an AJAX implodiert werden, mit * als Kleber
	if(count($array_erlaubte_mitglieder) > 0) {
		$array_fuer_AJAX = implode("*", $array_erlaubte_mitglieder);
	}
    else {
        $array_fuer_AJAX = "";
    }
    if(!isset($inhalt)) {$inhalt = "";}
	if($tabelle == "Kunden" || $tabelle == "Mitarbeiter") {$inhalt = c3po::lesen($inhalt);}
	echo '<input name="auswahl_'.$feldname.'" id="auswahl_'.$feldname.'" value="'.$inhalt.'" list="'.$listenname.'" 
	onblur="f_dropdown_id_eintragen(\'auswahl_'.$feldname.'\', \''.$feldname.'\', \''.$tabelle.'\', \''.$spalte.'\', \''.$url_basiclevel.'\', \''.$function_to_run.'\', \''.$array_fuer_AJAX.'\')">
	
	<datalist id="'.$listenname.'">';
	if ($result = $mysqli->query($abfrage)) {
		$inhalte = Array();
		while ($row = $result->fetch_object()) {
			if($tabelle == "Kunden" || $tabelle == "Mitarbeiter") {
				$inhalte[] = c3po::lesen($row->$spalte);
			}
			else {
				$inhalte[] = $row->$spalte;
			}
			
		}
		// An dieser Stelle wird unterschieden, ob die Mitglieder der Liste
		// Mitglieder eines Arrays mit erlaubeten Elementen sein müssen um angezeigt zu werden
		// -> Filteroption
		sort($inhalte);
		foreach($inhalte as $inhalt) {
			if(count($array_erlaubte_mitglieder) > 0) {
				if (in_array($inhalt, $array_erlaubte_mitglieder)) {
					echo '<option value="'.$inhalt.'">';
				}
			}
			else {
				echo '<option value="'.$inhalt.'">';
			}
		}
	}
	echo '</datalist>';
	// Nun wird ein unsichtbares Feld geschaffen, in welches die ID des ausgewählten Datensatzes eingetragen wird
	echo '<input name="'.$feldname.'" id="'.$feldname.'" type="hidden" value="'.$id_selected.'">';		

}

function combobox_array_personenobjekte($personen, $id_selected, $feldname, $listenname, $feldgroesse=30, $url_basiclevel="", $function_to_run="") {
	$personen = array_mit_personen_sortieren($personen);
	echo '<script language="JavaScript">
	function ueberpruefe_inhalt() {
		feldinhalt = document.getElementById(\'auswahl_'.$feldname.'\').value;
		person = new Array();
		';
		$cnt = 0;
		foreach ($personen as $person) {
	echo 'person['.$cnt.'] = new Array();
		person['.$cnt.']["ID"] = '.$person->ID.';
		person['.$cnt.']["personencode"] = "'.$person->personencode.'";
		';
		$cnt++;
		}	
		$cnt--;
		echo '
		gefunden = 0;
		for (x = 0; x <= '.$cnt.'; x++) {
			if (person[x]["personencode"] == feldinhalt) {
			document.getElementById(\''.$feldname.'\').value = person[x]["ID"];
			';
			if ($function_to_run != "") {
			  echo $function_to_run.';';
			}
	   echo'
			}
		}
	}
	</script>';
	
	echo '<input style="width: 150px;" name="auswahl_'.$feldname.'" id="auswahl_'.$feldname.'" list="'.$listenname.'" 
	onblur="ueberpruefe_inhalt()">
	<datalist id="'.$listenname.'">';
	foreach ($personen as $person) {
		echo '<option value="'.$person->personencode.'">';
		if($id_selected == $person->ID) {
			$inhalt = $person->personencode;
		}
	}
	echo '</datalist>';	
	echo '<input name="'.$feldname.'" id="'.$feldname.'" type="hidden" value="'.$id_selected.'">';
	if(isset($inhalt)) {
		echo '<script>
		document.getElementById(\'auswahl_'.$feldname.'\').value = "'.$inhalt.'";
		</script>';
	}		
}

function dropdown_array_personenobjekte($personen, $id_selected) {
	#$personen = array_mit_personen_sortieren($personen);
	foreach ($personen as $person) {
		echo '<option value="'.$person->ID.'" ';
		if($person->ID == $id_selected) {echo "selected";}
		echo '>'.$person->benutzername.'</option>';
	}
}

function combobox_array_key_value($array, $name) {
	// JS - Teil zur Ajktualisierung der ID
	echo '<script language="JavaScript">
		function ueberpruefe_inhalt2() {
		feldinhalt = document.getElementById(\'auswahl_'.$name.'\').value;
		elemente = new Array();
		';
		$cnt = 0;
		foreach ($array as $key=>$element) {
	echo 'elemente['.$cnt.'] = new Array();
		elemente['.$cnt.']["ID"] = '.$key.';
		elemente['.$cnt.']["elementbezeichnung"] = "'.$element.'";
		';
		$cnt++;
		}	
		$cnt--;
		echo '
		gefunden = 0;
		for (x = 0; x <= '.$cnt.'; x++) {
			if (elemente[x]["elementbezeichnung"] == feldinhalt) {
			document.getElementById(\'element_nr_'.$name.'\').value = elemente[x]["ID"];
	    	}
		}
	}
	</script>';
	
	// Auswahlfeld
	echo '<input type="search" name="auswahl_'.$name.'" id="auswahl_'.$name.'" list="'.$name.'" onblur="ueberpruefe_inhalt2()">
	<datalist id="'.$name.'">';
	foreach ($array as $element) {
		echo '<option value="'.$element.'">';
	}
	echo '</datalist>
	<input id="element_nr_'.$name.'" name="'.$name.'" type="hidden">';
}

// 4. FUNKTION FÜR EIN DROPDOWNMENU MIT BESONDEREN AUSWAHLMÖGLICHKEITEN
// MIT DIVERSER ANZAHL

function multidropdown($liste,$werte,$suchwert = 0) {
	$anzahl = count($liste);
	echo '<option></option>';
    for ($i = 0; $i < $anzahl; $i++) {
        echo "<option value='$werte[$i]' ";
        if(isset($werte[$i]) && isset($liste[$i])) {
            if ($werte[$i]==$suchwert) {
                echo "selected";
            }   
		    echo ">$liste[$i]</option>";
        }
	}
}

// 5. DROP DOWN MENU FÜR UHRZEITANGABEN
// $feld bedeutet die Bezeichnung des Formularfeldes (wie z.B. "von") 
// die dann ergänzt wird zu stunde_von oder minute_von
// $tabelle (=1 od. 0) fügt bei Bedarf zwischen die Felder die Ausdrücke </td><td>
function uhrzeitdropdown($feld,$uhrzeit,$tabelle) {
	if ($uhrzeit==NULL) {
		$uhrzeit="00:00:00";
		}
	
	$zeit=explode(":",$uhrzeit);
	$stunde=$zeit[0];
	$minuten=$zeit[1];
			
	echo "<select name='stunde_$feld' id='stunde_$feld'>";
	echo "<option value=100 ";
	if ($stunde==100) {
		echo "selected"; }
	echo ">k.A.</option>";
			
	for ($a=0;$a<=23;$a++) {
		echo "<option ";
			if ($stunde==$a) {
				echo "selected";
				}
		echo ">$a</option>";
		}
	
	if ($tabelle==1) {
		echo "</td><td>";
		} 
	
	echo "</select> <select name='minuten_$feld' id='minuten_$feld'>";
	echo "<option value=100 ";
	if ($minuten==100) {
		echo "selected"; }
	echo ">k.A.</option>";
	for ($a=0;$a<=59;$a=$a+5) {
		echo "<option ";
			if ($minuten==$a) {
				echo "selected";
				}
		echo ">$a</option>";
		}
	
	}
	
// 5b. UHRZEITDROPDOWN OHNE DES SELECTFELDES UM EIGENE FUNKTIONEN ETC AN DAS FELD KOPPELN ZU KOENNEN

function stundendropdown($uhrzeit) {
	$zeit=explode(":",$uhrzeit);
	$stunde=$zeit[0];	
	for ($x=0;$x<24;$x++) {
		echo '<option ';
		if ($stunde==$x) {echo "selected";}
		echo '>'.$x.'</option>';
		}
	}
	


function minutendropdown($uhrzeit) {
	$zeit=explode(":",$uhrzeit);
	$minuten=$zeit[1];
	
	for ($x=0;$x<59;$x=$x+5) {
		echo '<option ';
		if ($minuten==$x) {echo "selected";}
		echo '>'.$x.'</option>';		
		}
	}

// 6. CHECKBOX WIRD BEIM WERT 1 MARKIERT		


function checkbox1($wert) {
	if ($wert==1) {
		echo "checked";
		}
	}
	
// 21. f_ja($var) - wenn eine Checkbox oder Dropdown "ja" als Wert gibt und darauf ein Kommentar folgen soll, wird "ja" in "Ja - " verändert damit der darauffolgende Text normal aussieht	
	
function f_ja($var) {
	if ($var!="" && $var!="k.A.") {$var="$var - ";}
	if ($var=="0 - ") {$var="";} 
	return $var;
	}
	
// 22.	Markieren eines Radiobuttons
	
function select_radio($wert,$bezeichnung) {
	if ($wert==$bezeichnung) {
		echo ' checked';
		}
	}
	


function zahlendropdown($zahl1,$zahl2,$auswahl) {
	for ($x=$zahl1; $x<=$zahl2; $x++) {
			echo '<option ';
			if ($x==$auswahl) {echo 'selected';}
			echo '>'.$x.'</option>';
		}
	}
	


function monatsdropdown($auswahl) {	
	$monate=array("Januar","Februar","M&auml;rz","April","Mai","Juni",
				"Juli","August","September","Oktober","November","Dezember");
	for ($x=1; $x<=12; $x++) {
		echo '<option value="'.$x.'" ';
		if ($x==$auswahl) {echo 'selected';}
		echo '>'.$monate[$x-1].'</option>';
		}
	}


function automatisches_feld($id,$kurzcode,$text,$art_antwort,$tabelle_antworten,$farbe="white") {
	echo '<tr><td ';
	if ($art_antwort=="kommentar") {echo 'id="my_small_title"';}
	echo '>'.$text.'</td><td>';
	
	switch ($art_antwort) {
		case "auswahl":			
			echo '<select name="'.$kurzcode.'" id="'.$kurzcode.'" style="background-color:'.$farbe.';">';
			databasedropdown_filtered_must ($tabelle_antworten,"text",0,"id_frage",$id);
			echo '</select>';
			echo '</td>';
			break;
		case "texfeld":
			echo '<td><textarea name="'.$kurzcode.'" id="'.$kurzcode.'" cols="80" rows="10"></textarea></td>';
			break;
		case "checkbox":
			echo '<td><input name="'.$kurzcode.'" id="'.$kurzcode.'" type="checkbox" value="ja"></td>';
			break;
		}
	echo '</tr>';
}	


function schieberegler($url_basiclevel, $name, $funktion_an="", $funktion_aus="") {
	echo '	<script language="JavaScript">
	// zustand: 1 = eingeschaltet, 0 = ausgeschaltet
	function f_regler_an(x) {
		x++;
		document.images["regler"].src = "'.$url_basiclevel.'pics/schieberegler/regler"+x+".png";
		if (x<22) {
			window.setTimeout("f_regler_an("+x+")", 15);
		}
		else {';
			if ($funktion_an != "") {echo $funktion_an;}
  echo '}	
	}
	
	function f_regler_aus(x) {
		x--;
		document.images["regler"].src = "'.$url_basiclevel.'pics/schieberegler/regler"+x+".png";
		if (x>0) {
			window.setTimeout("f_regler_aus("+x+")", 15);
		}
		else {';
			if ($funktion_aus != "") {echo $funktion_aus;}
  echo '}
	}
	
	function f_schieberegler(x) {
		zustand = document.getElementById("zustand").value;
		if (zustand == 0) {
			f_regler_an(0);
			document.getElementById("zustand").value = 1;
		}
		if (zustand == 1) {
			f_regler_aus(22);
			document.getElementById("zustand").value = 0;
		}
	}
	</script>
	
	<img src="../pics/schieberegler/regler0.png" id="regler" onclick="f_schieberegler(0)">
	<input name="'.$name.'" id="zustand" value="0" size="1" type="hidden">';
}

function linie_dropdown($hidden_field, $border_to_apply, $px = 0, $nr = 1) {
	echo '<div style="background-color: gainsboro; position: absolute; top: 10px; left: 470px; height: 12px; width: 100px; padding: 5px; border-radius: 5px; z-index: 50;" id="aktuelle_linienstaerke'.$nr.'">
	<div style="width: 50px; height: 1px; border: '.$px.'px solid black; "></div>
	</div>
	<div style="background-color: gainsboro; position: absolute; top: 10px; left: 470px; height: 200px; width: 100px; padding: 5px; border-radius: 5px; z-index: 50; display: none;" id="dropdown_linienstaerke'.$nr.'">';
	$linienstaerken = Array(3, 5, 10, 20, 30);
	echo '<span style="position: relative; top: 5px;" 
	onmouseover="$(this).css(\'color\', \'red\');"
	onmouseout="$(this).css(\'color\', \'black\');"
	onclick="rahmenstaerke'.$nr.'(0)">kein Rahmen</span>';
	$y = 10;
	for($i = 0; $i <= 4; $i++) {
		echo '<div style="position: relative; background-color: black; top: '.$y.'px; width: 100px; height: '.$linienstaerken[$i].'px;"
		onmouseover="$(this).css(\'background-color\', \'red\');"
		onmouseout="$(this).css(\'background-color\', \'black\');"
		onclick="rahmenstaerke'.$nr.'('.$linienstaerken[$i].')"></div>';
		$y = $y + 5;
	}
	echo '<span style="position: relative; top: 55px;">sonst.: <input size="3" id="anderer_wert'.$nr.'" onblur="wert_lesen'.$nr.'()"></span>';
	echo '</div><input type="hidden" name="'.$hidden_field.'" id="'.$hidden_field.'">';
	// jQuery: 
	echo '<script>
		$("#aktuelle_linienstaerke'.$nr.'").mouseover(function(){
			$("#dropdown_linienstaerke'.$nr.'").fadeIn("fast");
		});

		function rahmenstaerke'.$nr.'(staerke) {
			document.getElementById("'.$hidden_field.'").value = staerke;
			var linie = staerke + "px";
			$("#'.$border_to_apply.'").css(\'border-width\', linie);
			$("#dropdown_linienstaerke'.$nr.'").fadeOut("fast");
			if(staerke > 0) { 
				$("#aktuelle_linienstaerke'.$nr.'").html("<span style=\'position: relative; left: 20px;\'>" + staerke + "px</span>");
			}
			else {
				$("#aktuelle_linienstaerke'.$nr.'").empty();
			}
		}

		function wert_lesen'.$nr.'() {
			var staerke = document.getElementById("anderer_wert'.$nr.'").value;
			rahmenstaerke'.$nr.'(staerke);
		}
	</script>';
}

function datum_dropdown ($datum, $id_feld) {
	// Funktion benutzt die JS-Funktion f_datum_dropdown aus tools.js
	// Diese wiederum benutzt Datumsfunktionen aus tools_kalender.js
	$array_datum = array_aus_datum($datum);
	$monate      = array_monate();
	echo '<select style="font-size: 40px; width: 15%;" name="tage'.$id_feld.'" id="tage'.$id_feld.'" onchange="f_datum_dropdown(\''.$id_feld.'\')">';

	for ($tag = 1; $tag <= 31; $tag++) {
		echo '<option ';
		if($tag == $array_datum[2]) {echo 'selected';}
		echo '>'.$tag.'</option>';
	}
	echo '</select>

	<select style="font-size: 40px; width: 30%;" name="monate'.$id_feld.'" id="monate'.$id_feld.'" onchange="f_datum_dropdown(\''.$id_feld.'\')">';

	for ($monat = 1; $monat <= 12; $monat++) {
		echo '<option value="'.$monat.'" ';
		if($monat == $array_datum[1]) {echo 'selected';}
		echo '>'.$monate[$monat].'</option>';
	}
	echo '</select>
	<select style="font-size: 40px; width: 20%;" name="jahr'.$id_feld.'" id="jahr'.$id_feld.'" onchange="f_datum_dropdown(\''.$id_feld.'\')">';

	for ($jahr = 1900; $jahr <= 2050; $jahr++) {
		echo '<option ';
		if($jahr == $array_datum[0]) {echo 'selected';}
		echo '>'.$jahr.'</option>';
	}
	echo '</select>
	<input  id="datum'.$id_feld.'" name="datum'.$id_feld.'" type="hidden" value="'.$datum.'">';
}

?>