var app = angular.module('TraspasosApp', [ 'ui.bootstrap' ]);
app
		.controller(
				'traspasosController',
				function($scope, $http) {

					$scope.cargarTraspasos = function(response) {
						$http.get("api.php").then(function(response) {
							$scope.traspasos = response.data.traspasos;
						});
					}

					$scope.cargarTraspasos();

					/**
					 * Muestra una orden de traspaso
					 * */
					$scope.mostrarTraspaso = function(traspaso){
						$scope.tituloModal = "Mostrar Traspaso";
						$http.get("api.php?id="+traspaso.id).then(function(response) {
							$scope.traspaso = response.data.traspaso;							
							$scope.proveedores = response.data.proveedores;							
							//var dia=new Date($scope.orden_traspaso.fecha);
							//$scope.orden_traspaso.fecha = dia.getTime() + (dia.getTimezoneOffset() * 60000);	// para la fecha en el lugar actual	
							
							//alert("la fecha es ::  "+ $scope.orden_traspaso.fecha);
							$('#mostrarTraspasoModal').modal('toggle');							
						});
					}

					/**
					 * Crear una nueva orden de traspaso
					 */
					$scope.nuevoTraspaso = function() {
						$scope.traspaso = {
							id : null,
							productos_traspaso : []
						};
						$scope.ocultarSubFormulario=true;
						$scope.tituloModal = "Nuevo Traspaso";
						// obtenemos a los proveedores
						$http.get("../sucursales/api.php")
							.then(function(response) {
								$scope.sucursales = response.data;
								$http.get("../productos/api.php").then(function(response){
									$scope.productos = response.data;
									$scope.sumarTotalFinal();
									$('#editarTraspasosModal').modal('toggle');
								});
							});
					};
					/**
					 * funcion para obtener el total final a partir de los demas totales
					 */
					$scope.sumarTotalFinal = function() {
						$scope.totalFinal = 0.0;
						
						for (var i = 0; i < $scope.traspaso.productos_traspaso.length; i++) {
							$scope.totalFinal += parseFloat($scope.traspaso.productos_traspaso[i].cantidad*$scope.traspaso.productos_traspaso[i].precio_unitario);							
						}
						//alert("termino de sumar");
					};

					/**
					 * adiciona un nuevo producto temporal a la transaccion producto_traspaso
					 */
					$scope.adicionarProductoTraspaso = function(producto_traspaso) {
						
						$http.get("../productos/api.php?id="+producto_traspaso.fk_producto).then(function(producto){
							producto_traspaso.producto=producto.data;
							$scope.traspaso.productos_traspaso.push(producto_traspaso);
							$scope.inicializarProductoTraspaso();							
							$scope.sumarTotalFinal();
							$scope.ocultarSubFormulario=true;
							
						});
						
					};

					// TODO: Adicionar la funcion eliminar Producto traspaso
					$scope.eliminarProductotraspaso = function(movimiento) {
						if (confirm("Desea eliminar la El Producto : "
								+ movimiento.producto.producto + ' ' +
						        movimiento.producto.marca + ' ' + movimiento.producto.modelo + ' ' + movimiento.producto.descripcion
					)) {
							
						var vecOpe = [];
							for (var i = 0; i < $scope.traspaso.productos_traspaso.length; i++) {
								if ($scope.traspaso.productos_traspaso[i].id !== movimiento.id) {
									vecOpe.push($scope.traspaso.productos_traspaso[i]);
								}
							}
							$scope.traspaso.productos_traspaso = vecOpe;
							$scope.sumarTotalFinal();							
						}
					};

					/**
					 * funcion que inicializa un producto_traspaso
					 * */
					$scope.inicializarProductoTraspaso = function(){
						$scope.producto_traspaso = {
								id : null
							};
					}

					/**
					 * Se prepara el traspaso para editar
					 */
					$scope.editarTraspaso = function(traspaso) {
						$scope.ocultarSubFormulario=true;						
						$scope.tituloModal = "Editar Traspaso";
						$http({
							url : 'api.php?id=' + traspaso.id,
							method : "GET",
						}).then(function(response) {
							$scope.traspaso = response.data.traspaso;
							$scope.sucursales = response.data.sucursales;
							var dia=new Date($scope.traspaso.fecha);
							$scope.traspaso.fecha = dia.getTime() + (dia.getTimezoneOffset() * 60000);	// para la fecha en el lugar actual	
							$http.get("../productos/api.php").then(function(response){
							$scope.productos = response.data;
							$scope.sumarTotalFinal();
							$('#editarTraspasosModal').modal('toggle');
							});

						});
					};					
					/**
					 * Guarda un objeto  de traspaso
					 */
					$scope.guardarTraspaso = function() {						
						$http(
								{
									url : 'api.php',
									method : $scope.traspaso.id === null ? "POST"
											: "PUT",
									data : $scope.traspaso
								}).then(
								function(response) {
									// alert(response.status);
									console.log(response);
									if (response.status === 201
											|| response.status === 200) {
										$('#editarTraspasosModal').modal(
												'toggle');
										$scope.cargarTraspasos();
									} else {
										//alert("Ocurrio un error 10000");
										console.log(response.data);
									}
								}, function(error) { // optional									
									$scope.cargarTraspasos();
									//alert("Ocurrio un error 20000" + error);
									console.log("ERROR:", error)
								});
					};
					/**
					 * Registrar el ingreso a almacenes 
					 */
					/**
					 * Eliminar Orden de traspaso
					 */
					$scope.eliminarTraspaso = function(traspaso) {
						if (confirm("Esta seguro de eliminar el traspaso")) {
							$http({
								url : 'api.php',
								method : "DELETE",
								data : {
									"id" : traspaso.id
								}
							}).then(function(response) {
								$scope.cargarTraspasos();
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
