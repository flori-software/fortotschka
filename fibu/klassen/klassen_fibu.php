<?php 
class jahr {
    public $ID;
    public $jahr;
    public $datum_von;
    public $datum_bis;
    public $aktiv;
    public function __construct($id = 0) {
        if($id != 0) {   
            $this->ID = $id;
        } else {
            $this->ID = $_SESSION["jahr_id"];
        }
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `jahr` WHERE `ID`='".$this->ID."'";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->jahr      = $row->jahr;
                $this->datum_von = $row->datum_von;
                $this->datum_bis = $row->datum_bis;

                $_SESSION["jahr_id"] = $this->ID;
                $_SESSION["jahr"]    = $this->jahr;
            }
        }
        
    }
    public function formular_lesen() {
        $this->jahr      = $_POST["jahr"];
        $this->datum_von = $_POST["datum_von"];
        $this->datum_bis = $_POST["datum_bis"];
        $this->aktiv=1;
    }
    public function speichern($formular_lesen = 1) {
        if($formular_lesen == 1) {$this->formular_lesen();} // Wenn beim Jahresabschluss ein neues Geschäftsjahr angelegt wird, kein Formular lesen
        
        $eintrag = "INSERT INTO `jahr` (`jahr`, `datum_von`, `datum_bis`, `aktiv`)
        VALUES ('".$this->jahr."', '".$this->datum_von."', '".$this->datum_bis."', '".$this->aktiv."')";
        $id_jahr = standard_sql($eintrag, "Speichern eines Geschaeftsjahres");
        return $id_jahr;
    }
    /*
    public function aendern() {
        $this->jahr = $_POST["jahr"];
        $eintrag = "UPDATE `jahr` Set `jahr`='".$this->jahr."'";
        standard_sql($eintrag, "Wahl der Geschaeftsjahres");
    }
    */
    public static function alle_jahre() {
        $mysqli  = myDatabase();
        $abfrage = "SELECT * FROM `jahr` ORDER BY `jahr` ASC";
        $jahre = Array();
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $jahr = new jahr;
                $jahr->ID = $row->ID;
                $jahr->jahr = $row->jahr;
                $jahre[] = $jahr;
            }
        }
        return $jahre; 
    }
}
class teilbuchung {
    public $ID;
    public $id_buchung;
    public $kommentar;               
    public $id_deb_kred;
    public $id_konto_soll;
    public $id_konto_haben;
    public $summe;
    public $nr_spendenquittung;
    public $gesperrt;
    public $id_jahr;

    // Wird bishr nur bei einer Spendenquittung benötigt, die Werte werden dort kalkuliert:
    public $kommentar_hauptbuchung; 
    public $datum; 

    public function formular_lesen($cnt) {
        $this->id_konto_soll  = PostMyVar("id_konto_soll".$cnt, 0, "");
        $this->id_konto_haben = PostMyVar("id_konto_haben".$cnt, 0, "");
        $this->kommentar      = PostMyVar("kommentar".$cnt, "");
        $this->id_deb_kred    = PostMyVar("id_deb_kred".$cnt, 0, "");
        $this->summe          = PostMyVar("summe".$cnt, 0, "");
        #echo 'Summe muesste sein:'.$_POST["summe0"].'<br>';
        #echo 'Gelesene Summe ist '.$_POST["summe".$cnt].' im Feld summe'.$cnt.'<br>';
    }

    public function speichern() {
        $eintrag = "INSERT INTO `teilbuchungen` (`id_buchung`, `kommentar`, `id_deb_kred`, `id_konto_soll`, `id_konto_haben`, `summe`, `id_jahr`) VALUES
        ('".$this->id_buchung."', '".$this->kommentar."', '".$this->id_deb_kred."', '".$this->id_konto_soll."', '".$this->id_konto_haben."', '".$this->summe."', '".$_SESSION["jahr_id"]."')";
        standard_sql($eintrag, "Speichern einer Teilbuchung");
    }

