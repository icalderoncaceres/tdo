<?php
include_once 'bd.php';
class eventos{
	protected $table="eventos";
	private $id;
	private $mensaje;
        private $usuarios_id;
        private $eventos_tipos_id;
        private $fecha;
        private $evento_id;
        private $grupos;
        private $estado;
	public function eventos($id = NULL){
		if(!is_null($id)){
			$this->buscarEvento($id);
		}
	}
	public function nuevoEvento($params){
		$bd = new bd();
		$result = $bd->doInsert($this->table, $params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarEvento($id){
		$this->id = $id;
		$bd = new bd();
		$result = $bd->doSingleSelect($this->table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["mensaje"] = $result["mensaje"];
                        $valores["usuarios_id"] = $result["usuarios_id"];
                        $valores["eventos_tipos_id"] = $result["eventos_tipos_id"];
                        $valores["fecha"] = $result["fecha"];
                        $valores["evento_id"] = $result["evento_id"];
                        $valores["grupos"] = $result["grupos"];
                        $valores["estado"] = $result["estado"];
			$this->setEvento($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setEvento($params){
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
	public function atributoFormateado($atributo="mensaje",$longitud=45){
		$devolver=(strlen($this->$atributo)<=$longitud?$this->titulo:substr($this->titulo,0,$longitud) . "...");
		return $devolver;
	}
        /******************************GETTERS******************************/
        public function getEventosByGrupos($grupos_id,$inicio=0){
            $bd=new bd();
            $consulta="select * from eventos where usuarios_id in (select usuarios_id from usuarios_grupos"
                    . " where grupos_id=$grupos_id) and estado=1 order by fecha DESC limit 5 OFFSET $inicio";
            $result=$bd->query($consulta);
            return $result;
        }
}