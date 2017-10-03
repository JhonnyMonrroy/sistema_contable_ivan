<!DOCTYPE html>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Módulo Usuarios v1.0</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/angular.min.js"></script>
<script src="app.js"></script>
</head>
<body>
	<div class="container" data-ng-app="usuariosApp"
		data-ng-controller="usuariosCtrl">
		<h1>Usuarios</h1>
		<button type="button" class="btn btn-primary"
			data-ng-click="nuevoUsuario()">Nuevo Usuario</button>
		<p />
		<table class="table">
			<tr>
				<th>ID</th>
				<th>NOMBRE</th>
				<th>CI</th>
				<th>CEL</th>
				<th>USUARIO</th>
				<th>PASS</th>
				<th>TIPO</th>
				<th>SUCURSAL</th>
				<th></th>
			</tr>
			<tr data-ng-repeat="usuario in usuarios">
				<td>{{ usuario.id }}</td>
				<td>{{ usuario.nombre }}</td>
				<td>{{ usuario.ci }}</td>
				<td>{{ usuario.celular }}</td>
				<td>{{ usuario.username }}</td>
				<td>****</td>
				<td>{{obtenerTipoUsuario(usuario.fk_tipo)}}</td>
<!-- 				<td>{{ usuario.fk_sucursal }}</td> -->
				<td>{{ usuario.sucursal.obs }}</td>
				<td>
					<button type="button" class="btn btn-warning btn-xs"
						data-ng-click="editarUsuario(usuario.id)">Editar</button>
					<button type="button" class="btn btn-danger btn-xs"
						data-ng-click="eliminarUsuario(usuario)">Eliminar</button>
				</td>
			</tr>
		</table>

		<!-- Modal Editar Usuario-->
		<div id="editarUsuarioModal" class="modal fade" role="dialog">
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
								<label class="control-label col-sm-2" for="nombre">Nombre:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="nombre"
										placeholder="Nombre del usuario"
										data-ng-model="usuario.nombre">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="ci">CI:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="ci"
										placeholder="Cedula de identidad" data-ng-model="usuario.ci">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cel">Cel:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="cel"
										placeholder="Celular" data-ng-model="usuario.celular">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="usuario">Username:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="usuario"
										placeholder="username" data-ng-model="usuario.username">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="pwd">Password:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="pwd"
										placeholder="Contraseña" data-ng-model="usuario.password">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="tipo">Tipo:</label>
								<div class="input-group col-sm-8">
									<select id="tipo" data-ng-model="usuario.fk_tipo"
										class="form-control">
										<option></option>
										<option data-ng-repeat="tipo in tipos" value="{{tipo.id}}">{{tipo.nombre}}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="fk_sucursal" class="control-label col-sm-2">SUCURSAL:</label>
								<div class="input-group col-sm-8">
									<select class="form-control" id="fk_sucursal"
										data-ng-model="usuario.fk_sucursal">
										<option></option>
										<option data-ng-repeat="sucursal in sucursales"
											value="{{sucursal.id}}">{{sucursal.obs}} -
											{{sucursal.direccion}}</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success"
							data-ng-click="guardarUsuario()">Guardar</button>
						<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
					</div>
				</div>

			</div>
		</div>

	</div>
</body>
</html>