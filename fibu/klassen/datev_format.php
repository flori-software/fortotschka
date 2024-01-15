<?php
class DatevFormatType {
    const PLAIN = 1;
    const ESCAPED = 2;
}

class DatevFormat {
    public DatevFormatHeader $header;
    public array $rows = [];

    public function __construct(DateTime $start, DateTime $end, Datev_Settings $settings) {
        $this->header = new DatevFormatHeader($start, $end, $settings);
    }

    public function add_row($row) {
        array_push($this->rows, $row);
    }

    public function get_csv() {
        $csv = $this->header->to_string();
        $csv .= "Umsatz (ohne Soll/Haben-Kz);Soll/Haben-Kennzeichen;WKZ Umsatz;Kurs;Basis-Umsatz;WKZ Basis-Umsatz;Konto;Gegenkonto (ohne BU-Schlüssel);BU-Schlüssel;Belegdatum;Belegfeld 1;Belegfeld 2;Skonto;Buchungstext;Postensperre;Diverse Adressnummer;Geschäftspartnerbank;Sachverhalt;Zinssperre;Beleglink;Beleginfo - Art 1;Beleginfo - Inhalt 1;Beleginfo - Art 2;Beleginfo - Inhalt 2;Beleginfo - Art 3;Beleginfo - Inhalt 3;Beleginfo - Art 4;Beleginfo - Inhalt 4;Beleginfo - Art 5;Beleginfo - Inhalt 5;Beleginfo - Art 6;Beleginfo - Inhalt 6;Beleginfo - Art 7;Beleginfo - Inhalt 7;Beleginfo - Art 8;Beleginfo - Inhalt 8;KOST1 - Kostenstelle;KOST2 - Kostenstelle;Kost-Menge;EU-Land u. UStID;EU-Steuersatz;Abw. Versteuerungsart;Sachverhalt L+L;Funktionsergänzung L+L;BU 49 Hauptfunktionstyp;BU 49 Hauptfunktionsnummer;BU 49 Funktionsergänzung;Zusatzinformation - Art 1;Zusatzinformation- Inhalt 1;Zusatzinformation - Art 2;Zusatzinformation- Inhalt 2;Zusatzinformation - Art 3;Zusatzinformation- Inhalt 3;Zusatzinformation - Art 4;Zusatzinformation- Inhalt 4;Zusatzinformation - Art 5;Zusatzinformation- Inhalt 5;Zusatzinformation - Art 6;Zusatzinformation- Inhalt 6;Zusatzinformation - Art 7;Zusatzinformation- Inhalt 7;Zusatzinformation - Art 8;Zusatzinformation- Inhalt 8;Zusatzinformation - Art 9;Zusatzinformation- Inhalt 9;Zusatzinformation - Art 10;Zusatzinformation- Inhalt 10;Zusatzinformation - Art 11;Zusatzinformation- Inhalt 11;Zusatzinformation - Art 12;Zusatzinformation- Inhalt 12;Zusatzinformation - Art 13;Zusatzinformation- Inhalt 13;Zusatzinformation - Art 14;Zusatzinformation- Inhalt 14;Zusatzinformation - Art 15;Zusatzinformation- Inhalt 15;Zusatzinformation - Art 16;Zusatzinformation- Inhalt 16;Zusatzinformation - Art 17;Zusatzinformation- Inhalt 17;Zusatzinformation - Art 18;Zusatzinformation- Inhalt 18;Zusatzinformation - Art 19;Zusatzinformation- Inhalt 19;Zusatzinformation - Art 20;Zusatzinformation- Inhalt 20;Stück;Gewicht;Zahlweise;Forderungsart;Veranlagungsjahr;Zugeordnete Fälligkeit;Skontotyp;Auftragsnummer;Buchungstyp;USt-Schlüssel (Anzahlungen);EU-Land (Anzahlungen);Sachverhalt L+L (Anzahlungen);EU-Steuersatz (Anzahlungen);Erlöskonto (Anzahlungen);Herkunft-Kz;Buchungs GUID;KOST-Datum;SEPA-Mandatsreferenz;Skontosperre;Gesellschaftername;Beteiligtennummer;Identifikationsnummer;Zeichnernummer;Postensperre bis;Bezeichnung SoBil-Sachverhalt;Kennzeichen SoBil-Buchung;Festschreibung;Leistungsdatum;Datum Zuord. Steuerperiode;Fälligkeit;Generalumkehr (GU);Steuersatz;Land\r\n";
        foreach($this->rows as $row) {
            $csv .= $row->to_string();
        }
        return $csv;
    }

