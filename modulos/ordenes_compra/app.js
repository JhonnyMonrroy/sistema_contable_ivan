var app = angular.module('ordenesCompraApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'ordenesCompraCtrl',
				function($scope, $http) {

					$scope.cargarOrdendesCompra = function(response) {
						$http.get("api.php").then(function(response) {
							$scope.ordenes_compra = response.data.ordenes_compra;
						});
					}

					$scope.cargarOrdendesCompra();



					/**
					 * Muestra una orden de compra
					 * */
					$scope.mostrarOrdenCompra = function(orden_compra){
						$http.get("api.php?id="+orden_compra.id).then(function(response) {
							$scope.orden_compra = response.data.orden_compra;
							$('#mostrarOrdenCompraModal').modal('toggle');
						});
					}

					/**
					 * Crear una nueva orden de compra
					 */
					$scope.nuevaOrdenCompra = function() {
						$scope.orden_compra = {
							id : null
						};
						$scope.tituloModal = "Nueva orden de compra";
						// obtenemos a los proveedores
						$http
								.get("../proveedores/api.php")
								.then(
										function(response) {
											$scope.proveedores = response.data;
											$('#editarOrdenCompraModal').modal(
													'toggle');
										});

					};

					/**
					 * Se prepara la orden de compra para editar
					 */
					$scope.editarOrdenCompra = function(orden_compra) {
						$scope.tituloModal = "Editar Orden de Compra";
						$http({
							url : 'api.php?id=' + orden_compra.id,
							method : "GET",
						}).then(function(response) {
							$scope.orden_compra = response.data.orden_compra;
							$http
							.get("../proveedores/api.php")
							.then(
									function(response) {
										$scope.proveedores = response.data.proveedores;
										$('#editarOrdenCompraModal').modal(
												'toggle');
									});
						});
					};

					/**
					 * Guarda un objeto orden de compra
					 */
					$scope.guardarOrdenCompra = function() {
						//$scope.orden_compra.fk_proveedor=;
						$http(
								{
									url : 'api.php',
									method : $scope.orden_compra.id === null ? "POST"
											: "PUT",
									data : $scope.orden_compra
								}).then(
								function(response) {
									// alert(response.status);
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
										$('#editarOrdenCompraModal').modal(
												'toggle');
										$scope.cargarOrdendesCompra();
									} else {
										alert("Ocurrio un error");
										console.log(response.data);
									}
								}, function(error) { // optional
									alert("Ocurrio un error");
									console.log("ERROR:", error)
								});
					};

					/**
					 * Eliminar Orden de Compra
					 */
					$scope.eliminarOrdenCompra = function(orden_compra) {
						if (confirm("Esta seguro de eliminar la orden de compra")) {
							$http({
								url : 'api.php',
								method : "DELETE",
								data : {
									"id" : orden_compra.id
								}
							}).then(function(response) {
								$scope.cargarOrdendesCompra();
							}, function(error) { // optional
								alert("Ocurrio un error");
								console.log("ERROR:", error)
							});
						}
					};

					$scope.popup1 = {
						opened : false
					};
					$scope.open1 = function() {
						$scope.popup1.opened = true;
					};
					// para los calendarios
					$scope.popup2 = {
						opened : false
					};
					$scope.open2 = function() {
						$scope.popup2.opened = true;
					};
				});