    public function lesen() {
        $mysqli  = MyDatabase();
        $teilbuchungen = Array();
        $abfrage = "SELECT * FROM `teilbuchungen` WHERE `ID`=".$this->ID;
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->kommentar          = $row->kommentar;
                $this->id_buchung         = $row->id_buchung;
                $this->id_deb_kred        = $row->id_deb_kred;
                $this->id_konto_soll      = $row->id_konto_soll;
                $this->id_konto_haben     = $row->id_konto_haben;
                $this->summe              = $row->summe;
                $this->id_jahr            = $row->id_jahr; 
                $this->nr_spendenquittung = $row->spendenquittung;
                $this->gesperrt           = $row->gesperrt;

                // Datum wird anhand der Hauptbuchung ermittelt:
                $this->datum                  = gesuchter_wert($this->id_buchung, "buchungen", "datum");
                $this->kommentar_hauptbuchung = gesuchter_wert($this->id_buchung, "buchungen", "kommentar");
            }
        }
    }

    public static function alle_zu_einer_buchung_lesen($id_buchung) {
        $mysqli  = MyDatabase();
        $teilbuchungen = Array();
        $abfrage = "SELECT * FROM `teilbuchungen` WHERE `id_buchung`=".$id_buchung;
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $teilbuchung     = new teilbuchung;
                $teilbuchung->ID = $row->ID;
                $teilbuchung->lesen();
                $teilbuchungen[] = $teilbuchung;
            }
        }
        return $teilbuchungen; 
    }

    public static function teilbuchungen_ohne_spendenquittung_lesen($id_debitor = 0) {
        // dabei werden nur Teilbuchungen geselen, die einem Debitor zugeordnet wurden und noch keine Nr. einer Spendenquittung haben
        $mysqli  = MyDatabase();
        $teilbuchungen = Array();
        $abfrage = "SELECT * FROM `teilbuchungen` WHERE `id_deb_kred` > 0 AND `nr_spendenquittung` = 0";
        if($id_debitor != 0) {
            $abfrage .= " AND `id_deb_kred`='".$id_debitor."'";
        }
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $teilbuchung     = new teilbuchung;
                $teilbuchung->ID = $row->ID;
                $teilbuchung->lesen();
                // Es werden Cluster mit der ID des Debitors gebildet, in diese Cluster kommen dann die jeweiligen Teilbuchungen
                if(!is_array($teilbuchungen[$teilbuchung->id_deb_kred])) {$teilbuchungen[$teilbuchung->id_deb_kred] = Array();}
                $teilbuchungen[$teilbuchung->id_deb_kred][] = $teilbuchung;
            }
        }
        return $teilbuchungen;
    }
}


class buchung {

    public $ID;
    public $datum;
    public $kommentar;
    public $id_jahr;
    public $gesperrt;

    public $teilbuchungen; // Array er Objekte der Klasse teilbuchung

    // Errechnete Eigenschaften
    public $summe; 

    public function __construct() {
        $this->teilbuchungen = Array();
    }

    public function formular_lesen($aktion = "speichern") {
        echo 'Lese das Formular<br>';
        $this->datum            = $_POST["datum"];
        $this->kommentar        = $_POST["kommentar"];
        for($cnt = 0; $cnt < 20; $cnt++) {
            $teilbuchung = new teilbuchung;
            $teilbuchung->formular_lesen($cnt);
            $this->summe += $teilbuchung->summe; 
            $this->teilbuchungen[] = $teilbuchung;
        } 
        switch ($aktion) {
            case 'speichern':
                $this->speichern();
            break;
            
            case 'bearbeiten':
                $this->bearbeiten();
            break;
        }
    }

    private function speichern() {
        if($this->summe > 0 && $this->datum != "0000-00-00") {
            $eintrag = "INSERT INTO `buchungen` (`datum`, `kommentar`, `id_jahr`, `gesperrt`) VALUES ('".$this->datum."', '".$this->kommentar."', '".$_SESSION["jahr_id"]."', 0)";
            $this->ID = standard_sql($eintrag, "Eintrag der Buchung");

            // Schreiben der ID in die Teilbuchungen
            foreach ($this->teilbuchungen as $teilbuchung) {
                $teilbuchung->id_buchung = $this->ID;
                if($teilbuchung->summe != 0) {
                    $teilbuchung->speichern();
                }  
            }
        } else {
            echo "Die Buchung konnte nicht gespeichert werden, da sie nicht korrekt war (z.B. Summe = 0 oder kein g&uuml;ltiges Datum.";
        }
    }

    private function bearbeiten() {
        $eintrag = "UPDATE `buchungen` Set 
        `datum`           = '".$this->datum."',
        `kommentar`       = '".$this->kommentar."'
        WHERE `ID`='".$this->ID."'";
        #echo $eintrag.'<br>';
        standard_sql($eintrag, "Bearbeiten einer Buchung");

        // Löschen der bisherigen Teilbuchungen
        $eintrag = "DELETE FROM `teilbuchungen` WHERE `id_buchung`=".$this->ID;
        standard_sql($eintrag, "Loeschen der Teilbuchungen");

        // Neuspeichern der Teilbuchungen
        foreach ($this->teilbuchungen as $teilbuchung) {
            $teilbuchung->id_buchung = $this->ID;
            if($teilbuchung->summe != 0) {
                $teilbuchung->speichern();
            }
        }
    }

