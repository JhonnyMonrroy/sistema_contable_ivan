<?php
    require_once("../../conexion.php");
    require_once '../../lib/rb.php';
    R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
	const T_transacciones="transacciones";
	const T_tipos_transaccion="tipo_trans";
	const T_cuentas="cuentas";
	const T_operaciones="operaciones";
	$id=$_GET["id"];
	$transaccion=R::findOne( T_transacciones, ' id = ? ', [ $id ] );
	$tipo = R::findOne(T_tipos_transaccion, ' id = ? ', [ $transaccion->fk_tipo_transaccion ]);
	$operaciones=R::find( T_operaciones, ' fk_transaccion = ? ', [ $transaccion->id ] );
	$operaciones_result=[];
	$totalDebe = 0;
	$totalHaber = 0;
	foreach ($operaciones as $operacion){
		$operacion->cuenta=R::findOne( T_cuentas, ' id = ? ', [ $operacion->fk_cuenta ] );
		$totalDebe += $operacion->debe;
		$totalHaber += $operacion->haber;
		array_push($operaciones_result,$operacion);
	}
	$transaccion->operaciones=$operaciones_result;
?>
<!DOCTYPE html>	
<html>
<head>
<style>
@font-face{
	src: url("../../fonts/OpenSans.ttf");
	font-family: "OpenSans";
}
@font-face{
	src: url("../../fonts/Oswald.ttf");
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
div.nrotipo{
	width: 90%;
	margin: 0 auto;
}
div.nrotipo h4{
	margin:0;
}
div.numero{
	margin-top: 20px;
	margin-left: 40px;
}
div.fecha{
	margin-right: 40px;
	margin-bottom: 10px;
}
div.numero h1{
	text-align: right;
}
div.glosa{
	width: 86%;
	margin: 0 auto;
	border: 3px solid #000;
	padding: 20px;
	margin: 10px auto;
}
div.glosa label{
	font-weight: bold;
	font-family: "Oswald";
}
div.tabla{
	border: 3px solid #000;
	padding: 20px;
	height: 320px;
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
	width: 15%;
}
thead tr th:nth-child(2){
	width: 55%;
}
thead tr th:nth-child(3){
	width: 15%;
}
thead tr th:nth-child(4){
	width: 15%;
}
tbody tr td:nth-child(3){
	text-align: right;
}
tbody tr td:nth-child(4){
	text-align: right;
}
/*Totales*/
div.total{
	border: 3px solid #000;
	border-top: none;
	border-bottom: none;
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
.f{
	padding: 5!important;
	width: 89.5%!important;
	border-top: 3px solid #000!important;
	border-bottom: 3px solid #000!important;
	/*padding-bottom: 10!important;*/
}
.firma{
	margin:0;
	padding-top: 60px;
	text-align: center !important;
	border: 1px solid #000;
	width: 33.5%;
}
.pie{
	display: inline-block;
	margin-left: 10px;
	font-size: 12px;
}
</style>
</head>
<body>
	<div class="center">
		<h1>COMPROBANTE DE <?php echo $tipo->tipo_transaccion; ?></h1>
	</div>
	<div class="numero center">
		<h1>Nº: <?php echo $transaccion->id; ?></h1>
	</div>
	<div class="nrotipo">
		<h4>Nº: CD<?php $letra = $tipo->tipo_transaccion;
				echo substr($letra,0,1); ?> 
				- <?php echo $transaccion->nro_tipo_comprobante; 
		?></h4>
	</div>
	<div class="fecha center">
		<label><?php 
			$d = $transaccion->fecha;
			$fecha = strftime("%d de %B de %Y", strtotime($d));
			echo "La Paz, ".$fecha;
		?></label>
	</div>
	<div class="glosa center">
		<label>GLOSA</label>
		<p><?php echo $transaccion->glosa; ?></p>
	</div>
	<div class="tabla center">
		<table>
			<thead>
				<tr>
					<th>CUENTA CTE.</th>
					<th>CUENTA</th>
					<th>DEBE</th>
					<th>HABER</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($transaccion->operaciones as $transac){
				?>
					<tr>
						<td><?php echo $transac->cuenta->codigo; ?></td>
						<td><?php echo $transac->cuenta->nombre_cta; ?></td>
						<td><?php echo $transac->debe; ?></td>
						<td><?php echo $transac->haber; ?></td>
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
				<td class="tdebe"><?php echo $totalDebe; ?></td>
				<td class="tdebe"><?php echo $totalHaber; ?></td>
			</tr>
		</table>
	</div>
	<div class="total f center">
		<table>
			<tr>
				<td class="firma">Gerente Gral.</td>
				<td class="firma">Contador</td>
				<td class="firma">Auxiliar</td>
			</tr>
		</table>
	</div>
	<div class="center">
		<p class="pie"><?php 
			$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			 
			echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		?></p>
	</div>
</body>
</html>