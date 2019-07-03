<?php
session_start();
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";


if(isset($_SESSION["id_benutzer"])) {
	$member     = new Benutzer;
	$member->ID = $_SESSION["id_benutzer"];
    echo 'Hallo!';
}
else {
	echo '<form action="login.php" method="POST" class="login">
	<input name="benutzername" placeholder="Benutzername"><br>
	<input name="passwort" placeholder="Passwort" type="password"><br>
	<input type="submit" value="Einloggen">
	</form>';
}


include "page_end.php";
?>