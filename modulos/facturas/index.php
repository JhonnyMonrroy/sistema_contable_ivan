<!DOCTYPE html>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modulo Facturas v1.0</title>
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
	<div class="container" data-ng-app="facturasApp"
		data-ng-controller="facturasCtrl">
		<h1>Factura</h1>
		<button type="button" class="btn btn-primary"
			data-ng-click="nuevaFactura()">Nueva Factura</button>
		<p />
		<table class="table">
			<tr>
				<th>CODIGO_FAC</th>
				<th>NFACTURA</th>
				<th>NIT</th>
				<th>NOMBRE</th>
				<th>FECHA</th>
				<th>TOTALP</th>
				<th>DESCUENTO</th>
				<th>TOTALF</th>
				<th>CODIGO_CTRL</th>
				<th>ESTADO</th>
				<th>DOSIFICACION</th>
				<th></th>
			</tr>
			<tr data-ng-repeat="factura in facturas">
				<td>{{ factura.id}}</td>
				<td>{{ factura.nfactura}}</td>
				<td>{{ factura.nit}}</td>
				<td>{{ factura.nombre}}</td>
				<td>{{ factura.fecha | date : "dd/MM/yyyy" }}</td>
				<td>{{ factura.totalp}}</td>
				<td>{{ factura.descuento}}</td>
				<td>{{ factura.totalf}}</td>
				<td>{{ factura.codigo_ctrl}}</td>
				<td>{{ factura.estado}}</td>
				<td>{{ factura.id_dosificacion}}</td>
				<td>
					<button type="button" class="btn btn-default btn-xs"
						data-ng-click="mostrarFactura(factura)">Mostrar</button>
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarFactura(factura)">Editar</button>
<!-- 					<button type="button" class="btn btn-danger btn-xs" -->
<!-- 						data-ng-click="eliminarCuenta(cuenta)" disabled="disabled">Eliminar</button> -->
				</td>
			</tr>
		</table>

		<!-- Modal Editar Comprobante-->
		<div id="editarFacturaModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
            <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ tituloModal }}</h4>
					</div>
					<div class="modal-body">
				    <form class="form-horizontal">
			         <div class="panel panel-default">
                        <div class="form-group">
				            <label class="control-label col-sm-1" for="nfactura">Nro:</label>
				            <div class="col-sm-1">
					           <span>{{factura.nfactura}}</span>
				            </div>
				            <label class="control-label col-sm-2" for="fecha">FECHA:</label>
				            <div class="form-group col-sm-2">
						      <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup="dd/MM/yyyy"
											ng-model="factura.fecha" is-open="popup1.opened"
											datepicker-options="dateOptions" ng-required="true"
											close-text="Close" alt-input-formats="altInputFormats" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open1()">
                                        <i class="glyphicon glyphicon-calendar"></i>
				                    </button>
                                </span>
						      </p>
				            </div>
                        </div>
				        <div class="form-group">
				            <label class="control-label col-sm-1" for="nit">NIT:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nit" ng-model="factura.nit" placeholder="nit">
                            </div>
                            <label class="control-label col-sm-1" for="nombre">NOMBRE:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nombre" ng-model="factura.nombre" placeholder="nombre">
                            </div>
                            <label class="control-label col-sm-1" for="descuento">Descuento:</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="descuento" ng-model="factura.descuento" placeholder="descuento">
                            </div>
                        </div>
                        <div class="panel-heading">Detalle de la factura</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>id</th>
								    <th>Producto</th>
								    <th>Cantidad</th>
								    <th>Precio Unitario</th>
								    <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="detalle_factura in factura.detalles">
                                        <td>{{detalle_factura.producto.codigo_prod}}</td>
										<td>{{detalle_factura.producto.producto}}</td>
                                        <td>{{detalle_factura.cantidad}}</td>
										<td>{{detalle_factura.precio_unit}}</td>
                                        <td>{{detalle_factura.cantidad * detalle_factura.precio_unit}}</td>
										<td>
										  <button type="button"
											class="btn btn-danger btn-xs glyphicon glyphicon-remove"
											data-ng-click="eliminarDetalle_factura(detalle_factura)"></button>
										</td>
                                    </tr>
									<tr>
										<td colspan="2">
										  <div class="form-group col-sm-10">
											<select class="form-control" id="sel1" data-ng-model="detalle_factura.producto">
                                                <option selected></option>
												<option data-ng-repeat="producto in productos" value="{{producto}}">{{producto.codigo_prod}} - {{producto.producto}}</option>
											</select>
										  </div>
										</td>
										<td><input type="text" data-ng-model="detalle_factura.cantidad" /></td>
										<td><input type="text" data-ng-model="detalle_factura.precio_unit" /></td>
										<td></td>
										<td>
										  <button type="button" class="btn btn-primary btn-xl glyphicon glyphicon-ok"
													data-ng-click="adicionarDetalle_factura(detalle_factura)"></button>
										</td>
									</tr>
									<tr>
										<th colspan="2">TOTAL</th>
										<td></td>
										<td></td>
                                        <td>{{sumaProd}}</td>
										</tr>
									<tr>
										<th colspan="2">TOTAL Descuento</th>
										<th colspan="2" style="text-align: center;">{{sumaHaber - sumaDebe}}</th>
									</tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" data-ng-click="guardarFactura()">Guardar</button>
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                        </div>
                     </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
		

		<!-- Modal Mostrar Comprobante-->
		<div id="mostrarFacturaModal" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{tituloModal}}</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Nro.:</th>
                            <td>{{factura.nfactura}}</td>
                            <th>nit :</th>
                            <td>{{factura.nit}}</td>
                            <th>nombre:</th>
                            <td>{{factura.nombre}}</td>
                            <th>Fecha:</th>
                            <td>{{factura.fecha | date : "dd/MM/yyyy" }}</td>
                        </tr>
                        <tr>
                            
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