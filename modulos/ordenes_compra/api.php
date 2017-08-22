<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_proveedores="proveedores";
const T_ordenes_compra="ordenes_compra";

// aca se define este api
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){	// para obtener una orden de compra
			$orden=R::findOne( T_ordenes_compra, ' id = ? ', [ $_GET["id"] ] );
		}else{
			$ordenes_compra = R::findAll(T_ordenes_compra);
			$result["ordenes_compra"]=$ordenes_compra;
		}
		print json_encode($result);
		break;
	case 'POST':
		// guardar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$orden_compra=R::dispense(T_ordenes_compra);
			$orden_compra->fecha=$data["fecha"];
			$orden_compra->fk_proveedor=$data["proveedor"]["id"];
			$orden_compra->contenedor=$data["contenedor"];
			$orden_compra->origen=$data["origen"];
			$orden_compra->fecha_llegada=$data["fecha_llegada"];
			$orden_compra->forma_pago=$data["forma_pago"];
			$orden_compra->observaciones=$data["observaciones"];
			$orden_compra->importe=$data["importe"];
			$orden_compra->recibido=$data["recibido"];
			$orden_compra->fecha_recibido=$data["fecha_recibido"];
			$orden_compra->diferencia=$data["diferencia"];
			$id_orden_compra=R::store($orden_compra);
			http_response_code(201);
			$orden_compra=R::load(T_ordenes_compra,$id_orden_compra);
			// aca tiene que crear un regiostro en kardex
			$respuesta["orden_compra"]=$orden_compra;
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar la orden de compra";
			$respuesta["error"]=$e;
		}finally{
			print json_encode($respuesta);
		}
		break;
	case 'PUT':
		// actualizar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$orden_compra=R::load(T_ordenes_compra,[$data["id"]]);
			$orden_compra->fecha=$data["fecha"];
			$orden_compra->fk_proveedor=$data["proveedor"]["id"];
			$orden_compra->contenedor=$data["contenedor"];
			$orden_compra->origen=$data["origen"];
			$orden_compra->fecha_llegada=$data["fecha_llegada"];
			$orden_compra->forma_pago=$data["forma_pago"];
			$orden_compra->observaciones=$data["observaciones"];
			$orden_compra->importe=$data["importe"];
			$orden_compra->recibido=$data["recibido"];
			$orden_compra->fecha_recibido=$data["fecha_recibido"];
			$orden_compra->diferencia=$data["diferencia"];
			$id_orden_compra=R::store($orden_compra);
			http_response_code(200);
			$orden_compra=R::load(T_ordenes_compra,$id_orden_compra);
			$respuesta["orden_compra"]=$orden_compra;
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar la orden de compra";
			$respuesta["error"]=$e;
		}finally{
			print json_encode($respuesta);
		}
		break;
	case 'HEAD':
		do_something_with_head($request);
		break;
	case 'DELETE':
		$data = json_decode(file_get_contents('php://input'), true);
		$orden_compra=R::load(T_ordenes_compra,$data["id"]);
		R::trash($orden_compra);
		http_response_code(200);
		break;
	case 'OPTIONS':
		do_something_with_options($request);
		break;
	default:
		handle_error($request);
		break;
}

?>
