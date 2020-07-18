<?php
session_start();
include "listen.php";
include "db_functions.php";
include "formulare.php";
include "date_and_time.php";

function MyDatabase() {
	$mysqli=new mysqli("localhost","d032ff91","ZurGroesserenEhreGottes","d032ff91");
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

function konsole($text) {
	echo '<script>
	console.log("'.$text.'");
	</script>';
}

function formatierung_div($farbe1, $farbe2, $breite, $hoehe, $radius, $padding, $font_size = 12, $klasse = "") {
	echo '<style>';
	if($klasse == "") {
		echo 'div';
	}
	else {
		echo '.'.$klasse;
	}

	echo '{';
		if($breite != 0) {echo 'width: '.$breite.'px;';}
		if($hoehe  != 0) {echo 'height:'.$hoehe.'px;';}
		echo 'font-size:'.$font_size.'px;';
		echo 'border-radius: '.$radius.'px;
		padding: '.$padding.'px;
		background: -webkit-linear-gradient('.$farbe1.', '.$farbe2.'); /* For Safari 5.1 to 6.0 */
   		background: -o-linear-gradient('.$farbe1.', '.$farbe2.'); /* For Opera 11.1 to 12.0 */
    	background: -moz-linear-gradient('.$farbe1.', '.$farbe2.'); /* For Firefox 3.6 to 15 */
		background: linear-gradient('.$farbe1.', '.$farbe2.'); /* Standard syntax (must be last) */

	}
	</style>';
}
?>
