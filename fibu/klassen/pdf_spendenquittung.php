<?php

class pdf_spendenquittung extends TCPDF {
    private $spendenquittung; // Objekt der Klasse spendenquittung
    
    public function __construct($spendenquittung) {
        $this->spendenquittung = $spendenquittung;
        parent::__construct('P', 'mm', 'A4');

        // Erste Seite wird hinzugefügt
        $this->AddPage();


        $this->SetXY(5, 5);
		$this->SetFont("Helvetica", "", 8);
        // PDF wird erzeugt
        $this->Output();
    }

    public function Header() {
        // Set header content here
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Spendenquittung', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    public function Footer() {
        // Set footer content here
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Seite ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}






?>