    public function get_zip($file) {
        
        $dirname = __DIR__ . '/../download/';
        $filename = $dirname . 'DatevExport_' . date('d_m_Y_H_i') . ".zip";
        $zip = new ZipArchive();  
        if(!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }
        if($zip->open($filename, ZipArchive::CREATE) === true) {
            $zip->addFromString($file, $this->get_csv());
            $test = $this->get_csv();
            
            $zip->close();
            if (file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
                unlink($filename);
            }
            
        }
    }
}

class DatevFormatRow {
    public array $cells = [];

    public function __construct($length) {
        for($i = 0; $i < $length; $i++) {
            array_push($this->cells, NULL);
        }
    }

    public function set_cell($position, $type, $value) {
        $this->cells[$position - 1] = new DatevFormatCell($type, $value);
    }

    public function to_string() {
        $result = '';
        foreach($this->cells as $cell) {
            if(is_null($cell)) {
                $result .= ';';
            }
            else if($cell->type === DatevFormatType::ESCAPED) {
                $result .= '"' . $cell->value . '";';
            }
            else if($cell->type === DatevFormatType::PLAIN) {
                $result .= '' . $cell->value . ';';
            }
        }
        return substr($result, 0, -1) . "\r\n";
    }
}

class DatevFormatCell {
    public int $type;
    public string $value;

    public function __construct($type, $value) {
        $this->type = $type;
        
        if(is_numeric($value)) {
            $this->value = strval($value);
        }
        else {
            $this->value = $value;
        }
    }
}

class DatevFormatHeader extends DatevFormatRow {
    public function __construct(DateTime $start, DateTime $end, Datev_Settings $settings) {
        parent::__construct(31);

        $this->set_cell(1, DatevFormatType::ESCAPED, 'EXTF');
        $this->set_cell(2, DatevFormatType::PLAIN, '700');
        $this->set_cell(3, DatevFormatType::PLAIN, '21');
        $this->set_cell(4, DatevFormatType::ESCAPED, 'Buchungsstapel');
        $this->set_cell(5, DatevFormatType::PLAIN, '9');
        $this->set_cell(6, DatevFormatType::PLAIN, date("YmdHisv"));
        $this->set_cell(7, DatevFormatType::PLAIN, '');
        $this->set_cell(8, DatevFormatType::ESCAPED, 'RE');
        $this->set_cell(9, DatevFormatType::ESCAPED, '');
        $this->set_cell(10, DatevFormatType::ESCAPED, '');
        $this->set_cell(11, DatevFormatType::PLAIN, $settings->advisor_nr);
        $this->set_cell(12, DatevFormatType::PLAIN, $settings->client_nr);
        $this->set_cell(13, DatevFormatType::PLAIN, $settings->begin_fiscal_year->format('Ymd'));
        $this->set_cell(14, DatevFormatType::PLAIN, '4');
        $this->set_cell(15, DatevFormatType::PLAIN, $start->format("Ymd"));
        $this->set_cell(16, DatevFormatType::PLAIN, $end->format("Ymd"));
        $this->set_cell(17, DatevFormatType::ESCAPED, '');
        $this->set_cell(18, DatevFormatType::ESCAPED, '');
        $this->set_cell(19, DatevFormatType::PLAIN, '');
        $this->set_cell(20, DatevFormatType::PLAIN, '');
        $this->set_cell(21, DatevFormatType::PLAIN, '');
        $this->set_cell(22, DatevFormatType::ESCAPED, '');
        $this->set_cell(23, DatevFormatType::PLAIN, '');
        $this->set_cell(24, DatevFormatType::ESCAPED, '');
        $this->set_cell(25, DatevFormatType::PLAIN, '');
        $this->set_cell(26, DatevFormatType::PLAIN, '');
        $this->set_cell(27, DatevFormatType::ESCAPED, '');
        $this->set_cell(28, DatevFormatType::PLAIN, '');
        $this->set_cell(29, DatevFormatType::PLAIN, '');
        $this->set_cell(30, DatevFormatType::ESCAPED, '');
        $this->set_cell(31, DatevFormatType::ESCAPED, '');
    }
}

class DatevFormatBooking extends DatevFormatRow {
    public $sales;//float
    public $sh = 'S';//string
    public $account = 0;//int
    public $contra_account = 0;//int
    public $receipt_date;//DateTime
    public $receipt_nr;//string
    public $cost_location;//string
    public $text;//string

