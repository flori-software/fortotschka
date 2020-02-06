<?php
// Herzlichen Dank an Thorsten Rotering. Hier oben nun die Ergänzung für Währung (Kommazahl mit Eure und Cent) 
function betrag2text($betrag) {
    $euro = floor($betrag);
    $cent = ($betrag - $euro) * 100;
    $text = num2text($euro)." Euro";
    if($cent > 0) {
        $text .= " und ".num2text($cent)." Cent";
    }
    return $text;
}


/**
 * @author Thorsten Rotering <support@rotering-net.de>
 * @version 1.1 (2017-08-06)
 *
 * Hiermit wird unentgeltlich, jeder Person, die eine Kopie dieses Skripts erhÃ¤lt, die Erlaubnis erteilt,
 * diese uneingeschrÃ¤nkt zu benutzen, inklusive und ohne Ausnahme, dem Recht, sie zu verwenden, zu kopieren,
 * zu Ã¤ndern, zu fusionieren, zu verlegen, zu verbreiten, zu unterlizenzieren und/oder zu verkaufen, und
 * Personen, die dieses Skript erhalten, diese Rechte zu geben, unter den folgenden Bedingungen:
 *
 * Der obige Urheberrechtsvermerk und dieser Erlaubnisvermerk sind in allen Kopien oder Teilkopien des
 * Skripts beizulegen.
 *
 * DAS SKRIPT WIRD OHNE JEDE AUSDRÃœCKLICHE ODER IMPLIZIERTE GARANTIE BEREITGESTELLT, EINSCHLIESSLICH DER
 * GARANTIE ZUR BENUTZUNG FÃœR DEN VORGESEHENEN ODER EINEM BESTIMMTEN ZWECK SOWIE JEGLICHER RECHTSVERLETZUNG,
 * JEDOCH NICHT DARAUF BESCHRÃ„NKT. IN KEINEM FALL SIND DIE AUTOREN ODER COPYRIGHTINHABER FÃœR JEGLICHEN SCHADEN
 * ODER SONSTIGE ANSPRÃœCHE HAFTBAR ZU MACHEN, OB INFOLGE DER ERFÃœLLUNG EINES VERTRAGES, EINES DELIKTES ODER
 * ANDERS IM ZUSAMMENHANG MIT DEM SKRIPT ODER SONSTIGER VERWENDUNG DES SKRIPTS ENTSTANDEN.
 */

define('NUMERAL_SIGN', 'minus');
define('NUMERAL_HUNDREDS_SUFFIX', 'hundert');
define('NUMERAL_INFIX', 'und');

/* Die ZahlwÃ¶rter von 0 bis 19. */
$lNumeral = array('null', 'ein', 'zwei', 'drei', 'vier',
                  'fünf', 'sechs', 'sieben', 'acht', 'neun',
                  'zehn', 'elf', 'zwölf', 'dreizehn', 'vierzehn',
                  'fünfzehn', 'sechzehn', 'siebzehn', 'achtzehn', 'neunzehn');

/* Die Zehner-ZahlwÃ¶rter. */
$lTenner = array('', '', 'zwanzig', 'dreißig', 'vierzig',
                 'fünfzig', 'sechzig', 'siebzig', 'achtzig', 'neunzig');

/* Die Gruppen-Suffixe. */
$lGroupSuffix = array(array('s', ''),
                      array('tausend ', 'tausend '),
                      array('e Million ', ' Millionen '),
                      array('e Milliarde ', ' Milliarden '),
                      array('e Billion ', ' Billionen '),
                      array('e Billiarde ', ' Billiarden '),
                      array('e Trillion ', ' Trillionen '));


/**
 * Liefert das Zahlwort zu einer Ganzzahl zurÃ¼ck.
 * @global array $lNumeral
 * @param int $pNumber Die Ganzzahl, die in ein Zahlwort umgewandelt werden soll.
 * @return string Das Zahlwort.
 */
function num2text($pNumber)
{
    global $lNumeral;
    
    if ($pNumber == 0) {
        return $lNumeral[0]; // â€žnullâ€œ
    } elseif ($pNumber < 0) {
        return NUMERAL_SIGN . ' ' . num2text_group(abs($pNumber));
    } else {
        return num2text_group($pNumber);
    }
}

/**
 * Rekursive Methode, die das Zahlwort zu einer Ganzzahl zurÃ¼ckgibt.
 * @global array $lNumeral
 * @global array $lTenner
 * @global array $lGroupSuffix
 * @param int $pNumber Die Ganzzahl, die in ein Zahlwort umgewandelt werden soll.
 * @param int $pGroupLevel (optional) Das Gruppen-Level der aktuellen Zahl.
 * @return string Das Zahlwort.
 */
function num2text_group($pNumber, $pGroupLevel = 0)
{
    global $lNumeral, $lTenner, $lGroupSuffix;
    
    /* Ende der Rekursion ist erreicht, wenn Zahl gleich Null ist */
    if ($pNumber == 0) {
        return '';
    }
    
    /* Zahlengruppe dieser Runde bestimmen */
    $lGroupNumber = $pNumber % 1000;
    
    /* Zahl der Zahlengruppe ist Eins */
    if ($lGroupNumber == 1) {
        $lResult = $lNumeral[1] . $lGroupSuffix[$pGroupLevel][0]; // â€žeine Milliardeâ€œ
        
    /* Zahl der Zahlengruppe ist grÃ¶ÃŸer als Eins */   
    } elseif ($lGroupNumber > 1) {
        $lResult = '';
        
        /* Zahlwort der Hunderter */
        $lFirstDigit = floor($lGroupNumber / 100);
        
        if ($lFirstDigit > 0) {
            $lResult .= $lNumeral[$lFirstDigit] . NUMERAL_HUNDREDS_SUFFIX; // â€žfÃ¼nfhundertâ€œ
        }
        
        /* Zahlwort der Zehner und Einer */
        $lLastDigits = $lGroupNumber % 100;
        $lSecondDigit = floor($lLastDigits / 10);
        $lThirdDigit = $lLastDigits % 10;
        
        if ($lLastDigits == 1) {
            $lResult .= $lNumeral[1] . 's'; // "eins"
        } elseif ($lLastDigits > 1 && $lLastDigits < 20) {
            $lResult .= $lNumeral[$lLastDigits]; // "dreizehn"
        } elseif ($lLastDigits >= 20) {
            if ($lThirdDigit > 0) {
                $lResult .= $lNumeral[$lThirdDigit] . NUMERAL_INFIX; // "sechsundâ€¦"
            }
            $lResult .= $lTenner[$lSecondDigit]; // "â€¦achtzig"
        }
        
        /* Suffix anhÃ¤ngen */
        $lResult .= $lGroupSuffix[$pGroupLevel][1]; // "Millionen"
    }
    
    /* NÃ¤chste Gruppe auswerten und Zahlwort zurÃ¼ckgeben */
    return num2text_group(floor($pNumber / 1000), $pGroupLevel + 1) . $lResult;
}