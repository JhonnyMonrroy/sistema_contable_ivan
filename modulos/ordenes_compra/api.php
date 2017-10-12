<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_proveedores="proveedores";
const T_ordenes_compra="ordenescompra";
const T_movimientos = "movimientos";
const T_productos ="productos";
// aca se define este api
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){	// para obtener una orden de compra
			$orden=R::findOne( T_ordenes_compra, ' id = ? ', [ $_GET["id"] ] );
			$proveedores = R::findAll(T_proveedores);
			//obtener ovimientos
			$movimientos =R::find( T_movimientos, ' compra = ? ', [ $orden->id ] );
			$movimientos_result=[];
			$totalFinal = 0;
			foreach ($movimientos as $movimiento){
				$movimiento->fk_producto = $movimiento->producto;
				$movimiento->producto=R::findOne( T_productos, ' id = ? ', [ $movimiento->producto ] );
				$movimiento->cantidad = $movimiento->cantsol;
				$movimiento->precio_unitario = $movimiento->cu;
				$movimiento->cantidad_recibida = $movimiento->cantsol;
				$totalFinal += $movimiento->cu * $movimiento->cantsol;
				array_push($movimientos_result,$movimiento);
			}
			$orden->productos_compra=$movimientos_result;
			$result["totalFinal"] = $totalFinal;
			$result["proveedores"]=$proveedores;
			$result["orden_compra"]=$orden;
		}else{
			$ordenes_compra = R::findAll(T_ordenes_compra);
			foreach ($ordenes_compra as $orden_compra){
				$orden_compra->proveedor =R::findOne( T_proveedores, ' id = ? ', [$orden_compra->fk_proveedor] );
			}			
			$result["ordenes_compra"]=$ordenes_compra;			
		}
		print json_encode($result);
		break;
	case 'POST':
		// guardar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$orden_compra=R::dispense(T_ordenes_compra);
			//$orden_compra=R::load(T_ordenes_compra,[$data["id"]]);
			$orden_compra->fecha=$data["fecha"];
			$orden_compra->fk_proveedor=$data["fk_proveedor"]; //["id"];// bo 001
			$orden_compra->contenedor=$data["contenedor"];
			$orden_compra->origen=$data["origen"];
			$id_orden_compra=R::store($orden_compra);
			
			$orden_compra=R::load(T_ordenes_compra,$id_orden_compra);
						
			//$orden_compra->productos_compra = $data["productos_compra"];
			foreach( $data["productos_compra"] as $objeto){
				//	Object { id="11",  codigo_prod="111",  producto="LLANTA",  más...}
				$movimiento = R::dispense(T_movimientos);
				$movimiento->pedido  = 0;
				$movimiento->producto = $objeto["fk_producto"];
				$movimiento->compra = $id_orden_compra;
				$movimiento->traspaso = 0;
				$movimiento->venta = 0;
				$movimiento->cantsol =  $objeto["cantidad"];
				$movimiento->cants = 0;
				$movimiento->cante = 0;
				$movimiento->cu = $objeto["precio_unitario"];
				$movimiento->cose = 0;
				$movimiento->coss = 0;
				$movimiento->puv = 0;
				$id_movimiento=R::store($movimiento);
			}
			
			$respuesta["orden_compra"]=$orden_compra;
			http_response_code(201);

		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]= $e->getmessage() + "No se pudo guardar la mueva orden de compra";
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
			if(!(isset($data["ingreso"]) && $data["ingreso"]!=null)  /*is_empty($data["ingreso"])*/ ){
				$orden_compra->fecha=$data["fecha"];
				$orden_compra->fk_proveedor=$data["fk_proveedor"]; 
				$orden_compra->contenedor=$data["contenedor"];
				$orden_compra->origen=$data["origen"];
				$id_orden_compra=R::store($orden_compra);
				
	
				$productos_compra = $data["productos_compra"];
				$productos_compraantiguas=R::find( T_movimientos, ' compra = ? ', [ $orden_compra->id ]);
				// guardamos las nuevas operaciones
				foreach ($productos_compra as $objeto){
					$movimiento = R::dispense(T_movimientos);
					$movimiento->pedido  = 0;
					$movimiento->producto = $objeto["fk_producto"];
					$movimiento->compra = $id_orden_compra;
					$movimiento->traspaso = 0;
					$movimiento->venta = 0;
					$movimiento->cantsol =  $objeto["cantidad"];
					$movimiento->cants = 0;
					$movimiento->cante = 0;
					$movimiento->cu = $objeto["precio_unitario"];
					$movimiento->cose = 0;
					$movimiento->coss = 0;
					$movimiento->puv = 0;
					$id_movimiento=R::store($movimiento);
				}
				//Borrando operaciones antiguas
				foreach ($productos_compraantiguas as $mov){
					$movimiento = R::findOne(T_movimientos, ' id=? ',[$mov["id"]]);
					R::trash($movimiento);
				}				
			}else{
				$productos_compra = $data["productos_compra"];
				$productos_compraantiguas=R::find( T_movimientos, ' compra = ? ', [ $orden_compra->id ]);
				$id_orden_compra = $orden_compra->id;
				// guardamos las nuevas operaciones
				foreach ($productos_compra as $objeto){
					$movimiento = R::findOne(T_movimientos, ' id=? ',[$objeto["id"]]);					
					$movimiento->pedido  =  $id_orden_compra;
					//$movimiento->producto = $objeto["fk_producto"];
					//$movimiento->compra = $id_orden_compra;
					//$movimiento->traspaso = 0;
					//$movimiento->venta = 0;
					//$movimiento->cantsol = 0;
					$movimiento->cante = $objeto["cantidad_recibida"];
					//$movimiento->cants = 0;
					//$movimiento->cu = $objeto["precio_unitario"];
					//$movimiento->cose = 0;
					//$movimiento->coss = 0;
					//$movimiento->puv = 0;
					$id_movimiento=R::store($movimiento);
				}								
			}

			http_response_code(200);
			$orden_compra=R::load(T_ordenes_compra,$id_orden_compra);
			$respuesta["orden_compra"]=$orden_compra;
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar los cambios de la orden de compra";
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
		$productos_orden = R::find( T_movimientos, ' compra = ? ', [ $orden_compra->id ]);
		//eliminando los movimientos relacionado con la venta 
		foreach ($productos_orden as $mov){
			$movimiento = R::findOne(T_movimientos, ' id=? ',[$mov["id"]]);
			R::trash($movimiento);
		}	
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