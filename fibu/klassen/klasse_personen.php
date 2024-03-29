<?php

class Kontaktdaten {
	public $strasse;
	public $plz;
	public $ort;
	
	public $telefonnummer;
	public $mobil;
	public $email;

}

class Benutzer {
	public $ID;
	public $vorname;
	public $nachname;
	public $benutzername;
	public $kontakt; // Eigenständige Klasse
	public $monate; // Array
    public $iban;
    public $bic;
	public $admin;
	public $passwort;
    public $jahresbeitrag;
    public $monatsbeitrag;            
    public $mandatsreferenznummer;    

	public function __construct() {
		$this->monate = Array();
		$this->kontakt = new Kontaktdaten;
	}

	public static function neuen_speichern($benutzername, $passwort) {
		$mysqli   = MyDatabase();
		$eintrag  = "INSERT INTO `Benutzer` (`benutzername`, `passwort`) VALUES ('".$benutzername."', '".$passwort."')";
		if($mysqli->query($eintrag)) {
			echo "Neuer Benutzer gespeichert.<p>";
		}
		else {
			echo "Fehler beim Speichern des neuen Benutzers, siehe SQL_Befehl: <br>".$eintrag."<p>";
		}
	}
	
	public function formular_benutzerdaten_lesen() {
		$this->vorname					= $_POST["vorname"];
		$this->nachname					= $_POST["nachname"];
		$this->benutzername				= $_POST["benutzername"];
		$this->kontakt->strasse			= $_POST["strasse"];
		$this->kontakt->plz				= $_POST["plz"];
		$this->kontakt->ort 			= $_POST["ort"];
		$this->kontakt->telefonnummer	= $_POST["telefonnummer"];
		$this->kontakt->mobil 			= $_POST["mobil"];
		$this->kontakt->email			= $_POST["email"];
        $this->iban                     = $_POST["iban"];
        $this->bic                      = $_POST["bic"];
        $this->monate[1]                = PostMyVAr("januar", 0);
        $this->monate[2]                = PostMyVAr("februar", 0);
        $this->monate[3]                = PostMyVAr("maerz", 0);
        $this->monate[4]                = PostMyVAr("april", 0);
        $this->monate[5]                = PostMyVAr("mai", 0);
        $this->monate[6]                = PostMyVAr("juni", 0);
        $this->monate[7]                = PostMyVAr("juli", 0);
        $this->monate[8]                = PostMyVAr("august", 0);
        $this->monate[9]                = PostMyVAr("september", 0);
        $this->monate[10]               = PostMyVAr("oktober", 0);
        $this->monate[11]               = PostMyVAr("november", 0);
        $this->monate[12]               = PostMyVAr("dezember", 0);
        $this->monatsbeitrag            = PostMyVAr("monatsbeitrag", 0);
        $this->mandatsreferenznummer    = $_POST["mandatsreferenznummer"];
        
		if(isset($_POST["admin"])) {
			$this->admin				= $_POST["admin"];
		}
		else {
			$this->admin				= 0;
		}
		// Evtl. Anpassung des Passworts
		$passwort 						= $_POST["passwort"];
		$passwort2 						= $_POST["passwort2"];
		if($passwort != "" && $passwort === $passwort2) {
			$this->passwort = $passwort;
		}
		else {
			$this->passwort = "";
		}
		$this->daten_bearbeiten();
	}

	private function daten_bearbeiten() {
		$mysqli  = MyDatabase();
		$eintrag = "UPDATE `Benutzer` Set
		`benutzername`  = '".$this->benutzername."',
		`nachname`      = '".$this->nachname."',
		`vorname`       = '".$this->vorname."',
		`strasse`       = '".$this->kontakt->strasse."',
		`plz`           = '".$this->kontakt->plz."',
		`ort`           = '".$this->kontakt->ort."',
		`telefonnummer` = '".$this->kontakt->telefonnummer."',
		`mobil`         = '".$this->kontakt->mobil."',
		`email`         = '".$this->kontakt->email."',
		`admin`         = '".$this->admin."',
        `iban`          = '".$this->iban."',              
        `bic`           = '".$this->bic."',                  
        `monat1`       = '".$this->monate[1]."',               
        `monat2`       = '".$this->monate[2]."',            
        `monat3`       = '".$this->monate[3]."',              
        `monat4`       = '".$this->monate[4]."',        
        `monat5`       = '".$this->monate[5]."',            
        `monat6`       = '".$this->monate[6]."',        
        `monat7`       = '".$this->monate[7]."',        
        `monat8`       = '".$this->monate[8]."',      
        `monat9`       = '".$this->monate[9]."',
        `monat10`      = '".$this->monate[10]."',         
        `monat11`      = '".$this->monate[11]."',         
        `monat12`      = '".$this->monate[12]."',                    
        `monatsbeitrag` = '".$this->monatsbeitrag."',           
        `mandatsreferenznummer` = '".$this->mandatsreferenznummer."'";
		if($this->passwort != "") {$eintrag .= ", `passwort` = '".$this->passwort."'";}
		$eintrag .= "WHERE `ID` = '".$this->ID."'";
		
		if($mysqli->query($eintrag)) {
			echo "Daten ver&auml;ndert<p>";
		}
		else {
			echo "Fehler beim Speichern der Daten: $eintrag";
		}
	}

