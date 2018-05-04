<?php
include_once 'bd.php';
/**
 * @property string table;
 * @property int id;
 * @property string contenido;
 * @property date fecha;
 * @property int usuarios_id;
 * @property string temas_id;
 * @property string status;
 */
class aportes{
	protected $table="aportes";
	private $id;
	private $contenido;
	private $fecha;
	private $usuarios_id;
	private $temas_id;
    private $status;
	public function aportes($id = NULL){
		if(!is_null($id)){
			$this->buscarAporte($id);
		}
	}
	public function nuevoAporte($params){  //Funcion que se mejorara a medida que se utilice la clase
		$bd = new bd();
		$result = $bd->doInsert($this->table, $params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarAporte($id){
		$this->id = $id;
		$bd = new bd();
		$result = $bd->doSingleSelect($this->table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["contenido"] = $result["contenido"];
			$valores["fecha"] = $result["fecha"];
			$valores["usuarios_id"] = $result["usuarios_id"];
			$valores["temas_id"] = $result["temas_id"];
                        $valores["status"] = $result["status"];
			$this->setAporte($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setAporte($params){
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
	public function getUsuario($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->doSingleSelect("usuarios","id=$this->usuarios_id");
		if($result){
			return "{$result["nombres"]} {$result["apellidos"]}";
		}else{
			return false;
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
			$consulta=$bd->doSingleSelect("aportes_calificaciones","usuarios_id={$_SESSION["id"]} and aportes_id=$id");
			if($consulta){
				$result=$bd->doUpdate("aportes_calificaciones",array("calificacion"=>$calificacion,"fecha"=>$tiempo),"usuarios_id={$_SESSION["id"]} and aportes_id=$id");
			}else{
				$result=$bd->doInsert("aportes_calificaciones",array("usuarios_id"=>$_SESSION["id"],"aportes_id"=>$id,"calificacion"=>$calificacion,"fecha"=>$tiempo));
			}
		}else{
			$result=$bd->query("delete from aportes_calificaciones where usuarios_id={$_SESSION["id"]} and aportes_id=$id");
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
		$condicion="usuarios_id={$_SESSION["id"]} and aportes_id=$id";
		$result=$bd->doSingleSelect("aportes_calificaciones",$condicion);
		if($result){
			return $result["calificacion"];
		}else{
			return 0;
		}
	}
	public function contarCalificaciones($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->query("select (select count(aportes_id) from aportes_calificaciones where calificacion=1 and aportes_id=$id) as tota1,
					   (select count(aportes_id) from aportes_calificaciones where calificacion=-1 and aportes_id=$id) as tota2");
		$row=$result->fetch();
		return array("good"=>$row["tota1"],"bad"=>$row["tota2"]);
	}
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
}