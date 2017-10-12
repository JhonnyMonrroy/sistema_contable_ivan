<!DOCTYPE html>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modulo Comprobantes v1.0</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="../../css/bootstrap.css"> -->
<link rel="stylesheet" href="../../css/datetimepicker.css" />

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/angular.min.js"></script>

<script src="../../js/moment.min.js"></script>
<script type="text/javascript" src="../../js/angular-animate.min.js"></script>
<script type="text/javascript" src="../../js/angular-touch.min.js"></script>
<script type="text/javascript" src="../../js/ui-bootstrap-tpls.min.js"></script>
<script src="app.js"></script>
</head>
<body>
	<div class="container" data-ng-app="transaccionesApp"
		data-ng-controller="transaccionesCtrl">
		<h1>Libro Mayor</h1>
		<div class="form-group col-sm-4">
			<label>Cuenta:</label>
			<select class="form-control" id="sel1">
				<option selected></option>
				<option data-ng-repeat="cuenta in cuentas" value="{{cuenta}}">{{cuenta.codigo}} - {{cuenta.nombre_cta}}</option>
			</select>
		</div>
		<table class="table">
			<tr>
				<th>FECHA</th>
				<th>NRO. COMPROBANTE</th>
				<th>NRO.TIPO</th>
				<th>TIPO</th>
				<th>GLOSA</th>
				<th>DEBE</th>
				<th>HABER</th>
			</tr>
			<tr data-ng-repeat="transaccion in transacciones">
				<td>{{ transaccion.fecha | date : "dd/MM/yyyy" }}</td>
				<td>{{ transaccion.nro_comprobante }}</td>
				<td>{{ transaccion.nro_tipo_comprobante }}</td>
				<td>{{ transaccion.tipo_transaccion.tipo_transaccion }}</td>
				<td>{{ transaccion.glosa }}</td>
				<span  data-ng-repeat="operacion in transaccion.operaciones">
				<td>{{ operacion.debe}}</td>
				<td>{{ operacion.haber}}</td>
				</span>
			</tr>
			<tr>
				<th colspan="5">TOTAL</th>
				<td>{{sumaDebe}}</td>
				<td>{{sumaHaber}}</td>
			</tr>
			<tr>
				<th colspan="5">TOTAL DIFERENCIA</th>
				<th colspan="2" style="text-align: center;">{{sumaHaber - sumaDebe}}</th>
			</tr>
		</table>

		
	</div>
</body>
</html>