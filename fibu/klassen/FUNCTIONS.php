<?php
session_start();
include "listen.php";
include "db_functions.php";
include "formulare.php";
include "date_and_time.php";

function MyDatabase() {
	$mysqli=new mysqli("localhost","web934","DoamneMiluieste333","usr_web934_1");
	if (mysqli_connect_errno()) {
    	printf("Es konnte keine Verbindung zur Datenbank aufgebaut werden<p>", mysqli_connect_error());
    	exit();
	}
	return $mysqli;
}		

function PostMyVar($x, $leer, $unwanted_value = "") {
	$mysqli=MyDatabase();
	if (isset($_POST["$x"]) && $_POST["$x"]!=$unwanted_value) {
		$myVar=$_POST["$x"];
	}
	else {
		$myVar=$leer;
	}
	// NULL Werte sollen ohne Anführungszeichen gespeichert werden
	return $myVar;
}

function GetMyVar($x, $leer, $unwanted_value = "") {
	$mysqli=MyDatabase();
	if (isset($_GET["$x"]) && $_GET["$x"]!=$unwanted_value) {
		$myVar=$_GET["$x"];
	}
	else {
		$myVar=$leer;
	}
	// NULL Werte sollen ohne Anführungszeichen gespeichert werden
	return $myVar;
}

function zahl_de($zahl) {
	// Die Zahl wird vom Computerformat ins deutsche Format umgewandelt
	$zahl = floatval($zahl);
	$zahl = number_format($zahl,2,",",".");
	return $zahl;
}

function zahl_pc($zahl) {
	// Die Zahl wird vom deutschen Format ins PC-Format umgewandelt - 
	// Punkt in Nichts und Komma in Punkt
	$zahl=str_replace(".","",$zahl);
	$zahl=str_replace(",",".",$zahl);
	return $zahl;	
}

function checkbox($wert) {
    if($wert == 1) {
        echo " checked";
    } 
}

?>