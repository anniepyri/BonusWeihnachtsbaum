<?php

$baumhoehe = random_int(4, 6);
/* baumhoehe legt die Höhe zufällig, ohne Stamm und Stern, in einem Bereich von 3 bis 17, fest (der Bereich ist +1 angegeben,
 da später, beim erstellen der Äste, immer -1 gerechnet wird */

$anzahlLeer = 5 + ($baumhoehe - 1);
/* anzahlLeer bestimmt die Anzahl der Leerzeichen, die für die richtige Platzierung eines Elements benötigt werden.
 +5 setzt den Baum vom Rand weg. */

$space = str_repeat(' ', $anzahlLeer);
/* space stellt den passenden Abstand vom Bildschirmrand für jedes entsprechende Element dar. */

$stamm = $space."|||";
/* Erzeugung des Stamms */


 function stern (string $space) {

     $auswahlStern = random_int(1, 3); // generiert eine zufällige Zahl zwischen 1 und 3
     $stern = '';

     switch ($auswahlStern) { //Auswahl eines Sterns in Abhängigkeit der zufälligen Zahl
         case 1:
             $stern .= $space."\033[1;33m\ / \n".$space."-X-\n".$space."/|\ \033[0m \n \n";
             break;

         case 2:
             $stern .= $space."\033[1;33m\|/ \n".$space."-O-\n".$space."/|\ \033[0m \n \n";
             break;

         case 3:
             $stern .= $space." "."⭐ \n \n";
             break;
     }

     echo $stern; //Ausgabe
 }

 /* Die Funktion Stern generiert einen Stern für die Spitze des Baums. Hier wird mithilfe einer Zufallszahl eine von drei
  Sternvorlagen aus einem Switch Case ausgewählt. Durch space wird jeweils die Position der Sterns angepasst.
  Die Sterne des Case 1 und 2 werden zusätzlich in Gelb dargestellt. Am Ende der Funktion wird der Stern ausgegeben. */


function baum (int $baumhoehe) {

    $j = 0;
    $i = $baumhoehe;
//Zählvariablen

    $nadel = ['X']; //Array mit normalem <<Blatt>>
    $deko = ["\033[0;31m*\033[0m", "\033[0;35m0\033[0m", "x"]; //Array mit Dekoelementen, Farben v.l.n.r.: rot, lile, weiß
    $dekoCount = count($deko) - 1; //zählt die Elemente des Deko Arrays, für die später zufällige Auswahl eines Elements

    while ($j++ <= $baumhoehe) { //1.Schleife

        while (--$i > 0) { //2.Schleife

            $x = (2 * $j++) - 2; //Anzahl Sterne pro Reihe
            $y = 6 + ($i - 1); //Anzahl Leerzeichen pro Reihe, +6 für Randabstand
            $element = ''; //Variable, die das Innere des Baums beginnt, weitere Elemente werden rechts daran kokateniert
            $array = [];


            for ($k = 1; $k <= ($x+1); $k++) { //Schleife, für die Anzahl der Elemente pro Reihe

                $z = random_int(1, 2); //generieren von Zufallszahl
                $array[] = $z;

                //var_dump($k-2);


                switch ($z) { //Auswahl zwischen Deko oder Nadel für jedes einzelne Element
                    case 1:
                        $e=$k-2;
                        //var_dump($e);
                        if($e>=0){
                            if($array[$e]===1) {
                                //echo "bt";
                                goto two;
                            }
                        }

                        $element .= $deko[random_int(0, $dekoCount)]; //zufällige Auswahl eines der drei Dekoelemente
                        break;

                    case 2;
                        two:
                        $element .= "\033[0;32m$nadel[0]\033[0m"; //Nadel wird Grün gefärbt
                        break;
                }

                $baumAnfang = random_int(1,2); //generieren von Zufallszahl

                switch ($baumAnfang){ //Auswahl für erstes Element einer Reihe zwischen Begrenzungsnadel oder Deko
                    case 1: if($array[0]===1){
                        $baumAnfang = "\033[0;32m/\033[0m"; //Nadel wird Grün gefärbt
                    }else {
                        $baumAnfang ="\033[0;36m*\033[0m"; //Deko wird Cyan gefärbt
                    }
                        break;

                    case 2:
                        if($array[0]===2){
                            $baumAnfang = "\033[0;36m*\033[0m"; //Deko wird Cyan gefärbt
                        }else {
                            $baumAnfang ="\033[0;32m/\033[0m"; //Nadel wird Grün gefärbt
                        }
                        break;
                }

                $baumEnde = random_int(1,2); //generieren von Zufallszahl

                switch ($baumEnde) { //Auswahl für letztes Element einer Reihe zwischen Begrenzungsnadel oder Deko
                    case 1: if($array[($k-1)]===1){
                        $baumEnde = "\033[0;32m\ \033[0m \n"; //Nadel wird Grün gefärbt
                    }else {
                        $baumEnde ="\033[0;36m*\033[0m \n"; //Deko wird Cyan gefärbt
                    }
                        break;

                    case 2:
                        if($array[($k-1)]===2){
                            $baumEnde = "\033[0;36m*\033[0m \n"; //Deko wird Cyan gefärbt
                        }else {
                            $baumEnde ="\033[0;32m\ \033[0m \n"; //Nadel wird Grün gefärbt
                        }
                        break;
                }
            }

            $space = str_repeat(' ', $y); //darstellen des Leerraums links vom Baum

            $ast = $space . $baumAnfang . $element . $baumEnde; //erstellen eines Astes aus einzelnen Elementen
            echo $ast; //Ausgabe eines Astes

           // print_r($array);
        }
    }
}