    public function kurzinfo_lesen() {
        // Für eine Spendenquittung wird nur das Datum und der Kommentarbenötigt
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `buchungen` WHERE `ID`='".$this->ID."'";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->datum         = $row->datum;
                $this->kommentar     = $row->kommentar;
            }
        }
    }

    public function lesen() {
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `buchungen` WHERE `ID`='".$this->ID."'";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->datum         = $row->datum;
                $this->kommentar     = $row->kommentar;
                $this->gesperrt      = $row->gesperrt;
                $this->teilbuchungen = teilbuchung::alle_zu_einer_buchung_lesen($this->ID);
            }
        }
    }

    public function loeschen() {
        // Buchung löschen
        $eintrag = "DELETE FROM `buchungen` WHERE `ID`=".$this->ID;
        standard_sql($eintrag, "Loeschen eines Buchungssatzes");

        // Teilbuchungen löschen
        $eintrag = "DELETE FROM `teilbuchungen` WHERE `id_buchung`=".$this->ID;
        standard_sql($eintrag, "Loeschen der Teilbuchungen");
    }

    public static function lesen_alle($datum_von = "0001-01-01", $datum_bis = "2100-12-31", $id_konto_soll = 0, $id_konto_haben = 0) {
        $buchungen = Array();
        $mysqli  = MyDatabase();
        $abfrage = "SELECT `ID` FROM `buchungen` WHERE `datum` >= '".$datum_von."' AND `datum` <= '".$datum_bis."' ";
        if($id_konto_soll != 0) {$abfrage .= "AND `id_konto_soll`='.$id_konto_soll.'";}
        if($id_konto_haben != 0) {$abfrage .= "AND `id_konto_haben`='.$id_konto_haben.'";}
        $abfrage .= " ORDER BY `datum` DESC, `ID` DESC";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $buchung = new buchung;
                $buchung->ID = $row->ID;
                $buchung->lesen();
                $buchungen[] = $buchung;
            }
        }
        return $buchungen;
    }
}

class konto {
    public $ID;
    public $nr;
    public $bezeichnung;
    public $art;           // erlaubt: aktiva, passiva, ertrag, aufwand
    public $saldo_anfang;
    public $saldo_aktuell;
    public $summe_soll;
    public $summe_haben;
    public $umsaetze;      // Array
    public $aktiv;

    public $bewegung; // Kalkulierter Wert für die Bilanz
    
    public function formular_lesen() {
        $this->nr           = $_POST["nr"];
        $this->bezeichnung  = $_POST["bezeichnung"];
        $this->art          = $_POST["art"];
        $this->saldo_anfang = $_POST["saldo_anfang"];
        $this->aktiv        = 1;
    }

    public function speichern() {
        $mysqli  = MyDatabase();
        $eintrag = "INSERT INTO `kontenplan` (`nr`, `bezeichnung`, `art`, `aktiv`)
        VALUES ('".$this->nr."', '".$this->bezeichnung."', '".$this->art."', '".$this->aktiv."')";
        $this->ID = standard_sql($eintrag, "Speichern des Kontos");
        $this->anfangssaldo_eintragen();
    }

    public function anfangssaldo_eintragen($id_jahr = 0) {
        if($id_jahr == 0) {$id_jahr = $_SESSION["jahr_id"];}
        $eintrag = "INSERT INTO `anfangssalden` (`id_konto`, `id_jahr`, `anfangssaldo`) VALUES 
        ('".$this->ID."', '".$id_jahr."', '".$this->saldo_anfang."')";
        standard_sql($eintrag, "Eintragen eines neuen Kontos");
    }
    
    public function deaktivieren() {
        $mysqli  = MyDatabase();
        $eintrag = "UPDATE `kontenplan` Set `aktiv`='0' WHERE `ID`='".$this->ID."'";
        standard_sql($eintrag, "Deaktivieren des Kontos");
    }
    
    public function reaktivieren() {
        $mysqli  = MyDatabase();
        $eintrag = "UPDATE `kontenplan` Set `aktiv`='1' WHERE `ID`='".$this->ID."'";
        standard_sql($eintrag, "Reaktivieren des Kontos");
    }
    
