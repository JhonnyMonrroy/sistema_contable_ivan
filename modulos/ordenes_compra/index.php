<!DOCTYPE html>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modulo Ordenes de Compra v1.0</title>
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
	<div class="container" data-ng-app="ordenesCompraApp"
		data-ng-controller="ordenesCompraCtrl">
		<h1>Ordenes de Compra</h1>
		<button type="button" class="btn btn-primary"
			data-ng-click="nuevaOrdenCompra()">Nueva Orden de compra</button>
		<p />
		<table class="table">
			<tr>
				<th>ID</th>
				<th>FECHA</th>
				<th>PROVEEDOR</th>
				<th>ORIGEN</th>
				<th>FECHA DE LLEGADA</th>
				<th>FORMA DE PAGO</th>
				<th>OBSERVACIONES</th>
				<th>RECIBIDO</th>
				<th>FECHA RECIBIDO</th>
				<th>DIFERENCIA</th>
				<th></th>
			</tr>
			<tr data-ng-repeat="orden in ordenes_compra">
				<td>{{ orden.id}}</td>
				<td>{{ orden.fecha | date : "dd/MM/yyyy" }}</td>
				<td>{{ orden.proveedor.razon_social }}</td>
				<td>{{ orden.contenedor }}</td>
				<td>{{ orden.origen }}</td>
				<td>{{ orden.fecha_llegada | date : "dd/MM/yyyy" }}</td>
				<td>{{ orden.forma_pago }}</td>
				<td>{{ orden.observaciones }}</td>
				<td>{{ orden.importe }}</td>
				<td>{{ orden.fecha_recibido | date : "dd/MM/yyyy" }}</td>
				<td>{{ orden.diferencia }}</td>
				<td>
					<button type="button" class="btn btn-default btn-xs"
						data-ng-click="mostrarOrdenCompra(orden)">Mostrar</button>
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarOrdenCompra(orden)">Editar</button>
					<button type="button" class="btn btn-danger btn-xs"
						data-ng-click="eliminarOrdencompra(oden)">Eliminar</button>
				</td>
			</tr>
		</table>

		<!-- Modal Editar orden de Compra-->
		<div id="editarOrdenCompraModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ tituloModal }}</h4>
					</div>
					<div class="modal-body">

						<form class="form-horizontal">

							<div class="form-group">
								<label class="control-label col-sm-2" for="fecha_c">FECHA:</label>
								<p class="input-group">
									<input type="text" class="form-control"
										uib-datepicker-popup="dd/MM/yyyy" ng-model="ordenCompra.fecha"
										is-open="popup1.opened" datepicker-options="dateOptions"
										ng-required="true" close-text="Close"
										alt-input-formats="altInputFormats" /> <span
										class="input-group-btn">
										<button type="button" class="btn btn-default"
											ng-click="open1()">
											<i class="glyphicon glyphicon-calendar"></i>
										</button>
									</span>
								</p>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="proveedor">Proveedor:</label>
								<div>
									<select class="form-control" id="proveedor"
										data-ng-model="orden_compra.fk_proveedor">
										<option></option>
										<option data-ng-repeat="proveedor in proveedores"
											value="{{proveedor.id}}">{{proveedor.razon_social}}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-1" for="ncomprobante">No.:
								</label>
								<div class="col-sm-1">
									<span>{{transaccion.nro_comprobante}}</span>
								</div>
								<label class="control-label col-sm-1" for="ntc">No.
									Tipo:</label>
								<div class="col-sm-1">
									<span>{{transaccion.nro_tipo_comprobante}}</span>
								</div>


								<label class="control-label col-sm-2" for="fecha_c">FECHA:</label>
								<div class="form-group col-sm-2">
									<p class="input-group">
										<input type="text" class="form-control"
											uib-datepicker-popup="dd/MM/yyyy"
											ng-model="transaccion.fecha" is-open="popup2.opened"
											datepicker-options="dateOptions" ng-required="true"
											close-text="Close" alt-input-formats="altInputFormats" /> <span
											class="input-group-btn">
											<button type="button" class="btn btn-default"
												ng-click="open2()">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</span>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-1" for="glosa">Glosa:</label>
								<div class="col-sm-11">
									<input type="text" class="form-control" id="glosa"
										ng-model="transaccion.glosa" placeholder="Glosa del asiento">
								</div>
							</div>
							<div class="modal-heading">Detalle del comprobante</div>
							<div class="modal-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>COD_CUENTA</th>
											<th>DESCRIPCION</th>
											<th>DEBE</th>
											<th>HABER</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr data-ng-repeat="operacion in transaccion.operaciones">
											<td>{{operacion.cuenta.codigo}}</td>
											<td>{{operacion.cuenta.nombre_cta}}</td>
											<td>{{operacion.debe}}</td>
											<td>{{operacion.haber}}</td>
											<td>
												<button type="button"
													class="btn btn-danger btn-xs glyphicon glyphicon-remove"
													data-ng-click="eliminarOperacion(operacion)"></button>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="form-group col-sm-10">
													<select class="form-control" id="sel1"
														data-ng-model="operacion.cuenta">
														<option selected></option>
														<option data-ng-repeat="cuenta in cuentas"
															value="{{cuenta}}">{{cuenta.codigo}} -
															{{cuenta.nombre_cta}}</option>
													</select>
												</div>
											</td>
											<!-- 											<td><input type="text" -->
											<!-- 												data-ng-model="operacion.descripcion" /></td> -->
											<td><input type="text" data-ng-model="operacion.debe" /></td>
											<td><input type="text" data-ng-model="operacion.haber" /></td>
											<td>
												<button type="button"
													class="btn btn-primary btn-xl glyphicon glyphicon-ok"
													data-ng-click="adicionarOperacion(operacion)"></button>
											</td>
										</tr>
										<tr>
											<th colspan="2">TOTAL</th>
											<td>{{sumaDebe}}</td>
											<td>{{sumaHaber}}</td>
											<td></td>
										</tr>
										<tr>
											<th colspan="2">TOTAL DIFERENCIA</th>
											<th colspan="2" style="text-align: center;">{{sumaHaber
												- sumaDebe}}</th>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success"
									data-ng-click="guardarTransaccion()">Guardar</button>
								<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Mostrar Comprobante-->
		<div id="mostrarTransaccionModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ tituloModal }}</h4>
					</div>
					<div class="modal-body">
						<table class="table">
							<tr>
								<th>Nro.:</th>
								<td>{{transaccion.nro_comprobante}}</td>
								<th>Nro. Tipo:</th>
								<td>{{transaccion.nro_tipo_comprobante}}</td>
								<th>Comprobante de:</th>
								<td>{{transaccion.tipo_transaccion.tipo_transaccion}}</td>
								<th>Fecha:</th>
								<td>{{transaccion.fecha | date : "dd/MM/yyyy" }}</td>
							</tr>
							<tr>
								<th>Glosa:</th>
								<td colspan="7">{{transaccion.glosa}}</td>
							</tr>
							<tr>
								<th colspan="8">Detalle del comprobante</th>
							</tr>
							<tr>
								<td colspan="8">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>COD_CUENTA</th>
												<th>DESCRIPCION</th>
												<th>DEBE</th>
												<th>HABER</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr data-ng-repeat="operacion in transaccion.operaciones">
												<td>{{operacion.cuenta.codigo}}</td>
												<td>{{operacion.cuenta.nombre_cta}}</td>
												<td>{{operacion.debe}}</td>
												<td>{{operacion.haber}}</td>
											</tr>
											<tr>
												<th colspan="2">TOTAL</th>
												<td>{{sumaDebe}}</td>
												<td>{{sumaHaber}}</td>
												<td></td>
											</tr>
											<tr>
												<th colspan="2">TOTAL DIFERENCIA</th>
												<th colspan="2" style="text-align: center;">{{sumaHaber
													- sumaDebe}}</th>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
					</div>

				</div>
			</div>
		</div>
	</div>

</body>
</html>