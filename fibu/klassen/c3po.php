<?php

class c3po {
    
    public $paket;
    
    private $zahlen;     // Array
    private $buchstaben; // Array

    public function __construct($paket) {
        $this->zahlen = Array();
        $this->paket = $paket;
        $this->buchstaben = "%";
        $this->buchstaben = "K";
        $this->buchstaben = "f";
        $this->buchstaben = "§";
        $this->buchstaben = "@";
        $this->buchstaben = "#";
        $this->buchstaben = "*";
        $this->buchstaben = "?";
        $this->buchstaben = "$";
        $this->buchstaben = "&";
    }

    public function coden() {
        $this->algorithmA();
        return $this->paket;
    } 

    public function decoden() {
        // Entschlüsselung der 2. Stufe
        $ergebnis = str_replace("W", "CI", $this->paket);

        // Entschlüsselung der Komplikationen
        $ergebnis = str_replace("E", "%x", $ergebnis);
        $ergebnis = str_replace("G", "%j", $ergebnis);
        $ergebnis = str_replace("O", "p)", $ergebnis);
        $ergebnis = str_replace("M", "}%", $ergebnis);
        $ergebnis = str_replace("I", "+w", $ergebnis);
        $ergebnis = str_replace("R", "{s", $ergebnis);
        $ergebnis = str_replace("C", "%<", $ergebnis);
        $ergebnis = str_replace("A", "%>", $ergebnis);
        $ergebnis = str_replace("L", "%}", $ergebnis);

        // Entschlüsselung zum Hexadezimalen Code
        $ergebnis = str_replace("§", "f", $ergebnis);
        $ergebnis = str_replace("!", "e", $ergebnis);
        $ergebnis = str_replace("j", "d", $ergebnis);
        $ergebnis = str_replace("s", "c", $ergebnis);
        $ergebnis = str_replace("p", "b", $ergebnis);
        $ergebnis = str_replace(">", "a", $ergebnis);
        $ergebnis = str_replace("x", "9", $ergebnis);
        $ergebnis = str_replace("u", "8", $ergebnis);
        $ergebnis = str_replace("w", "7", $ergebnis);
        $ergebnis = str_replace("z", "6", $ergebnis);
        $ergebnis = str_replace("$", "5", $ergebnis);
        $ergebnis = str_replace("<", "4", $ergebnis);
        $ergebnis = str_replace("-", "3", $ergebnis);
        $ergebnis = str_replace("&", "2", $ergebnis);
        $ergebnis = str_replace("+", "1", $ergebnis);
        $ergebnis = str_replace("}", "0", $ergebnis);
        $ergebnis = str_replace("{", "15", $ergebnis);
        $ergebnis = str_replace(")", "14", $ergebnis);
        $ergebnis = str_replace("(", "13", $ergebnis);
        $ergebnis = str_replace("*", "12", $ergebnis);
        $ergebnis = str_replace("#", "11", $ergebnis);
        $ergebnis = str_replace("%", "16", $ergebnis);
        
        #echo "Hexadezimaler Code: ".$ergebnis;
        
        // Array mit Buchstaben bilden
        $this->paket = "";
        while(strlen($ergebnis) > 0) {
            $piece    = substr($ergebnis, 0, 3);
            $ergebnis = substr($ergebnis, 3);
            $piece    = hexdec($piece);
            $piece    = $piece - 251;
            $this->paket .= chr($piece);
        }
        #echo "<p>Entschlüsselter Text: ".$this->paket."<p>";
        return $this->paket;
    }

    private function algorithmA() {
        $laenge = strlen($this->paket);
        for($pos = 0; $pos < $laenge; $pos++) {
            $buchstabe = substr($this->paket, $pos, 1);
            // Umwandlung in ASCII
            $this->zahlen[] = ord($buchstabe);
            // Erhöhung um 251 um immer dreistellige Ergebnisse zu bekommen
            $this->zahlen[$pos] = dechex($this->zahlen[$pos] + 251);
        }
        $ergebnis = "";
        foreach ($this->zahlen as $zahl) {
            $ergebnis .= $zahl;
        }
        // Chiffrierung des Hexadezimalen Codes
        $ergebnis = str_replace("16", "%", $ergebnis);
        $ergebnis = str_replace("11", "#", $ergebnis);
        $ergebnis = str_replace("12", "*", $ergebnis);
        $ergebnis = str_replace("13", "(", $ergebnis);
        $ergebnis = str_replace("14", ")", $ergebnis);
        $ergebnis = str_replace("15", "{", $ergebnis);
        $ergebnis = str_replace("0", "}", $ergebnis);
        $ergebnis = str_replace("1", "+", $ergebnis);
        $ergebnis = str_replace("2", "&", $ergebnis);
        $ergebnis = str_replace("3", "-", $ergebnis);
        $ergebnis = str_replace("4", "<", $ergebnis);
        $ergebnis = str_replace("5", "$", $ergebnis);
        $ergebnis = str_replace("6", "z", $ergebnis);
        $ergebnis = str_replace("7", "w", $ergebnis);
        $ergebnis = str_replace("8", "u", $ergebnis);
        $ergebnis = str_replace("9", "x", $ergebnis);
        $ergebnis = str_replace("a", ">", $ergebnis);
        $ergebnis = str_replace("b", "p", $ergebnis);
        $ergebnis = str_replace("c", "s", $ergebnis);
        $ergebnis = str_replace("d", "j", $ergebnis);
        $ergebnis = str_replace("e", "!", $ergebnis);
        $ergebnis = str_replace("f", "§", $ergebnis);
        #echo "Ergebnis der Verschlüsselung der 1. Stufe: ".$ergebnis."<p>";

        // Komplikationen
        $ergebnis = str_replace("%}", "L", $ergebnis);
        $ergebnis = str_replace("%>", "A", $ergebnis);
        $ergebnis = str_replace("%<", "C", $ergebnis);
        $ergebnis = str_replace("{s", "R", $ergebnis);
        $ergebnis = str_replace("+w", "I", $ergebnis);
        $ergebnis = str_replace("}%", "M", $ergebnis);
        $ergebnis = str_replace("p)", "O", $ergebnis);
        $ergebnis = str_replace("%j", "G", $ergebnis);
        $ergebnis = str_replace("%x", "E", $ergebnis);

        // Komplikationen 2. Stufe
        $ergebnis = str_replace("CI", "W", $ergebnis);
        
        $this->paket = $ergebnis;

    }
    
    public static function lesen($paket) {
        $paket = new c3po($paket);
        $uebersetzung = $paket->decoden();
        return $uebersetzung;
    }

    public static function verschluesseln($paket) {
        $paket = new c3po($paket);
        $uebersetzung = $paket->coden();
        return $uebersetzung;
    }
    
}


?>