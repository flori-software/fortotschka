<?php
session_start();

header("refresh:0;url=index.php");

include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";

$benutzername = $_POST["benutzername"];
$passwort     = $_POST["passwort"];
    echo "Benutzername und Passwort sind ".$benutzername." ".$passwort."<br>";
$benutzer = new Benutzer;
$benutzer->login($benutzername, $passwort);

echo "Eingeloggt ".$_SESSION["id_benutzer"];


?>