    public function lesen_uebersicht() {
        $mysqli  = MyDatabase();
        $abfrage = "SELECT * FROM `kontenplan` WHERE `ID`='".$this->ID."'";
        if ($result = $mysqli->query($abfrage)) {
            while ($row = $result->fetch_object()) {
                $this->nr           = $row->nr;
                $this->bezeichnung  = $row->bezeichnung;
                $this->art          = $row->art;           
                $abfrage2 = "SELECT * FROM `anfangssalden` WHERE `id_jahr`=".$_SESSION["jahr_id"]." AND `id_konto`=".$this->ID;
                $this->saldo_anfang = gesuchter_wert_sql($abfrage2, "anfangssaldo");   
                // Berechnung der aktuellen Kontostände:
                $this->aktuelles_saldo();   
            }
        }
    }

    public function lesen_kontenart() {
        $this->art = gesuchter_wert($this->ID, "kontenplan", "art");
    }
    
    public static function lesen_ueberischt_kontenart($art) {
        // art: aktiva, passiva, ertrag, aufwand
        $mysqli  = MyDatabase();
        $konten = Array();
        $abfrage = "SELECT * FROM `kontenplan` WHERE `art`='".$art."' ORDER BY `nr` ASC";
        if ($result = $mysqli->query($abfrage)) {
            while ($row = $result->fetch_object()) {
                $konto     = new konto;
                $konto->ID = $row->ID;
                $konto->lesen_uebersicht();
                $konten[] = $konto;
            }
        }
        return $konten;
    }

    public function aktuelles_saldo() {
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `teilbuchungen` WHERE (`id_konto_soll`=".$this->ID." OR `id_konto_haben`=".$this->ID.") AND `id_jahr`=".$_SESSION["jahr_id"];

        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $teilbuchung     = new teilbuchung;
                $teilbuchung->ID = $row->ID;
                $teilbuchung->lesen();

                // Berechnung des Saldos
                if($teilbuchung->id_konto_soll == $this->ID) {
                    $this->summe_soll += $teilbuchung->summe;
                } elseif($teilbuchung->id_konto_haben == $this->ID) {
                    $this->summe_haben += $teilbuchung->summe;
                }
            }
        }
        if($this->art == "aktiva" || $this->art == "aufwand") {
            $this->saldo_aktuell = $this->saldo_anfang + $this->summe_soll - $this->summe_haben;
        } else {
            $this->saldo_aktuell = $this->saldo_anfang - $this->summe_soll + $this->summe_haben;
        }
        
    }
    
}

class spendenquittung {
    public $ID;
    public $nr_spendenquittung;
    public $debitor;                // Objekt vom Typ Benutzer
    public $summe;
    public $datum;
    public $freistellung_vom;
    public $vorstand;    
    public $absender;              // Objekt vom Typ Benutzer

    public $teilbuchungen;         // Array
    public $datum_erste_spende;
    public $datum_letzte_spende;

    public function __construct($id = 0) {
        $this->teilbuchungen = Array();
        if($id != 0) {
            $this->ID = $id;
            $this->lesen();
        }
    }

