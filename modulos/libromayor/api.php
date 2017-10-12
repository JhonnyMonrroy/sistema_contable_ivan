<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_transacciones="transacciones";
const T_tipos_transaccion="tipo_trans";
const T_cuentas="cuentas";
const T_operaciones="operaciones";

// aca se define este api

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");


switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["transaccion"])){
			$transaccion=R::findOne( T_transacciones, ' id = ? ', [ $_GET["transaccion"] ] );
			if(!is_null($transaccion)){
				$transaccion->tipo_transaccion=R::findOne( T_tipos_transaccion, ' id = ? ', [ $transaccion->fk_tipo_transaccion ] );
				$operaciones=R::find( T_operaciones, ' fk_transaccion = ? ', [ $transaccion->id ] );
				$operaciones_result=[];
				foreach ($operaciones as $operacion){
					$operacion->cuenta=R::findOne( T_cuentas, ' id = ? ', [ $operacion->fk_cuenta ] );
					array_push($operaciones_result,$operacion);
				}
				$transaccion->operaciones=$operaciones_result;
				$result["transaccion"]=$transaccion;
			}else{
				http_response_code(404);
				$result["codigo"]=404;
				$result["mensaje"]="No se encontro la transaccion de id: ".$_GET["transaccion"];
			}
		}else{
			if(isset($_GET["sig_nro_tipo_comprobante"])){
				$sig_nro_comprobante=$_GET["sig_nro_tipo_comprobante"];
				$result["sig_nro_tipo_comprobante"]=R::getCell('SELECT max(nro_tipo_comprobante) FROM '.T_transacciones.' WHERE fk_tipo_transaccion = ?',[$sig_nro_comprobante])+1;
			}else{
				$cuentas = R::findAll(T_cuentas, 'tipo=?', ["S"]);
				$result["cuentas"]=$cuentas;
				$result["tipos_transaccion"]=R::find(T_tipos_transaccion);
				$result["sig_nro_comprobante"]=R::getCell('SELECT max(nro_comprobante) FROM '.T_transacciones)+1;
				$transacciones=R::findAll(T_transacciones);
				foreach ($transacciones as $transaccion){
					$transaccion->tipo_transaccion=R::findOne( T_tipos_transaccion, ' id = ? ', [ $transaccion->fk_tipo_transaccion ] );
				}
				$result["transacciones"]=$transacciones;
			}
		}
		print json_encode($result);
		break;
	case 'HEAD':
		do_something_with_head($request);
		break;
	case 'OPTIONS':
		do_something_with_options($request);
		break;
	default:
		handle_error($request);
		break;
}

?>
