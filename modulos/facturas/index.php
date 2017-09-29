<!DOCTYPE html>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modulo Ventas v1.0</title>
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
	<div class="container" data-ng-app="FacturasApp"
		data-ng-controller="facturasController">
		<h1>Factura</h1>
		<button type="button" class="btn btn-primary"
			data-ng-click="nuevaFactura()">Nueva Factura</button>
		<p />
		<table class="table">
			<tr>
				<th>ID</th>
				<th>NRO FACTURA</th>
				<th>NIT</th>
				<th>RAZON SOCIAL</th>
				<th>FECHA</th>
				<th>TOTAL</th>
				<th>DESCUENTO</th>
				<th>TOTAL FINAL</th>
				<th>CODIGO DE CONTROL</th>
				<th></th>
			</tr>
			<tr data-ng-repeat="factura in facturas">
				<td>{{ factura.id}}</td>
				<td>{{ factura.nfactura }}</td>
				<td>{{ factura.nit }}</td>
				<td>{{ factura.nombre}}</td>
				<td>{{ factura.fecha | date : "dd/MM/yyyy" }}</td>
				<td>{{ factura.totalp }}</td>
				<td>{{ factura.descuento }}</td>
				<td>{{ factura.totalf }}</td>
				<td>{{ factura.codigo_ctrl }}</td>
			
				<td>
				
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarVenta(venta)">Editar
					</button>
					<button type="button" class="btn btn-danger btn-xs"
						data-ng-click="eliminarVenta(venta)">Eliminar</button>
					<button type="button" class="btn btn-default btn-xs"
						data-ng-click="imprimirFactura(venta)">Imprimir</button>
				<!--
					<button type="button" class="btn btn-default btn-xs"
						data-ng-click="mostrarVenta(venta)">Mostrar</button>

					<button type="button" class="btn btn-danger btn-xs"
				-->		
				</td>
			</tr>
		</table>
<!-- Modal Venta-->
<div id="editarFacturasModal" class="modal fade" role="dialog">
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
								<label class="control-label col-sm-2" for="id">No.:</label>
								<div class="col-sm-8">
									<span>{{factura.id}}</span>
								</div>	
							</div>
							<div class="form-group">														
								<label class="control-label col-sm-2" for="nite">NIT:</label>
								<div class="col-sm-8">
									<span>{{factura.nit}}</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="id">AUTORIZACION:</label>
								<div class="col-sm-8">
									<span>{{}}</span>
								</div>
							</div>
							<div class="form-group">
								<label for="nrofactura" class="control-label col-sm-2">Nº FACTURA:</label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" id="nrofactura"
									data-ng-model="factura.nfactura"></div>
							</div>
							<div class="form-group">
								<label for="nitr" class="control-label col-sm-2">NIT : </label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" id="nitr"
									data-ng-model="factura.nit"></div>
							</div>
							<div class="form-group">
								<label for="nombre" class="control-label col-sm-2">NOMBRE : </label> <div class="input-group col-sm-8"><input type="text"
									class="form-control" id="nombre"
									data-ng-model="factura.nombre"></div>
							</div>
							<div class="form-group">
								<label for="fecha" class="control-label col-sm-2">FECHA:</label>
								<p class="input-group col-sm-2">
								<input type="text" class="form-control"
									uib-datepicker-popup="dd/MM/yyyy"
									ng-model="factura.fecha" is-open="popup1.opened"
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
							<label for="fecha" class="control-label col-sm-2">ESTADO:</label>
							<div class="form-group col-sm-3">
								<select class="form-control" id="tipo_c"
									data-ng-change="actualizarNroTipoComprobante()"
									data-ng-model="factura.estado">
									<option></option>
									<option data-ng-repeat="factura in facturas"
									value="{{factura.estado}}">{{factura.estado}}</option>
								</select>
							</div>
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
										<tr data-ng-repeat="prod in venta.productos_venta">
											<td>{{prod.producto.codigo_prod}}</td>
											<td>{{prod.producto.producto}} {{prod.producto.marca}} {{prod.producto.modelo}} {{prod.producto.descripcion}}</td>
											<td>{{prod.cantidad}}</td>
											<td>{{prod.precio_unitario}}</td>
											<td>{{prod.cantidad*prod.precio_unitario}}</td>
											<td>
												<button type="button"
													class="btn btn-danger btn-xs glyphicon glyphicon-remove"
													data-ng-click="eliminarProductoVenta(prod)"></button>
											</td>
										</tr>
										<tr data-ng-hide="ocultarSubFormulario">
											<td colspan="2">
												<div class="form-group col-sm-12">
													<select class="form-control" id="sel1"
														data-ng-model="producto_venta.fk_producto">
														<option selected></option>
														<option data-ng-repeat="producto in productos"
															value="{{producto.id}}">{{producto.codigo_prod}} - {{producto.producto}} {{producto.marca}} {{producto.modelo}} {{producto.descripcion}}</option>
													</select>
												</div>
											</td>
											<td><input type="text" data-ng-model="producto_venta.cantidad" /></td>
											<td><input type="text" data-ng-model="producto_venta.precio_unitario" /></td>
											<td>
												{{(producto_venta.cantidad!=''&&producto_venta.precio_unitario)?producto_venta.cantidad*producto_venta.precio_unitario:null}}
											</td>
											<td>
												<button type="button"
													class="btn btn-primary btn-xl glyphicon glyphicon-ok"
													data-ng-click="adicionarProductoVenta(producto_venta)"></button>
											</td>
										</tr>
										<tr>
										
											<th colspan="4">TOTAL BS</th>
											<td>{{totalFinal}}</td>											
											<th></th>
											
										</tr>
										<tr>
										
											<th colspan="4">DESCUENTO</th>
											<td>
												<div class="input-group col-sm-12">
													<input type="text" class="form-control" id="descuento" data-ng-model="factura.descuento"></div>
											</td>											
											<th></th>
											
										</tr>
										<tr>
										
											<th colspan="4">TOTAL FINAL</th>
											<td>{{totalFinal}}</td>											
											<th></th>
											
										</tr>
										<tr>
										
											<th colspan="5">SON:</th>
											<td>{{venta.saldo}}</td>											
											<th></th>
											
										</tr>
										<tr>
										
											<th colspan="5">CODIGO DE CONTROL:</th>
											<td>{{totalFinal}}</td>											
											<th></th>
											
										</tr>
										
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success"
									data-ng-click="guardarVenta()">Guardar</button>
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