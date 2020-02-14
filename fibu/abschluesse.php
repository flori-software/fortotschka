<?php
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klassen_fibu.php";

echo 'Gesch&auml;ftsjahre:';
$jahre = jahr::alle_jahre();
echo 'Jahre gelesen<p>';

$abschluss_erstellen = GetMyVar("abschluss_erstellen", 0);

foreach($jahre as $jahr) {
    echo '<a href="kontenplan.php?aktion=jahr_aktivieren&id='.$jahr->ID.'">'.$jahr->jahr.'</a>&nbsp;';
}
if(isset($_SESSION["jahr"])) {
    echo ' - aktives Gesch&auml;ftsjahr ist '.$_SESSION["jahr"].'<br>';
    echo 'Abschl&uuml;sse<p>';
    if($abschluss_erstellen == 1) {
        echo "Erstelle einen Jahresabschluss<p>";
        $abschluss = new abschluss(1);
        $button_zeigen = 0;
    } else {
        // Die Summen eines potenziellen Abschlusses werden nur angezeigt, es wird aber KEIN Abschluss gespeichert
        $abschluss = new abschluss(0);
        $button_zeigen = 1;
    }
    // Gibt es bereits einen Abschluss für das ausgewählte Geschäftsjahr?
    $id_eintrag = gesuchter_wert($id_jahr, "abschluesse", "ID");
    if($id_eintrag > 0) {
        echo '<span id="my_small_title">F&uuml;r das aktuelle Gesch&auml;ftsjahr gibt es bereits einen Jahresabschluss<p></span>';
    } elseif($button_zeigen == 1) {
        formatierung_div("salmon", "mistyrose", "600", "50", "20", "10", $font_size = 12, $klasse = "button_abschluss");
        echo '<div class="button_abschluss" style="font-size: 16px; color: maroon;" onclick="abschluss_erstellen()">
        Jahresabschluss f&uuml;r das aktuelle Gesch&auml;ftsjahr erstellen
        </div>';
    }
}
?>
<script>
function abschluss_erstellen() {
    if(confirm("Durch das Erstellen eines Abschlusses werden alle Buchungen gesperrt. Soll jetzt ein Abschluss erstellt werden?")) {
        location.href = "abschluesse.php?abschluss_erstellen=1";
    }
}


</script>