    public function __construct($sales, $account, $contra_account, $sh, $receipt_date, $receipt_nr, $cost_location, $text) {
        parent::__construct(120);

        $this->sales = $sales;
        $this->account = $account;
        $this->contra_account = $contra_account;
        $this->receipt_date = $receipt_date;
        $this->receipt_nr = $receipt_nr;
        $this->sh = strtoupper($sh);
        $this->cost_location = $cost_location;
        $this->text = $text;

        $this->set_cell(1, DatevFormatType::PLAIN, number_format($this->sales, 2, ',', ''));
        $this->set_cell(2, DatevFormatType::ESCAPED, $this->sh);
        $this->set_cell(3, DatevFormatType::ESCAPED, '');
        $this->set_cell(4, DatevFormatType::PLAIN, '');
        $this->set_cell(5, DatevFormatType::PLAIN, '');
        $this->set_cell(6, DatevFormatType::ESCAPED, '');
        $this->set_cell(7, DatevFormatType::PLAIN, strval($this->account));
        $this->set_cell(8, DatevFormatType::PLAIN, strval($this->contra_account));
        $this->set_cell(9, DatevFormatType::ESCAPED, '');
        $this->set_cell(10, DatevFormatType::PLAIN, $this->receipt_date->format('dm'));
        $this->set_cell(11, DatevFormatType::ESCAPED, $this->receipt_nr);
        $this->set_cell(12, DatevFormatType::ESCAPED, '');
        $this->set_cell(13, DatevFormatType::PLAIN, '');
        $this->set_cell(14, DatevFormatType::ESCAPED, $this->text);
        $this->set_cell(15, DatevFormatType::PLAIN, '');
        $this->set_cell(16, DatevFormatType::ESCAPED, '');
        $this->set_cell(17, DatevFormatType::PLAIN, '');
        $this->set_cell(18, DatevFormatType::PLAIN, '');
        $this->set_cell(19, DatevFormatType::PLAIN, '');
        $this->set_cell(20, DatevFormatType::ESCAPED, '');
        $this->set_cell(21, DatevFormatType::ESCAPED, '');
        $this->set_cell(22, DatevFormatType::ESCAPED, '');
        $this->set_cell(23, DatevFormatType::ESCAPED, '');
        $this->set_cell(24, DatevFormatType::ESCAPED, '');
        $this->set_cell(25, DatevFormatType::ESCAPED, '');
        $this->set_cell(26, DatevFormatType::ESCAPED, '');
        $this->set_cell(27, DatevFormatType::ESCAPED, '');
        $this->set_cell(28, DatevFormatType::ESCAPED, '');
        $this->set_cell(29, DatevFormatType::ESCAPED, '');
        $this->set_cell(30, DatevFormatType::ESCAPED, '');
        $this->set_cell(31, DatevFormatType::ESCAPED, '');
        $this->set_cell(32, DatevFormatType::ESCAPED, '');
        $this->set_cell(33, DatevFormatType::ESCAPED, '');
        $this->set_cell(34, DatevFormatType::ESCAPED, '');
        $this->set_cell(35, DatevFormatType::ESCAPED, '');
        $this->set_cell(36, DatevFormatType::ESCAPED, '');
        $this->set_cell(37, DatevFormatType::ESCAPED, $this->cost_location);
        $this->set_cell(38, DatevFormatType::ESCAPED, '');
        $this->set_cell(39, DatevFormatType::PLAIN, '');
        $this->set_cell(40, DatevFormatType::ESCAPED, '');
        $this->set_cell(41, DatevFormatType::PLAIN, '');
        $this->set_cell(42, DatevFormatType::ESCAPED, '');
        $this->set_cell(43, DatevFormatType::PLAIN, '');
        $this->set_cell(44, DatevFormatType::PLAIN, '');
        $this->set_cell(45, DatevFormatType::PLAIN, '');
        $this->set_cell(46, DatevFormatType::PLAIN, '');
        $this->set_cell(47, DatevFormatType::PLAIN, '');
        $this->set_cell(48, DatevFormatType::ESCAPED, '');
        $this->set_cell(49, DatevFormatType::ESCAPED, '');
        $this->set_cell(50, DatevFormatType::ESCAPED, '');
        $this->set_cell(51, DatevFormatType::ESCAPED, '');
        $this->set_cell(52, DatevFormatType::ESCAPED, '');
        $this->set_cell(53, DatevFormatType::ESCAPED, '');
        $this->set_cell(54, DatevFormatType::ESCAPED, '');
        $this->set_cell(55, DatevFormatType::ESCAPED, '');
        $this->set_cell(56, DatevFormatType::ESCAPED, '');
        $this->set_cell(57, DatevFormatType::ESCAPED, '');
        $this->set_cell(58, DatevFormatType::ESCAPED, '');
        $this->set_cell(59, DatevFormatType::ESCAPED, '');
        $this->set_cell(60, DatevFormatType::ESCAPED, '');
        $this->set_cell(61, DatevFormatType::ESCAPED, '');
        $this->set_cell(62, DatevFormatType::ESCAPED, '');
        $this->set_cell(63, DatevFormatType::ESCAPED, '');
        $this->set_cell(64, DatevFormatType::ESCAPED, '');
        $this->set_cell(65, DatevFormatType::ESCAPED, '');
        $this->set_cell(66, DatevFormatType::ESCAPED, '');
        $this->set_cell(67, DatevFormatType::ESCAPED, '');
        $this->set_cell(68, DatevFormatType::ESCAPED, '');
        $this->set_cell(69, DatevFormatType::ESCAPED, '');
        $this->set_cell(70, DatevFormatType::ESCAPED, '');
        $this->set_cell(71, DatevFormatType::ESCAPED, '');
        $this->set_cell(72, DatevFormatType::ESCAPED, '');
        $this->set_cell(73, DatevFormatType::ESCAPED, '');
        $this->set_cell(74, DatevFormatType::ESCAPED, '');
        $this->set_cell(75, DatevFormatType::ESCAPED, '');
        $this->set_cell(76, DatevFormatType::ESCAPED, '');
        $this->set_cell(77, DatevFormatType::ESCAPED, '');
        $this->set_cell(78, DatevFormatType::ESCAPED, '');
        $this->set_cell(79, DatevFormatType::ESCAPED, '');
        $this->set_cell(80, DatevFormatType::ESCAPED, '');
        $this->set_cell(81, DatevFormatType::ESCAPED, '');
        $this->set_cell(82, DatevFormatType::ESCAPED, '');
        $this->set_cell(83, DatevFormatType::ESCAPED, '');
        $this->set_cell(84, DatevFormatType::ESCAPED, '');
        $this->set_cell(85, DatevFormatType::ESCAPED, '');
        $this->set_cell(86, DatevFormatType::ESCAPED, '');
        $this->set_cell(87, DatevFormatType::ESCAPED, '');
        $this->set_cell(88, DatevFormatType::PLAIN, '');
        $this->set_cell(89, DatevFormatType::PLAIN, '');
        $this->set_cell(90, DatevFormatType::PLAIN, '');
        $this->set_cell(91, DatevFormatType::ESCAPED, '');
        $this->set_cell(92, DatevFormatType::PLAIN, '');
        $this->set_cell(93, DatevFormatType::PLAIN, '');
        $this->set_cell(94, DatevFormatType::PLAIN, '');
        $this->set_cell(95, DatevFormatType::ESCAPED, '');
        $this->set_cell(96, DatevFormatType::ESCAPED, '');
        $this->set_cell(97, DatevFormatType::PLAIN, '');
        $this->set_cell(98, DatevFormatType::ESCAPED, '');
        $this->set_cell(99, DatevFormatType::PLAIN, '');
        $this->set_cell(100, DatevFormatType::PLAIN, '');
        $this->set_cell(101, DatevFormatType::PLAIN, '');
        $this->set_cell(102, DatevFormatType::ESCAPED, '');
        $this->set_cell(103, DatevFormatType::ESCAPED, '');
        $this->set_cell(104, DatevFormatType::PLAIN, '');
        $this->set_cell(105, DatevFormatType::ESCAPED, '');
        $this->set_cell(106, DatevFormatType::PLAIN, '');
        $this->set_cell(107, DatevFormatType::ESCAPED, '');
        $this->set_cell(108, DatevFormatType::PLAIN, '');
        $this->set_cell(109, DatevFormatType::ESCAPED, '');
        $this->set_cell(110, DatevFormatType::ESCAPED, '');
        $this->set_cell(111, DatevFormatType::PLAIN, '');
        $this->set_cell(112, DatevFormatType::ESCAPED, '');
        $this->set_cell(113, DatevFormatType::PLAIN, '');
        $this->set_cell(114, DatevFormatType::PLAIN, '');
        $this->set_cell(115, DatevFormatType::PLAIN, '');
        $this->set_cell(116, DatevFormatType::PLAIN, '');
        $this->set_cell(117, DatevFormatType::PLAIN, '');
        $this->set_cell(118, DatevFormatType::ESCAPED, '');
        $this->set_cell(119, DatevFormatType::PLAIN, '');
        $this->set_cell(120, DatevFormatType::ESCAPED, '');
    }
}

class Datev_Settings {
    public DateTime $begin_fiscal_year;
    public int $advisor_nr;
    public int $client_nr;
    public string $accounting;

    public function __construct($begin_fiscal_year, $advisor_nr, $client_nr, $accounting) {
        $this->begin_fiscal_year = $begin_fiscal_year;
        $this->advisor_nr = $advisor_nr;
        $this->client_nr = $client_nr;
        $this->accounting = $accounting;
    }
}