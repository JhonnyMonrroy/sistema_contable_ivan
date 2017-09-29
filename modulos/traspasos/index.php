<!DOCTYPE html>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Traspasos v1.0</title>
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
	<div class="container" data-ng-app="TraspasosApp"
		data-ng-controller="traspasosController">
		<h1>Traspasos</h1>
		<button type="button" class="btn btn-primary"
			data-ng-click="nuevoTraspaso()">Nuevo Traspaso</button>
		<p />
		<table class="table">
			<tr>
				<th>ID</th>
				<th>FECHA</th>
				<th>ORIGEN</th>
				<th>DESTINO</th>
				<th>OBSERVACIONES</th>
				<!--
				<th>TOTAL</th>
				<th>DESCUENTO</th>
				<th>A_CUENTA</th>
				<th>SALDO</th>
				-->
				<th></th>
			</tr>
			<tr data-ng-repeat="traspaso in traspasos">
				<td>{{ traspaso.id}}</td>
				<td>{{ traspaso.fecha | date : "dd/MM/yyyy" }}</td>
				<td>{{ traspaso.origen.responsable }} - {{ traspaso.origen.direccion }}</td>
				<td>{{ traspaso.destino.responsable }} - {{ traspaso.destino.direccion }}</td>
				<td>{{ traspaso.observaciones }}</td>

				<td>
				
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarTraspaso(traspaso)">Editar
					</button>
					<button type="button" class="btn btn-danger btn-xs"
						data-ng-click="eliminarTraspaso(traspaso)">Eliminar</button>
				</td>
			</tr>
		</table>
<!-- Modal Venta-->
<div id="editarTraspasosModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ tituloModal }}</h4>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="fecha" class="control-label col-sm-2">FECHA:</label>
								<p class="input-group col-sm-2">
								<input type="text" class="form-control"
									uib-datepicker-popup="dd/MM/yyyy"
									ng-model="traspaso.fecha" is-open="popup1.opened"
									datepicker-options="dateOptions" ng-required="true"
									close-text="Close" alt-input-formats="altInputFormats" /> <span
									class="input-group-btn">
									<button type="button" class="btn btn-default"
										ng-click="open1()">
										<i class="glyphicon glyphicon-calendar"></i>
									</button>
								</span>
							</p>
							</div>
							<div class="form-group">
								<label for="tx_proveedor" class="control-label col-sm-2">ORIGEN:</label>
								<div class="input-group col-sm-8">
									<select class="form-control" id="tx_origen"
										data-ng-model="traspaso.fk_origen">
										<option></option>
										<option data-ng-repeat="sucursal in sucursales" 
											value="{{sucursal.id}}">{{sucursal.responsable}} - {{sucursal.direccion}}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="tx_proveedor" class="control-label col-sm-2">DESTINO:</label>
								<div class="input-group col-sm-8">
									<select class="form-control" id="tx_destino"
										data-ng-model="traspaso.fk_destino">
										<option></option>
										<option data-ng-repeat="sucursal in sucursales" 
										value="{{sucursal.id}}">{{sucursal.responsable}} - {{sucursal.direccion}}</option>
									</select>
								</div>
							</div>							
						</div>
						<div class="form-group">
								<label for="observaciones" class="control-label col-sm-2">OBSERVACIONES:</label> 
								<div class="input-group col-sm-8">
								<input type="text"
									class="form-control" id="observaciones"
									data-ng-model="traspaso.observaciones">
								</div>
							</div>

						<form class="form-horizontal">
							<div class="modal-heading">Productos solicitados</div>
							<div class="modal-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>CODIGO</th>
											<th>DESCRIPCION</th>
											<th>CANTIDAD DE PEDIDO</th>
											<th>PRECIO UNITARIO</th>
											<th>TOTAL</th>
											<th><button type="button"
													class="btn btn-default btn-xl glyphicon {{ocultarSubFormulario?'glyphicon-plus':'glyphicon-minus'}}"
													data-ng-click="ocultarSubFormulario=!ocultarSubFormulario" title="{{ocultarSubFormulario?'Mostrar Adicionar Producto':'Ocultar Adicionar Producto'}}"></button></th>
										</tr>
									</thead>
									<tbody>
										<tr data-ng-repeat="prod in traspaso.productos_traspaso">
											<td>{{prod.producto.codigo_prod}}</td>
											<td>{{prod.producto.producto}} {{prod.producto.marca}} {{prod.producto.modelo}} {{prod.producto.descripcion}}</td>
											<td>{{prod.cantidad}}</td>
											<td>{{prod.precio_unitario}}</td>
											<td>{{prod.cantidad*prod.precio_unitario}}</td>
											<td>
												<button type="button"
													class="btn btn-danger btn-xs glyphicon glyphicon-remove"
													data-ng-click="eliminarProductotraspaso(prod)"></button>
											</td>
										</tr>
										<tr data-ng-hide="ocultarSubFormulario">
											<td colspan="2">
												<div class="form-group col-sm-12">
													<select class="form-control" id="sel1"
														data-ng-model="producto_traspaso.fk_producto">
														<option selected></option>
														<option data-ng-repeat="producto in productos"
															value="{{producto.id}}">{{producto.codigo_prod}} - {{producto.producto}} {{producto.marca}} {{producto.modelo}} {{producto.descripcion}}</option>
													</select>
												</div>
											</td>
											<td><input type="text" data-ng-model="producto_traspaso.cantidad" /></td>
											<td><input type="text" data-ng-model="producto_traspaso.precio_unitario" /></td>
											<td>
											{{(producto_traspaso.cantidad!=''&&producto_traspaso.precio_unitario)?producto_traspaso.cantidad*producto_traspaso.precio_unitario:null}}												
											</td>
											<td>
												<button type="button"
													class="btn btn-primary btn-xl glyphicon glyphicon-ok"
													data-ng-click="adicionarProductoTraspaso(producto_traspaso)"></button>
											</td>
										</tr>
										<tr>
										
											<th colspan="4">TOTAL FINAL</th>
											<td>{{totalFinal}}</td>											
											<th></th>
											
										</tr>
									
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success"
									data-ng-click="guardarTraspaso()">Guardar</button>
								<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>

</body>
</html>