<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
//const T_proveedores="proveedores";
//const T_ordenes_compra="ordenescompra";
const T_facturas = "facturas";
const T_productos ="productos";
const T_dosificacion ="dosificacion";
const T_detallefactura ="detalle_factura";
// aca se define este api
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){	// para obtener una venta
			$factura=R::findOne( T_facturas, ' id = ? ', [ $_GET["id"] ] );
			$dosificacion = R::findAll(T_dosificacion);
			//obtener movimientos
			$detallefactura =R::find( T_detallefactura, ' id_factura = ? ', [ $factura->id ] );
			$detallefactura_result=[];
			$totalFinal = 0;
			foreach ($detallefactura as $detallefacturas){
				$detallefactura->codigo_prod = $detallefactura->producto;
				$detallefactura->producto=R::findOne( T_productos, ' id = ? ', [ $detallefactura->producto ] );
				$detallefactura->cantidad = $detallefactura->cants;
				$detallefactura->precio_unitario = $detallefactura->puv;
				$totalFinal += $detallefactura->puv * $detallefactura->cants;
				array_push($detallefactura_result,$detallefactura);
			}
			$factura->productos_factura=$detallefactura_result;
			$result["totalFinal"] = $totalFinal;
			$result["dosificacion"]=$dosificacion;
			$result["factura"]=$factura;
		}else{
			$facturas = R::findAll(T_facturas);
			foreach ($facturas as $factura){
				$factura->dosificacion = R::findOne( T_dosificacion, ' id = ? ', [$factura->id_dosificacion] );
			}			
			$result["facturas"]=$facturas;			
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
			$factura->fecha=$data["fecha"];
			$factura->totalp=$data["totalp"];
			$factura->descuento=$data["descuento"];
			$factura->totalf=$data["totalf"];
			$factura->codigo_ctrl=$data["codigo_ctrl"];
			$factura->estado=$data["estado"];
			$id_factura=R::store($factura);

			$facturas=R::load(T_facturas,$id_factura);
						
			//$orden_compra->productos_compra = $data["productos_compra"];
			foreach( $data["productos_factura"] as $objeto){
				//	Object { id="11",  codigo_prod="111",  producto="LLANTA",  más...}
				$detallefactura = R::dispense(T_detallefactura);
				$detallefactura->codigo_prod  = 0;
				$detallefactura->producto = $objeto["descripcion"];
				$detallefactura->precio_unit = 0;
				$detallefactura->cantidad = 0;
				$detallefactura->factura = $id_factura;
				$id_detallefactura=R::store($detallefactura);
			}
			
			$respuesta["factura"]=$factura;
			http_response_code(201);

		} catch (Exception $e) {
			http_response_code(405);
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]= $e->getmessage() + "No se pudo guardar la mueva factura";
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
