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
						$scope.tituloModal = "Mostrar orden de compra";
						$http.get("api.php?id="+orden_compra.id).then(function(response) {
							$scope.orden_compra = response.data.orden_compra;							
							$scope.proveedores = response.data.proveedores;							
							//var dia=new Date($scope.orden_compra.fecha);
							//$scope.orden_compra.fecha = dia.getTime() + (dia.getTimezoneOffset() * 60000);	// para la fecha en el lugar actual	
							
							//alert("la fecha es ::  "+ $scope.orden_compra.fecha);
							$('#mostrarOrdenCompraModal').modal('toggle');							
						});
					}

					/**
					 * Crear una nueva orden de compra
					 */
					$scope.nuevaOrdenCompra = function() {
						$scope.orden_compra = {
							id : null,
							productos_compra : []
						};
						$scope.ocultarSubFormulario=true;
						$scope.tituloModal = "Nueva orden de compra";
						// obtenemos a los proveedores
						$http.get("../proveedores/api.php")
							.then(function(response) {
								$scope.proveedores = response.data;
								$http.get("../productos/api.php").then(function(response){
									$scope.productos = response.data;
									$scope.sumarTotalFinal();
									$('#editarOrdenCompraModal').modal('toggle');
								});
							});
					};
					/**
					 * funcion para obtener el total final a partir de los demas totales
					 */
					$scope.sumarTotalFinal = function() {
						$scope.totalFinal = 0.0;
						
						for (var i = 0; i < $scope.orden_compra.productos_compra.length; i++) {
							$scope.totalFinal += parseFloat($scope.orden_compra.productos_compra[i].cantidad*$scope.orden_compra.productos_compra[i].precio_unitario);							
						}
						//alert("termino de sumar");
					};

					/**
					 * adiciona un nuevo producto temporal a la transaccion
					 */
					$scope.adicionarProductoCompra = function(producto_compra) {
						$http.get("../productos/api.php?id="+producto_compra.fk_producto).then(function(producto){
							producto_compra.producto=producto.data;
							$scope.orden_compra.productos_compra.push(producto_compra);
							$scope.inicializarProductoCompra();							
							$scope.sumarTotalFinal();
							$scope.ocultarSubFormulario=true;
							
						});
					};
					/**
					 * ver reporte pdf de la orden de compra
					 * 
					 */
					$scope.imprimirOrdenCompra = function(orden_compra) {
						window.open('pdf.php?id='+orden_compra.id,'popup','width=300,height=400')
					};
					// TODO: Adicionar la funcion eliminar Producto Compra
					$scope.eliminarProductoCompra = function(movimiento) {
						if (confirm("Desea eliminar la El Producto : "
								+ movimiento.producto.producto + ' ' +
						        movimiento.producto.marca + ' ' + movimiento.producto.modelo + ' ' + movimiento.producto.descripcion
					)) {
							var vecOpe = [];
							for (var i = 0; i < $scope.orden_compra.productos_compra.length; i++) {
								if ($scope.orden_compra.productos_compra[i].id !== movimiento.id) {
									vecOpe
											.push($scope.orden_compra.productos_compra[i]);
								}
							}
							$scope.orden_compra.productos_compra = vecOpe;
							$scope.sumarTotalFinal();
						}
					};

					/**
					 * funcion que inicializa un producto_compra
					 * */
					$scope.inicializarProductoCompra = function(){
						$scope.producto_compra = {
								id : null
							};
					}

					/**
					 * Se prepara la orden de compra para editar
					 */
					$scope.editarOrdenCompra = function(orden_compra) {
						$scope.ocultarSubFormulario=true;						
						$scope.tituloModal = "Editar Orden de Compra";
						$http({
							url : 'api.php?id=' + orden_compra.id,
							method : "GET",
						}).then(function(response) {
							$scope.orden_compra = response.data.orden_compra;
							$scope.proveedores = response.data.proveedores;
							var dia=new Date($scope.orden_compra.fecha);
							$scope.orden_compra.fecha = dia.getTime() + (dia.getTimezoneOffset() * 60000);	// para la fecha en el lugar actual	
							$http.get("../productos/api.php").then(function(response){
							$scope.productos = response.data;
							$scope.sumarTotalFinal();
							$('#editarOrdenCompraModal').modal('toggle');
							});

						});
					};					
					/**
					 * Se prepera para mostrar la orden de compra para ingresar a almacenes
					 */
					$scope.ingresoOrdenCompra = function(orden_compra) {
						$scope.ocultarSubFormulario=true;						
						$scope.tituloModal = "Ingreso a Almacenes la Orden de Compra";
						$scope.ingreso = 'true';
						$http({
							url : 'api.php?id=' + orden_compra.id,
							method : "GET",
						}).then(function(response) {
							$scope.orden_compra = response.data.orden_compra;
							$scope.proveedores = response.data.proveedores;
							var dia=new Date($scope.orden_compra.fecha);
							$scope.orden_compra.fecha = dia.getTime() + (dia.getTimezoneOffset() * 60000);	
							// para la fecha en el lugar actual	
							$http.get("../productos/api.php").then(function(response){
							$scope.productos = response.data;
							$scope.sumarTotalFinal();
							$('#ingresarOrdenCompraModal').modal('toggle');
							});

						});
					};
					/**
					 * Guarda un objeto orden de compra
					 */
					$scope.guardarOrdenCompra = function() {						
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
										//alert("Ocurrio un error 10000");
										console.log(response.data);
									}
								}, function(error) { // optional									
									$scope.cargarOrdendesCompra();
									//alert("Ocurrio un error 20000" + error);
									console.log("ERROR:", error)
								});
					};
					/**
					 * Registrar el ingreso a almacenes 
					 */
					/**
					 * Guarda un objeto orden de compra
					 */
					$scope.guardarIngresoOrdenCompra = function() {
						if($scope.ingreso=='true'){							
							$scope.orden_compra.ingreso='true';							
						}
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
										$('#ingresarOrdenCompraModal').modal(
												'toggle');
										$scope.cargarOrdendesCompra();
									} else {
										//alert("Ocurrio un error 10000");
										console.log(response.data);
									}
								}, function(error) { // optional									
									$scope.cargarOrdendesCompra();
									//alert("Ocurrio un error 20000" + error);
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
