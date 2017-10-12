var app = angular.module('kardexApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'kardexCtrl',
				function($scope, $http) {

					$scope.cargarTransacciones = function(response) {
						$http.get("api.php").then(function(response) {

							$scope.sucursales = response.data.sucursales;
							$scope.productos = response.data.productos;
							$scope.movimientos = response.data.movimientos;
							$scope.sumarCanteCants();
						});
					}

					$scope.sumarCanteCants = function() {
						$scope.sumaCante = 0.0;
						$scope.sumaCants = 0.0;
						for (var i = 0; i < $scope.movimientos.length; i++) {
							$scope.sumaCante += parseFloat($scope.movimientos[i].cante);
							$scope.sumaCants += parseFloat($scope.movimientos[i].cants);
						}
					}

					$scope.cargarTransacciones();
					/**
					 * PROCEDIMIENTO que consulta con los filtros
					 * */
					$scope.consultaKardex = function() {
						$http(
								{
									url : 'api.php',
									method :  "POST",
									data : $scope.consulta
								}).then(
								function(response) {
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
												$scope.movimientos = response.data.movimientos;												$scope.sumarCanteCants();

									} else {
										//alert("Ocurrio un error 10000");
										console.log(response.data);
									}
								}, function(error) { // optional

									//alert("Ocurrio un error 20000" + error);
									console.log("ERROR:", error)
								});
					};

					/**
					 * ver reporte pdf del libro mayor
					 *
					 */
					$scope.imprimirComprobante=function(transaccion) {
						window.open('pdfcomprobante.php?id='+transaccion.id,'popup','width=300,height=400')
					};

					$scope.popup1 = {
						opened : false
					};
					$scope.open1 = function() {
						$scope.popup1.opened = true;
					};
					$scope.popup2 = {
						opened : false
					};
					$scope.open2 = function() {
						$scope.popup2.opened = true;
					};
				});
