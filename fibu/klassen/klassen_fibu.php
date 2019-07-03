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
    public $summe;
}


class buchung {
    public $ID;
    public $nr;
    public $id_konto_soll; // Array, beinhalten Objekte des Typs Teilbuchung
    public $id_konto_haben; // Array
    public $id_deb_kred;
    public $summe;
    public $datum;
    public $kommentar;

    public function formular_lesen() {
        $this->nr               = $_POST["nr"];
        $this->id_konto_soll    = $_POST["id_konto_soll"];
        $this->id_konto_haben   = $_POST["id_konto_haben"];
        $this->id_deb_kred      = $_POST["id_deb_kred"];
        $this->summe            = zahl_pc($_POST["summe"]);
        $this->datum            = $_POST["datum"];
        $this->kommentar        = $_POST["kommentar"];
    }

    public function speichern() {
        $this->formular_lesen();
        $eintrag = "INSERT INTO `buchungen` (`nr`, `id_konto_soll`, `id_konto_haben`, `id_deb_kred`, `summe`, `datum`, `kommentar`)
        VALUES ('".$this->nr."', '".$this->id_konto_soll."', '".$this->id_konto_haben."', '".$this->id_deb_kred."', '".$this->summe."', '".$this->datum."', '".$this->kommentar."')";
        standard_sql($eintrag, "Eintrag der Buchung");
    }

    public function lesen() {
        $mysqli = MyDatabase();
        $abfrage = "SELECT * FROM `buchungen` WHERE `ID`='".$this->ID."'";
        if($result = $mysqli->query($abfrage)) {
            while($row = $result->fetch_object()) {
                $this->nr               = $row->nr;
                $this->id_konto_soll    = $row->id_konto_soll;
                $this->id_konto_haben   = $row->id_konto_haben;
                $this->id_deb_kred      = $row->id_deb_kred;
                $this->summe            = zahl_de($row->summe);
                $this->datum            = $row->datum;
                $this->kommentar        = $row->kommentar;
            }
        }
    }

    public function bearbeiten() {
        $this->formular_lesen();
        $eintrag = "UPDATE `buchungen` Set 
        `nr`              = '".$this->nr."',
        `id_konto_soll`   = '".$this->id_konto_soll."',
        `id_konto_haben`  = '".$this->id_konto_haben."',
        `id_deb_kred`     = '".$this->id_deb_kred."',
        `summe`           = '".zahl_pc($this->summe)."',
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
        $this->aktiv=1;
    }

    public function speichern() {
        $this->formular_lesen();
        
        $mysqli  = MyDatabase();
        $eintrag = "INSERT INTO `kontenplan` (`nr`, `bezeichnung`, `art`, `aktiv`)
        VALUES ('".$this->nr."', '".$this->bezeichnung."', '".$this->art."', '".$this->aktiv."')";
        $this->ID = standard_sql($eintrag, "Speichern des Kontos");
        $jahr = new jahr;
        
        $eintrag = "INSERT INTO `anfangssalden` (`id_konto`, `id_jahr`, `anfangssaldo`) VALUES 
        ('".$this->ID."', '".$_SESSION["jahr_id"]."', '".zahl_pc($this->saldo_anfang)."')";
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
            }
        }
        $abfrage = "SELECT * FROM `anfangssalden` WHERE `id_konto`='".$this->ID."' AND `id_jahr`='".$_SESSION["jahr_id"]."'";
        if ($result = $mysqli->query($abfrage)) {
            while ($row = $result->fetch_object()) {
                $this->saldo_anfang = $row->anfangssaldo;                
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