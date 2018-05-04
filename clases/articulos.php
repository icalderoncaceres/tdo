<?php
include_once 'bd.php';
/**
 *
 */
class articulos {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	//Articulos (a)
	protected $a_table = "articulos";
	private $id = 0;
	private $a_titulo;
	private $a_descripcion;
	private $a_usuarios_id;
	private $a_ruta;
	private $a_fecha;
	private $a_status;
	// Comentarios (c)
	protected $c_table = "articulos_comentarios";
	private $c_articulos_id;
	private $c_usuarios_id;
	private $c_fecha;
	private $c_calificacion;
	// Visitas (v)
	protected $v_table = "articulos_visitas";
	private $v_articulos_id;
	private $v_usuarios_id;
	private $v_fecha;

	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function articulos($id = NULL) {
		if ($id != NULL) {
			// Hago consulta;
			$this->buscarArticulo ( $id );
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	public function buscarArticulo($id) {
		// hace consulta y setea valores
		$this->id = $id;
		if(!$this->getdatosArticulos()){			
//			$this->getdatosComentarios();
//			$this->getdatosVisitas();
		}else{
			return false;
		}
	}
	public function crearArticulo($nuevoId) {
		if (isset ( $this->a_seudonimo )) {
			$bd = new bd ();
			$result = 0;
			$this->id = $nuevoId;
			$result += $bd->doInsert ( $this->a_table, $this->serializarDatos ( "c_", $this->u_table ) );
			$result += $bd->doInsert ( $this->s_table, $this->serializarDatos ( "v_", array (
			$this->a_table 
			) ) );
			if ($result >= 3) {
				return true;
			} else {
				return false;
			}
		} else {
			throw new Exception ( "Error Usuario 004: No se han definido datos de acceso" );
		}
	}
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	private function serializarDatos($prefix = "a_", $foreign_table = false) {
		$reflection = new ReflectionObject ( $this );
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $property ) {
			$name = $property->getName ();
			if (substr ( $name, 0, 2 ) == $prefix || $name == "id") {
				if ($name == "id") {
					if ($foreign_table != false) {
						if (is_array ( $foreign_table )) {
							foreach ( $foreign_table as $f_table ) {
								$params ["{$f_table}_id"] = $this->$name;
							}
						} else {
							$params ["{$foreign_table}_id"] = $this->$name;
						}
					} else {
						$params ["id"] = $this->$name;
					}
				} else {
					$params [substr ( $name, strpos ( $name, "_" ) + 1 )] = $this->$name;
				}
			}
		}
		return $params;
	}
	private function nuevoArticulo() {
		foreach ( get_class_vars ( get_class ( $this ) ) as $name => $default ) {
			$this->$name = $default;
		}
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Getters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function getdatosArticulos(){
		$bd = new bd();
		$result = $bd->doSingleSelect($this->a_table,"id = {$this->id}");
		if($result){
			$this->datosArticulo($result["titulo"], $result["descripcion"], $result["usuarios_id"], $result["ruta"], $result["fecha"], $result["status"]);
			$this->id = $result["id"];
		}else {
			return false;
		}
	}
	public function getdatosComentarios(){
		$bd = new bd();
		$result = $bd->doFullSelect($this->c_table,"articulos_id = {$this->id}");
		if($result){
			$this->datosComentarios($result["usuarios_id"], $result["fecha"], $result["calificacion"]);
				
		}else{
			return false;
		}
	}
	public function getdatosVisitas(){
		$bd = new bd();
		$result = $bd->doFullSelect($this->v_table,"articulos_id = {$this->id}");
		if($result){
			$this->datosVisitas($result["usuarios_id"],$result["fecha"]);
		}else{
			return false;
		}
	}
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function datosArticulo($titulo, $descripcion, $usuarios_id, $ruta, $fecha, $status=1) {
		$this->nuevoArticulo ();
		$this->a_titulo = $titulo;
		$this->a_descripcion = $descripcion;
		$this->a_usuarios_id = $usuarios_id;
		$this->a_ruta = $ruta;
		$this->a_fecha = $fecha;
		$this->a_status = $status;
	}
	public function listarArticulos($status=1){
		$bd=new bd();
		$result=$bd->query("select id from articulos where status=$status order by fecha desc");
		return $result;
	}
	public function getVisitas($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->query("select count(*) as tota from {$this->v_table} where articulos_id=$id");
		$row = $result->fetch();
		return $row["tota"];
	}
	public function getComentarios($tipo=0,$id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		if($tipo==0){
			$result=$bd->query("select count(*) as tota from {$this->c_table} where articulos_id=$id");
		}else{
			$result=$bd->query("select count(*) as tota from {$this->c_table} where articulos_id=$id and calificacion=$tipo");
		}
		$row = $result->fetch();
		return $row["tota"];
	}
	public function getUsuario($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->doSingleSelect("usuarios","id={$this->a_usuarios_id}");
		if(!empty($result)){
			return "{$result["nombres"]} {$result["apellidos"]}";
		}else{
			return " Datos del Colaborador no disponibles";
		}
	}
	public function setCalificacion($calificacion,$accion="poner",$id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		if(!isset($_SESSION)){
			session_start();
		}
		$tiempo = date("Y-m-d H:i:s",time());
		if($accion=="poner"){
			$consulta=$bd->doSingleSelect("articulos_comentarios","usuarios_id={$_SESSION["id"]} and articulos_id=$id");
			if($consulta){
				$result=$bd->doUpdate("articulos_comentarios",array("calificacion"=>$calificacion,"fecha"=>$tiempo),"usuarios_id={$_SESSION["id"]} and articulos_id=$id");
			}else{
				$result=$bd->doInsert("articulos_comentarios",array("usuarios_id"=>$_SESSION["id"],"articulos_id"=>$id,"calificacion"=>$calificacion,"fecha"=>$tiempo));
			}
		}else{
			$result=$bd->query("delete from articulos_comentarios where usuarios_id={$_SESSION["id"]} and articulos_id=$id");
		}
		return $result;
	}
	public function getCalificacion($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		if(!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION["id"])){
			return 0;
		}
		$bd=new bd();
		$condicion="usuarios_id={$_SESSION["id"]} and articulos_id=$id";
		$result=$bd->doSingleSelect("articulos_comentarios",$condicion);
		if($result){
			return $result["calificacion"];
		}else{
			return 0;
		}
	}
}