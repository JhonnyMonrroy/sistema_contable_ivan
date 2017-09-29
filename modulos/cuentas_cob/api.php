<?php
require("../../conexion.php");

class Producto{
	const TABLA="cuentascob";
	
	public $id=-1;	// ID entero
	public $tipo="";	// NOMBRE cadena
	public $fecha="";	// USUARIO
	public $tipo_cambio="";	// CI
	public $glosa="";	// CI
	public $cuenta="";	// CI
	public $ccuenta="";	// CEL
	public $importe="";	// USUARIO
	public $fk_transaccion="";	// USUARIO
	
	private $conexion=null;
	
	/**
	 * Constructor
	 * */
	function __construct() {
		public $id=-1;	// ID entero
		public $tipo="";	// NOMBRE cadena
		public $fecha="";	// USUARIO
		public $tipo_cambio="";	// CI
		public $glosa="";	// CI
		public $cuenta="";	// CI
		public $ccuenta="";	// CEL
		public $importe="";	// USUARIO
		public $fk_transaccion="";	// USUARIO
			$this->conexion=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	}
	
	/**
	 * Metodo que guarda un registro en la base de datos
	 * retorna un objeto creado
	 * */
	public function guardar(){
		if($this->id==-1){	// es nuevo
			$sql="insert into ".self::TABLA." (tipo,fecha,tipo_cambio,glosa,cuenta,ccuenta,importe,fk_transaccion) values('".$this->tipo."','".$this->fecha."','".$this->tipo_cambio."','".$this->glosa."','".$this->cuenta."','".$this->ccuenta."','".$this->importe."','".$this->fk_transaccion."')";
		}else{// actualizar
			$sql="update ".self::TABLA." set tipo='".$this->tipo."',fecha='".$this->fecha."',tipo_cambio='".$this->tipo_cambio."',glosa='".$this->glosa."',cuenta='".$this->cuenta."',ccuenta='".$this->ccuenta."',importe='".$this->importe."',fk_transaccion='".$this->fk_transaccion."' where id='".$this->id."'";
		}
		if(mysqli_query($this->conexion,$sql)){
			if($this->id==-1){
				// nuevo
				$sql="select max(id) from ".self::TABLA;
				$result=mysqli_query($this->conexion,$sql);
				$fila=mysqli_fetch_array($result);
				$this->id=$fila[0];
			}
			return self::getCuentascobDeId($this->id);
		}
		return null;
	}
	
	/**
	 * Metodo que elimina un registro en la base de datos
	 * retorna un objeto creado
	 * */
	public function eliminar(){
		$sql="delete from ".self::TABLA." where ID='".$this->id."'";
		mysqli_query($this->conexion,$sql);
		return null;
	}
	
	/**
	 * Obtienen todos los registros de la tabla usuario
	 * */
	public static function lista(){
		$producto=new self();
		$lista=array();	// vector de usuarios
		$sql="select * from ".self::TABLA." order by id"; //lo agregrue yo
		//$result=mysqli_query($producto->conexion,"select * from ".self::TABLA); // select * from id_cont
		$result=mysqli_query($cuentascob->conexion,$sql);
		//echo $producto->conexion;
		while($fila=mysqli_fetch_array($result)) {
			array_push($lista,self::mapper($fila));	// guardamos a cada usuario en el vector
		}
		return $lista;
	}
	
	/**
	 * Obtienen el objeto usuario de id, null en caso de que no exista
	 * */
	public static function getCuentascobDeId($id){
		$producto=new self();
		$sql="select * from ".self::TABLA." where id ='$id'";
		$result=mysqli_query($cuentascob->conexion,$sql); // select * from usuario_cont
		if($fila=mysqli_fetch_array($result)) {
			return self::mapper($fila);	// guardamos a cada usuario en el vector
		}
		return null;
	}
	
	/**
	 * Mapeador para crear un objeto usuario
	 * */
	private static function mapper($fila){
		$miCuentascob=new self();	// creamos un usuario con datos vacios
		$miCuentascob->id=$fila["id"];	// los campos de la tabla
		$miCuentascob->tipo=$fila["tipo"];
		$miCuentascob->fecha=$fila["fecha"];
		$miCuentascob->tipo_cambio=$fila["tipo_cambio"];
		$miCuentascob->glosa=$fila["glosa"];
		$miCuentascob->cuenta=$fila["cuenta"];
		$miCuentascob->ccuenta=$fila["ccuenta"];
		$miCuentascob->fk_transaccion=$fila["fk_transaccion"];
		$miCuentascob->importe=$fila["importe"];
		return $miCuentascob;
	}
	
	/**
	 * Función que convierte en Json este objeto
	 * */
	public function toJSON(){
		return json_encode($this);
	}
}

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
	case 'GET':
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($_GET["id"])){
			$producto=Producto::getCuentascobDeId($_GET["id"]);
			print json_encode($cuentascob);
		}else{
			print json_encode(Cuentascob::lista());
		}
		break;
	case 'POST':
		// guardar
		$data = json_decode(file_get_contents('php://input'), true);
		$cuentascob=new Cuentascob();
		$cuentascob->tipo=$data["tipo"];
		$cuentascob->fecha=$data["fechao"];
		$cuentascob->tipo_cambio=$data["tipo_cambio"];
		$cuentascob->glosa=$data["glosa"];
		$cuentascob->cuenta=$data["cuenta"]);
		$cuentascob->ccuenta=$data["ccuenta"];
		$cuentascob->importe=$data["importe"];
		$cuentascob->fk_transaccion=$data["fk_transaccion"];
		if ($cuentascob->guardar()){
			http_response_code(201);
			print json_encode($producto);
		}else{
			http_response_code(405);
			$respuesta=array();
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar el usuario";
			print json_encode($respuesta);
		}
		break;
	case 'PUT':
		// actualizar
	//	$data = json_decode(file_get_contents('php://input'), true);
	//	$producto=Producto::getProductoDeId($data["id"]);
	//	$producto->codigo_prod=$data["codigo_prod"];
	//	$producto->producto=strtoupper($data["producto"]);
	//	$producto->marca=strtoupper($data["marca"]);
	//	$producto->medida=strtoupper($data["medida"]);
	//	$producto->modelo=$data["modelo"];
	//	$producto->descripcion=strtoupper($data["descripcion"]);
	//	$producto->precio1=$data["precio1"];
	//	$producto->precio2=$data["precio2"];
	//	$producto->precio3=$data["precio3"];
	//	if ($producto->guardar()){
	//		http_response_code(200);
	//		print json_encode($producto);
	//	}else{
	//		http_response_code(405);
	//		$respuesta=array();
	//		$respuesta["codigo"]=405;
	//		$respuesta["mensaje"]="No se pudo guardar el usuario";
	//		print json_encode($respuesta);
	//	}
	//	break;
	//	break;
	case 'HEAD':
		do_something_with_head($request);
		break;
	case 'DELETE':
	//	$data = json_decode(file_get_contents('php://input'), true);
	//	$producto=Producto::getProductoDeId($data["id"]);
	//	$producto->eliminar();
	//	http_response_code(200);
	//	break;
	case 'OPTIONS':
		do_something_with_options($request);
		break;
	default:
		handle_error($request);
		break;
}

?>