    public function lesen() {
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `spendenquittungen` WHERE `ID`='".$this->ID."'";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->nr_spendenquittung = $row->nr_spendenquittung;
                $this->summe              = $row->summe;
                $this->datum              = $row->datum;
                $this->freistellung_vom   = $row->freistellung_vom;
                $this->vorstand           = $row->vorstand;
                
                $this->debitor     = new Benutzer;
                $this->debitor->ID = $row->id_benutzer;
                $this->debitor->get_benutzerdaten();
                
                $this->absender                         = new Benutzer;
                $this->absender->nachname               = $row->absender_nachname;
                $this->absender->vorname                = $row->absender_vorname;
                $this->absender->kontakt->strasse       = $row->absender_strasse;
                $this->absender->kontakt->plz           = $row->absender_plz;
                $this->absender->kontakt->ort           = $row->absender_ort;
                $this->absender->kontakt->telefonnummer = $row->absender_telefonnummer;
            }
        }
        $this->teilbuchungen_spendenquittung_lesen();
    }

    public function teilbuchungen_spendenquittung_lesen() {
        $mysqli  = MyDatabase();
        $abfrage = "SELECT `ID` FROM `teilbuchungen` WHERE `nr_spendenquittung` = '".$this->nr_spendenquittung."'";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $teilbuchung     = new teilbuchung;
                $teilbuchung->ID = $row->ID;
                $teilbuchung->lesen();
                $this->teilbuchungen[] = $teilbuchung;

                // Jetzt wird noch das Datum der ersten und der letzten Teilbuchung bestimmt
                if(((isset($this->datum_erste_spende) && $teilbuchung->datum < $this->datum_erste_spende) || !isset($this->datum_erste_spende)) && $teilbuchung->datum != "0000-00-00") {$this->datum_erste_spende = $teilbuchung->datum;}
                if((isset($this->datum_letzte_spende) && $teilbuchung->datum > $this->datum_letzte_spende) || !isset($this->datum_letzte_spende)) {$this->datum_letzte_spende = $teilbuchung->datum;}
            }
        }
    }

    public static function spendenquittungen_erstellen($spendenquittungen) {
        $ich = new ich;
        $benutzer     = new Benutzer;
        $benutzer->ID = $_SESSION["id_benutzer"];
        $benutzer->get_benutzerdaten(); 
        foreach($spendenquittungen as $spendenquittung) {
            $spendenquittung->datum = heute_datum();

            // Eintrag der Stammdaten der Spendenquittung
            $eintrag = "INSERT INTO `spendenquittungen` 
            (`id_benutzer`, `summe`, `datum`, `freistellung_vom`, `vorstand`, `absender_nachname`, `absender_vorname`, `absender_strasse`, `absender_plz`, `absender_ort`, `absender_telefonnummer`)
            VALUES ('".$spendenquittung->debitor->ID."', '".$spendenquittung->summe."', '".$spendenquittung->datum."', '".$ich->freistellungsbescheid_vom."', '".$ich->vorstand."', '".$benutzer->nachname."', 
            '".$benutzer->vorname."', '".$benutzer->kontakt->strasse."', '".$benutzer->kontakt->plz."', '".$benutzer->kontakt->ort."', '".$benutzer->kontakt->telefonnummer."')";
            $id_spendenquittung = standard_sql($eintrag, "Erstellen einer Spendenquittung");

            // Eintrag der Nummer der Spendenquittung
            $jahr = jahr_aus_datum(heute_datum());
            $nr_spendenquittung = $jahr."_".$id_spendenquittung;
            $eintrag = "UPDATE `spendenquittungen` Set  `nr_spendenquittung`='".$nr_spendenquittung."' WHERE `ID`='".$id_spendenquittung."'";
            standard_sql($eintrag, "Eintrag der Nummer der Spendenquittung");

            // Markieren der Teilbuchungen mit der Nr. der Spendenquittung
            foreach($spendenquittung->teilbuchungen as $teilbuchung) {
                $eintrag = "UPDATE `teilbuchungen` Set `nr_spendenquittung`='".$nr_spendenquittung."' WHERE `ID`='".$teilbuchung->ID."'";
                standard_sql($eintrag, "Eintrag der Nummer der Spendenquittung in die Teilbuchung");
            }
        }
    }

    public static function lese_daten_offene_teilbuchungen($id_debitor = 0) {
        $cluster_teilbuchungen = teilbuchung::teilbuchungen_ohne_spendenquittung_lesen($id_debitor);
        
        $spendenquittungen     = Array();
        $start = time();
        
        foreach($cluster_teilbuchungen as $key=>$cluster) {
            $spendenquittung = new spendenquittung;

            $benutzer                 = new Benutzer;
            $benutzer->ID             = $key;
            $benutzer->get_benutzerdaten();
            $spendenquittung->debitor = $benutzer;
            
            $spendenquittung->summe = 0;
            
            foreach($cluster as $nr=>$teilbuchung) {
                // Das Datum ist in der Teilbuchung nicht gespeichert, sondern nur in der dazugehörigen (Hauot-)Buchung
                $buchung     = new buchung;
                $buchung->ID = $teilbuchung->id_buchung;
                $buchung->kurzinfo_lesen();
                
                $teilbuchung->datum                  = $buchung->datum;
                $teilbuchung->kommentar_hauptbuchung = $buchung->kommentar;

                // An dieser Stelle wird unterschieden, ob die Spende im Soll oder Haben gebuchgt wurde (es kann sich um eine Rücklastschrift handeln)    
                $konto = new konto;
                $konto->ID = $teilbuchung->id_konto_haben;
                
                $konto->lesen_kontenart();
                if($konto->art != "ertrag") {
                    $teilbuchung->summe = $teilbuchung->summe * -1;
                }
                
                $spendenquittung->summe += $teilbuchung->summe;
                $spendenquittung->teilbuchungen[] = $teilbuchung;
            }
            
            $spendenquittungen[] = $spendenquittung;
        }
        return $spendenquittungen;  
    }

    public static function uebersicht_alle_spendenquittungen() {
        $spendenquittungen = Array();
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `spendenquittungen` ORDER BY `ID` DESC";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $spendenquittung                     = new spendenquittung;
                $spendenquittung->ID                 = $row->ID;
                $spendenquittung->debitor            = benutzername($row->id_benutzer); // Normalerweise Objekt, aber in der Übersicht der Geschwindigkeit wegen nur Name
                $spendenquittung->summe              = $row->summe;
                $spendenquittung->datum              = $row->datum;
                $spendenquittung->nr_spendenquittung = $row->nr_spendenquittung;
                $spendenquittungen[] = $spendenquittung;
            }
        }    
        return $spendenquittungen;
    }
}

