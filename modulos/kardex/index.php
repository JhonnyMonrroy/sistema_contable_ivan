<!DOCTYPE html>

<html lang="es-ES">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">





<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Modulo kardex v1.0</title>

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

	<div class="container" data-ng-app="kardexApp"

		data-ng-controller="kardexCtrl">

		<h1>Kardex</h1>

		<div class="form-group">

								<label for="tx_sucursal" class="control-label col-sm-2">SUCURSAL:</label>

								<div class="input-group col-sm-8">

								<select class="form-control" id="sel1" data-ng-model="consulta.id_sucursal">

								      <option selected></option>

								      <option data-ng-repeat="sucursal in sucursales" 

									  value="{{sucursal.id}}">{{sucursal.responsable}} - {{sucursal.direccion}}</option>

							    </select>

								</div>

		</div>

		<div class="form-group">

								<label for="tx_produtcto" class="control-label col-sm-2">PRODUCTO:</label>

								<div class="input-group col-sm-8">

								<select class="form-control" id="sel1"

								data-ng-model="consulta.id_producto">

								<option selected></option>

								<option data-ng-repeat="producto in productos"

									value="{{producto.id}}">{{producto.codigo_prod}} - {{producto.producto}} {{producto.marca}} {{producto.modelo}} {{producto.descripcion}}</option>

							    </select>

								</div>

		</div>		

		<div class="form-group">

			<label for="fechaInicio" class="control-label col-sm-2">FECHA INICIO:</label>

			<p class="input-group col-sm-2">

			<input type="text" class="form-control"

				uib-datepicker-popup="dd/MM/yyyy"

				ng-model="consulta.fechaInicio" is-open="popup1.opened"

				datepicker-options="dateOptions" ng-required="true"

				close-text="Close" alt-input-formats="altInputFormats" /> 

				<span class="input-group-btn">

				<button type="button" class="btn btn-default"

					ng-click="open1()">

					<i class="glyphicon glyphicon-calendar"></i>

				</button>

				</span>

			</p>

		</div>

		<div class="form-group">

			<label for="fechaFin" class="control-label col-sm-2">FECHA FIN:</label>

			<p class="input-group col-sm-2">

			<input type="text" class="form-control"

				uib-datepicker-popup="dd/MM/yyyy"

				ng-model="consulta.fechaFin" is-open="popup2.opened"

				datepicker-options="dateOptions" ng-required="true"

				close-text="Close" alt-input-formats="altInputFormats" /> 

				<span class="input-group-btn">

				<button type="button" class="btn btn-default"

					ng-click="open2()">

					<i class="glyphicon glyphicon-calendar"></i>

				</button>

				</span>

			</p>

		</div>

		<div class="modal-footer">

								<button type="submit" class="btn btn-success"

									data-ng-click="consultaKardex()">Buscar</button>

								<button type="button" class="btn btn-info" data-dismiss="modal">Imprimir</button>

							</div>

		<table class="table">

			<tr>

				<th>SUCURSAL</th>

				<th>ID</th>

				<th>FECHA</th>

				<th>PRODUCTO</th>

				<th>TIPO</th>

				<th>CANTE</th>

				<th>CANTS</th>

				<th>SALDO</th>

				<th>PU</th>

				<th>IMPE</th>

				<th>IMPS</th>

			</tr>

			<tr data-ng-repeat="movimiento in movimientos">

			    <td>{{ movimiento.det_suc }}</td>

				<td>{{ movimiento.id }}</td>

				<td>{{ movimiento.fecha | date : "dd/MM/yyyy" }}</td>

				<td>{{ movimiento.det_prod }}</td>

				<td>{{ movimiento.tipo }}</td>

				<td>{{ movimiento.cante }}</td>

				<td>{{ movimiento.cants}}</td>

				<td>{{ movimiento.saldo}}</td>

				<td>{{ movimiento.pu }}</td>

				<td>{{ movimiento.impe }}</td>

				<td>{{ movimiento.imps }}</td>	

			</tr>

			<tr>

				<th colspan="5">TOTAL</th>

				<td>{{sumaCante}}</td>

				<td>{{sumaCants}}</td>

				<td>{{sumaCante - sumaCants}}</td>
				<td></td>

			</tr>

		</table>



		

	</div>

</body>

</html>