	public function login($benutzername, $passwort) {
		$test = 0;
		$mysqli = MyDatabase();
		$abfrage = "SELECT * FROM `Benutzer`";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				if($row->benutzername == $benutzername && $row->passwort == $passwort) {
					$_SESSION["id_benutzer"] = $row->ID;
					$test = 1;
					// Ist der Benutzer auch Administrator?
					$_SESSION["admin"] = $row->admin;
				}
			}
		}
		else {
			echo "Es konnten keine Beutzer aus der Datenbank gelesen werden<p>";
		}
		if($test == 0) {echo "<p>Benutzername oder Passwort falsch.<br>";}
	}

	public function logout() {
		session_destroy();
	}

	public function get_benutzerdaten() {
		$mysqli = MyDatabase();
		$abfrage = "SELECT * FROM `Benutzer` WHERE `ID`='".$this->ID."'";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				$this->vorname			= $row->vorname;
				$this->nachname			= $row->nachname;
				$this->benutzername		= $row->benutzername;
				$gekaufte_artikel		= $row->ids_gekaufte_artikel;
				$this->ids_gekaufte_artikel = explode("*", $gekaufte_artikel);
				$this->admin			= $row->admin;
				$this->kontakt->strasse	= $row->strasse;
				$this->kontakt->plz		= $row->plz;
				$this->kontakt->ort		= $row->ort;
				
				$this->kontakt->telefonnummer = $row->telefonnummer;
				$this->kontakt->mobil	= $row->mobil;
				$this->kontakt->email	= $row->email;
                
                $this->iban             = $row->iban;              
                $this->bic              = $row->bic;  

                $this->monate[1]        = $row->monat1;               
                $this->monate[2]        = $row->monat2;            
                $this->monate[3]        = $row->monat3;              
                $this->monate[4]        = $row->monat4;        
                $this->monate[5]        = $row->monat5;            
                $this->monate[6]        = $row->monat6;        
                $this->monate[7]        = $row->monat7;        
                $this->monate[8]        = $row->monat8;      
                $this->monate[9]        = $row->monat9;
                $this->monate[10]       = $row->monat10;         
                $this->monate[11]       = $row->monat11;         
                $this->monate[12]       = $row->monat12;                    
                $this->monatsbeitrag    = $row->monatsbeitrag;           
                $this->mandatsreferenznummer = $row->mandatsreferenznummer;
			}
		}
	}

	/*
	public function filme_speichern($filme) {
		$this->ids_gekaufte_artikel = Array();
		echo "Filme hat ".count($filme)." Elemente<br>";
		foreach ($filme as $key => $film) {
			if($film == 1) {$this->ids_gekaufte_artikel[] = $key;}
		}
		
		$ids_gekaufte_artikel = implode("*", $this->ids_gekaufte_artikel);
		$mysqli = MyDatabase();
		$eintrag = "UPDATE `Benutzer` Set `ids_gekaufte_artikel`='".$ids_gekaufte_artikel."' WHERE `ID` = '".$this->ID."'";
		if($mysqli->query($eintrag)) {
			echo 'Gekaufte Artikel gespeichert<br>';
		}
		else {
			echo 'Fehler beim Speichern der gekauften Artikel<br>';
		}
	}
	*/

	public function einzugsdaten_vorhanden() {
		$antwort = false;
		if($this->iban != "") {$antwort = true;}           
		if($this->monate[1] != 0) {$antwort = true;}             
		if($this->monate[2] != 0) {$antwort = true;}             
		if($this->monate[3] != 0) {$antwort = true;}              
		if($this->monate[4] != 0) {$antwort = true;}        
		if($this->monate[5] != 0) {$antwort = true;}             
		if($this->monate[6] != 0) {$antwort = true;}        
		if($this->monate[7] != 0) {$antwort = true;}         
		if($this->monate[8] != 0) {$antwort = true;}       
		if($this->monate[9] != 0) {$antwort = true;} 
		if($this->monate[10]!= 0) {$antwort = true;}         
		if($this->monate[11]!= 0) {$antwort = true;}        
		if($this->monate[12]!= 0) {$antwort = true;}                    
		if($this->monatsbeitrag != 0) {$antwort = true;}           
		if($this->mandatsreferenznummer != "") {$antwort = true;}
		return $antwort;
	}

	public static function namen_aller_benutzer() {
		$alle_benutzer = Array();
		$mysqli = MyDatabase();
		$abfrage = "SELECT * FROM `Benutzer` ORDER BY `benutzername` ASC";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				$benutzer     			= new Benutzer;
				$benutzer->ID 			= $row->ID;
				$benutzer->get_benutzerdaten();
				$alle_benutzer[] = $benutzer;
			}
		}
		return $alle_benutzer;
	}
    

}

?>