<?php
include 'Verhoeff.php';
include 'AllegedRC4.php';
include 'Base64SIN.php';

class ControlCode {
    
    function generate($numautorizacion, $numfactura, $nitcliente,
                      $fecha, $monto, $clave){        
        
        //validación de datos
        if( empty($numautorizacion) || empty($numfactura) || empty($fecha) || 
                empty($monto) || empty($clave) || (!strlen($nitcliente)>0 )  ){            
            throw new InvalidArgumentException('<b>Todos los campos son obligatorios</b>');
        }else{
            $this->validateNumber($numautorizacion);
            $this->validateNumber($numfactura);
            $this->validateNumber($fecha);
            $this->validateNumber($nitcliente);
            $this->validateNumber($monto);
            $this->validateDosageKey($clave);
        }
        
        //redondea monto de transaccion 
        $monto = $this->roundUp($monto);
                
        /* ========== PASO 1 ============= */
        $numfactura = self::addVerhoeffDigit($numfactura,2);
        $nitcliente = self::addVerhoeffDigit($nitcliente,2);
        $fecha = self::addVerhoeffDigit($fecha,2);
        $monto = self::addVerhoeffDigit($monto,2);
        //se suman todos los valores obtenidos
        $sumOfVariables = $numfactura
                          + $nitcliente
                          + $fecha
                          + $monto;
        //A la suma total se añade 5 digitos Verhoeff
        $sumOfVariables5Verhoeff = self::addVerhoeffDigit($sumOfVariables,5);  
        
         /* ========== PASO 2 ============= */
        $fiveDigitsVerhoeff = substr($sumOfVariables5Verhoeff,strlen($sumOfVariables5Verhoeff)-5);        
        $numbers = str_split($fiveDigitsVerhoeff);
        for($i=0;$i<5;$i++){
             $numbers[$i] = $numbers[$i] + 1;             
        }
                
        $string1 = substr($clave,0, $numbers[0] );
        $string2 = substr($clave,$numbers[0], $numbers[1] );
        $string3 = substr($clave,$numbers[0]+ $numbers[1], $numbers[2] );
        $string4 = substr($clave,$numbers[0]+ $numbers[1]+ $numbers[2], $numbers[3] );
        $string5 = substr($clave,$numbers[0]+ $numbers[1]+ $numbers[2]+ $numbers[3], $numbers[4] );        
        
        $numautorizacionkey = $numautorizacion . $string1;
        $numfacturakey = $numfactura . $string2;
        $nitclientekey = $nitcliente . $string3;
        $fechakey = $fecha . $string4;        
        $montokey = $monto . $string5;
        
          /* ========== PASO 3 ============= */        
        //se concatena cadenas de paso 2
        $stringDKey = $numautorizacionkey . $numfacturakey . $nitclientekey . $fechakey . $montokey;         
        //Llave para cifrado + 5 digitos Verhoeff generado en paso 2
        $keyForEncryption = $clave . $fiveDigitsVerhoeff;              
        //se aplica AllegedRC4
        $allegedRC4String = AllegedRC4::encryptMessageRC4($stringDKey, $keyForEncryption,true);
        
        /* ========== PASO 4 ============= */
        //cadena encriptada en paso 3 se convierte a un Array         
        $chars = str_split($allegedRC4String);
        //se suman valores ascii
        $totalAmount=0;
        $sp1=0;
        $sp2=0;
        $sp3=0;
        $sp4=0;
        $sp5=0;
        
        $tmp=1;
        for($i=0; $i<strlen($allegedRC4String);$i++){
            $totalAmount += ord($chars[$i]);
            switch($tmp){
                case 1: $sp1 += ord($chars[$i]); break;
                case 2: $sp2 += ord($chars[$i]); break;
                case 3: $sp3 += ord($chars[$i]); break;
                case 4: $sp4 += ord($chars[$i]); break;
                case 5: $sp5 += ord($chars[$i]); break;
            }            
            $tmp = ($tmp<5)?$tmp+1:1;
        }
        
        /* ========== PASO 5 ============= */    
        //suma total * sumas parciales dividido entre resultados obtenidos 
        //entre el dígito Verhoeff correspondiente más 1 (paso 2)
        $tmp1 = floor($totalAmount*$sp1/$numbers[0]);
        $tmp2 = floor($totalAmount*$sp2/$numbers[1]);
        $tmp3 = floor($totalAmount*$sp3/$numbers[2]);
        $tmp4 = floor($totalAmount*$sp4/$numbers[3]);
        $tmp5 = floor($totalAmount*$sp5/$numbers[4]);
        //se suman todos los resultados
        $sumProduct = $tmp1 + $tmp2 + $tmp3 + $tmp4 + $tmp5;        
        //se obtiene base64
        $base64SIN = Base64SIN::convert($sumProduct);
        
        /* ========== PASO 6 ============= */        
        //Aplicar el AllegedRC4 a la anterior expresión obtenida
        return AllegedRC4::encryptMessageRC4($base64SIN, $clave.$fiveDigitsVerhoeff);
    }
    
    /**
     * Añade N digitos Verhoeff a una cadena de texto
     * @param value String
     * @param max numero de digitos a agregar
     * @return String cadena original + N digitos Verhoeff
     */
    static function addVerhoeffDigit($num,$max){
        for($i=1;$i<=$max;$i++){
            $num .= Verhoeff::calc($num);            
        }            
        return $num;
    }
    
     /**
     * Redondea hacia arriba
     * @param value cadena con valor numerico de la forma 123 123.4 123,4
     */
    function roundUp($num){        
        //reemplaza (,) por (.)        
        $value2 = str_replace(',','.',$num);
        //redondea a 0 decimales        
        return round($value2, 0, PHP_ROUND_HALF_UP);
    }
    
    function validateNumber($num){
        if(!preg_match('/^[0-9,.]+$/', $num)){
            throw new InvalidArgumentException(sprintf("Error! Valor restringido a número, %s no es un número.",$num));
        }
    }
    
    function validateDosageKey($num){
        if(!preg_match('/^[A-Za-z0-9=#()*+-_\@\[\]{}%$]+$/', $num)){
            throw new InvalidArgumentException(sprintf("Error! llave de dosificación,<b> %s </b>contiene caracteres NO permitidos.",$num));
        }
    }
    
}

?>


<?php
    $numautorizacion = $_POST["numautorizacion"];
    $numfactura = $_POST["numfactura"];
    $nitcliente = $_POST["nitcliente"];
    $fecha = $_POST["fecha"];
    $monto = $_POST["monto"];
    $clave = $_POST["clave"];

    $objeto = new ControlCode();
    echo "Codigo de control </br>";
    echo $objeto->generate($numautorizacion,$numfactura,$nitcliente,$fecha,$monto,$clave);
    
?>