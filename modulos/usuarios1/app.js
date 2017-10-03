var app = angular.module('usuariosApp', []);
app.controller('usuariosCtrl', function($scope, $http) {

	$scope.cargarUsuarios = function() {
		$http.get("api.php").then(function(response) {
			$scope.usuarios = response.data;
		});
	};

	$scope.cargarUsuarios();

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
	$scope.nuevoUsuario = function() {
		$scope.cargarSucursales();
		$scope.tituloModal = "Nuevo usuario";
		$scope.usuario = {
			id : -1
		};
		$('#editarUsuarioModal').modal('toggle');
	};

	/**
	 * Función que obtendra la información de las sucursales
	 * @author jmonrroy 2017-10-02
	 * */
	$scope.cargarSucursales = function(){
		$http.get("../sucursales/api.php").then(function(response) {
			$scope.sucursales = response.data;
		});
	}
	/**
	 * Se prepara el usuario para editar
	 */
	$scope.editarUsuario = function(idUsuario) {
		$scope.cargarSucursales();
		$scope.tituloModal = "Editar usuario";
		$http({
			url : 'api.php?id=' + idUsuario,
			method : "GET",
		}).then(function(response) {
			$scope.usuario = response.data.usuario;
			$('#editarUsuarioModal').modal('toggle');
		});
	};
	/**
	 * Guarda un objeto usuario
	 */
	$scope.guardarUsuario = function() {
		$http({
			url : 'api.php',
			method : $scope.usuario.id == -1 ? "POST" : "PUT",
			data : $scope.usuario
		}).then(function(response) {
			// alert(response.status);
			// console.log(response);
			if (response.status === 201 || response.status === 200) {
				$('#editarUsuarioModal').modal('toggle');
				$scope.cargarUsuarios();
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
	 * Eliminar Usuario
	 */
	$scope.eliminarUsuario = function(usuario) {
		//console.log(usuario);
		if (confirm("Esta seguro de eliminar al usuario: "+usuario.nombre)) {
			$http({
				url : 'api.php',
				method : "DELETE",
				data : {
					"id" : usuario.id
				}
			}).then(function(response) {
				$scope.cargarUsuarios();
			}, function(error) { // optional
				alert("Ocurrio un error");
				console.log("ERROR:", error)
			});
		}
	};

	/**
	 * funcion temporal para obtener el tipo de usuario segun su fk_tipo
	 * */
	$scope.obtenerTipoUsuario = function(id_tipo){
		for (var tipo of $scope.tipos) {
			//console.log(id_tipo);
			if(tipo.id==id_tipo){
				return tipo.nombre;
			}
		}
	};
});