class ich {
    public $ID;
    public $vereinsname;
    public $adresszeile;
    public $strasse;
    public $plz;
    public $ort;
    public $telefonnummer;
    public $email;
    public $vorstand;
    public $freistellungsbescheid_vom;

    public function __construct() {
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `ich`";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->ID                           = $row->ID;
                $this->vereinsname                  = $row->vereinsname;
                $this->adresszeile                  = $row->adresszeile;
                $this->strasse                      = $row->strasse;
                $this->plz                          = $row->plz;
                $this->ort                          = $row->ort;
                $this->telefonnummer                = $row->telefonnummer;
                $this->email                        = $row->email;
                $this->vorstand                     = $row->vorstand;
                $this->freistellungsbescheid_vom    = $row->freistellungsbescheid_vom;
            }
        }
    }

    public function formular_lesen() {
        $this->vereinsname                  = $_POST["vereinsname"];
        $this->adresszeile                  = $_POST["adresszeile"];
        $this->strasse                      = $_POST["strasse"];
        $this->plz                          = $_POST["plz"];
        $this->ort                          = $_POST["ort"];
        $this->telefonnummer                = $_POST["telefonnummer"];
        $this->email                        = $_POST["email"];
        $this->vorstand                     = $_POST["vorstand"];
        $this->freistellungsbescheid_vom    = $_POST["freistellungsbescheid_vom"];
    }

    public function bearbeiten() {
        $eintrag = "UPDATE `ich` Set
        `vereinsname`               = '".$this->vereinsname."',
        `adresszeile`               = '".$this->adresszeile."',           
        `strasse`                   = '".$this->strasse."',       
        `plz`                       = '".$this->plz."',       
        `ort`                       = '".$this->ort."',
        `telefonnummer`             = '".$this->telefonnummer."',       
        `email`                     = '".$this->email."',          
        `vorstand`                  = '".$this->vorstand."',         
        `freistellungsbescheid_vom` = '".$this->freistellungsbescheid_vom."'";
        standard_sql($eintrag, "Bearbeiten der Vereinsdaten");
    }
}

class abschluss {
    public $aktiva;  //Array Konten
    public $passiva; //Array
    public $ertrag;  //Array
    public $aufwand; //Array

    public $summe_ertrag;
    public $summe_aufwand;
    public $kapital;
    public $eigenkapital;
    public $fremdkapital;
    public $ergebnis;

    public $echtlauf;

    public function __construct($echt) {
        $this->aktiva  = Array();
        $this->passiva = Array();
        $this->ertrag  = Array();
        $this->aufwand = Array();

        $this->echtlauf= $echt;    

        $this->bilanz_und_guv();
    }

