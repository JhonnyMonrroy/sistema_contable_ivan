<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_facturas="facturas";
const T_detallefactura="detallefactura";
const T_productos="productos";
const T_dosificacion="dosificacion";

// aca se define este api

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");


switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["factura"])){
			$factura=R::findOne( T_facturas, ' id = ? ', [ $_GET["factura"] ] );
			if(!is_null($factura)){
				$factura->dosificacion=R::findOne( T_dosificacion, ' id = ? ', [ $factura->id_dosificacion ] );
				//unset($transaccion->fk_tipo_transaccion);	// borramos este campo inutil
				$detalles=R::find( T_detallefactura, ' id_factura = ? ', [ $factura->id ] );
				$detalles_result=[];
				foreach ($detalles as $detalle){
					$detalle->producto=R::findOne( T_productos, ' codigo_prod = ? ', [ $detalle->codigo_prod ] );
					//unset($operacion->fk_cuenta);	// borramos este campo inutil
					array_push($detalles_result,$detalle);
				}
				$factura->detalles=$detalles_result;
				$result["factura"]=$factura;
			}else{
				http_response_code(404);
				$result["codigo"]=404;
				$result["mensaje"]="No se encontro la factura de id: ".$_GET["factura"];
			}
		}else{
			if (isset($_GET["sig_nro_factura"])) {
				$sig_nro_factura=$_GET["sig_nro_factura"];
				$result["sig_nro_factura"]=R::getCell('SELECT max(nfactura) FROM '.T_facturas.' WHERE nfactura = ?',[$sig_nro_factura])+1;

			}else{
				$result["productos"]=R::findAll(T_productos);
				$result["detalle_factura"]=R::findAll(T_detallefactura);
				$result["dosificacion"]=R::findAll(T_dosificacion);
				$result["sig_nro_factura"]=R::getCell('SELECT max(nfactura) FROM '.T_facturas)+1;
				$result["facturas"]=R::findAll(T_facturas);
			}
		}
		print json_encode($result);
		break;
	case 'POST':
		// guardar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$factura=R::dispense(T_facturas);
			$factura->nfactura=$data["nfactura"];
			$factura->nit=$data["nit"];
			$factura->nombre=$data["nombre"];
			$factura->descuento=$data["descuento"];
			$factura->fecha=$data["fecha"];
			$id_factura=R::store($factura);
			$detalles=$data["detalles"];
			foreach ($detalles as $det) {
				$detalle=R::dispense(T_detallefactura);
				$detalle->codigo_prod=$det["producto"]["codigo_prod"];
				$detalle->cantidad=$det["cantidad"];
				$detalle->precio_unit=$det["precio_unit"];
				$detalle->cantidad=$det["cantidad"];
				$detalle->id_factura=$id_factura;
				$id=R::store($detalle);
			}
			http_response_code(201);
			$factura=R::load(T_facturas,$id_factura);
			$factura->detalles=R::find( T_detallefactura, ' id_factura = ? ', [ $id_factura ] );
			$respuesta["fatura"]=$factura;
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar la factura";
			$respuesta["error"]=$e;
		}finally{
			print json_encode($respuesta);
		}
		break;
	case 'PUT':
		// actualizar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$factura=R::findOne(T_facturas, ' id = ? ',[$data["id"]]);
			$transaccion->nro_comprobante=$data["nro_comprobante"];
			$transaccion->nro_tipo_comprobante=$data["nro_tipo_comprobante"];
			$transaccion->fk_tipo_transaccion=$data["tipo_transaccion"]["id"];
			$transaccion->glosa=$data["glosa"];
			//$transaccion->fecha=$data["fecha"];
			$id_transaccion=R::store($transaccion);
			$operaciones=$data["operaciones"];
			foreach ($operaciones as $ope){
				if($ope["id"]==null)
					$operacion=R::dispense(T_operaciones);
				else
					$operacion=R::findOne(T_operaciones, ' id=? ',[$ope["id"]]);
				$operacion->fk_cuenta=$ope["cuenta"]["id"];
				//$operacion->descripcion=$ope["descripcion"];
				$operacion->debe=$ope["debe"];
				$operacion->haber=$ope["haber"];
				$operacion->fk_transaccion=$id_transaccion;
				$id=R::store($operacion);
			}
			http_response_code(200);
			$transaccion=R::load(T_transacciones,$id_transaccion);
			$transaccion->operaciones=R::find( T_operaciones, ' fk_transaccion = ? ', [ $id_transaccion ] );
			$respuesta["transaccion"]=$transaccion;
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar la transaccion";
			$respuesta["error"]=$e;
		}finally{
			print json_encode($respuesta);
		}
		break;
	case 'HEAD':
		do_something_with_head($request);
		break;
	case 'DELETE':

		break;
	case 'OPTIONS':
		do_something_with_options($request);
		break;
	default:
		handle_error($request);

		break;
}

?>
