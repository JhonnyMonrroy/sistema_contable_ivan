var app = angular.module('FacturasApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'facturasController',
				function($scope, $http) {

					$scope.cargarFacturas = function(response) {
						$http.get("api.php").then(function(response) {
							$scope.facturas = response.data.facturas;
						});
					}

					$scope.cargarFacturas();
					/**
					 * Crear una nueva Venta
					 */
					$scope.nuevaFactura = function() {
						$scope.factura = {
							id : null,
							productos_factura : []
						};
						
						$scope.ocultarSubFormulario=true;
						$scope.tituloModal = "Nueva Factura";
						// obtenemos a los clientes
						$http.get("../clientes/api.php")
							.then(function(response) {
								$scope.clientes = response.data;
								$http.get("../productos/api.php").then(function(response){
									$scope.productos = response.data;
									//$scope.sumarTotalFinal();
									$('#editarFacturasModal').modal('toggle');
								});
							});
					};
					/**
					 * Guarda un objeto orden de compra
					 */
					$scope.guardarFactura = function() {
						//alert($scope.venta.id);
						//$scope.orden_compra.fk_proveedor=;
						$http(
								{
									url : 'api.php',
									method : $scope.factura.id === null ? "POST": "PUT",
									data : $scope.factura
								}).then(
								function(response) {
									// alert(response.status);
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
										$('#editarFacturasModal').modal('toggle');
									    $scope.cargarFacturas();
									} else {
										//alert("Ocurrio un error 10000");
										console.log(response.data);
									}
								}, function(error) { // optional									
									$scope.cargarFacturas();
									//alert("Ocurrio un error 20000" + error);
									console.log("ERROR:", error)
								});
					};
					/**
					 * eliminar producto venta
					 */
					$scope.eliminarProductoVenta = function(movimiento) {
						if (confirm("Desea eliminar la El Producto : "
								+ movimiento.producto.producto + ' ' +
						        movimiento.producto.marca + ' ' + movimiento.producto.modelo + ' ' + movimiento.producto.descripcion
					)) {
							var vecOpe = [];
							for (var i = 0; i < $scope.venta.productos_venta.length; i++) {
								if ($scope.venta.productos_venta[i].id !== movimiento.id) {
									vecOpe
											.push($scope.venta.productos_venta[i]);
								}
							}
							$scope.venta.productos_venta = vecOpe;
							$scope.sumarTotalFinal();
						}
					};					
					/**
					 * funcion para obtener el total final a partir de los demas totales
					 */
					$scope.sumarTotalFinal = function() {
						$scope.totalFinal = 0.0;
						$scope.factura.total  = 0.0;
						$scope.factura.saldo = 0.0;
						
						for (var i = 0; i < $scope.venta.productos_venta.length; i++) {
							$scope.totalFinal += parseFloat($scope.venta.productos_venta[i].cantidad*$scope.venta.productos_venta[i].precio_unitario);							
						}
						$scope.venta.total  = $scope.totalFinal;
						$scope.venta.saldo  = $scope.venta.total - $scope.venta.descuento - $scope.venta.a_cuenta
						//alert("termino de sumar");
					};					
					/**
					 * adiciona un nuevo producto temporal a la transaccion
					 */
					$scope.adicionarProductoFactura = function(producto_factura) {
						$http.get("../productos/api.php?id="+producto_factura.fk_producto).then(function(producto){
							producto_factura.producto=producto.data;
							$scope.factura.productos_factura.push(producto_factura);
							$scope.inicializarProductoVenta();							
							$scope.sumarTotalFinal();
							$scope.ocultarSubFormulario=true;
							
						});
					};
					/**
					 * funcion que inicializa un producto_venta
					 * */
					$scope.inicializarProductoVenta = function(){
						$scope.producto_venta = {
								id : null
							};
					}
					/**
					 * Se prepara el registro de venta para editar
					 */
					$scope.editarVenta = function(venta) {
						$scope.ocultarSubFormulario=true;						
						$scope.tituloModal = "Editar Venta";
						$http({
							url : 'api.php?id=' + venta.id,
							method : "GET",
						}).then(function(response) {
							$scope.venta = response.data.venta;
							$scope.clientes = response.data.clientes;
							var dia=new Date($scope.venta.fecha);
							$scope.venta.fecha = dia.getTime() + (dia.getTimezoneOffset() * 60000);	// para la fecha en el lugar actual	
							$http.get("../productos/api.php").then(function(response){
							$scope.productos = response.data;
							$scope.sumarTotalFinal();
							$('#editarVentasModal').modal('toggle');
							});

						});
					};
					/**
					 * Eliminar Venta
					 */
					$scope.eliminarVenta = function(venta) {
						if (confirm("Esta seguro de eliminar la venta")) {
							$http({
								url : 'api.php',
								method : "DELETE",
								data : {
									"id" : venta.id
								}
							}).then(function(response) {
								$scope.cargarVentas();
							}, function(error) { // optional
								alert("Ocurrio un error");
								console.log("ERROR:", error)
							});
						}
					};																			
					/**
					 * para los calendarios */
					$scope.popup1 = {

						opened : false

					};

					$scope.open1 = function() {

						$scope.popup1.opened = true;

					};				
				});
