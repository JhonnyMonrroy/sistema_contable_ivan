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
				<th>CONTENEDOR</th>
				<th>ORIGEN</th>
				<th></th>
			</tr>
			<tr data-ng-repeat="orden in ordenes_compra">
				<td>{{ orden.id}}</td>
				<td>{{ orden.fecha | date : "dd/MM/yyyy" }}</td>
				<td>{{ orden.proveedor.razon_social }}</td>
				<td>{{ orden.contenedor }}</td>
				<td>{{ orden.origen }}</td>
				
				<td>
					<button type="button" class="btn btn-default btn-xs"
						data-ng-click="mostrarOrdenCompra(orden)">Mostrar</button>
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarOrdenCompra(orden)">Editar</button>
					<button type="button" class="btn btn-danger btn-xs"
						data-ng-click="eliminarOrdenCompra(orden)">Eliminar</button>
					<button type="button" class="btn btn-secondary btn-xs"
						data-ng-click="ingresoOrdenCompra(orden)">Ingreso</button>	
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
						<div class="form-horizontal">
							<div class="form-group">
								<label for="fecha_c" class="control-label col-sm-2">FECHA:</label>
								<p class="input-group col-sm-2">
									<input type="text" class="form-control"
										uib-datepicker-popup="dd/MM/yyyy"
										ng-model="orden_compra.fecha" is-open="popup1.opened"
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
								<label for="tx_proveedor" class="control-label col-sm-2">PROVEEDOR:</label>
								<div class="input-group col-sm-8">
									<select class="form-control" id="tx_proveedor"
										data-ng-model="orden_compra.fk_proveedor">
										<option></option>
										<option data-ng-repeat="proveedor in proveedores" 
											value="{{proveedor.id}}">{{proveedor.razon_social}}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="contenedor" class="control-label col-sm-2">CONTENEDOR:</label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" id="contenedor"
									data-ng-model="orden_compra.contenedor"></div>
							</div>
							<div class="form-group">
								<label for="origen" class="control-label col-sm-2">ORIGEN:</label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" data-ng-model="orden_compra.origen"></div>
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
										<tr data-ng-repeat="prod in orden_compra.productos_compra">
											<td>{{prod.producto.codigo_prod}}</td>
											<td>{{prod.producto.producto}} {{prod.producto.marca}} {{prod.producto.modelo}} {{prod.producto.descripcion}}</td>
											<td>{{prod.cantidad}}</td>
											<td>{{prod.precio_unitario}}</td>
											<td>{{prod.cantidad*prod.precio_unitario}}</td>
											<td>
												<button type="button"
													class="btn btn-danger btn-xs glyphicon glyphicon-remove"
													data-ng-click="eliminarProductoCompra(prod)"></button>
											</td>
										</tr>
										<tr data-ng-hide="ocultarSubFormulario">
											<td colspan="2">
												<div class="form-group col-sm-12">
													<select class="form-control" id="sel1"
														data-ng-model="producto_compra.fk_producto">
														<option selected></option>
														<option data-ng-repeat="producto in productos"
															value="{{producto.id}}">{{producto.codigo_prod}} - {{producto.producto}} {{producto.marca}} {{producto.modelo}} {{producto.descripcion}}</option>
													</select>
												</div>
											</td>
											<td><input type="text" data-ng-model="producto_compra.cantidad" /></td>
											<td><input type="text" data-ng-model="producto_compra.precio_unitario" /></td>
											<td>
												{{(producto_compra.cantidad!=''&&producto_compra.precio_unitario)?producto_compra.cantidad*producto_compra.precio_unitario:null}}
											</td>
											<td>
												<button type="button"
													class="btn btn-primary btn-xl glyphicon glyphicon-ok"
													data-ng-click="adicionarProductoCompra(producto_compra)"></button>
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
									data-ng-click="guardarOrdenCompra()">Guardar</button>
								<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Ingresar a almacenes -->
	
	<div id="ingresarOrdenCompraModal" class="modal fade" role="dialog">
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
								<label for="fecha_c" class="control-label col-sm-2">FECHA:</label>
								<p class="input-group col-sm-2">
									<input type="text" class="form-control"
										uib-datepicker-popup="dd/MM/yyyy"
										ng-model="orden_compra.fecha" is-open="popup1.opened"
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
								<label for="tx_proveedor" class="control-label col-sm-2">PROVEEDOR:</label>
								<div class="input-group col-sm-8">
									<select class="form-control" id="tx_proveedor"
										data-ng-model="orden_compra.fk_proveedor">
										<option></option>
										<option data-ng-repeat="proveedor in proveedores" 
											value="{{proveedor.id}}">{{proveedor.razon_social}}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="contenedor" class="control-label col-sm-2">CONTENEDOR:</label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" id="contenedor"
									data-ng-model="orden_compra.contenedor"></div>
							</div>
							<div class="form-group">
								<label for="origen" class="control-label col-sm-2">ORIGEN:</label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" data-ng-model="orden_compra.origen"></div>
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
											<th>CANTIDAD RECIBIDA</th>
										</tr>
									</thead>
									<tbody>
										<tr data-ng-repeat="prod in orden_compra.productos_compra">
											<td>{{prod.producto.codigo_prod}}</td>
											<td>{{prod.producto.producto}} {{prod.producto.marca}} {{prod.producto.modelo}} {{prod.producto.descripcion}}</td>
											<td>{{prod.cantidad}}</td>
											<td>{{prod.precio_unitario}}</td>
											<td>{{prod.cantidad*prod.precio_unitario}}</td>
											<td><input type="text" size="10"  												
                                                class="form-control"data-ng-model="prod.cantidad_recibida" >
										        </td>
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
									data-ng-click="guardarIngresoOrdenCompra()">Ingresar a Almacen</button>
								<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>		

		<!-- Modal Mostrar Comprobante-->
		<div id="mostrarOrdenCompraModal" class="modal fade" role="dialog">
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
						<label for="fecha_c" class="control-label col-sm-2">FECHA:</label>
						<p class="input-group col-sm-2">
						{{orden_compra.fecha | date : "dd/MM/yyyy"}}							
							</span>
						</p>
					</div>
					<div class="form-group">
						<label for="tx_proveedor" class="control-label col-sm-2">PROVEEDOR:</label>
						<div class="input-group col-sm-8"> 
							<select class="form-control" id="tx_proveedor" disabled="true"
								data-ng-model="orden_compra.fk_proveedor">
								<option></option>
								<option data-ng-repeat="proveedor in proveedores" 
									value="{{proveedor.id}}">{{proveedor.razon_social}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="contenedor" class="control-label col-sm-2">CONTENEDOR:</label> <div class="input-group col-sm-8">
							<input type="text"
							class="form-control" id="contenedor"
							data-ng-model="orden_compra.contenedor" disabled="true" ></div>
					</div>
					<div class="form-group">
						<label for="origen" class="control-label col-sm-2">ORIGEN:</label> <div class="input-group col-sm-8"><input type="text"
							class="form-control" data-ng-model="orden_compra.origen" disabled="true"></div>
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
									<!--
									<th><button type="button"
											class="btn btn-default btn-xl glyphicon {{ocultarSubFormulario?'glyphicon-plus':'glyphicon-minus'}}"
											data-ng-click="ocultarSubFormulario=!ocultarSubFormulario" 
											title="{{ocultarSubFormulario?'Mostrar Adicionar Producto':'Ocultar Adicionar Producto'}}">
										</button>
									</th>
                                    -->

								</tr>
							</thead>
							<tbody>
								<tr data-ng-repeat="prod in orden_compra.productos_compra">
									<td>{{prod.producto.codigo_prod}}</td>
									<td>{{prod.producto.producto}} {{prod.producto.marca}} {{prod.producto.modelo}} {{prod.producto.descripcion}}</td>
									<td>{{prod.cantidad}}</td>
									<td>{{prod.precio_unitario}}</td>
									<td>{{prod.cantidad*prod.precio_unitario}}</td>
									<!--
									<td>
										<button type="button"
											class="btn btn-danger btn-xs glyphicon glyphicon-remove"
											data-ng-click="eliminarProductoCompra(prod)"></button>
									</td>
                                    -->
								</tr>
							</tbody>
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