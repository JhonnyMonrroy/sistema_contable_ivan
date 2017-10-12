<?php 
	header("Content-Type: application/json; charset=UTF-8");
	require_once("../../conexion.php");
	$conexion = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

	$sql = "SELECT sucursales.responsable, productos.producto, pedido, compra, traspaso, venta, cante, cants, cu, cose, coss FROM movimientos INNER JOIN sucursales ON sucursales.id = movimientos.fksucursal INNER JOIN productos ON productos.id = movimientos.producto";
	$resultado = $conexion->query($sql);
	$salida = "";
	while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
	    if ($salida != ""){$salida .= ",";}

	    $salida .= '{"responsable":"'.$fila["responsable"].'",';
	    $salida .= '"producto":"'.$fila["producto"].'",';
	    $salida .= '"pedido":"'.$fila["pedido"].'",';
	    $salida .= '"compra":"'.$fila["compra"].'",';
	    $salida .= '"traspaso":"'.$fila["traspaso"].'",';
	    $salida .= '"venta":"'.$fila["venta"].'",';
	    $salida .= '"cante":"'.$fila["cante"].'",';
	    $salida .= '"cants":"'.$fila["cants"].'",';
	    $salida .= '"cu":"'.$fila["cu"].'",';
	    $salida .= '"cose":"'.$fila["cose"].'",';
	    $salida .= '"coss":"'.$fila["coss"].'"}';
	}

	$salida ='{"registros":['.$salida.']}';

	// $sql1 = "SELECT * FROM productos";
	// $result = $conexion->query($sql1);
	// $prod = "";
	// while ($fila1  = $result->fetch_array(MYSQLI_ASSOC)){

	//     $prod .= '{"codigoprod":"'.$fila1["codigo_prod"].'",';
	//     $prod .= '"producto":"'.$fila1["producto"].'"}';
	// }

	// $prod ='{"prod":['.$prod.']}';
	$conexion->close();
	echo ($salida);
	// echo ($prod);
?>