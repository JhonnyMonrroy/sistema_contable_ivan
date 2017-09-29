var app = angular.module('VentasApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'ventasController',
				function($scope, $http) {

					$scope.cargarVentas = function(response) {
						$http.get("api.php").then(function(response) {
							$scope.ventas = response.data.ventas;
						});
					}

					$scope.cargarVentas();
					/**
					 * Crear una nueva Venta
					 */
					$scope.nuevaVenta = function() {
						$scope.venta = {
							id : null,
							productos_venta : []
						};
						
						$scope.ocultarSubFormulario=true;
						$scope.tituloModal = "Nueva Venta";
						// obtenemos a los clientes
						$http.get("../clientes/api.php")
							.then(function(response) {
								$scope.clientes = response.data;
								$http.get("../productos/api.php").then(function(response){
									$scope.productos = response.data;
									//$scope.sumarTotalFinal();
									$('#editarVentasModal').modal('toggle');
								});
							});
					};
					/**
					 * Guarda un objeto orden de compra
					 */
					$scope.guardarVenta = function() {
						//alert($scope.venta.id);
						//$scope.orden_compra.fk_proveedor=;
						$http(
								{
									url : 'api.php',
									method : $scope.venta.id === null ? "POST": "PUT",
									data : $scope.venta
								}).then(
								function(response) {
									// alert(response.status);
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
										$('#editarVentasModal').modal('toggle');
									    $scope.cargarVentas();
									} else {
										//alert("Ocurrio un error 10000");
										console.log(response.data);
									}
								}, function(error) { // optional									
									$scope.cargarVentas();
									//alert("Ocurrio un error 20000" + error);
									console.log("ERROR:", error)
								});
					};

					/*Procesar PEPS*/

					$scope.procesar = function() {
						$http(
								{
									url : 'peps.php',
								}).then(
								function(response) {
									// alert(response.status);
									console.log(response);
								}, function(error) { // optional									
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
						$scope.venta.total  = 0.0;
						$scope.venta.saldo = 0.0;
						
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
					$scope.adicionarProductoVenta = function(producto_venta) {
						$http.get("../productos/api.php?id="+producto_venta.fk_producto).then(function(producto){
							producto_venta.producto=producto.data;
							$scope.venta.productos_venta.push(producto_venta);
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
