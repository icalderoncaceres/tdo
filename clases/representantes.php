<?php
include_once 'bd.php';
class representantes {
	protected $table = "usuarios_representantes";
	private $fecha;
	private $usuarios_id;
	private $representantes_id;
	public function nuevoRepresentante($codigo,$usuarios_id=NULL, $representantes_id=NULL) {
                $bd=new bd();
                if(is_null($representantes_id)){
                    if(!isset($_SESSION))
                        session_start ();
                    $representantes_id=$_SESSION["id"];
                }
                if(is_null($usuarios_id)){
                    $result=$bd->doSingleSelect("codigos","codigo like '$codigo'","usuarios_id");
                    if(!$result){
                        return "No";
                    }else{
                        $usuarios_id=$result["usuarios_id"];
                    }
                }
                if($usuarios_id==$representantes_id)
                    return "Igual";
		$bd = new bd ();
                $tiempo = date("Y-m-d H:i:s",time());
		$bd->doInsert ( $this->table, array (
				"fecha" => $tiempo,
				"usuarios_id" => $usuarios_id,
				"representantes_id" => $representantes_id
		) );
                return "Ok";
	}
}