<?php
include_once 'bd.php';
/**
 * @property string table
 * @property string a_table
 * @property int id
 * @property string titulo;
 * @property string areas_id;
 * @property string usuarios_id;
 * @property string fecha;
 * @property string status;
 */
class temas{
	protected $table="temas";
	protected $a_table="aportes";
	private $id;
	private $titulo;
	private $areas_id;
	private $usuarios_id;
	private $fecha;
	private $status;
	public function temas($id = NULL){
		if(!is_null($id)){
			$this->buscarTema($id);
		}
	}
	public function nuevoTema($params){
		$bd = new bd();
		$result = $bd->doInsert($this->table, $params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarTema($id){
		$this->id = $id;
		$bd = new bd();
		$result = $bd->doSingleSelect($this->table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["titulo"] = $result["titulo"];
			$valores["areas_id"] = $result["areas_id"];
			$valores["usuarios_id"] = $result["usuarios_id"];
			$valores["fecha"] = $result["fecha"];
			$valores["status"] = $result["status"];
			$this->setTema($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setTema($params){
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
	public function getAportes($limite=25,$inicio=0,$id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$strLimite=" limit $limite OFFSET $inicio";
		$consulta="select aportes.id as id_a,aportes.fecha,aportes.contenido,usuarios.id,usuarios.nombres,usuarios.apellidos from aportes,usuarios 
			   where aportes.temas_id=$id and usuarios_id=usuarios.id and aportes.status=1 order by aportes.fecha desc $strLimite";
		$result=$bd->query($consulta);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	public function countAportes($id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		}
		$result=$bd->query("select count(*) as tota from aportes where temas_id=$id and status=1");
		if($result->rowCount()>0){
			$row = $result->fetch();
			return $row["tota"];
		}else{
			return 0;
		}
	}
	public function agregarAporte($contenido,$id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		if(!isset($_SESSION)){
			session_start();
		}
		$bd=new bd();
		$tiempo = date("Y-m-d H:i:s",time());
		$valores=array("contenido"=>$contenido,
			       "fecha"=>$tiempo,
			       "usuarios_id"=>$_SESSION["id"],
			       "temas_id"=>$id,
                   "status"=>1
		);
		$result=$bd->doInsert("aportes",$valores);
		return $result;
	}
	public function getRuta(){
		$bd=new bd();
		$consulta="select temas.titulo,areas.nombre from temas,areas where temas.areas_id=areas.id and temas.id={$this->id}";
		$result=$bd->query($consulta);
		if($result->rowCount()>0){
			$row = $result->fetch();
			return utf8_encode($row["nombre"]) . "-" . utf8_encode($row["titulo"]);
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
		$devolver=(strlen($this->$atributo)<=$longitud?$this->$atributo:substr($this->$atributo,0,$longitud) . "...");
		return $devolver;
	}
}