/* In der Funktion baum wird das Innere des Weihnachtsbaums generiert. Zunächst werden die Zählvariablen i und j
 mit Werten belegt. Dann werden zwei Arrays angelegt. Im Array nadel, ist die <<Nadel>> einer Tanne gespeichert.
 Das Array deko enthält drei verschiedene Dekoelemente, jeweils in einer anderen Farbe. In einer kopfgesteuerten while-
 Schleife, wird folgender Algorithmus solange ausgeführt, bis die baumhöhe erreicht ist. In einer weiteren while Schleife
 wird von der Baumhöhe jeweils eins abgezogen und der Algorithmus soange ausgeführt wie i größer 0 ist. Es werden die
 Anzahlen, der pro Reihe benötigten Anzahl an Elementen des Baums und der Leerzeichen für die Formatierung berechnet.
 In einer for- Schleife wird von 0 um eins hochgezählt bis die Anzahl an Elementen pro Reihe erreicht ist. Für jeden Durchlauf
 der Schleife, also für jedes Element eines Astes, wird eine Zufallszahl generiert, mithilfe derrer in einem Switch Case
 entschieden wird, ob das Element eine Nadel oder Deko ist. Nach dieser Schleife wird jeweils für das Erste und Letzte
 Element eines Astes eine Zufallszahl generiert, mithilfe derer in einem Switch Case entschieden wird, ob das jeweilige
 Element Deko oder eine Nadel ist. Eine weitere space Variabel stellt auch hier die Abstände zum Rand dar. Für stern und Stamm
 wird eine andere Berechnung verwendet als für das Innere des Baums. Zuletzt wird ein Ast aus dem passenden Leerabstand,
 einem ersten Element, einer Element Reihe und einem letzten Element gebildet und ausgegeben. Durch den Schleifendurchlauf
 wird die entsprechende Anzahl an Ästen, die zu Beginn generiert wurde, erstellt. */

stern($space); //Funktionsaufruf mit Ausgabe Stern
baum($baumhoehe); //Funktionsaufruf mit Ausgabe des Inneren des Baums
echo "\033[0;33m $stamm \033[0m"; //Ausgabe des Stamms in Braun

/* In der abschließenden Ausgabe wird durch Aufruf der entsprechenden Funktion bzw. Variablen der Baum genriert und auf
der Konsole ausgegeben. Der Stamm wird dabei noch mit einer Farbe belegt. */


