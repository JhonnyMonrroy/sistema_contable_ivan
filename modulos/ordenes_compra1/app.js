var app = angular.module('ordenesCompraApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'ordenesCompraCtrl',
				function($scope, $http) {

					$scope.cargarOrdendeCompra = function(response) {
						$http.get("api.php").then(function(response) {
							$scope.ordenes = response.data.ordenes;
						});
					}

					$scope.cargarOrdendeCompra();



					/**
					 * Muestra una orden de compra
					 * */
					$scope.mostrarOrdenCompra = function(orden){
						$http.get("api.php?orden="+orden.id).then(function(response) {
							$scope.orden = response.data.orden;
							$('#mostrarOrdenCompraModal').modal('toggle');
						});
					}

					/**
					 * Crear una nueva orden de compra
					 */
					$scope.nuevaOrdenCompra = function() {
						$scope.orden = {
							id : null
						};
						$scope.tituloModal = "Nueva Orden de Compra";
						// obtenemos a los proveedores
						$http
								.get("../proveedores/api.php")
								.then(
										function(response) {
											$scope.proveedores = response.data;
											$('#editarOrdenCompraModal').modal(
													'toggle');
										});
						$http
								.get("../productos/api.php")
								.then(
										function(response) {
											$scope.productos = response.data;
											$('#editarOrdenCompraModal').modal(
													'toggle');
										});

					};

					/**
					 * Se prepara la orden de compra para editar
					 */
					$scope.editarOrdenCompra = function(orden) {
						$scope.tituloModal = "Editar Orden de Compra";
						$http({
							url : 'api.php?id=' + orden.id,
							method : "GET",
						}).then(function(response) {
							$scope.orden = response.data.orden;
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
								$http({
									url : 'api.php',
									method : $scope.orden.id === null ? "POST" : "PUT",
									data : $scope.orden
								}).then(
								function(response) {
									// alert(response.status);
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
										$('#editarOrdenCompraModal').modal(
												'toggle');
										$scope.cargarOrdendeCompra();
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
					$scope.eliminarOrdenCompra = function(orden) {
						if (confirm("Esta seguro de eliminar la orden de compra: "+orden.id)) {
							$http({
								url : 'api.php',
								method : "DELETE",
								data : {
									"id" : orden.id
								}
							}).then(function(response) {
								$scope.cargarOrdendeCompra();
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
					$scope.popup3 = {
						opened : false
					};
					$scope.open3 = function() {
						$scope.popup3.opened = true;
					};
				});
