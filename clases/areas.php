<?php
include_once 'bd.php';
/**
 * @property string table
 * @property int id
 * @property string nombre;
 */
class areas{
	protected $table="areas";
	private $id;
	private $nombre;
	public function areas($id = NULL){
		if(!is_null($id)){
			$this->buscarArea($id);
		}
	}
	public function nuevaArea($params){  //Función que se mejorara cuando se trabaje en el modulo de registrar temas
		$bd = new bd();
		$result = $bd->doInsert($this->table, $params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarArea($id){
		$this->id = $id;
		$bd = new bd();
		$result = $bd->doSingleSelect($this->table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["nombre"] = $result["nombre"];
			$this->setArea($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setArea($params){
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
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	public function atributoFormateado($atributo="titulo",$longitud=15){
		$devolver=(strlen($this->$atributo)<=$longitud?$this->titulo:substr($this->titulo,0,$longitud) . "...");
		return $devolver;
	}
	public function getTemas($limite=25,$inicio=0,$id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		}
		$strLimite=" limit $limite OFFSET $inicio";
		$consulta="select temas.id as id_t,titulo,temas.fecha,usuarios.* from temas,usuarios where 
			   areas_id=$id and usuarios_id=usuarios.id order by temas.fecha desc $strLimite";
		$result=$bd->query($consulta);
		$devolver=array();
		if($result->rowCount()>0){
			foreach($result as $r=>$valor)
			{
				$devolver[$r]=$valor;
				$total=$bd->query("select count(*) as tota from visitas where temas_id={$valor["id_t"]}");
				$row = $total->fetch();
				$devolver[$r]["totaVisitas"]=$row["tota"];
				$total=$bd->query("select count(*) as tota from aportes where temas_id={$valor["id_t"]}");
				$row = $total->fetch();
				$devolver[$r]["totaRespuestas"]=$row["tota"];
			}
			return $devolver;
		}else{
			return false;
		}		
	}
	public function getRecursos($filtro,$id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		}
		$consulta="select recursos.id as id_r,titulo,recursos.descripcion as des_r,recursos.fecha,recursos.ruta,usuarios.* from recursos,usuarios where
			   areas_id=$id and usuarios_id=usuarios.id and recursos.tipos_id in ($filtro) and status=1 order by recursos.fecha desc";
		$result=$bd->query($consulta);
		$devolver=array();
		if($result->rowCount()>0){
			foreach($result as $r=>$valor)
			{
				$devolver[$r]=$valor;
				$total=$bd->query("select count(*) as tota from recursos_visitas where recursos_id={$valor["id_r"]}");
				$row = $total->fetch();
				$devolver[$r]["totaVisitas"]=$row["tota"];
				$total=$bd->query("select count(*) as tota from recursos_descargas where recursos_id={$valor["id_r"]}");
				$row = $total->fetch();
				$devolver[$r]["totaDescargas"]=$row["tota"];
				$total=$bd->query("select count(*) as tota from recursos_comentarios where recursos_id={$valor["id_r"]} and calificacion=1");
				$row = $total->fetch();
				$devolver[$r]["totaPositivos"]=$row["tota"];
				$total=$bd->query("select count(*) as tota from recursos_comentarios where recursos_id={$valor["id_r"]} and calificacion=-1");
				$row = $total->fetch();
				$devolver[$r]["totaNegativos"]=$row["tota"];
			}
			return $devolver;
		}else{
			return false;
		}
	}
	public function agregarTema($titulo,$id=NULL){
		if(!isset($_SESSION)){
			session_start();
		}
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$tiempo = date("Y-m-d H:i:s",time());
		$valores=array("titulo"=>$titulo,
			       "fecha"=>$tiempo,
			       "usuarios_id"=>$_SESSION["id"],
			       "areas_id"=>$id,
		);
		$result=$bd->doInsert("temas",$valores);
		return $result;
	}
	public function countTemas($id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		}
		$result=$bd->query("select count(*) as tota from temas where areas_id=$id");
		if($result->rowCount()>0){
			$row = $result->fetch();
			return $row["tota"];
		}else{
			return 0;
		}
	}
	public function countAportes($id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		} 
		$result=$bd->query("select count(*) as tota from aportes where temas_id in (select id from temas where areas_id=$id)");
		if($result->rowCount()>0){
			$row = $result->fetch();
			return $row["tota"];
		}else{
			return 0;
		}
	}
	public function countRecursos($id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		}
		$result=$bd->query("select count(*) as tota from recursos where areas_id=$id");
		if($result->rowCount()>0){
			$row = $result->fetch();
			return $row["tota"];
		}else{
			return 0;
		}
	}
	public function countDescargas($id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		}
		$result=$bd->query("select count(*) as tota from recursos_descargas where recursos_id in (select id from recursos where areas_id=$id)");
		if($result->rowCount()>0){
			$row = $result->fetch();
			return $row["tota"];
		}else{
			return 0;
		}
	}
	public function countVisitasRecursos($id=NULL){
		$bd=new bd();
		if(is_null($id)){
			$id=$this->id;
		} 
		$result=$bd->query("select count(*) as tota from recursos_visitas where recursos_id in (select id from recursos where areas_id=$id)");
		if($result->rowCount()>0){
			$row = $result->fetch();
			return $row["tota"];
		}else{
			return 0;
		}
	}
}