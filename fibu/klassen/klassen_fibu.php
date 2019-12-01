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
            $mysqli = MyDatabase();
            $abfrage = "SELECT * FROM `jahr` WHERE `ID`='".$this->ID."'";
            if($result = $mysqli->query($abfrage)) {
                while($row = $result->fetch_object()) {
                    $this->jahr = $row->jahr;
                    $_SESSION["jahr_id"] = $this->ID;
                    $_SESSION["jahr"]    = $this->jahr;
                }
            }
        }
    }
    public function formular_lesen() {
        $this->jahr      = $_POST["jahr"];
        $this->datum_von = $_POST["datum_von"];
        $this->datum_bis = $_POST["datum_bis"];
        $this->aktiv=1;
    }
    public function speichern() {
        
        $this->formular_lesen();
        $eintrag = "INSERT INTO `jahr` (`jahr`, `datum_von`, `datum_bis`, `aktiv`)
        VALUES ('".$this->jahr."', '".$this->datum_von."', '".$this->datum_bis."', '".$this->aktiv."')";
        standard_sql($eintrag, "Speichern eines Geschaeftsjahres");
        
    }
    public function aendern() {
        $this->jahr = $_POST["jahr"];
        $eintrag = "UPDATE `jahr` Set `jahr`='".$this->jahr."'";
        standard_sql($eintrag, "Wahl der Geschaeftsjahres");
    }
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
    public $id_jahr;

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
                $this->kommentar      = $row->kommentar;
                $this->id_deb_kred    = $row->id_deb_kred;
                $this->id_konto_soll  = $row->id_konto_soll;
                $this->id_konto_haben = $row->id_konto_haben;
                $this->summe          = $row->summe;
                $this->id_jahr        = $row->id_jahr; 
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
        if($this->summe > 0) {
            $eintrag = "INSERT INTO `buchungen` (`datum`, `kommentar`, `id_jahr`, `gesperrt`) VALUES ('".$this->datum."', '".$this->kommentar."', '".$_SESSION["jahr_id"]."', 0)";
            $this->ID = standard_sql($eintrag, "Eintrag der Buchung");
        }
        foreach ($this->teilbuchungen as $teilbuchung) {
            $teilbuchung->id_buchung = $this->ID;
            if($teilbuchung->summe != 0) {
                $teilbuchung->speichern();
            }  
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
        $abfrage .= " ORDER BY `datum` DESC";
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
        $eintrag = "INSERT INTO `anfangssalden` (`id_konto`, `id_jahr`, `anfangssaldo`) VALUES 
        ('".$this->ID."', '".$_SESSION["jahr_id"]."', '".$this->saldo_anfang."')";
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





?>