<?php
session_start();
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";
include "klassen/klasse_personen.php";
include "fpdf17/fpdf.php";
include "klassen/klasse_pdf_spendenquittung.php";

$spendenquittung = new spendenquittung($_GET["id"]);

$pdf_dokument    = new pdf_spendenquittung($spendenquittung);
$pdf_dokument->Output(); 

?>