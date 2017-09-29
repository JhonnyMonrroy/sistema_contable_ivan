<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_proveedores="proveedores";
const T_ordenes_compra="ordenescompra";
const T_movimientos = "movimientos";
const T_productos ="productos";
const T_traspasos ="traspasos";
const T_traspasos_det ="traspasosdet";
const T_sucursales ="sucursales";

// aca se define este api
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){	// para obtener una orden de compra
			$traspaso=R::findOne( T_traspasos, ' id = ? ', [ $_GET["id"] ] );
			$sucursales = R::findAll(T_sucursales);
			//obtener ovimientos
			$transaccionesDet =R::find( T_traspasos_det, ' fk_traspaso = ? ', [ $traspaso->id ] );
			$traspasos_det_result=[];
			$totalFinal = 0;
			foreach ($transaccionesDet as $transacDet){				
				$transacDet->producto=R::findOne( T_productos, ' id = ? ', [ $transacDet->fk_producto ] );
				//$transacDet->cantidad = $movimiento->cantsol;
				$transacDet->precio_unitario = $transacDet->costo;
				//$transacDet->cantidad_recibida = $movimiento->cantsol;
				$totalFinal += $transacDet->cantidad * $transacDet->costo;
				array_push($traspasos_det_result,$transacDet);
			}
			$traspaso->productos_traspaso=$traspasos_det_result;
			$result["totalFinal"] = $totalFinal;
			$result["sucursales"]=$sucursales;
			$result["traspaso"]=$traspaso;
		}else{
			$traspasos = R::findAll(T_traspasos);			
			foreach ($traspasos as $traspaso){
				$traspaso->origen =R::findOne( T_sucursales, ' id = ? ', [$traspaso->fk_origen] );
				$traspaso->destino =R::findOne( T_sucursales, ' id = ? ', [$traspaso->fk_destino] );
			}					
			$result["traspasos"]=$traspasos;			
		}
		print json_encode($result);
		break;
	case 'POST':
		// guardar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$traspaso=R::dispense(T_traspasos);			
			$traspaso->fecha=$data["fecha"];
			$traspaso->fk_origen=$data["fk_origen"];
			$traspaso->fk_destino=$data["fk_destino"];
			$traspaso->observaciones=$data["observaciones"];			
			$id_traspaso = R::store($traspaso);
			
			$traspaso=R::load(T_traspasos,$id_traspaso);
						
			foreach( $data["productos_traspaso"] as $objeto){	
				$traspasoDetalle = R::dispense(T_traspasos_det);	
				$traspasoDetalle->fk_traspaso = $id_traspaso;
				$traspasoDetalle->fk_producto = $objeto["fk_producto"];
				$traspasoDetalle->cantidad =  $objeto["cantidad"];
				$traspasoDetalle->costo	= $objeto["precio_unitario"];	
				$idTraspasoDet = R::store($traspasoDetalle);
				// salida del producto 
				$movimiento = R::dispense(T_movimientos);
				$movimiento->pedido  = 0;
				$movimiento->producto = $objeto["fk_producto"];
				$movimiento->fk_sucursal = $data["fk_origen"];
				$movimiento->traspaso = $id_traspaso;
				$movimiento->compra = 0;				
				$movimiento->venta = 0;
				$movimiento->cantsol =  0;
				$movimiento->cants = $objeto["cantidad"];
				$movimiento->cante = 0;
				$movimiento->cu = $objeto["precio_unitario"];
				$movimiento->cose = 0;
				$movimiento->coss = 0;
				$movimiento->puv = 0;
				$id_movimiento=R::store($movimiento);
				// entrada producto 
				$movimientoE = R::dispense(T_movimientos);
				$movimientoE->pedido  = 0;
				$movimientoE->producto = $objeto["fk_producto"];
				$movimientoE->fk_sucursal = $data["fk_destino"];
				$movimientoE->traspaso = $id_traspaso;
				$movimientoE->compra = 0;				
				$movimientoE->venta = 0;
				$movimientoE->cantsol =  0;
				$movimientoE->cants = 0;
				$movimientoE->cante = $objeto["cantidad"];
				$movimientoE->cu = $objeto["precio_unitario"];
				$movimientoE->cose = 0;
				$movimientoE->coss = 0;
				$movimientoE->puv = 0;
				$id_movimientoE=R::store($movimientoE);				
			}
			
			$respuesta["traspaso"]=$traspaso;
			http_response_code(201);

		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]= $e->getmessage() + "No se pudo guardar el nuevo traspaso";
			$respuesta["error"]=$e;
		}finally{
			print json_encode($respuesta);
		}
		break;
	case 'PUT':
		// actualizar
		try{			
			$data = json_decode(file_get_contents('php://input'), true);			
			$orden_compra=R::findOne(T_ordenes_compra, ' id = ? ',[$data["id"]]);			
				$traspaso=R::findOne(T_traspasos, ' id = ? ',[$data["id"]]);
				$traspaso->fecha = $data["fecha"];
				$traspaso->fk_origen = $data["fk_origen"]; 
				$traspaso->fk_destino = $data["fk_destino"]; 
				$traspaso->observaciones=$data["observaciones"];				
				$id_traspaso=R::store($traspaso);
				
	
				$productos_traspaso = $data["productos_traspaso"];
				//obt transacciones de traspasos actuales
				$traspaso_det_antiguas=R::find( T_traspasos_det, ' fk_traspaso = ? ', [ $traspaso->id ]);
				//Borrando operaciones antiguas
				foreach ($traspaso_det_antiguas as $trapd){
					$trasp_det = R::findOne(T_traspasos_det, ' id=? ',[$trapd["id"]]);
					R::trash($trasp_det);
				}
				//obtener los movimientos antiguos
				$productos_traspaso_antiguas=R::find( T_movimientos, ' traspaso = ? ', [ $traspaso->id ]);
				//Borrando operaciones antiguas
				foreach ($productos_traspaso_antiguas as $mov){
					$movimiento = R::findOne(T_movimientos, ' id=? ',[$mov["id"]]);
					R::trash($movimiento);
				}
				// adicionar los nuevos registros 
				foreach( $data["productos_traspaso"] as $objeto){	
					$traspasoDetalle = R::dispense(T_traspasos_det);	
					$traspasoDetalle->fk_traspaso = $id_traspaso;
					$traspasoDetalle->fk_producto = $objeto["fk_producto"];
					$traspasoDetalle->cantidad =  $objeto["cantidad"];
					$traspasoDetalle->costo	= $objeto["precio_unitario"];	
					$idTraspasoDet = R::store($traspasoDetalle);
					// salida del producto 
					$movimiento = R::dispense(T_movimientos);
					$movimiento->pedido  = 0;
					$movimiento->producto = $objeto["fk_producto"];
					$movimiento->fk_sucursal = $data["fk_origen"];
					$movimiento->traspaso = $id_traspaso;
					$movimiento->compra = 0;				
					$movimiento->venta = 0;
					$movimiento->cantsol =  0;
					$movimiento->cants = $objeto["cantidad"];
					$movimiento->cante = 0;
					$movimiento->cu = $objeto["precio_unitario"];
					$movimiento->cose = 0;
					$movimiento->coss = 0;
					$movimiento->puv = 0;
					$id_movimiento=R::store($movimiento);
					// entrada producto 
					$movimientoE = R::dispense(T_movimientos);
					$movimientoE->pedido  = 0;
					$movimientoE->producto = $objeto["fk_producto"];
					$movimientoE->fk_sucursal = $data["fk_destino"];
					$movimientoE->traspaso = $id_traspaso;
					$movimientoE->compra = 0;				
					$movimientoE->venta = 0;
					$movimientoE->cantsol =  0;
					$movimientoE->cants = 0;
					$movimientoE->cante = $objeto["cantidad"];
					$movimientoE->cu = $objeto["precio_unitario"];
					$movimientoE->cose = 0;
					$movimientoE->coss = 0;
					$movimientoE->puv = 0;
					$id_movimientoE=R::store($movimientoE);				
				}					
			
			$respuesta["traspaso"]=$traspaso;
			http_response_code(201);
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar los cambios del traspaso ";
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
		$traspaso=R::load(T_traspasos,$data["id"]);	
		//obt transacciones de traspasos actuales
		$traspaso_det_antiguas=R::find( T_traspasos_det, ' fk_traspaso = ? ', [ $traspaso->id ]);
		//Borrando operaciones antiguas
		foreach ($traspaso_det_antiguas as $trapd){
			$trasp_det = R::findOne(T_traspasos_det, ' id=? ',[$trapd["id"]]);
			R::trash($trasp_det);
		}
		//obtener los movimientos antiguos
		$productos_traspaso_antiguas=R::find( T_movimientos, ' traspaso = ? ', [ $traspaso->id ]);
		//Borrando operaciones antiguas
		foreach ($productos_traspaso_antiguas as $mov){
			$movimiento = R::findOne(T_movimientos, ' id=? ',[$mov["id"]]);
			R::trash($movimiento);
		}	
		R::trash($traspaso);
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