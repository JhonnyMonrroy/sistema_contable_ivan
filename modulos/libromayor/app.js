var app = angular.module('transaccionesApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'transaccionesCtrl',
				function($scope, $http) {

					$scope.cargarTransacciones = function(response) {
						$http.get("api.php").then(function(response) {
							$scope.transacciones = response.data.transacciones;
							$scope.cuentas = response.data.cuentas;
							$scope.operaciones = response.data.operaciones;
							$scope.sumarDebeHaber();
						});
					}

					/*$scope.sumarDebeHaber = function() {
						$scope.sumaDebe = 0.0;
						$scope.sumaHaber = 0.0;
						for (var i = 0; i < $scope.transaccion.operaciones.length; i++) {
							$scope.sumaDebe += parseFloat($scope.transaccion.operaciones[i].debe);
							$scope.sumaHaber += parseFloat($scope.transaccion.operaciones[i].haber);
					}*/

					$scope.cargarTransacciones();

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
				});
