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
	<div class="container" data-ng-app="filtroproductosApp"
		data-ng-controller="filtroproductosCtrl">
		<h1>Kardex de Productos</h1>
		<div class="form-group col-sm-4">
			<label>Producto:</label>
			<select class="form-control" id="sel1">
				<option selected></option>
				<option data-ng-repeat="producto in productos" value="{{producto}}">{{producto.id}} - {{producto.producto}}</option>
			</select>
		</div>
		<table class="table">
			<tr>
				<th>SUCURSAL</th>
				<th>PRODUCTO</th>
				<th>PEDIDO</th>
				<th>COMPRA</th>
				<th>TRASPASO</th>
				<th>VENTA</th>
				<th>CANTIDAD ENTRADA</th>
				<th>CANTIDAD SALIDA</th>
				<th>COSTO UNITARIO</th>
				<th>COSTO ENTRADA</th>
				<th>COSTO SALIDA</th>
			</tr>
			<tr data-ng-repeat="movimiento in movimientos">
				<td>{{ movimiento.responsable }}</td>
				<td>{{ movimiento.producto }}</td>
				<td>{{ movimiento.pedido }}</td>
				<td>{{ movimiento.compra }}</td>
				<td>{{ movimiento.traspaso }}</td>
				<td>{{ movimiento.venta }}</td>
				<td>{{ movimiento.cante }}</td>
				<td>{{ movimiento.cants }}</td>
				<td>{{ movimiento.cu }}</td>
				<td>{{ movimiento.cose }}</td>
				<td>{{ movimiento.coss 	}}</td>
			</tr>
			<tr>
				<th colspan="6">TOTAL</th>
				<td>{{cante}}</td>
				<td>{{cants}}</td>
				<td></td>
				<td>{{cose}}</td>
				<td>{{coss}}</td>
			</tr>
		</table>

		
	</div>
</body>
</html>