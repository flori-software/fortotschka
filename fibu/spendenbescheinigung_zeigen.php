<?php
session_start();

include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";

include "TCPDF/tcpdf.php";

include "klassen/num2text.php";
include "klassen/pdf_spendenquittung.php";

$spendenquittung = new spendenquittung($_GET["id"]);


$pdf_dokument    = new pdf_spendenquittung($spendenquittung);


?>