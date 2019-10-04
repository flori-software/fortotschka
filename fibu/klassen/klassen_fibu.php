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

    public static function alle_zu_einer_buchung_lesen($id_buchung) {
        $mysqli  = MyDatabase();
        $teilbuchungen = Array();
        $abfrage = "SELECT * FROM `teilbuchungen` WHERE `id_buchung`=".$id_buchung;
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $teilbuchung = new teilbuchung;
                $teilbuchung->ID = $row->ID;
                $teilbuchung->id_buchung     = $row->id_buchung;
                $teilbuchung->kommentar      = $row->kommentar;
                $teilbuchung->id_deb_kred    = $row->id_deb_kred;
                $teilbuchung->id_konto_soll  = $row->id_konto_soll;
                $teilbuchung->id_konto_haben = $row->id_konto_haben;
                $teilbuchung->summe          = $row->summe;
                $teilbuchung->id_jahr        = $row->id_jahr; 
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

    public $teilbuchungen; // Array er Objekte der Klasse teilbuchung

    // Errechnete Eigenschaften
    public $summe; 

    public function __construct() {
        $this->teilbuchungen = Array();
    }

    public function formular_lesen() {
        echo 'Lese das Formular<br>';
        $this->datum            = $_POST["datum"];
        $this->kommentar        = $_POST["kommentar"];
        for($cnt = 0; $cnt < 20; $cnt++) {
            $teilbuchung = new teilbuchung;
            $teilbuchung->formular_lesen($cnt);
            $this->summe += $teilbuchung->summe; 
            $this->teilbuchungen[] = $teilbuchung;
        } 
        $this->speichern();
    }

    private function speichern() {
        if($this->summe > 0) {
            $eintrag = "INSERT INTO `buchungen` (`datum`, `kommentar`, `id_jahr`) VALUES ('".$this->datum."', '".$this->kommentar."', '".$_SESSION["jahr_id"]."')";
            $this->ID = standard_sql($eintrag, "Eintrag der Buchung");
        }
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
                $this->teilbuchungen = teilbuchung::alle_zu_einer_buchung_lesen($this->ID);
            }
        }
    }

    public function bearbeiten() {
        $this->formular_lesen();
        $eintrag = "UPDATE `buchungen` Set 
        `datum`           = '".$this->datum."',
        `kommentar`       = '".$this->kommentar."'
        WHERE `ID`='".$this->ID."'";
        standard_sql($eintrag, "Bearbeiten einer Buchung");
    }

    public static function lesen_alle($datum_von = "0001-01-01", $datum_bis = "2100-12-31", $id_konto_soll = 0, $id_konto_haben = 0) {
        $buchungen = Array();
        $mysqli  = MyDatabase();
        $abfrage = "SELECT `ID` FROM `buchungen` WHERE `datum` >= '".$datum_von."' AND `datum` <= '".$datum_bis."' ";
        if($id_konto_soll != 0) {$abfrage .= "AND `id_konto_soll`='.$id_konto_soll.'";}
        if($id_konto_haben != 0) {$abfrage .= "AND `id_konto_haben`='.$id_konto_haben.'";}
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
    public $umsaetze;      // Array
    public $aktiv;
    
    public function formular_lesen() {
        $this->nr           = $_POST["nr"];
        $this->bezeichnung  = $_POST["bezeichnung"];
        $this->art          = $_POST["art"];
        $this->saldo_anfang = $_POST["saldo_anfang"];
    }

    public function speichern() {
        $mysqli  = MyDatabase();
        $eintrag = "INSERT INTO `kontenplan` (`nr`, `bezeichnung`, `art`, `aktiv`)
        VALUES ('".$this->nr."', '".$this->bezeichnung."', '".$this->art."', '".$this->aktiv."')";
        $this->ID = standard_sql($eintrag, "Speichern des Kontos");
        $jahr = new jahr;
        $eintrag = "INSERT INTO `anfangssalden` (`id_konto`, `jahr`, `anfangssaldo`) VALUES 
        ('".$this->ID."', '".$jahr."', '".$this->saldo_anfang."')";
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
                $this->saldo_anfang = $row->saldo_anfang;       
            }
        }
    }
    
    public static function lesen_ueberischt_kontenart($art) {
        // art: aktiva, passiva, ertrag, aufwand
        $mysqli  = MyDatabase();
        $konten = Array();
        $abfrage = "SELECT * FROM `kontenplan` WHERE `art`='".$art."'";
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
    
}





?>