    private function bilanz_und_guv() {
        // GuV
        echo '<span style="font-family: Arial Black; font-size: 16px;">Gewinn- und Verlustrechnung</span><p>';
        $kontenarten    = Array("Ertrag", "Aufwand");
        echo '<table rules="all">
        <tr><td>Konto-nr.</td><td>Bezeichnung</td><td>Ertrag</td><td>Aufwand</td></tr>';
        foreach ($kontenarten as $art) {
            $konten = konto::lesen_ueberischt_kontenart($art);
            foreach ($konten as $konto) {
                if($art == "Ertrag") {
                    echo "<tr><td>".$konto->nr.'</td><td>'.$konto->bezeichnung.'</td><td align="right">'.zahl_de($konto->saldo_aktuell).'</td><td></td></tr>';
                    $this->ertrag[] = $konto;
                    $this->summe_ertrag += $konto->saldo_aktuell;
                } else {
                    echo "<tr><td>".$konto->nr.'</td><td>'.$konto->bezeichnung.'</td><td></td><td align="right" ';
                    if($konto->saldo_aktuell > 0) {echo 'style="color: red;"';}
                    echo '>'.zahl_de($konto->saldo_aktuell).'</td></tr>';
                    $this->aufwand[] = $konto;
                    $this->summe_aufwand += $konto->saldo_aktuell;
                }
            }
        }
        $this->ergebnis = $this->summe_ertrag - $this->summe_aufwand;
        echo '<tr><td colspan="2"></td><td>'.zahl_de($this->summe_ertrag).'</td><td style="color: red;">'.zahl_de($this->summe_aufwand).'</td></tr>';
        echo '<tr style="font-size: 20px;"><td colspan="4" ';
        if($this->ergebnis < 0) echo 'style="color: red;"';
        echo '>Jahresergebnis: '.zahl_de($this->ergebnis).'</td></tr></table><p>';

        // Bilanz
        echo '<span style="font-family: Arial Black; font-size: 16px;">Bilanz</span><p>';
        $kontenarten = Array("Aktiva", "Passiva");
        echo '<table rules="all">
        <tr><td>Konto-nr.</td><td>Bezeichnung</td><td>Aktiva</td><td>Passiva</td><td>Saldo Anfang</td><td>Ver&auml;nderung</td><td>Saldo aktuell</td></tr>
        <tr><td colspan="7" align="center">AKTIVA</td></tr>';
        $pruefsumme_guv = 0;
        foreach ($kontenarten as $key=>$art) {
            if($key == 1) {
                // Wenn key = 1 ist das Array der Aktivakonten komplett durchiteriert
                echo '<tr><td colspan="6"><td align="right" ';
                if($this->kapital < 0) {echo 'style="color: red;"';}
                echo '>'.zahl_de($this->kapital).'</td></tr>
                <tr><td colspan="7" align="center">PASSIVA</td></tr>';}
            $konten = konto::lesen_ueberischt_kontenart($art);
            foreach ($konten as $konto) {
                if($art == "Aktiva") {
                    $konto->bewegung = $konto->saldo_aktuell - $konto->saldo_anfang;
                    $pruefsumme_guv += $konto->bewegung;
                    echo '<tr align="right"><td>'.$konto->nr.'</td><td>'.$konto->bezeichnung.'</td><td align="center">X</td><td></td><td>'.zahl_de($konto->saldo_anfang).'</td><td ';
                    if($konto->bewegung < 0) {echo 'style="color: red;"';}
                    echo '>'.zahl_de($konto->bewegung).'</td><td>'.zahl_de($konto->saldo_aktuell).'</td></tr>';
                    $this->aktiva[] = $konto;
                    $this->kapital += $konto->saldo_aktuell;
                } else {
                    $konto->bewegung = $konto->saldo_aktuell - $konto->saldo_anfang;
                    $pruefsumme_guv -= $konto->bewegung;
                    echo '<tr align="right"><td>'.$konto->nr.'</td><td>'.$konto->bezeichnung.'</td><td></td><td align="center">X</td><td>'.zahl_de($konto->saldo_anfang).'</td><td ';
                    if($konto->bewegung < 0) {echo 'style="color: blue;"';}
                    echo '>'.zahl_de($konto->bewegung).'</td><td>'.zahl_de($konto->saldo_aktuell).'</td></tr>';
                    $this->passiva[]     = $konto;
                    $this->fremdkapital += $konto->saldo_aktuell;
                }
            }
            // Falls keine Schulden bestehen, gibt es kein Fremdkapital. Es muss jedoch ein Wert für einen korrekten Eintrag in der DB gesetzt werden
            if($this->fremdkapital == "") {$this->fremdkapital = 0;}
        }

        // Eigenkapitalberechnung
        $this->eigenkapital = $this->kapital - $this->fremdkapital;
        if($this->eigenkapital < 0) {
            $text  = "Durch Eigenkapital nicht gedeckter Fehlbetrag";
            $color = "red";
        } else {
            $text  = "Eigenkapital";
            $color = "green";
        }
        echo '<tr><td colspan="6">Fremdkapital</td><td align="right">'.zahl_de($this->fremdkapital).'</td></tr>';
        echo '<tr style="font-size: 20px;"><td colspan="6">'.$text.'</td><td style="color: '.$color.';" align="right">'.zahl_de($this->eigenkapital).'</td></tr>';
        echo '</table><p>';

        $plausibiltaetspruefungszahl = $this->ergebnis - $pruefsumme_guv;
        // Das Ergebnis der Plausibilitätsprüfung wird auf 2 - Nachkommastellen gekürzt
        $plausibiltaetspruefungszahl = round($plausibiltaetspruefungszahl, 2);
        if($plausibiltaetspruefungszahl == 0) {
            echo 'Ergebnis der Plausibilit&auml;tspr&uuml;fung: OK<p>';
            if($this->echtlauf == 1) {$this->speichern();}
        } else {
            echo '<span style="color: red;">Es gibt eine Abweichung zwischen den Bewegungen in den Konten und dem Jahresergebnis von '.zahl_de($plausibiltaetspruefungszahl).'</span>';
        }
    }

    private function speichern() {
        // Speichern eines neuen Geschäftsjahres
        $folgejahr            = new jahr();
        $folgejahr->aktiv     = 1;
        $jahreszahl      = jahr_aus_datum($folgejahr->datum_von);
        $jahreszahl++;
        $folgejahr->jahr      = $jahreszahl;
        $folgejahr->datum_von = datum_jahr_tauschen($folgejahr->datum_von, $jahreszahl);
        // Unregelmäßiges Geschäftsjahr
        if(monat_aus_datum($folgejahr->datum_bis) < monat_aus_datum($folgejahr->datum_von)) {
            // Das Geschäftsjahr im anderen Kalenderjahr als es anfängt
            $jahreszahl++;
        }
        $folgejahr->datum_bis = datum_jahr_tauschen($folgejahr->datum_bis, $jahreszahl);
        $folgejahr->ID        = $folgejahr->speichern(0); // 0 steht für "Formular nicht lesen"

        // Speichern des Abschlusses
        $eintrag = "INSERT INTO `abschluesse` (`id_jahr`, `eigenkapital`, `ergebnis`, `fremdkapital`, `kapital`, `summe_ertrag`, `summe_aufwand`)
        VALUES ('".$_SESSION["jahr_id"]."', '".$this->eigenkapital."', '".$this->ergebnis."', '".$this->fremdkapital."', '".$this->kapital."', '".$this->summe_ertrag."', '".$this->summe_aufwand."')";
        $id_abschluss = standard_sql($eintrag, "Speichern des Jahresabschlusses");
        
        // Speichern der Konten
        $alle_konten = Array($this->aktiva, $this->passiva, $this->ertrag, $this->aufwand);
        foreach($alle_konten as $key=>$kontenart) {
            foreach ($kontenart as $konto) {
                // Bei Erfolgskonten ist die Kontenbewegung identisch mit dem Saldo
                if($key == 2 || $key == 3) {
                    $konto->bewegung = $konto->saldo_aktuell;
                }
                // Eintrag des Kontos in den Jahresabschluss
                $eintrag = "INSERT INTO `abschluesse_konten` (`art`, `id_abschluss`, `nr_konto`, `bezeichnung`, `saldo_anfang`, `bewegung`, `saldo_ende`) VALUES
                ('".$konto->art."', '".$id_abschluss."', '".$konto->nr."', '".$konto->bezeichnung."', '".$konto->saldo_anfang."', '".$konto->bewegung."', '".$konto->saldo_aktuell."')";
                standard_sql($eintrag, "Eintrag der Abschlusskonten");

                // Anlegen des Anfangsbestands im kommenden Geschäftsjahr für Bestandskonten
                if($key == 0 || $key == 1) {
                    $konto->saldo_anfang = $konto->saldo_aktuell;
                } else {
                    $konto->saldo_anfang = 0;
                }
                $konto->anfangssaldo_eintragen($folgejahr->ID);
            }
        }

        // Blockieren der Umsätze
        $eintrag = "UPDATE `buchungen` Set `gesperrt`='1' WHERE `id_jahr`='".$_SESSION["jahr_id"]."'";
        standard_sql($eintrag, "Sperren der Buchungen");
        $eintrag = "UPDATE `teilbuchungen` Set `gesperrt`='1' WHERE `id_jahr`='".$_SESSION["jahr_id"]."'";
        standard_sql($eintrag, "Sperren der Teilbuchungen");

        
    }

    public static function lese_id_eintrag_jahresabschluss($id_jahr) {
        $id_eintrag = gesuchtes_feld($id_jahr, "abschluesse", "id_jahr", "ID");
        return $id_eintrag;
    }


}

?>