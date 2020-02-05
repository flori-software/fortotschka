<?php
class pdf_spendenquittung extends FPDF {
    private $daten;

    public function __construct($spendenquittung) {
        $this->daten = $spendenquittung;
        parent::__construct('P', 'mm', 'A4');
        $this->AddPage();
        $this->mittelteil();
    }

    public function header() {
        $this->Image("pics/bildreihe.png", 0, 0, 210);
        $this->Image("pics/logo.png", 10, 5, 150);
        
        // Vereinsanschrift
        $ich = new ich;
        $inhalte   = Array();
        $inhalte[] = $ich->vereinsname;
        $inhalte[] = $daten->absender->nachname." ".$daten->absender->vorname;
        $inhalte[] = $daten->absender->kontakt->strasse;
        $inhalte[] = $daten->absender->kontakt->plz." ".$daten->absender->kontakt->ort;
        $inhalte[] = $daten->kontakt->absender->telefonnummer;
        $inhalte[] = $ich->email;
        
        $this->SetFont("Arial", "", 10);
        $x = 150;
        $y = 35;
        
        foreach ($inhalte as $inhalt) {
            $this->SetXY($x, $y);
            $this->Cell(50, 5, utf8_decode($inhalt), 0);
            $y += 5;
        }

        // Überschrift
        $this->SetXY(10, 28);
        $this->SetFont("Arial", "B", 14);
        $this->MultiCell(140, 25, utf8_decode("Bestätigung über Zuwendungen im Sinne des §10 EstG"), 0); 
        
        $this->SetXY(10, 35);
        $this->MultiCell(140, 25, utf8_decode("Art der Zuwendung: Geldzuwendung"), 0);
    }

    private function mittelteil() {
        $this->SetFont("Arial", "", 12);
        // Name des Spenders
        $this->SetXY(10, 70);
        $this->Cell(63, 10, utf8_decode($this->daten->debitor->nachname.", ".$this->daten->debitor->vorname), 1);

        // Strasse
        $this->SetXY(73, 70);
        $this->Cell(63, 10, "", 1);

        // PLZ und Ort
        $this->SetXY(136, 70);
        $this->Cell(63, 10, "", 1);

        // Betrag als Zahl
        $this->SetXY(10, 80);
        $this->Cell(63, 10, "", 1);

        // Betrag in Worten
        $this->SetXY(73, 80);
        $this->Cell(63, 10, "", 1);

        // Zeitraum der Spenden
        $this->SetXY(136, 80);
        $this->Cell(63, 10, "", 1);

    }

    public function footer() {

    }
}






?>