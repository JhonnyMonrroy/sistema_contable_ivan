<?php
require_once("../../conexion.php");
const T_usuarios ="usuarios";
const T_sucursales ="sucursales";
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){
			$usuario=R::load(T_usuarios,$_GET["id"]);
			//$sucursales = R::findAll(T_sucursales);
			$resultado["usuario"]=$usuario;
			//$resultado["sucursales"]=$sucursales;
			print json_encode($resultado);
		}else{
			$lista_usuarios=R::findAll(T_usuarios);
			// cargamos sus sucursales respectivas
			foreach ($lista_usuarios as $usuario){
				$usuario->sucursal=R::load(T_sucursales,$usuario->fk_sucursal);
			}
			print json_encode($lista_usuarios);
		}
		break;
	case 'POST':
		// guardar
		try {
			$data = json_decode(file_get_contents('php://input'), true);
			$usuario=R::dispense(T_usuarios);
			//$usuario=new Usuario();
			$usuario->nombre=$data["nombre"];
			$usuario->ci=$data["ci"];
			$usuario->celular=$data["celular"];
			$usuario->username=$data["username"];
			$usuario->password=$data["password"];
			$usuario->fk_tipo=$data["fk_tipo"];
			$usuario->fk_sucursal=$data["fk_sucursal"];
			if($id_usuario=R::store($usuario)){
				http_response_code(201);
				$usuario=R::load(T_usuarios,$id_usuario);
				print json_encode($usuario);
			}else{
				http_response_code(405);
				$respuesta=array();
				$respuesta["codigo"]=405;
				$respuesta["mensaje"]="No se pudo guardar el usuario";
				print json_encode($respuesta);
			}
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta=array();
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar el usuario";
			$respuesta["error"]=$e;
			print json_encode($respuesta);
		}

		break;
	case 'PUT':
		// actualizar
		$data = json_decode(file_get_contents('php://input'), true);
	//	$usuario=Usuario::getUsuarioDeId($data["id"]);
		$usuario=R::Load(T_usuarios, $data["id"]);
		$usuario->nombre=$data["nombre"];
		$usuario->ci=$data["ci"];
		$usuario->celular=$data["celular"];
		$usuario->username=$data["username"];
		$usuario->password=$data["password"];
		$usuario->fk_tipo=$data["fk_tipo"];
		$usuario->fk_sucursal=$data["fk_sucursal"];
		$id=R::store($usuario);
		if ($id!=null){
			http_response_code(200);
			print json_encode($usuario);
		}else{
			http_response_code(405);
			$respuesta=array();
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar el usuario";
			print json_encode($respuesta);
		}
		break;
	case 'DELETE':
		$data = json_decode(file_get_contents('php://input'), true);
		$usuario=R::load(T_usuarios,$data["id"]);
		R::trash($usuario);
		http_response_code(204);
		break;
	default:
		handle_error($request);
		break;
}

?>
