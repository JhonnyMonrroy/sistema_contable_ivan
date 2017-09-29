<?php

class Base64SIN {
    
    static function convert($numero){
        $dicionario = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", 
                            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
                            "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", 
                            "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d",
                            "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", 
                            "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", 
                            "y", "z", "+", "/");        
        $cociente = 1;                 
        $palabra = "";
        while ($cociente > 0)
        {
            $cociente = floor($numero / 64);
            $resto = $numero % 64;
            $palabra = $dicionario[$resto] . $palabra;
            $numero = $cociente;
        }
        return $palabra;
    }    
}