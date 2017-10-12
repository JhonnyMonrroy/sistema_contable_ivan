<?php
require_once("../../conexion.php");
require_once '../../lib/rb.php';
R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
const T_productos ="productos";;
const T_sucursales ="sucursales";

// aca se define este api

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");


switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		$productos = R::findAll(T_productos);
		$sucursales = R::findAll(T_sucursales);
		$result["sucursales"] = $sucursales;
		$result["productos"] = $productos;
		$query = "select *
		from (
		SELECT concat_ws(' - ', su.responsable, su.direccion) as det_suc ,co.fecha, mo.id, 
		concat_ws(' - ', pro.codigo_prod, pro.producto, pro.marca,pro.medida, pro.modelo, pro.descripcion) as det_prod,
		'compra' as tipo, cante, cants,0 as saldo, puv, 0 as impe, 0 as imps
		  FROM movimientos mo LEFT JOIN sucursales su on su.id = mo.fk_sucursal
		  inner join ordenescompra co on co.id = mo.compra
		  inner JOIN productos pro on pro.id = mo.producto
		UNION 
		SELECT concat_ws(' - ', su.responsable, su.direccion) as det_suc,tra.fecha, mo.id, 
		concat_ws(' - ', pro.codigo_prod, pro.producto, pro.marca,pro.medida, pro.modelo, pro.descripcion) as det_prod,
		'traspaso' as tipo, cante, cants,0 as saldo, puv, 0 as impe, 0 as imps
		  FROM movimientos mo INNER JOIN sucursales su on su.id = mo.fk_sucursal
		  inner join traspasos tra on tra.id = mo.traspaso
		  inner JOIN productos pro on pro.id = mo.producto
		UNION
		SELECT concat_ws(' - ', su.responsable, su.direccion) as det_suc,ve.fecha, mo.id, 
		concat_ws(' - ', pro.codigo_prod, pro.producto, pro.marca,pro.medida, pro.modelo, pro.descripcion) as det_prod,
		'venta' as tipo, cante, cants,0 as saldo, puv, 0 as impe, 0 as imps
		  FROM movimientos mo LEFT JOIN sucursales su on su.id = mo.fk_sucursal
		  inner join ventas ve on ve.id = mo.venta
		  inner JOIN productos pro on pro.id = mo.producto
		) AS tabla";
		$movimientos =     R::getAll( $query);
		$result["movimientos"]=$movimientos;
		print json_encode($result);
		break;
		case 'POST':
		// consultar
		try{
			$data = json_decode(file_get_contents('php://input'), true);
			$query = "select *
			from (
			SELECT concat_ws(' - ', su.responsable, su.direccion) as det_suc ,co.fecha, mo.id, 
			concat_ws(' - ', pro.codigo_prod, pro.producto, pro.marca,pro.medida, pro.modelo, pro.descripcion) as det_prod,
			'compra' as tipo, cante, cants,0 as saldo, puv, 0 as impe, 0 as imps,
			 mo.producto as idProducto, su.id as idSucursal
			  FROM movimientos mo LEFT JOIN sucursales su on su.id = mo.fk_sucursal
			  inner join ordenescompra co on co.id = mo.compra
			  inner JOIN productos pro on pro.id = mo.producto
			UNION 
			SELECT concat_ws(' - ', su.responsable, su.direccion) as det_suc,tra.fecha, mo.id, 
			concat_ws(' - ', pro.codigo_prod, pro.producto, pro.marca,pro.medida, pro.modelo, pro.descripcion) as det_prod,
			'traspaso' as tipo, cante, cants,0 as saldo, puv, 0 as impe, 0 as imps,
			mo.producto as idProducto, su.id as idSucursal
			  FROM movimientos mo INNER JOIN sucursales su on su.id = mo.fk_sucursal
			  inner join traspasos tra on tra.id = mo.traspaso
			  inner JOIN productos pro on pro.id = mo.producto
			UNION
			SELECT concat_ws(' - ', su.responsable, su.direccion) as det_suc,ve.fecha, mo.id, 
			concat_ws(' - ', pro.codigo_prod, pro.producto, pro.marca,pro.medida, pro.modelo, pro.descripcion) as det_prod,
			'venta' as tipo, cante, cants,0 as saldo, puv, 0 as impe, 0 as imps,
			mo.producto as idProducto, su.id as idSucursal
			  FROM movimientos mo LEFT JOIN sucursales su on su.id = mo.fk_sucursal
			  inner join ventas ve on ve.id = mo.venta
			  inner JOIN productos pro on pro.id = mo.producto
			) AS tabla where idProducto = :idProducto and idSucursal = :idSucursal and fecha BETWEEN  :fechaInicio and :fechaFin";
			$movimientos =  R::getAll( $query, [':idProducto' => $data["id_producto"], ':idSucursal' => $data["id_sucursal"], ':fechaInicio' => $data["fechaInicio"],':fechaFin' => $data["fechaFin"]]);
			$respuesta["movimientos"]=$movimientos;
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
