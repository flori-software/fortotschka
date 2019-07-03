<?php
/* 14. Liste mit grafischen Buttons zum Verndern oder Deaktivieren MIT BIS ZU ZWEI ELEMENTEN
 setzt in der Tabelle DIE EXISTENZ DER SPALTE aktiv VORAUS 
 $liste steht fr den Namen der Liste damit entsprechende Elemente auch bearbeitet oder 
 geloescht werden knnen 
$abfrage - ist der komplette STRING für die Abfrage
$spalte[1 oder 2] - die String für bis zu 2 Spalten koennen für die Ausgaben abgefragt werden
$aktion - stringt oder zahl, welche später sagt welche Art von Elementen wieder angezeigt werden soll, 
		deaktiviewrt oder reaktiviert werden soll
$aktiv - Anzeige der aktiven oder inaktiven Elemente
$url - Die URL der absendenden Seite zu der wieder zurueckgeleitet werden soll fürs Loeschen oder Bearbeiten der Elemente
$url_basiclevel - die relative URL zum Hauptlevel der Anwendung, d.h. "" wenn die Seite sich in keinem Unterordner befindet oder "../" wenn die Seite sich in einem Unteriordner befindet - wichtig für die URL zu den Grafikdateien 
$url_bearbeiten - Adresse der Seite welche die Ueberarbeitung der existierenden Elemente vornimmt
[$filter_spalte] - versteht sich von selbst
[$filter_kriterium] - versteht sich von selbst
[$spalte_immer_zulassen] - auch wenn das obige kriterium nicht zutrifft, aber dieses schon, dann ist das Ergebnis positiv
[$spalte_immer_zulassen_kriterium]
*/

function liste_mit_grafiken($abfrage, $spalte1, $spalte2, $aktion, $aktiv, $url, $url_basiclevel, $url_bearbeiten, $filter_spalte="", $filter_kriterium="", $spalte_immer_zulassen="", $spalte_immer_zulassen_kriterium="", $recht_loeschen = 1) {
	
	$mysqli=MyDatabase();
	echo '<script language="JavaScript" src="'.$url_basiclevel.'tools_vE.js"></script>';
	echo "<table>";
	echo "<table border='0' style='width:100px;'>";
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object())	 {
			$id=$row->ID;
			$feld1=$row->$spalte1;
			
			if ($filter_spalte!="") {
				$filter_eintrag=$row->$filter_spalte;
			}
			else {
				$filter_eintrag="";
			}
			
			if ($spalte_immer_zulassen!="") {
				$filter_eintrag2=$row->$spalte_immer_zulassen;
			}
			else {
				$filter_eintrag2="";
			}
					
			if ($filter_spalte=="" || $filter_eintrag==$filter_kriterium || $filter_eintrag2==$spalte_immer_zulassen_kriterium) {
				if (strlen($feld1) > 15) {
					$feld1 = substr($feld1, 0, 12)."...";
				}
				if($url_bearbeiten == "personal_kinder_bearbeiten.php") {$feld1 = c3po::lesen($feld1);}
				if($url_bearbeiten == "beratung_doku_situation_bearbeiten.php") {$feld1 = date_to_datum($feld1);}
				echo "<tr id='zeile_grau'><td style='white-space: nowrap; overflow: hidden;'>$feld1</td>";	
				if ($spalte2!==0) {
					$feld2 = $row->$spalte2;
					if($url_bearbeiten == "beratung_doku_situation_bearbeiten.php") {
						konsole("Entschluesselung");
						$feld2 = c3po::lesen($feld2);
					}
					if($url_bearbeiten == "liste_veranstaltungen_bearbeiten.php" || $url_bearbeiten == "personal_kinder_bearbeiten.php") {
						$feld2 = date_to_datum($feld2);	
					}
					echo "<td style='white-space: nowrap; overflow: hidden; width: 20%;'>$feld2</td>";
				}	
				echo "<td style='width:10%;'>";	
				// Nun werden die Grafiken hinzugefuegt, zuerst fuer aktive Elemente, dann fuer den Papierkorb
				if ($aktiv==1) {
					// AKTIVE ELEMENTE
					$id_bild=$id*10+2;
					$name_bild="bild".$id_bild;		
					// Kostentraegergruppe 1 darf NIE geloescht werden (d.h. Kranken- und Pflegekassen	 						
					if (($spalte1!="kostentraeger_gruppe" || $id>1) && ($spalte1!="Abrechnungseinheit" || $id>4) && $recht_loeschen == 1) {	
					echo   '<img src="'.$url_basiclevel.'pics/loeschen.png" 
							name="'.$name_bild.'"			
							onclick="f_element_deaktivieren('.$id.',\''.$aktion.'\',\''.$url.'\')"
							onmouseover="f_loeschen_big_button2('.$id_bild.',\''.$url_basiclevel.'\')"
							onmouseout="f_loeschen_small_button2('.$id_bild.',\''.$url_basiclevel.'\')">';
					}			
					echo "</td><td style='width:10%;'>";					
					$id_bild=$id*10+3;		
					$name_bild="bild".$id_bild;	
					echo   '<img src="'.$url_basiclevel.'pics/stift.png" 
							name="'.$name_bild.'"
							onclick="f_element_bearbeiten('.$id.',\''.$aktion.'\',\''.$url_bearbeiten.'\')"
							onmouseover="f_bearbeiten_big_button2('.$id_bild.',\''.	$url_basiclevel.'\')"
							onmouseout="f_bearbeiten_small_button2('.$id_bild.',\''.$url_basiclevel.'\')"
							>';					
					echo "</td></tr>";
				}
		
				if ($aktiv==0) {
					// PAPIERKORB
					$id_bild=$id*10+1;
					$name_bild="bild".$id_bild;
		
					echo   '<img src="'.$url_basiclevel.'pics/pfeil.png" 
							name="'.$name_bild.'"
							onclick="f_element_reaktivieren('.$id.',\''.$aktion.'\',\''.$url.'\')"
							onmouseover="f_pfeil_select('.$id_bild.',\''.$url_basiclevel.'\')"
							onmouseout="f_pfeil_unselect('.$id_bild.',\''.$url_basiclevel.'\')">';
					echo "</td><td>";		
				}
			}
		}
	}	
	echo "</table>";	      
}


