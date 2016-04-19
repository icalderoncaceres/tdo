<?php
include_once 'bd.php';
/**
 * @property string r_table
 * @property int id
 * @property string r_titulo;
 * @property string r_descripcion;
 * @property string r_areas_id;
 * @property string r_tipos_id;
 * @property string r_usuarios_id;
 * @property string r_ruta;
 * @property string r_fecha;
 * @property string r_status;
 * @property string r_formatos_id;
 */
class recursos{
	protected $r_table="recursos";
	private $id;
	private $r_titulo;
	private $r_descripcion;
	private $r_areas_id;
	private $r_tipos_id;
	private $r_usuarios_id;
	private $r_ruta;
	private $r_fecha;
	private $r_status;
	private $r_formatos_id;
	public function recursos($id = NULL){
		if(!is_null($id)){
			$this->buscarRecurso($id);
		}
	}
	public function nuevoRecurso($params){  //Función que se mejorara a medida que se utilice la clase
		$bd = new bd();
		$result = $bd->doInsert($this->r_table, $params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarRecurso($id){
		$this->id = $id;
		$bd = new bd();
		$result = $bd->doSingleSelect($this->r_table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["r_titulo"] = $result["titulo"];
			$valores["r_descripcion"] = $result["descripcion"];
			$valores["r_areas_id"] = $result["areas_id"];
			$valores["r_tipos_id"] = $result["tipos_id"];
			$valores["r_usuarios_id"] = $result["usuarios_id"];
			$valores["r_ruta_id"] = $result["ruta"];
			$valores["r_fecha"] = $result["fecha"];
			$valores["r_status"] = $result["status"];
			$valores["r_formatos_id"] = $result["formatos_id"];
			$this->setRecurso($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setRecurso($params){
		if(!empty($params)){
			foreach ($params as $key => $values){
				$this->$key = $values;
			}
			return true;
		}else{
			throw "Error Publicar 001: No se recibieron parametros";
			return false;
		}
	}
	public function getArea($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->doSingleSelect("areas","id=$this->r_areas_id");
		if($result){
			return $result["nombre"];
		}else{
			return false;
		}
	}
	public function getUsuario($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->doSingleSelect("usuarios","id=$this->r_usuarios_id");
		if($result){
			return "{$result["nombres"]} {$result["apellidos"]}";
		}else{
			return false;
		}
	}
	public function countVisitas(){
		$bd=new bd();
		$result=$bd->query("select count(*) as tota from recursos_visitas where recursos_id=$this->id");
		$row=$result->fetch();
		return $row["tota"];
	}
	public function countDescargas(){
		$bd=new bd();
		$result=$bd->query("select count(*) as tota from recursos_descargas where recursos_id=$this->id");
		$row=$result->fetch();
		return $row["tota"];
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
			$consulta=$bd->doSingleSelect("recursos_comentarios","usuarios_id={$_SESSION["id"]} and recursos_id=$id");
			if($consulta){
				$result=$bd->doUpdate("recursos_comentarios",array("calificacion"=>$calificacion,"fecha"=>$tiempo),"usuarios_id={$_SESSION["id"]} and recursos_id=$id");
			}else{
				$result=$bd->doInsert("recursos_comentarios",array("usuarios_id"=>$_SESSION["id"],"recursos_id"=>$id,"calificacion"=>$calificacion,"fecha"=>$tiempo));
			}
		}else{
			$result=$bd->query("delete from recursos_comentarios where usuarios_id={$_SESSION["id"]} and recursos_id=$id");
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
		$bd=new bd();
		$condicion="usuarios_id={$_SESSION["id"]} and recursos_id=$id";
		$result=$bd->doSingleSelect("recursos_comentarios",$condicion);
		if($result){
			return $result["calificacion"];
		}else{
			return 0;
		}
	}
	public function getFormato($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->doSingleSelect("formatos","id={$this->r_formatos_id}");
		if($result){
			return $result["nombre"];
		}else{
			return false;
		}
	}
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	public function atributoFormateado($atributo="titulo",$longitud=15){
		$devolver=(strlen($this->$atributo)<=$longitud?$this->titulo:substr($this->titulo,0,$longitud) . "...");
		return $devolver;
	}
}