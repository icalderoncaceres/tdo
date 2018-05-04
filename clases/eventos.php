<?php
include_once 'bd.php';
include_once 'fotos.php';
include_once 'usuarios.php';
class eventos{
	protected $table="eventos";
	private $id;
	private $mensaje;
    private $usuarios_id;
    private $eventos_tipos_id;
    private $fecha;
    private $evento_id;
    private $grupos;
    private $status;
    private $fotos_id;
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
                        $valores["status"] = $result["status"];
                        $valores["fotos_id"] = $result["fotos_id"];
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
            $codigo="I" . $grupos_id . "F";
            $consulta="select id from eventos where grupos like '%$codigo%' and status=1 order by fecha desc limit 20 OFFSET $inicio";
            $result=$bd->query($consulta);
            return $result;
        }
        public function countEventosByGrupos($grupos_id){
            $bd=new bd();
            $codigo="I" . $grupos_id . "F";
            $consulta="select count(id) as tota from eventos where grupos like '%$codigo%' and status=1";
            $result=$bd->query($consulta);
            $row=$result->fetch();
            return $row["tota"];
        }
        public function getEventosByUsuarios($usuarios_id,$inicio=0){
            $bd=new bd();
//            $consulta="select id from eventos where grupos like '%$codigo%' order by fecha desc limit 20 OFFSET $inicio";
            $consulta="select id from eventos where usuarios_id in (select usuarios_id from usuarios_grupos where id in (select id from usuarios_grupos where usuarios_id=$usuarios_id)) and status=1 order by fecha desc limit 20 OFFSET $inicio";
            $result=$bd->query($consulta);
            return $result;
        }
        public function countEventosByUsuarios($usuarios_id){
            $bd=new bd();
            $consulta="select count(id) as tota from eventos where usuarios_id in (select usuarios_id from usuarios_grupos where id in (select id from usuarios_grupos where usuarios_id=$usuarios_id)) and status=1";
            $result=$bd->query($consulta);
            $row=$result->fetch();
            return $row["tota"];
        }                
        public function getTitulo(){
            $html="<div class='col-xs-12 t16'>";
            $foto=new fotos();
            $usua=new usuario($this->usuarios_id);
            $html.="<a href='perfil.php?id=" . $usua->id . "'><img class='imagenes-usuario' src='" . $foto->buscarFotoUsuario($this->usuarios_id) . "'/> ";
            $html.=$usua->getNombre() . "</a>" . $this->getResumen();
            $html.="</div>";
            return $html;
        }
        public function getResumen(){
            switch($this->eventos_tipos_id){
                case 1:
                    if(is_null($this->fotos_id)){
                        return " agreg&oacute; un mensaje";
                    }else{
                        if($this->mensaje!="")
                            return " agreg&oacute; una foto y un mensaje";
                        else
                            return " agreg&oacute; una foto";
                    }
                    break;
                case 2:
                    return " recomend&oacute; el siguiente aporte";
                    break;
                case 3:
                    return " recomend&oacute; el siguiente recurso educativo";
                    break;
                case 4:
                    return " recomend&oacute; el siguiente art&iacute;culo";
                    break;
                case 5:
                    return " comparti&oacute; el siguiente recurso";
                    break;
            }
        }
        public function getComentarios($inicio=0){
            $foto=new fotos();
            $html="";
            $bd=new bd();
            $result=$bd->query("select * from eventos_comentarios where eventos_id={$this->id} and status=1 order by fecha desc limit 13 OFFSET $inicio");
            if($result){
                foreach($result as $r=>$valor){
                    $usua=new usuario($valor["usuarios_id"]);
                    $html.="<div class='col-xs-12'><a href='perfil.php?id=" . $usua->id . "'><img class='imagenes-usuario' src='" . $foto->buscarFotoUsuario($usua->id) . "' />";
                    $html.=" " . $usua->getNombre(10) . "</a> " . $valor["comentario"] . "</div>";
                }
            }
            return $html;
        }
        public function countComentarios(){
            $bd=new bd();
            $result=$bd->query("select count(id) as tota from eventos_comentarios where eventos_id={$this->id} and status=1");
            $row=$result->fetch();
            return $row["tota"];
        }
        public function countCalificaciones($valor=NULL){
            $bd=new bd();
            if(!is_null($valor)){
                $result=$bd->query("select count(id) as tota from eventos_calificaciones where eventos_id=$this->id and calificacion=$valor");
                $row=$result->fetch();
                return $row["tota"];
            }else{
                $result=$bd->query("select (select count(id) from eventos_calificaciones where eventos_id=$this->id and calificacion=1) as tota1,"
                        . "(select count(id) from eventos_calificaciones where eventos_id=$this->id and calificacion=-1) as tota2");
                $row=$result->fetch();
                return array($row["tota1"],$row["tota2"]);
            }
        }
        public function hasCalificacion(){
            $bd=new bd();
            $usuario=$_SESSION["id"];
            $result=$bd->doSingleSelect("eventos_calificaciones","usuarios_id=$usuario and eventos_id=$this->id","calificacion");
            if(!empty($result)){
                return $result["calificacion"];
            }else{
                return 0;
            }
        }
}