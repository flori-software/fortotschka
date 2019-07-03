<?php
session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</head>
	<link rel="stylesheet" type="text/css" href="beauty.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 	<link rel="stylesheet" href="/resources/demos/style.css">
	<body>
	<div class="mittelteil" id="mittelteil">
	<img src="pics/titelbild.jpg" class="titelbild">
<?php	
	$menu_inhalte = Array();
    if(isset($_SESSION["id_benutzer"])) {
        $menu_inhalte[1]["name"] = "Mitglieder";
        $menu_inhalte[1]["link"] = "mein_konto.php";
        $menu_inhalte[2]["name"] = "Kontenplan";
        $menu_inhalte[2]["link"] = "kontenplan.php";
        $menu_inhalte[3]["name"] = "Buchungen";
        $menu_inhalte[3]["link"] = "buchungen.php";
        $menu_inhalte[4]["name"] = "Spendenbescheinigungen";
        $menu_inhalte[4]["link"] = "spendenbescheinigungen.php";
        $menu_inhalte[5]["name"] = "Abschl&uuml;sse";
        $menu_inhalte[5]["link"] = "abschluesse.php";
		$menu_inhalte[6]["name"] = "Ausloggen";
		$menu_inhalte[6]["link"] = "ausloggen.php";
	}

	foreach($menu_inhalte as $key=>$menupunkt) {
		echo '<a class="menu" href="'.$menupunkt[link].'">'.$menupunkt[name].'</a>';
	}
	echo '<p><div class="inhalt">';




?>