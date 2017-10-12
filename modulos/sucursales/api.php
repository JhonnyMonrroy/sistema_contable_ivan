<?php
require("../../conexion.php");

class sucursal{
	const TABLA="sucursales";

	public $id=-1;	// ID entero
	public $responsable="";	// NOMBRE cadena
	public $direccion="";	// USUARIO
	public $fono="";	// CI
	public $obs="";	// CI

	private $conexion=null;

	/**
	 * Constructor
	 * */
	//function construct() { La sintaxis para contructores en php es con dos guines bajos
	function __construct() {
		$this->id=-1;	// ID entero
		$this->responsable="";	// NOMBRE cadena
		$this->direccion="";	// CI
		$this->fono="";	// USUARIO
		$this->obs="";	// USUARIO
		$this->conexion=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	}

	/**
	 * Metodo que guarda un registro en la base de datos
	 * retorna un objeto creado
	 * */
	public function guardar(){
		if($this->id==-1){	// es nuevo
			$sql="insert into ".self::TABLA." (responsable,direccion,fono,obs) values('".$this->responsable."','".$this->direccion."','".$this->fono."','".$this->obs."')";
		}else{// actualizar
			//$sql="update ".self::TABLA." set responsable='".$this->responsable."',direccion='".$this->direccion."',fono='".$this->fono."',obs='".$this->obs."' where id='".$this->id."'";
			$sql="update ".self::TABLA." set responsable='".$this->responsable."',direccion='".$this->direccion."',fono='".$this->fono."',obs='".$this->obs."' where id='".$this->id."'";
		}
		if(mysqli_query($this->conexion,$sql)){
			if($this->id==-1){
				// nuevo
				$sql="select max(id) from ".self::TABLA;
				$result=mysqli_query($this->conexion,$sql);
				$fila=mysqli_fetch_array($result);
				$this->id=$fila[0];
			}
			return self::getsucursalDeId($this->id);
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
		$sucursal=new self();
		$lista=array();	// vector de usuarios
		$sql="select * from ".self::TABLA." order by id"; //lo agregrue yo
		//$result=mysqli_query($sucursal->conexion,"select * from ".self::TABLA); // select * from id_cont
		$result=mysqli_query($sucursal->conexion,$sql);
		//echo $sucursal->conexion;
		while($fila=mysqli_fetch_array($result)) {
			array_push($lista,self::mapper($fila));	// guardamos a cada usuario en el vector
		}
		return $lista;
	}

	/**
	 * Obtienen el objeto usuario de id, null en caso de que no exista
	 * */
	public static function getsucursalDeId($id){
		$sucursal=new self();
		$sql="select * from ".self::TABLA." where id ='$id'";
		$result=mysqli_query($sucursal->conexion,$sql); // select * from usuario_cont
		if($fila=mysqli_fetch_array($result)) {
			return self::mapper($fila);	// guardamos a cada usuario en el vector
		}
		return null;
	}

	/**
	 * Mapeador para crear un objeto usuario
	 * */
	private static function mapper($fila){
		$misucursal=new self();	// creamos un usuario con datos vacios
		$misucursal->id=$fila["id"];	// los campos de la tabla
		$misucursal->responsable=$fila["responsable"];
		$misucursal->direccion=$fila["direccion"];
		$misucursal->fono=$fila["fono"];
		$misucursal->obs=$fila["obs"];
		return $misucursal;
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
			$sucursal=sucursal::getsucursalDeId($_GET["id"]);
			print json_encode($sucursal);
		}else{
			print json_encode(sucursal::lista());
		}
		break;
	case 'POST':
		// guardar
		$data = json_decode(file_get_contents('php://input'), true);
		$sucursal=new sucursal();
		$sucursal->responsable=$data["responsable"];
		$sucursal->direccion=$data["direccion"];
		$sucursal->fono=strtoupper($data["fono"]);
		$sucursal->obs=strtoupper($data["obs"]);
		if ($sucursal->guardar()){
			http_response_code(201);
			print json_encode($sucursal);
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
		$data = json_decode(file_get_contents('php://input'), true);
		$sucursal=sucursal::getsucursalDeId($data["id"]);
		$sucursal->resposable=$data["responsable"];
		$sucursal->direccion=strtoupper($data["direccion"]);
		$sucursal->fono=strtoupper($data["fono"]);
		$sucursal->obs=$data["obs"];
		$sucursal->cel=strtoupper($data["cel"]);
		if ($sucursal->guardar()){
			http_response_code(200);
			print json_encode($sucursal);
		}else{
			http_response_code(405);
			$respuesta=array();
			$respuesta["codigo"]=405;
			$respuesta["mensaje"]="No se pudo guardar el usuario";
			print json_encode($respuesta);
		}
		break;
		break;
	case 'HEAD':
		do_something_with_head($request);
		break;
	case 'DELETE':
		$data = json_decode(file_get_contents('php://input'), true);
		$sucursal=sucursal::getsucursalDeId($data["id"]);
		$sucursal->eliminar();
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
