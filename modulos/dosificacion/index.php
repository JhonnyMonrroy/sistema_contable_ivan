<!DOCTYPE html>
<html lang="es-ES">
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Módulo dosificacions v1.0</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/angular.min.js"></script>
	<!-- <script src="app.js"></script> -->
  </head>
  <body>
  	<div class="container" data-ng-app="dosificacionApp" data-ng-controller="dosificacionCtrl">
  		<h1>Dosificacions</h1>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editardosificacionModal" data-ng-click="nuevodosificacion()">Nuevo dosificacion</button>
		<p/>
		<table class="table">
			<tr>
				<th>ID</th><th>TRAMITE</th><th>AUTORIZACION</th><th>FECHA</th><th>LLAVE</th><th>FECHA FIN</th><th>OFICINA</th><th></th>
			</tr>
			<tr data-ng-repeat="dosificacion in dosificacions">
			    <td>{{ dosificacion.id }}</td>
			    <td>{{ dosificacion.ntramite }}</td>
			    <td>{{ dosificacion.nautorizacion }}</td>
			    <td>{{ dosificacion.fecha_inicio }}</td>
			    <td>{{ dosificacion.llave }}</td>
			    <td>{{ dosificacion.fecha_fin }}</td>
			    <td>{{ dosificacion.fk_sucursal }}</td>
			    <td>
					<button type="button" class="btn btn-warning btn-xs" data-ng-click="editardosificacion(dosificacion.id)">Editar</button>
					<button type="button" class="btn btn-danger btn-xs" data-ng-click="eliminardosificacion(dosificacion)">Eliminar</button>
			    </td>
			</tr>
		</table>

		<!-- Modal Editar dosificacion-->
		<div id="editardosificacionModal" class="modal fade" role="dialog">
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
					    <label class="control-label col-sm-2" for="ntramite">No. Tramite:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="ntramite" placeholder="tramite" data-ng-model="dosificacion.ntramite">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="nautorizacion">No. Autorizacion:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="nautorizacion" placeholder="Autorizacion" data-ng-model="dosificacion.nautorizacion">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="fecha_inicio">Fecha:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="fecha_inicio" placeholder="Fecha de Dosificacion" data-ng-model="dosificacion.fecha_inicio">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="llave">Llave:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="llave" placeholder="Llave" data-ng-model="dosificacion.Llave">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="fecha_fin">Fecha Final:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="fecha_fin" placeholder="Fecha Final" data-ng-model="dosificacion.fecha_fin">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="fk_sucursal">Sucursal:</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" id="fk_sucursal" placeholder="Sucursal" data-ng-model="dosificacion.fk_sucursal">
					    </div>
					  </div>
					 </form>
			  </div>
			  <div class="modal-footer">
			  	<button type="submit" class="btn btn-success" data-ng-click="guardardosificacion()">Guardar</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
			  </div>
			</div>

		  </div>
		</div>

  	</div>
  	<script>

  	var app = angular.module('dosificacionApp', []);
app.controller('dosificacionCtrl', function($scope, $http) {

	$scope.cargardosificacions = function() {
		$http.get("api.php").then(function(response) {
			$scope.dosificacions = response.data
			//alert($scope.dosificacions);
		});
	};

	$scope.cargardosificacions();

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
	$scope.nuevodosificacion = function() {
		$scope.tituloModal = "Nuevo dosificacion";
		$scope.dosificacion = {
			id : -1
		};
	};
	/**
	 * Se prepara el usuario para editar
	 */
	$scope.editardosificacion = function(iddosificacion) {
		$scope.tituloModal = "Editar dosificacion";
		$http({
			url : 'api.php?id=' + iddosificacion,
			method : "GET",
		}).then(function(response) {
			$scope.dosificacion = response.data;
			//console.log($scope.dosificacion);
			$('#editardosificacionModal').modal('toggle');
		});
	};
	/**
	 * Guarda un objeto usuario
	 */
	$scope.guardardosificacion = function() {
		//console.log($scope.dosificacion);
		$http({
			url : 'api.php',
			method : $scope.dosificacion.id == -1 ? "POST" : "PUT",
			data : $scope.dosificacion
		}).then(function(response) {
			 //alert(response.status);
			// console.log(response);
			if (response.status === 201 || response.status === 200) {
				$('#editardosificacionModal').modal('toggle');
				$scope.cargardosificacions();
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
	$scope.eliminardosificacion = function(dosificacion) {
		//console.log(dosificacion);
		//if (confirm("Esta seguro de eliminar al usuario: "+dosificacions.razon_social)) {
		if (confirm("Esta seguro de eliminar al usuario: "+dosificacion.razon_social)) {
			$http({
				url : 'api.php',
				method : "DELETE",
				data : {
					"id" : dosificacion.id
				}
			}).then(function(response) {
				$scope.cargardosificacions();
			}, function(error) { // optional
				console.log("ERROR:", error)
			});
		}
	};
});

  	</script>
  </body>
</html>
