var app = angular.module('filtroproductosApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'filtroproductosCtrl',
				function($scope, $http) {

					$scope.cargarFiltroProducto = function(response) {
						$http.get("filtroproductos.php").then(function(response) {
							$scope.movimientos = response.data.registros;
							$scope.productos = response.data.prod;
							$scope.sumarmovimientos();
	 					});
					}

					// $scope.sumarmovimientos = function() {
					// 	$scope.cante = 0.0;
					// 	$scope.cants = 0.0;
					// 	$scope.cose = 0.0;
					// 	$scope.coss = 0.0;
					// 	for (var i = 0; i < $scope.movimientos.length; i++) {
					// 		$scope.cante += parseFloat($scope.movimientos[i].cante);
					// 		$scope.cants += parseFloat($scope.movimientos[i].cants);
					// 		$scope.cose += parseFloat($scope.movimientos[i].cose);
					// 		$scope.coss += parseFloat($scope.movimientos[i].coss);
					// }

					$scope.cargarFiltroProducto();

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
