<?php
include_once 'bd.php';
/**
 * @property string table;
 * @property int id;
 * @property string nombre;
 * @property string fecha;
 * @property string fecha_fin;
 * @property string relaciones_id;
 */
class grupos{
	protected $table="grupos";
	private $id;
	private $nombre;
	private $fecha;
	private $fecha_fin;
    private $relaciones_id;
    private $codigos_id;
    private $usuarios_id;
	public function grupos($id = NULL){
		if(!is_null($id)){
			$this->buscarGrupo($id);
		}
	}
	public function nuevoGrupo($params){
		$bd = new bd();
                $codigo=$bd->query("select id,codigo from codigos where grupos_id is null and usuarios_id is null limit 1");
                $row=$codigo->fetch();
                $params["codigos_id"]=$row["id"];
		$result = $bd->doInsert($this->table, $params);
		if($result){
                        $nuevoId=$bd->lastInsertId();
                        $condicion="id={$row["id"]}";
                        $result.=$bd->doUpdate("codigos", array("grupos_id"=>$nuevoId), $condicion);                       
                        $valores=array("grupos_id"=>$nuevoId,
                                       "usuarios_id"=>$params["usuarios_id"],
                                       "roles_id"=>1,
                                       "fecha"=>date("Y-m-d H:i:s",time()));
                        $result.=$bd->doInsert("usuarios_grupos",$valores);
                        $this->setGrupo($params);
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarGrupo($id){
		$this->id = $id;
		$bd = new bd();
		$result = $bd->doSingleSelect($this->table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["nombre"] = $result["nombre"];
			$valores["fecha"] = $result["fecha"];
			$valores["fecha_fin"] = $result["fecha_fin"];
			$valores["relaciones_id"] = $result["relaciones_id"];
                        $valores["codigos_id"] = $result["codigos_id"];
			$valores["usuarios_id"] = $result["usuarios_id"];
			$this->setGrupo($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setGrupo($params){
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
	public function atributoFormateado($atributo="nombre",$longitud=15){
		$devolver=(strlen($this->$atributo)<=$longitud?$this->titulo:substr($this->titulo,0,$longitud) . "...");
		return $devolver;
	}
        public function getGrupo($codigo){
	    if(!isset($_SESSION))
		session_start();
            $bd=new bd();
            $consulta="select g.id,nombre,u.id as id_adm,CONCAT(u.nombres,' ',u.apellidos) as admin from grupos as g,codigos as c,usuarios as u
                       where g.codigos_id=c.id and g.usuarios_id=u.id and c.codigo like '$codigo'";
            $result=$bd->query($consulta);
            if($result->rowCount()>0){
                $row=$result->fetch();
		if($row["id_adm"]==$_SESSION["id"]){
		    $devolver=array("result"=>"Adm");
		}else{
		    $result=$bd->query("select count(usuarios_id) as tota from usuarios_grupos where usuarios_id={$_SESSION["id"]} and grupos_id in (select id from grupos where codigos_id in (select id from codigos where codigo like '$codigo'))");
		    $total=$result->fetch();
		    if($total["tota"]>0){
			$devolver=array("result"=>"Usu");
		    }else{
  	                $devolver=array("result"=>"Si","nombre"=>$row["nombre"],"administrador"=>$row["admin"],"id"=>$row["id"]);
                    }
		}
                return $devolver;
            }else{
                return array("result"=>"No");
            }
        }
        public function addUsuario($usuario=NULL, $id=NULL){
            if(is_null($id)){
                $id=$this->id;
            }
            if(is_null($usuario)){
                if(!isset($_SESSION))
                    session_start();
                $usuario=$_SESSION["id"];
            }
	    $bd=new bd();
	    $tiempo = date("Y-m-d H:i:s",time());
	    return $result=$bd->doInsert("usuarios_grupos",array("grupos_id"=>$id,"usuarios_id"=>$usuario,"fecha"=>$tiempo));
        }
	public function getAdmin(){
	    $bd=new bd();
	    $result=$bd->query("select CONCAT(nombres,' ',apellidos) as admin from usuarios where id=$this->usuarios_id");
	    $row=$result->fetch();
	    return $row["admin"];
	}
	public function countMiembros($id=NULL){
	    if(is_null($id))
	    {
		$id=$this->id;
	    }
	    $bd=new bd();
	    $result=$bd->query("select count(usuarios_id) as tota from usuarios_grupos where grupos_id=$id");
	    $row=$result->fetch();
	    return $row["tota"];
	}
        public function getMiembros($id=NULL){
            if(is_null($id)){
                $id=$this->id;
            }
            $bd=new bd();
            $result=$bd->query("select usuarios_id from usuarios_grupos where grupos_id=$id");
            return $result;
        }
	public function getRelacion($id=NULL){
	    if(is_null($id)){
	        $id=$this->id;
	    }
	    $bd=new bd();
	    $result=$bd->doSingleSelect("relaciones","id=$this->relaciones_id","descripcion");
	    return $result["descripcion"];
	}
        public function getEntradas($inicio=0,$id=NULL){
            if(is_null($id)){
                $id=$this->id;
            }
            $bd=new bd();
            $result=$bd->query("select * from entradas_grupos where grupos_id=$id order by posicion limit 20 OFFSET $inicio");
            return $result;
        }
        public function countEntradas($id=NULL){
            if(is_null($id)){
                $id=$this->id;
            }
            $bd=new bd();
            $result=$bd->query("select count(id) as tota from entradas_grupos where grupos_id=$id and activo=1");
            $row=$result->fetch();
            return $row["tota"];
        }        
        public function getItems($entradas_id,$id=NULL){
            if(is_null($id)){
                $id=$this->id;
            }
            $bd=new bd();
            $result=$bd->query("select * from entradas_capitulos where entradas_id=$entradas_id order by posicion");
            return $result;
        }
        public function getCodigo($id=NULL){
            if(is_null($id)){
                $id=$this->id;                
            }
            $bd=new bd();
            $result=$bd->doSingleSelect("codigos","grupos_id=$id","codigo");
            return $result["codigo"];
        }
}