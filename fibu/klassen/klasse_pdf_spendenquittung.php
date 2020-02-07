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
        $inhalte[] = $this->daten->absender->nachname." ".$this->daten->absender->vorname;
        $inhalte[] = $this->daten->absender->kontakt->strasse;
        $inhalte[] = $this->daten->absender->kontakt->plz." ".$this->daten->absender->kontakt->ort;
        $inhalte[] = $this->daten->kontakt->absender->telefonnummer;
        $inhalte[] = $ich->email;
        
        $this->SetFont("Arial", "", 10);
        $x = 150;
        $y = 35;
        
        foreach ($inhalte as $inhalt) {
            $this->SetXY($x, $y);
            $this->Cell(50, 5, utf8_decode($inhalt), 0);
            $y += 5;
        }
    }

    private function mittelteil() {
        // Überschrift
        $this->SetXY(10, 28);
        $this->SetFont("Arial", "B", 14);
        $this->MultiCell(140, 25, utf8_decode("Bestätigung über Zuwendungen im Sinne des §10 EstG"), 0); 
        
        $this->SetXY(10, 35);
        $this->MultiCell(140, 25, utf8_decode("Art der Zuwendung: Geldzuwendung"), 0);

        // Nummer und Datum Datum
        $this->SetFont("Arial", "", 11);
        $this->SetXY(10, 42);
        $this->MultiCell(140, 25, "Spendenbescheinigung Nr. ".$this->daten->nr_spendenquittung." vom ".date_to_datum($this->daten->datum), 0);

        // Definition der Konstante EUR für korrekte Darstellung des Eurozeichens
		if(!defined(EUR)) {
			define(EUR, chr(128));
		}

        $this->SetFont("Arial", "", 11);
        // Name des Spenders
        $this->SetXY(10, 70);
        $this->Cell(63, 10, "", 1); // Rahmen
        // Für den Fall, dass die Ausgaben mehrzeilig sein muss, geschieht die Ausgabe nicht in der gleichen Zelle wie der Rahmen
        $this->SetXY(10, 70);
        $this->MultiCell(63, 5, utf8_decode($this->daten->debitor->nachname.", ".$this->daten->debitor->vorname), 0);

        // Strasse
        $this->SetXY(73, 70);
        $this->Cell(63, 10, "", 1);
        $this->SetXY(73, 70);
        $this->MultiCell(63, 5, utf8_decode($this->daten->debitor->kontakt->strasse), 0);

        // PLZ und Ort
        $this->SetXY(136, 70);
        $this->Cell(63, 10, "", 1);
        $this->SetXY(136, 70);
        $this->Cell(63, 5, utf8_decode($this->daten->debitor->kontakt->plz." ".$this->daten->debitor->kontakt->ort), 0);

        // Betrag als Zahl
        $this->SetXY(10, 80);
        $this->Cell(63, 10, zahl_de($this->daten->summe)." ".EUR, 1);

        // Betrag in Worten
        $this->SetXY(73, 80);
        $this->Cell(63, 10, "", 1);
        $this->SetXY(73, 80);
        $this->MultiCell(63, 5, utf8_decode(betrag2text($this->daten->summe)), 0);

        // Zeitraum der Spenden
        $this->SetXY(136, 80);
        $this->Cell(63, 10, "", 1);
        $this->SetXY(136, 80);
        $datum_von_bis = date_to_datum($this->daten->datum_erste_spende);
        if($this->daten->datum_letzte_spende != $this->daten->datum_erste_spende) {
            $datum_von_bis .= " - ".date_to_datum($this->daten->datum_letzte_spende);
        }
        $this->MultiCell(63, 5, $datum_von_bis, 0);
    
        // Kein Verzicht auf Erstattung von Aufwendungen
        $this->SetXY(10, 93);
        $this->MultiCell(189, 5, "Es handelt sich dabei nicht um den Verzicht auf Erstattung von Aufwendungen.", 0);

        // Freistellung vom... 
        $this->SetXY(10, 103);
        $this->MultiCell(189, 5, $this->daten->freistellung_vom, 0);

        // Verwendungszweck
        $this->SetXY(10, 123);
        $this->MultiCell(189, 5, utf8_decode("Es wird bestätigt, dass die Zuwendung nur zur Förderung des Zweckes Völkerverständigung / humanitäre Hilfe im Sinne der Anl. 1 zu § 48 Abs. 2 Einkommensteuer-Durchführungsverordnung verwendet wird."), 0);

        // Datum und Unterschrift
        $this->SetXY(10, 150);
        $this->MultiCell(189, 5, utf8_decode($this->daten->absender->kontakt->ort).", den ".date_to_datum($this->daten->datum), 0);
        $this->SetXY(100, 150);
        $this->Cell(100, 5, ".........................................................................................", 0);
        $this->SetXY(100, 155);
        $this->Cell(100, 5, "Unterschrift", 0);

        // Nur bei mehreren Spenden:
        if(count($this->daten->teilbuchungen) > 1) {
            $this->SetXY(10, 160);
            $this->SetFont("Arial", "B", 11);
            $this->Cell(100, 5, "Einzelspenden:", 0);
            $this->SetFont("Arial", "", 11);
            $y = 165;
            foreach($this->daten->teilbuchungen as $spende) {
                $this->SetXY(10, $y);
                $this->Cell(30, 5, date_to_datum($spende->datum), 1);
                $this->SetXY(40, $y);
                $this->Cell(30, 5, zahl_de($spende->summe)." ".EUR, 1, 0, "R");
                $this->SetXY(70, $y);
                $this->Cell(130, 5, utf8_decode($spende->kommentar_hauptbuchung), 1);
                $y += 5;
            }
        }
    }

    public function footer() {
        $this->SetFont("Arial", "", 9);
        $this->SetXY(10, 260);
        $text  = "Hinweis: Wer vorsätzlich oder grob fahrlässig eine unrichtige Zuwendungsbestätigung erstellt oder wer veranlasst, dass Zuwendungen nicht zu den in der Zuwendungsbestätigung angegebenen steuerbegünstigten Zwecken verwendet werden, ";
        $text .= "haftet für die Steuer, die dem Fiskus durch einen etwaigen Abzug der Zuwendungen beim Zuwendenden entgeht (§10b Abs. 4 EStG, §9 Abs. 3 KStG, §9 Nr. 5 GewStG).\n";
        $text .= "Diese Bestätigung wird nicht als Nachweis für die steuerliche Berücksichtigung der Zuwendung anerkannt, wenn das Datum des Freistellungsbescheides länger als 5 Jahre bzw. das Datum der vorläufigen Bescheinigung länger als 3 Jahre ";
        $text .= "seit Ausstellung der Bestätigung zurückliegt (BMF vom 15.12.1994 - BStBI I S. 884).";
        $this->MultiCell(190, 4, utf8_decode($text), 0);
    }
}






?>