/* 14B Liste mit nur einer Grafik zum loeschen des elements und ohne aktiver / inaktiver Elemente
die Elemente der Liste sind in der Tabelle als foreign-key gespeichert */

function liste_mit_foreignkey($abfrage,$foreignkey,$ur_tabelle,$ur_spalte,$aktion,$url,$url_basiclevel, $anzahl_listen_pro_seite=1) {
	$mysqli=MyDatabase();
	echo '<script language="JavaScript" src="'.$url_basiclevel.'tools_vE.js"></script>';
	// Zunaechst werden die Elemente der Urtabelle in einem Array gespeichert:
	$ur_abfrage="SELECT `ID`,`$ur_spalte` FROM $ur_tabelle";
	$ur_array=array();
	if ($result=$mysqli->query($ur_abfrage)); {
		while($row=$result->fetch_object()) {
				$ur_array[$row->ID] = $row->$ur_spalte;	
				if($ur_tabelle == "Mitarbeiter" || $ur_tabelle == "Kunden") {$ur_array[$row->ID] = c3po::lesen($ur_array[$row->ID]);}
			}
		}
		
	// Nun wird die Tabelle abgefragt, welche die foreign-keys beinhaltet:
	$elemente_liste_fk=array();
	if ($result=$mysqli->query($abfrage)) {
		while ($row=$result->fetch_object())	 {
			$id=$row->ID;
			$feld=$row->$foreignkey;
			$elemente_liste_fk[$id]=$ur_array[$feld];
			}
		}
		
	echo "<table>";
	echo "<table border='0'>";
	asort($elemente_liste_fk);
	foreach ($elemente_liste_fk as $key=>$value) {
		echo "<tr id='zeile_grau'><td>$value</td>
			<td>";
		
		// Nun werden die Grafiken hinzugefuegt:	
		$id_bild=$key*10*$anzahl_listen_pro_seite+2;
		$name_bild="bild".$id_bild;		
		echo   '<img src="'.$url_basiclevel.'pics/loeschen.png" 
				name="'.$name_bild.'"			
				onclick="f_element_deaktivieren('.$key.',\''.$aktion.'\',\''.$url.'\')"
				onmouseover="f_loeschen_big_button2('.$id_bild.',\''.$url_basiclevel.'\')"
				onmouseout="f_loeschen_small_button2('.$id_bild.',\''.$url_basiclevel.'\')">';
				
		echo "</td><td></tr>";
		}
		
	echo "</table>";	      
}

/* 16. Button zum Anzeigen aktiver oder inaktiver Elemente
       $aktiv - der Zustand gerade angezeigter Elemente
       $element - die Bezeichnung der Elemente (z.B. "Kunden") für den Buttoninhalt - IMMER IM PLURAL!!!
	   $url_teil1 - die URL der Seite, wie z.B. "kunden.php"
	   $url_variablen - die über die GET Methode weiterzugebenden Variablen welche NACH der $aktiv folgen*/
	   
function aktiv_inaktiv_button($aktiv,$element,$url_teil1,$url_variablen = "") {
	if ($aktiv==1) {
		$aktiv2=0;
		$buttoninhalt="Inaktive $element anzeigen";
		}
		else {
		$aktiv2=1;
		$buttoninhalt="Aktive $element anzeigen";
		}	
	echo '<a href="'.$url_teil1.'?aktiv='.$aktiv2.'&'.$url_variablen.'"><input type="button" value="'.$buttoninhalt.'"></a>';
	}

// Filter für die Abrechnungseinstellungen und Filtereinstellungen des Kundenbriefs
function liste_ID_mit_Checkboxen($elemente, $werte_array) {
    #echo "Null:".$elemente[0]["code"]."<br>";
    foreach ($elemente as $key=>$element) {
        echo '<tr><td><input type="checkbox" id="'.$key.'" name="'.$key.'" value="'.$element["ID"].'" ';
        if (in_array($element["ID"], $werte_array)) {
            echo 'checked';
        }    
        echo '></td><td>'.$element["code"].'</td></tr>';
    }

}
?>