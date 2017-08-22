var app = angular.module('facturasApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'facturasCtrl',
				function($scope, $http) {
					$scope.cargarFacturas = function(response) {
						console.log(response);
						$http.get("api.php").then(function(response) {
							console.log(response);
							$scope.facturas = response.data.facturas;
						});
					}

					$scope.cargarFacturas();

					$scope.cargarDatos = function() {
						console.log("hola");
						$http.get("api.php")
								.then(
										function(response) {
											$scope.productos = response.data.productos;
											$scope.detalle_factura = response.data.detalle_factura;
											$scope.dosificacion = response.data.dosificacion;
										});
					};

					/**
					 * Muestra una transacción
					 * */
					$scope.mostrarFactura = function(factura){
						$http.get("api.php?factura="+factura.id).then(function(response) {
							$scope.factura = response.data.factura;
							$scope.tituloModal = "factura "+factura.nfactura;
							$scope.sumarDebeHaber();
							$('#mostrarFacturaModal').modal('toggle');
						});

					}

					//$scope.cargarDatos();

					/**
					 * fucncion para actualizar
					 */
					$scope.actualizarNronFactura = function() {
						$http.get("api.php?sig_nro_factura="
												+ $scope.factura.nfactura)
								.then(
										function(response) {
											$scope.factura.nfactura = response.data.sig_nro_factura;
										});
					};

					// $scope.comprobante={fecha: new Date()};

					/**
					 * Crear un nuevo objeto transaccion
					 */
					$scope.nuevaFactura = function() {
						$scope.factura = {
							id : null,
							nfactura : null,
							id_dosificacion : null,
							detalles : []
						};
						$scope.detalle_factura = {
							id :null,
							precio_unit : 0.0,
							cantidad : 0.0,
							producto : null
						};
						$scope.tituloModal = "Nueva factura";
						$http
								.get("api.php")
								.then(
										function(response) {
											$scope.productos = response.data.productos;
											$scope.dosificacion = response.data.dosificacion;
											$scope.factura.nfactura = response.data.sig_nro_factura;
											$scope.sumarDebeHaber();
											$('#editarFacturaModal').modal(
													'toggle');
										});

					};

					$scope.sumarDebeHaber = function() {
						$scope.sumaProd = 0.0;
						$scope.subtotal =[];
						for (var i = 0; i < $scope.factura.detalles.length; i++) {
							$scope.subtotal[i]=parseFloat($scope.factura.detalles[i].precio_unit)*parseFloat($scope.factura.detalles[i].cantidad);
							$scope.sumaProd += $scope.subtotal[i];
						}
					};

					/**
					 * adiciona una operacion temporal a la transaccion
					 */
					$scope.adicionarDetalle_factura = function(detalle_factura) {
						detalle_factura.producto=JSON.parse(detalle_factura.producto);
						$scope.factura.detalles.push(detalle_factura);
						//console.log(operacion);
						$scope.detalle_factura = {
							id : null,
							precio_unit : 0.0,
							cantidad : 0.0,
							descripcion : "",
							producto: null
						};
						$scope.sumarDebeHaber();
					};

					/**
					 * eliminar una operacion temporal a la transaccion
					 */
					$scope.eliminarDetalle_factura = function(detalle_factura) {
						if (confirm("Desea eliminar detalle_factura: "
								+ detalle_factura.id +" - " +detalle_factura.producto.producto)) {
							var vecOpe = [];
							for (var i = 0; i < $scope.factura.detalles.length; i++) {
								if ($scope.factura.detalles[i].id !== detalle_factura.id) {
									vecOpe
											.push($scope.factura.detalles[i]);
								}
							}
							$scope.factura.detalles = vecOpe;
							$scope.sumarDebeHaber();
						}
					};

					/**
					 * Se prepara la transaccion usuario para editar
					 */
					$scope.editarFactura = function(factura) {
						$scope.tituloModal = "Editar factura";
						$scope.detalle_factura = {
							id : null,
							precio_unit : 0.0,
							cantidad : 0.0,
							descripcion : "",
							producto: null
						};
						$http({
							url : 'api.php?factura=' + factura.id,
							method : "GET",
						}).then(function(response) {
							$scope.factura = response.data.factura;
							$http
							.get("api.php")
							.then(
									function(response) {
										$scope.productos = response.data.productos;
										$scope.dosificacion = response.data.dosificacion;
										$scope.factura.nfactura = response.data.sig_nro_factura;
										$scope.sumarDebeHaber();
										$('#editarFacturaModal').modal(
												'toggle');
									});
							//$('#editarTransaccionModal').modal('toggle');
						});
					};
					/**
					 * Guarda un objeto transaccion
					 */
					$scope.guardarFactura = function() {
						//alert($scope.transaccion.fecha);
						$scope.factura.id_dosificacion=JSON.parse($scope.factura.id_dosificacion);
						console.log($scope.factura);
						$http(
								{
									url : 'api.php',
									method : $scope.factura.id === null ? "POST"
											: "PUT",
									data : $scope.factura
								}).then(
								function(response) {
									//// alert(response.status);
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
										$('#editarFacturaModal').modal(
												'toggle');
										$scope.cargarFacturas();
									} else {
										alert("Ocurrio un error");
										console.log(response.data);
									}
								}, function(error) { // optional
									alert("Ocurrio un error");
									console.log("ERROR:", error);
								});
					};

					$scope.popup1 = {
						opened : false
					};
					$scope.open1 = function() {
						$scope.popup1.opened = true;
					};
				});
