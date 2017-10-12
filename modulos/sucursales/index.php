<!DOCTYPE html>
<html lang="es-ES">
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Módulo sucursales v1.0</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/angular.min.js"></script>
	<!-- <script src="app.js"></script> -->
  </head>
  <body>
  	<div class="container" data-ng-app="sucursalApp" data-ng-controller="sucursalCtrl">
  		<h1>Sucursales</h1>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarsucursalModal" data-ng-click="nuevosucursal()">Nueva Sucursal</button>
		<p/>
		<table class="table">
			<tr>
				<th>ID</th><th>RESPONSABLE</th><th>DIRECCION</th><th>FONO</th><th>OBSERVACIONES</th><th></th>
			</tr>
			<tr data-ng-repeat="sucursal in sucursales">
			    <td>{{ sucursal.id }}</td>
			    <td>{{ sucursal.responsable }}</td>
			    <td>{{ sucursal.direccion }}</td>
			    <td>{{ sucursal.fono }}</td>
			    <td>{{ sucursal.obs }}</td>
			    <td>
					<button type="button" class="btn btn-warning btn-xs" data-ng-click="editarsucursal(sucursal.id)">Editar</button>
					<button type="button" class="btn btn-danger btn-xs" data-ng-click="eliminarsucursal(sucursal)">Eliminar</button>
			    </td>
			</tr>
		</table>

		<!-- Modal Editar sucursal-->
		<div id="editarsucursalModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">{{ tituloModal }}</h4>
			  </div>
			  <div class="modal-body">
				 <form class="form-horizontal">
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="id">No.:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="Id" placeholder="Id" data-ng-model="sucursal.id">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="Responsable">Responsable:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="responsable" placeholder="responsable" data-ng-model="sucursal.responsable">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="direccion">Direccion:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="direccion" placeholder="Direccion Sucursal" data-ng-model="sucursal.direccion">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="fono">Telefono:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="fono" placeholder="Telefono" data-ng-model="sucursal.fono">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="fono">Obs.:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="obs" placeholder="Observaciones" data-ng-model="sucursal.obs">
					    </div>
					  </div>
					  <p> <p\>
					 </form>
			  </div>
			  <div class="modal-footer">
			  	<button type="submit" class="btn btn-success" data-ng-click="guardarsucursal()">Guardar</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
			  </div>
			</div>

		  </div>
		</div>

  	</div>
  	<script>

  	var app = angular.module('sucursalApp', []);
app.controller('sucursalCtrl', function($scope, $http) {

	$scope.cargarsucursales = function() {
		$http.get("api.php").then(function(response) {
			$scope.sucursales = response.data
			//alert($scope.sucursales);
		});
	};

	$scope.cargarsucursales();

	$scope.tipos = [ {
		"id" : 1,
		"nombre" : "Administrador"
	}, {
		"id" : 2,
		"nombre" : "Contador"
	}, {
		"id" : 3,
		"nombre" : "Usuario"
	} ];

	/**
	 * Crear un nuevo objeto usuario
	 */
	$scope.nuevosucursal = function() {
		$scope.tituloModal = "Nueva Sucursal";
		$scope.sucursal = {
			id : -1
		};
	};
	/**
	 * Se prepara el usuario para editar
	 */
	$scope.editarsucursal = function(idsucursal) {
		$scope.tituloModal = "Editar sucursal";
		$http({
			url : 'api.php?id=' + idsucursal,
			method : "GET",
		}).then(function(response) {
			$scope.sucursal = response.data;
			//console.log($scope.sucursal);
			$('#editarsucursalModal').modal('toggle');
		});
	};
	/**
	 * Guarda un objeto usuario
	 */
	$scope.guardarsucursal = function() {
		//console.log($scope.sucursal);
		$http({
			url : 'api.php',
			method : $scope.sucursal.id == -1 ? "POST" : "PUT",
			data : $scope.sucursal
		}).then(function(response) {
			 //alert(response.status);
			// console.log(response);
			if (response.status === 201 || response.status === 200) {
				$('#editarsucursalModal').modal('toggle');
				$scope.cargarsucursales();
			} else {
				alert("Ocurrio un error1");
				console.log(response.data);
			}
		}, function(error) { // optional
			//console.log(response);
			alert("Ocurrio un error2");
			console.log("ERROR:", error)
		});
	};

	/**
	 * Eliminar Usuario
	 */
	$scope.eliminarsucursal = function(sucursal) {
		//console.log(sucursal);
		//if (confirm("Esta seguro de eliminar al usuario: "+sucursales.responsable)) {
		if (confirm("Esta seguro de eliminar al usuario: "+sucursal.responsable)) {
			$http({
				url : 'api.php',
				method : "DELETE",
				data : {
					"id" : sucursal.id
				}
			}).then(function(response) {
				$scope.cargarsucursales();
			}, function(error) { // optional
				console.log("ERROR:", error)
			});
		}
	};
});

  	</script>
  </body>
</html>
