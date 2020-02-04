<?php
class pdf_spendenquittung extends FPDF {

    public function __construct($spendenquittung) {
        parent::__construct('P', 'mm', 'A4');
        $this->AddPage();
    }

    public function header() {
        $this->Image("pics/bildreihe.png", 0, 0, 210);
        $this->Image("pics/logo.png", 10, 5, 150);
    }

    public function footer() {

    }
}






?>