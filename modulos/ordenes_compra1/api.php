<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_proveedores="proveedores";
const T_ordenes_compra="ordencompra";

// aca se define este api
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["orden"])){	// para obtener una orden de compra
			$orden=R::findOne( T_ordenes_compra, ' id = ? ', [ $_GET["orden"] ] );
		}else{
			$result["ordenes"]=R::findAll(T_ordenes_compra);
		}
		print json_encode($result);
		break;
	case 'POST':
		// guardar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$ordencompra=R::dispense(T_ordenes_compra);
			$ordencompra->fechaemision=$data["fechaemision"];
			$ordencompra->fk_proveedor=$data["proveedor"]["id"];
			$ordencompra->direccion=$data["direccion"];
			$ordencompra->telefono=$data["telefono"];
			$ordencompra->nit=$data["nit"];
			$ordencompra->embarque=$data["embarque"];
			$ordencompra->origen=$data["origen"];
			$ordencompra->destino=$data["destino"];
			$ordencompra->fechallegada=$data["fechallegada"];
			$ordencompra->solicitado=$data["solicitado"];
			$ordencompra->formapago=$data["formapago"];
			$ordencompra->observaciones=$data["observaciones"];
			$id_orden_compra=R::store($ordencompra);
			http_response_code(200);
			$ordencompra=R::load(T_ordenes_compra,$id_orden_compra);
			// aca tiene que crear un regiostro en kardex
			$respuesta["ordencompra"]=$ordencompra;
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
			$ordencompra=R::load(T_ordenes_compra,[$data["id"]]);
			$ordencompra->fechaemision=$data["fechaemision"];
			$ordencompra->fk_proveedor=$data["proveedor"]["id"];
			$ordencompra->direccion=$data["direccion"];
			$ordencompra->telefono=$data["telefono"];
			$ordencompra->nit=$data["nit"];
			$ordencompra->embarque=$data["embarque"];
			$ordencompra->origen=$data["origen"];
			$ordencompra->destino=$data["destino"];
			$ordencompra->fechallegada=$data["fechallegada"];
			$ordencompra->solicitado=$data["solicitado"];
			$ordencompra->formapago=$data["formapago"];
			$ordencompra->observaciones=$data["observaciones"];
			$id_orden_compra=R::store($ordencompra);
			http_response_code(200);
			$ordencompra=R::load(T_ordenes_compra,$id_orden_compra);
			$respuesta["ordencompra"]=$ordencompra;
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
		$ordencompra=R::load(T_ordenes_compra,$data["id"]);
		R::trash($ordencompra);
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
