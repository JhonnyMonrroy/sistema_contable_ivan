<?php
    require_once("../../conexion.php");
    require_once '../../lib/rb.php';
    R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
    const T_proveedores="proveedores";
    const T_ordenes_compra="ordenescompra";
    const T_movimientos = "movimientos";
    const T_productos ="productos";
	$id=$_GET["id"];
	$orden=R::findOne( T_ordenes_compra, ' id = ? ', [ $id ] );
	$proveedor = R::findOne(T_proveedores, ' id = ? ', [ $orden->fk_proveedor ]);
	//obtener ovimientos
	$movimientos =R::find( T_movimientos, ' compra = ? ', [ $orden->id ] );
	$movimientos_result=[];
	$totalFinal = 0;
	foreach ($movimientos as $movimiento){
		$movimiento->fk_producto = $movimiento->producto;
		$movimiento->producto=R::findOne( T_productos, ' id = ? ', [ $movimiento->producto ] );
		$totalFinal += $movimiento->cu * $movimiento->cants;
		array_push($movimientos_result,$movimiento);
	}
	$orden->productos_compra=$movimientos_result;
	
?>	
<html>
<head>
<style>
@font-face{
	src:url("file:///C|/xampp/htdocs/sistema_contable_ivan-modulo_KARDEX/sistema_contable_ivan-modulo_KARDEX/fonts/OpenSans.ttf");
	font-family: "OpenSans";
}
@font-face{
	src:url("file:///C|/xampp/htdocs/sistema_contable_ivan-modulo_KARDEX/sistema_contable_ivan-modulo_KARDEX/fonts/Oswald.ttf");
	font-family: "Oswald";
}
body{
	font-family: "OpenSans";
}
.center{
   width: 90%;
   margin: 0 auto;
}
div.center h1{
	margin:0;
	text-align: center;
	font-family: "Oswald";
}
div.numero{
	margin-top: 20px;
	margin-left: 40px;
}
div#primero{
	margin-top: 20px;
}
div.fecha{
	font-size: 12px;
	margin: 0px 0 10px 40px;
	font-weight: bold;
}
div.fecha:nth-child(7){
	position: absolute;
	left:250;
	top: 160;
}
div.numero h1{
	text-align: right;
	font-size: 16px;
}
div.obs{
	width: 86%;
	margin: 0 auto;
	border: 3px solid #000;
	padding: 20px;
	margin: 10px auto;
	height: 50px;
}
.titleobs{
	font-weight: bold;
	font-family: "Oswald";
	display: block;
	margin-top: 20px;
	margin-left: 60px;
}
div.tabla{
	border: 3px solid #000;
	padding: 20px;
	height: 350px;
	width: 86%;
}
div.tabla table{
	width: 100%;
	/*border: 1px solid #000;*/
	padding: 10px;
	font-size: 12px;
}
thead tr{
	border: 1px solid #000;
	background-color: orange;
}
thead tr th:nth-child(1){
	width: 5%;
}
thead tr th:nth-child(2){
	width: 15%;
}
thead tr th:nth-child(3){
	width: 47%;
}
thead tr th:nth-child(4){
	width: 8%;
}
thead tr th:nth-child(5){
	width: 12.5%;
}
thead tr th:nth-child(6){
	width: 12.5%;
}
tbody tr td:nth-child(1){
	text-align: center;
}
tbody tr td:nth-child(4){
	text-align: right;
}
tbody tr td:nth-child(5){
	text-align: right;
}
tbody tr td:nth-child(6){
	text-align: right;
}
/*Totales*/
div.total{
	border: 3px solid #000;
	border-top: none;
	padding: 20px;
	width: 86%;
	/*padding: 10px 34px;
	width: 69.3%;*/
}
div.total table{
	width: 100%;
	font-size: 12px;
	margin: 0 auto;
}
.tdebe{
	width: 15%;
	text-align: right;
}
div.total table tr td{
	font-weight: bold;
}

</style>
</head>
<body>
	<div class="numero center">
		<h1>NUMERO: <?php echo $orden->id; ?></h1>
	</div>
	<div class="center">
		<h1>ORDEN DE COMPRA</h1>
	</div>
	<div class="fecha center" id="primero">
		<label>FECHA DE EMISION:<?php echo $orden->fecha; ?></label>
	</div>
	<div class="fecha center">
		<label>NOMBRE DEL PROVEEDOR:<?php echo $proveedor->razon_social; ?></label>
	</div>
	<div class="fecha center">
		<label>DIRECCION:<?php echo $proveedor->direccion; ?></label>
	</div>
	<div class="fecha center">
		<label>TELEFONO/FAX:<?php echo $proveedor->fono; ?></label>
	</div>
	<div class="fecha center">
		<label>CONTENEDOR/EMBARQUE:<?php echo $orden->contenedor; ?></label>
	</div>
	<div class="fecha center">
		<label>ORIGEN:<?php echo $orden->origen; ?></label>
	</div>
	<div class="fecha center">
		<label>DESTINO:</label>
	</div>
	<div class="fecha center">
		<label>FECHA DE LLEGADA:</label>
	</div>
	<div class="fecha center">
		<label>SOLICITADO POR:</label>
	</div>
	<div class="fecha center">
		<label>FORMA DE PAGO:</label>
	</div>
	<div class="tabla center">
		<table>
			<thead>
				<tr>
					<th>Nº</th>
					<th>CODIGO</th>
					<th>DESCRIPCION DEL PRODUCTO</th>
					<th>CANTIDAD</th>
					<th>PRECIO UNITARIO</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
            <?php
			foreach ($orden->productos_compra as $prod_compra){
			?>
				<tr>
					<td><?php echo $prod_compra->id; ?></td>
					<td><?php echo $prod_compra->producto->codigo_prod; ?></td>
					<td><?php echo $prod_compra->producto->producto." ".$prod_compra->producto->marca." ".$prod_compra->producto->medida." ".$prod_compra->producto->modelo; ?></td>
					<td><?php echo $prod_compra->cantsol; ?></td>
					<td><?php echo $prod_compra->cu; ?></td>
					<td><?php echo $prod_compra->cantsol * $prod_compra->cu; ?></td>
				</tr>
            <?php
			}
			?>
			</tbody>
		</table>
	</div>
	<div class="total center">
		<table>
			<tr>
				<td>TOTAL</td>
				<td class="tdebe"><?php echo $totalFinal; ?></td>
			</tr>
		</table>
	</div>
	<label class="titleobs">OBSERVACIONES</label>
	<div class="obs center">
		<p></p>
	</div>
</body>
</html>