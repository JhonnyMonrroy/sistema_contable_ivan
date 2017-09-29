<?php
require("../../conexion.php");

class dosificacion{
	const TABLA="dosificacions";

	public $id=-1;	// ID entero
	public $ntramite="";	// NOMBRE cadena
	public $nautorizacion="";	// USUARIO
	public $fecha_inicio="";	// CI
	public $llave="";	// CI
	public $fecha_fin="";	// CI
	public $fk_sucursal="";	// CEL

	private $conexion=null;

	/**
	 * Constructor
	 * */
	//function construct() { La sintaxis para contructores en php es con dos guines bajos
	function __construct() {
		$this->id=-1;	// ID entero
		$this->ntramite="";	// NOMBRE cadena
		$this->nautorizacion="";	// CI
		$this->fecha_inicio="";	// USUARIO
		$this->llave="";	// USUARIO
		$this->fecha_fin="";	// USUARIO
		$this->fk_sucursal="";	// CEL
		$this->conexion=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	}

	/**
	 * Metodo que guarda un registro en la base de datos
	 * retorna un objeto creado
	 * */
	public function guardar(){
		if($this->id==-1){	// es nuevo
			$sql="insert into ".self::TABLA." (ntramite,nautorizacion,fecha_inicio,llave,fecha_fin,fk_sucursal) values('".$this->ntramite."','".$this->nautorizacion."','".$this->fecha_inicio."','".$this->llave."','".$this->fecha_fin."','".$this->fk_sucursal."')";
		}else{// actualizar
			//$sql="update ".self::TABLA." set ntramite='".$this->ntramite."',nautorizacion='".$this->nautorizacion."',fecha_inicio='".$this->fecha_inicio."',llave='".$this->llave."',fecha_fin='".$this->fecha_fin."',fk_sucursal='".$this->fk_sucursal."' where id='".$this->id."'";
			$sql="update ".self::TABLA." set ntramite='".$this->ntramite."',nautorizacion='".$this->nautorizacion."',fecha_inicio='".$this->fecha_inicio."',llave='".$this->llave."',fecha_fin='".$this->fecha_fin."',fk_sucursal='".$this->fk_sucursal."' where id='".$this->id."'";
		}
		if(mysqli_query($this->conexion,$sql)){
			if($this->id==-1){
				// nuevo
				$sql="select max(id) from ".self::TABLA;
				$result=mysqli_query($this->conexion,$sql);
				$fila=mysqli_fetch_array($result);
				$this->id=$fila[0];
			}
			return self::getdosificacionDeId($this->id);
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
		$dosificacion=new self();
		$lista=array();	// vector de usuarios
		$sql="select * from ".self::TABLA." order by nit"; //lo agregrue yo
		//$result=mysqli_query($dosificacion->conexion,"select * from ".self::TABLA); // select * from id_cont
		$result=mysqli_query($dosificacion->conexion,$sql);
		//echo $dosificacion->conexion;
		while($fila=mysqli_fetch_array($result)) {
			array_push($lista,self::mapper($fila));	// guardamos a cada usuario en el vector
		}
		return $lista;
	}

	/**
	 * Obtienen el objeto usuario de id, null en caso de que no exista
	 * */
	public static function getdosificacionDeId($id){
		$dosificacion=new self();
		$sql="select * from ".self::TABLA." where id ='$id'";
		$result=mysqli_query($dosificacion->conexion,$sql); // select * from usuario_cont
		if($fila=mysqli_fetch_array($result)) {
			return self::mapper($fila);	// guardamos a cada usuario en el vector
		}
		return null;
	}

	/**
	 * Mapeador para crear un objeto usuario
	 * */
	private static function mapper($fila){
		$midosificacion=new self();	// creamos un usuario con datos vacios
		$midosificacion->id=$fila["id"];	// los campos de la tabla
		$midosificacion->ntramite=$fila["ntramite"];
		$midosificacion->nautorizacion=$fila["nautorizacion"];
		$midosificacion->fecha_inicio=$fila["fecha_inicio"];
		$midosificacion->llave=$fila["llave"];
		$midosificacion->fecha_fin=$fila["fecha_fin"];
		$midosificacion->fk_sucursal=$fila["fk_sucursal"];
		return $midosificacion;
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
			$dosificacion=dosificacion::getdosificacionDeId($_GET["id"]);
			print json_encode($dosificacion);
		}else{
			print json_encode(dosificacion::lista());
		}
		break;
	case 'POST':
		// guardar
		$data = json_decode(file_get_contents('php://input'), true);
		$dosificacion=new dosificacion();
		$dosificacion->id=$fila["id"];	// los campos de la tabla
		$dosificacion->ntramite=$fila["ntramite"];
		$dosificacion->nautorizacion=$fila["nautorizacion"];
		$dosificacion->fecha_inicio=$fila["fecha_inicio"];
		$dosificacion->llave=$fila["llave"];
		$dosificacion->fecha_fin=$fila["fecha_fin"];
		$dosificacion->fk_sucursal=$fila["fk_sucursal"];
		if ($dosificacion->guardar()){
			http_response_code(201);
			print json_encode($dosificacion);
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
		$dosificacion=dosificacion::getdosificacionDeId($data["id"]);
		$dosificacion->id=$fila["id"];	// los campos de la tabla
		$dosificacion->ntramite=$fila["ntramite"];
		$dosificacion->nautorizacion=$fila["nautorizacion"];
		$dosificacion->fecha_inicio=$fila["fecha_inicio"];
		$dosificacion->llave=$fila["llave"];
		$dosificacion->fecha_fin=$fila["fecha_fin"];
		$dosificacion->fk_sucursal=$fila["fk_sucursal"];
		if ($dosificacion->guardar()){
			http_response_code(200);
			print json_encode($dosificacion);
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
		$dosificacion=dosificacion::getdosificacionDeId($data["id"]);
		$dosificacion->eliminar();
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
