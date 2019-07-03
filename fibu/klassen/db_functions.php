<?php


// 3. KUNDENNAME ANHAND DER ID ERMITTELN

function kundenname($kunde) {
	$mysqli=MyDatabase();
		if ($kunde!=0) {
		$abfrage=("SELECT kundecode FROM Kunden WHERE ID=$kunde");
		if ($result=$mysqli->query($abfrage)) {
			while ($row=$result->fetch_object()) {
				$kundecode = c3po::lesen($row->kundecode);
				}	
			}
		}
		else {
		$kundecode="N.N.";
		}
	return $kundecode;
	}

// 3 B . MITARBEITERCODE ANHAND DER ID ERMITTELN

function mitarbeitercode($angestellter) {
	$mysqli=MyDatabase();
	if ($angestellter!=0) {
		$abfrage=("SELECT `mitarbeiter` FROM `Mitarbeiter` WHERE ID='$angestellter'");
		if ($result=$mysqli->query($abfrage)) {
			while ($row=$result->fetch_object()) {
				$mitarbeitercode = c3po::lesen($row->mitarbeiter);
			}	
			
		}
	}
	else {
	$mitarbeitercode="N.N.";
	}
	return $mitarbeitercode;
}

// 3 C. EIN ELEMENT AUS BELIEBIGER TABELLE NACH ID ERMITTELN

function gesuchter_wert($id,$tabelle,$gesuchte_spalte) {
	$mysqli=MyDatabase();
		if ($id!=0) {
			$abfrage="SELECT `$gesuchte_spalte` FROM `$tabelle` WHERE `ID`=$id";
			#echo "Funktion gesuchter_wert bildet SQL-Befehl - ".$abfrage;
			if ($result=$mysqli->query($abfrage)) {
				while ($row=$result->fetch_object()) {
					$gesuchter_wert=$row->$gesuchte_spalte;
				}
			}		
		}
		else {
			$gesuchter_wert="N.N.";
		}
	if (!isset($gesuchter_wert)) {$gesuchter_wert=0;}
	return $gesuchter_wert;
}


// 3 D. EIN ELEMENT AUS BELIEBIGER TABELLE NACH BELIEBIGEM FELD ERMITTELN

function gesuchtes_feld($angabe,$tabelle,$gegebene_spalte,$gesuchte_spalte) {
	$mysqli=MyDatabase();
	$abfrage="SELECT `$gesuchte_spalte` FROM `$tabelle` WHERE `$gegebene_spalte`='$angabe'";
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			$gesuchter_wert=$row->$gesuchte_spalte;
			}
		}	
	if (!isset($gesuchter_wert)) {$gesuchter_wert=0;}
	return $gesuchter_wert;
	}

// 3 E. EIN ELEMENT AUS BELIEBIGER TABELLE NACH BELIEBIGEM FELD ERMITTELN

function gesuchter_wert_sql($abfrage,$gesuchte_spalte) {
	$mysqli=MyDatabase();	
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			$gesuchter_wert=$row->$gesuchte_spalte;
		}
	}	
	if (!isset($gesuchter_wert)) {$gesuchter_wert=0;}
	return $gesuchter_wert;
}

// 9. Suche eines Wertes in der DB zu einem bestimmten Datensatz - z.B. Name zur ID

function ausgabe_gespeicherte_elemente($spalte_zur_ausgabe,$tabelle,$spalte_wert,$vergleichswert) {
	$mysqli=MyDatabase();
	$abfrage="SELECT `$spalte_zur_ausgabe` FROM $tabelle WHERE `$spalte_wert` LIKE $vergleichswert LIMIT 1";
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object()) {
			$ausgabe=$row->$spalte_zur_ausgabe;
			return $ausgabe;
			}
		}
	}

function letzteID($tabelle) {
	$mysqli = MyDatabase();
	$abfrage = "SELECT `ID` FROM `$tabelle`";
	if ($result = $mysqli->query($abfrage)) {
		while ($row = $result->fetch_object()) {
			$lastID = $row->ID;
		}
	}
	return $lastID;
}	

function exists_in_db($abfrage) {
	$mysqli = MyDatabase();
	$test = 0;
	if ($result = $mysqli->query($abfrage)) {
		while ($row = $result->fetch_object()) {
			$test = 1;
		}
	}
	return $test;
}

// $text ist nur füe die Bestätigung des Erfolgs bei der Ausführung des Befehls
function standard_sql($abfrage,$text) {
	$mysqli=MyDatabase();
	// Da MYSQL das Datumsformat "0000-00-00" nicht mehr unterstützt, muss hier eine Korrektur vorgenommen werden:
	#echo "Habe folgende Abfrage übernommen:".$abfrage."<p>";
	$abfrage = str_ireplace("'0000-00-00'", "NULL", $abfrage);
	$abfrage = str_ireplace("'NULL'", "NULL", $abfrage);
	$id_eintrag = 0;
	if (!$mysqli->query($abfrage)) {
		echo("ERROR: $text: $abfrage <p>");
	}
	else {
		$id_eintrag = $mysqli->insert_id;
		// Wenn ein UPDATE Befehl ausgeführt wurde, gibt es keine $id_eintrag -> deshalb wird die id hier festgelegt weil save_and_update_parentwindow wissen muss, ob das Speiuchern geklappt hat
		if($id_eintrag == 0) {$id_eintrag = 1000000042;}	
	}
	return $id_eintrag;
}


function add_date_into_query($eintrag, $datum) {
	if($datum != "NULL" && $datum != "0000-00-00") {
		$eintrag .= ", '".$datum."'";
	}
	else {
		$eintrag .= ", '0000-00-00'";
		#$eintrag .= ", NULL";
	}
	return $eintrag;
}
?>