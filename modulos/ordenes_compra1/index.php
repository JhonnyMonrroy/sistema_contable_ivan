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
				<th>FECHA EMISION</th>
				<th>PROVEEDOR</th>
				<th>DIRECCION</th>
				<th>TELEFONO</th>
				<th>NIT</th>
				<th>EMBARQUE</th>
				<th>ORIGEN</th>
				<th>DESTINO</th>
				<th>FECHA LLEGADA</th>
				<th>SOLICITADO</th>
				<th>FORMA PAGO</th>
				<th>OBSERVACIONES</th>
				<th></th>
			</tr>
			<tr data-ng-repeat="orden in ordenes">
				<td>{{ orden.id}}</td>
				<td>{{ orden.fechaemision | date : "dd/MM/yyyy" }}</td>
				<td>{{ orden.proveedor.razon_social }}</td>
				<td>{{ orden.direccion }}</td>
				<td>{{ orden.telefono }}</td>
				<td>{{ orden.nit }}</td>
				<td>{{ orden.embarque }}</td>
				<td>{{ orden.origen }}</td>
				<td>{{ orden.destino }}</td>
				<td>{{ orden.fechallegada | date : "dd/MM/yyyy" }}</td>
				<td>{{ orden.solicitado }}</td>
				<td>{{ orden.formapago }}</td>
				<td>{{ orden.observaciones }}</td>
				<td>
					<button type="button" class="btn btn-default btn-xs"
						data-ng-click="mostrarOrdenCompra(orden)">Mostrar</button>
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarOrdenCompra(orden)">Editar</button>
					<button type="button" class="btn btn-danger btn-xs"
						data-ng-click="eliminarOrdenCompra(orden)">Eliminar</button>
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
						<div class="form-group col-sm-12">
							<label class="control-label" for="fechaemision">Fecha de Emision:</label>
							<p class="input-group">
								<input type="text" class="form-control"
										uib-datepicker-popup="dd/MM/yyyy" ng-model="orden.fechaemision"
										is-open="popup1.opened" datepicker-options="dateOptions"
										ng-required="true" close-text="Close"
										alt-input-formats="altInputFormats" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"
											ng-click="open1()">
								<i class="glyphicon glyphicon-calendar"></i>
								</button>
								</span>
								</p>
							</div>
						<div class="form-group col-sm-6">
							<label class="control-label" for="proveedor"> Nombre del Proveedor:</label>
								<div>
									<select class="form-control" id="proveedor"
										data-ng-model="orden.fk_proveedor">
										<option></option>
										<option data-ng-repeat="proveedor in proveedores"
											value="{{proveedor.id}}">{{proveedor.razon_social}}</option>
									</select>
								</div>
							</div>
							<div class="form-group col-sm-1"></div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="direccion"> Direccion:
								</label>
								<input type="text" class="form-control" id="direccion"
										ng-model="orden.direccion" placeholder="Direccion">
							</div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="telefono"> Telefono/Fax:</label>
									<input type="text" class="form-control" id="telefono"
										ng-model="orden.telefono" placeholder="Telefono/Fax">
							</div>
							<div class="form-group col-sm-1"></div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="nit"> RUC/NIT:</label>
								<input type="text" class="form-control" id="nit"
										ng-model="orden.nit" placeholder="RUC / NIT">
								<!--select class="form-control" id="tipo_c" data-ng-change="actualizarNroTipoComprobante()" data-ng-model="comprobante.fk_tipo_transaccion">
									<option selected></option>
									<option ng-repeat="tipo in tipos_transaccion" value="{{tipo.id}}">{{tipo.tipo_transaccion}}</option>
								</select-->
							</div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="embarque"> Contenedor / Embarque:</label>
								<input type="text" class="form-control" id="embarque"
										ng-model="orden.embarque" placeholder="Contenedor / Embarque">
							</div>
							<div class="form-group col-sm-1"></div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="origen"> Origen:</label>
								<input type="text" class="form-control" id="origen"
										ng-model="orden.origen" placeholder="Origen">
							</div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="destino"> Destino:</label>
								<input type="text" class="form-control" id="destino"
										ng-model="orden.destino" placeholder="Destino">
							</div>
							<div class="form-group col-sm-1"></div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="fecha_r"> Fecha Llegada:</label>
								<p class="input-group">
									<input type="text" class="form-control"
										uib-datepicker-popup="dd/MM/yyyy" ng-model="orden.fecha_llegada"
										is-open="popup3.opened" datepicker-options="dateOptions"
										ng-required="true" close-text="Close"
										alt-input-formats="altInputFormats" /> <span
										class="input-group-btn">
										<button type="button" class="btn btn-default"
											ng-click="open3()">
											<i class="glyphicon glyphicon-calendar"></i>
										</button>
									</span>
								</p>
							</div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="solicitado"> Solicitado por:</label>
									<input type="text" class="form-control" id="solicitado"
										ng-model="orden.solicitado" placeholder="Solicitado por">
							</div>
							<div class="form-group col-sm-1"></div>
							<div class="form-group col-sm-6">
								<label class="control-label" for="formapago"> Forma de Pago:</label>
									<input type="text" class="form-control" id="formapago"
										ng-model="orden.formapago" placeholder="Forma de Pago">
							</div>

							<!--Detalle de Compra-->
							<div class="modal-heading">Detalle de Compra</div>
							<div class="modal-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Nº</th>
											<th>CODIGO</th>
											<th>DESCRIPCION</th>
											<th>CANTIDAD</th>
											<th>PRECIO UNITARIO</th>
											<th>TOTAL</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr data-ng-repeat="producto in orden.productos">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td colspan="2">
												<div class="form-group col-sm-12">
													<select class="form-control" id="sel1"
														data-ng-model="operacion.cuenta">
														<option selected></option>
														<option data-ng-repeat="cuenta in cuentas"
															value="{{cuenta}}">{{producto.codigo_prod}} -
															{{producto.descripcion}}</option>
													</select>
												</div>
											</td>
											<!-- 											<td><input type="text" -->
											<!-- 												data-ng-model="operacion.descripcion" /></td> -->
											<td><input type="text" data-ng-model="orden.cantidad" /></td>
											<td><input type="text" data-ng-model="orden.preciounitario" /></td>
											<td><input type="text" data-ng-model="orden.total" /></td>
											<td>
												<button type="button"
													class="btn btn-primary btn-xl glyphicon glyphicon-ok"
													data-ng-click="adicionarOrden(orden)"></button>
											</td>
										</tr>
										<tr>
											<th colspan="5">TOTAL</th>
											<td>{{sumaorden}}</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div><!-- DetalleCompra-->
							<div class="form-group col-sm-12">
								<label class="control-label" for="observaciones"> Observaciones:</label>
									<input type="text" class="form-control" id="observaciones"
										ng-model="orden.observaciones" placeholder="Observaciones">
							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-success"
									data-ng-click="guardarOrdenCompra()">Guardar</button>
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
								<td>{{ orden.id}}</td>
								<td>{{ orden.fechaemision | date : "dd/MM/yyyy" }}</td>
								<td>{{ orden.proveedor.razon_social }}</td>
								<td>{{ orden.direccion }}</td>
								<td>{{ orden.telefono }}</td>
								<td>{{ orden.nit }}</td>
								<td>{{ orden.embarque }}</td>
								<td>{{ orden.origen }}</td>
								<td>{{ orden.destino }}</td>
								<td>{{ orden.fechallegada | date : "dd/MM/yyyy" }}</td>
								<td>{{ orden.solicitado }}</td>
								<td>{{ orden.formapago }}</td>
								<td>{{ orden.observaciones }}</td>
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