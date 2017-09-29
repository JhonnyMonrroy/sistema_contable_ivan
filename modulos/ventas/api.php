<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
//const T_proveedores="proveedores";
//const T_ordenes_compra="ordenescompra";
const T_movimientos = "movimientos";
const T_productos ="productos";
const T_clientes ="clientes";
const T_ventas ="ventas";
// aca se define este api
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){	// para obtener una venta
			$venta=R::findOne( T_ventas, ' id = ? ', [ $_GET["id"] ] );
			$clientes = R::findAll(T_clientes);
			//obtener movimientos
			$movimientos =R::find( T_movimientos, ' venta = ? ', [ $venta->id ] );
			$movimientos_result=[];
			$totalFinal = 0;
			foreach ($movimientos as $movimiento){
				$movimiento->fk_producto = $movimiento->producto;
				$movimiento->producto=R::findOne( T_productos, ' id = ? ', [ $movimiento->producto ] );
				$movimiento->cantidad = $movimiento->cants;
				$movimiento->precio_unitario = $movimiento->puv;
				$totalFinal += $movimiento->puv * $movimiento->cants;
				array_push($movimientos_result,$movimiento);
			}
			$venta->productos_venta=$movimientos_result;
			$result["totalFinal"] = $totalFinal;
			$result["clientes"]=$clientes;
			$result["venta"]=$venta;
		}else{
			$ventas = R::findAll(T_ventas);
			foreach ($ventas as $venta){
				$venta->cliente = R::findOne( T_clientes, ' id = ? ', [$venta->fkcliente] );
			}			
			$result["ventas"]=$ventas;			
		}
		print json_encode($result);
		break;
	case 'POST':
		// guardar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$venta=R::dispense(T_ventas);
			$venta->fecha=$data["fecha"];
			$venta->fkcliente=$data["fkcliente"];
			$venta->factura=$data["factura"];
			$venta->facturado=$data["facturado"];
			$venta->total=$data["total"];
			$venta->descuento=$data["descuento"];
			$venta->a_cuenta=$data["a_cuenta"];
			$venta->saldo=$data["saldo"];
			$venta->obs=$data["obs"];
			$id_venta=R::store($venta);
			
			$ventas=R::load(T_ventas,$id_venta);
						
			//$orden_compra->productos_compra = $data["productos_compra"];
			foreach( $data["productos_venta"] as $objeto){
				//	Object { id="11",  codigo_prod="111",  producto="LLANTA",  más...}
				$movimiento = R::dispense(T_movimientos);
				$movimiento->pedido  = 0;
				$movimiento->producto = $objeto["fk_producto"];
				$movimiento->compra = 0;
				$movimiento->traspaso = 0;
				$movimiento->venta = $id_venta;
				$movimiento->cante = 0;
				$movimiento->cants = $objeto["cantidad"];
				$movimiento->cu = 0;
				$movimiento->cose = 0;
				$movimiento->coss = 0;
				$movimiento->puv = $objeto["precio_unitario"];
				$id_movimiento=R::store($movimiento);
			}
			
			$respuesta["venta"]=$venta;
			http_response_code(201);

		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]= $e->getmessage() + "No se pudo guardar la mueva venta";
			$respuesta["error"]=$e;
		}finally{
			print json_encode($respuesta);
		}
		break;
	case 'PUT':
		// actualizar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$venta=R::findOne(T_ventas, ' id = ? ',[$data["id"]]);
			$venta->fecha=$data["fecha"];
			$venta->fkcliente=$data["fkcliente"]; 
			$venta->factura=$data["factura"];
			$venta->facturado=$data["facturado"];
			$venta->total=$data["total"];
			$venta->descuento=$data["descuento"];
			$venta->a_cuenta=$data["a_cuenta"];
			$venta->saldo=$data["saldo"];
			$venta->obs=$data["obs"];
			$id_venta=R::store($venta);
			

			$productos_venta = $data["productos_venta"];
			$productos_ventaantiguas=R::find( T_movimientos, ' venta = ? ', [ $venta->id ]);
			// guardamos las nuevas operaciones
			foreach ($productos_venta as $objeto){
				$movimiento = R::dispense(T_movimientos);
				$movimiento->pedido  = 0;
				$movimiento->producto = $objeto["fk_producto"];
				$movimiento->compra = 0;
				$movimiento->traspaso = 0;
				$movimiento->venta = $id_venta;
				$movimiento->cante = 0;
				$movimiento->cants =  $objeto["cantidad"];
				$movimiento->cu = 0;
				$movimiento->cose = 0;
				$movimiento->coss = 0;
				$movimiento->puv = $objeto["precio_unitario"];
				$id_movimiento=R::store($movimiento);
			}
			//Borrando operaciones antiguas
			foreach ($productos_ventaantiguas as $mov){
				$movimiento = R::findOne(T_movimientos, ' id=? ',[$mov["id"]]);
				R::trash($movimiento);
			}
			http_response_code(200);
			$venta=R::load(T_ventas,$id_venta);
			$respuesta["venta"]=$venta;
		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar los cambios de la venta";
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
		$venta=R::load(T_ventas,$data["id"]);
		$productos_venta = R::find( T_movimientos, ' venta = ? ', [ $venta->id ]);
		//eliminando los movimientos relacionado con la venta 
		foreach ($productos_venta as $mov){
			$movimiento = R::findOne(T_movimientos, ' id=? ',[$mov["id"]]);
			R::trash($movimiento);
		}
		R::trash($venta);

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
