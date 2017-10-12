<?php 
 	require_once("../../conexion.php");
	$conexion = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

	$matriz = array();
	$i;
	$j;
	$sqlQueryReceta;
    $sqlQueryKardex;
    $sqlQueryKardexSaldo;
    $rs;
    $rsKardex;
    $rsKardexSaldo;
        
    $v_producto;
    $v_cant_e;
    $v_cant_s;
    $v_pvu;
     
    $n ;
    $v_pu;
    $v_imp_e;
    $v_imp_s;
    $v_saldo;
    $v_totalv;
    $v_produccion;
    $v_nreseta;
    $v_proceso;
    $v_compra;
    $v_venta;
    $cantbuscada;
    $v_empresa;
    $v_tipo;

	//DoCmd.SetWarnings False 'Desactivar mensajes del sistema
	$sqlQueryReceta = "SELECT * from ventas_detalle";
    $rs = $conexion->query($sqlQueryReceta);
    foreach ($rs as $reg) {
        $reg["cantidad"];
        $reg["producto"];
        $reg["precio"];
    }
    $i = 0;
    while(!$reg == false){
        if($reg["cantidad"] > 0){
            $matriz[i][0] = $reg["producto"];
            $v_producto = $matriz[i][0];
            //$matriz[i][1] = $rs!$CANT;
            $matriz[i][2] = $reg["cantidad"];
            $matriz[i][3] = $reg["precio"];
            $v_cant_s = $matriz[i][2];
            //echo $matriz[i][0].$matriz[i][1].$matriz[i][2];
            //buscar si hay existencias
            //$sqlQueryKardex = "SELECT KARDEX.PRODUCTO, KARDEX.COMPRA, KARDEX.PU, Last(KARDEX.EXISTENCIAS) AS ÚltimoDeEXISTENCIAS, Sum(KARDEX.CANT_E) AS SumaDeCANT_E, Sum(KARDEX.CANT_S) AS SumaDeCANT_S " & _
                        // "FROM KARDEX GROUP BY KARDEX.PRODUCTO, KARDEX.COMPRA, KARDEX.PU HAVING (((Last(KARDEX.EXISTENCIAS))<>0));";
            $sqlQueryKardex = "SELECT * FROM movimientos WHERE producto = '" . $v_producto . "' and existencias > 0;";
            //echo $sqlQueryKardex;
            $rsKardex = $conexion->query($sqlQueryKardex);
            foreach ($rsKardex as $regk) {
                $regk["existencias"];
            }
            $sumExistencias;
            $sumExistencias = 0;
            while(!$regk == false){
                $sumExistencias = $sumExistencias + $regk["existencias"];
                $regk.next();
            }
            //buscar si es posible hcer la operacion
            if($sumExistencias - $v_cant_s < 0){
                echo "No hay existencias para el producto: " . $v_producto . "Usted solicita " . $v_cant_s . " pero solo existe " . $sumExistencias;
                exit(); //forzar la salida del procedimiento
            }
            $i = $i + 1;
        }
        $reg.next();
    }
    $n = $i;
    if($n > 0){
    	$mensaje = "Esta seguro de realizar la operación?";
        if(print( "<script language='JavaScript'>alert($mensaje)</script>")){
            //echo "Aca se procedera a realizar la operacion";
            $i = 0;
            $v_cant_s = $matriz[i][2];
            $v_producto = $matriz[i][0];
            $sqlQueryKardex = "SELECT * FROM movimientos WHERE producto = '" .$v_producto . "' and existencias > 0;";
            while($i < $n){
                $rsKardex = $conexion->query($sqlQueryKardex);
                foreach ($rsKardex as $regk){
                    $regk["existencias"];
                    $regk["cu"];
                    $regk["compra"];
                }
                if(!$regk == false){
                    if($regk["existencias"] >= $v_cant_s){
                        $cantbuscada = $v_cant_s;
                    }else{
                        $cantbuscada = $regk["existencias"];
                    }
                    $v_cant_s = $v_cant_s - $cantbuscada;
                    //$v_producto = $matriz[i][0];
                    //$v_cant_s = $matriz[i][2];
                    $v_pu = $regk["cu"]; //obtener de la compra
                    $v_imp_e = 0; //impuesto entrada
                    $v_imp_s = $cantbuscada * $regk["cu"];
                    $v_compra = $regk["compra"];
                    echo $v_compra;
                    //$v_saldo = 0;//hay que actualizar el saldo
                    //aca obtenemos el ultimo saldo del producto
                    $sqlQueryKardexSaldo = "SELECT * FROM movimientos WHERE producto = '" . $v_producto . "';";
                    $rsKardexSaldo = $conexion->query(sqlQueryKardexSaldo);
                    foreach ($rsKardexSaldo as $regKS) {
                        $regKS["cantsol"];
                        $regKS["fksucursal"];
                    }
                    if(!$regKS == false){ 
                        $regKS.end();
                        $v_saldo = $regKS["cantsol"];
                        $v_empresa = $regKS["fksucursal"];
                        $v_saldo = $v_saldo - $cantbuscada;
                    }else{
                        echo "Ocurrio un error al obtener el saldo";
                        exit();
                    }
                    
                    //v_reseta = rsKardex!NRECETA
                    $v_nreseta = 0;
                    $v_produccion = 0;
                    //v_cant_e = Me![CANT_R]
                    $v_venta = $this->$reg["venta"];
                    $v_pvu = $matriz[i][3];
                    $v_totalv = $v_pvu * $cantbuscada;
                    $v_tipo = "venta";
                    //MsgBox (v_produccion)
                    $sqlInsertar;
                    $sqlUpdate;
                    $sqlInsertar = "insert into movimientos (puv,venta, producto, cants, cu, fksucursal, cantsol, existencias, compra) values ('" . $v_pvu . "','" . $v_venta . "','" . $v_producto . "','" . $cantbuscada . "','" . $v_pu . "','" . $v_empresa . "','" . $v_saldo . "','0', '" . $v_compra . "')";
                    //MsgBox (sqlInsertar)
                    
                    $conexion->query($sqlInsertar);
                        $sqlUpdate = "update movimientos set existencias = existencias - " . $cantbuscada . " where id = " . $regK["id"];
                    //MsgBox (sqlUpdate)
                    $conexion->query($sqlUpdate);
                    if($v_cant_s <= 0){
                        $i = $i + 1;
                        $v_cant_s = $matriz[i][2];
                        $v_producto = $matriz[i][0];
                    }
                    $sqlQueryKardex = "SELECT * FROM movimientos WHERE producto = '" . $v_producto . "' and existencias > 0;";
                }else{
                    printf("Ocurrio un error");
                    exit();
                }
            }
        }
    }
    printf("Proceso finalizado!!!");
    //DoCmd.SetWarnings True 'activar mensajes del sistema
?>