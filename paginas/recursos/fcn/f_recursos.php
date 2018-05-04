<?php
	include_once "../../../clases/bd.php";
	include_once "../../../clases/recursos.php";
        $metodo=filter_input(INPUT_POST,"metodo");
	switch($metodo){
		case "ver":
			guardaVisitaDescarga("recursos_visitas");
			break;
		case "descargar":
			guardaVisitaDescarga("recursos_descargas");
			break;
		case "calificar":
			calificar();
			break;
		case "recomendar":
			recomienda();
			break;
	}
	function guardaVisitaDescarga($tabla){
		$bd=new bd();
                $id=  filter_input(INPUT_POST,"id");
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION)){
			session_start();
		}
		$valores=array("recursos_id"=>$id,
			       "usuarios_id"=>$_SESSION["id"],
			       "fecha"=>$tiempo
		);
		$result=$bd->doInsert($tabla,$valores);
		if($result){
			echo "ok.";
		}else{
			echo "Error";
		}
	}
	function calificar(){
                $id=  filter_input(INPUT_POST,"id");
                $calificacion=  filter_input(INPUT_POST,"calificacion");
                $accion=  filter_input(INPUT_POST,"accion");
		$recurso=new recursos($id);
		$result=$recurso->setCalificacion($calificacion,$accion);
                if($result){
                    echo "Ok";
                }else{
                    echo "Error";
                }
	}
	function recomienda(){
		$bd=new bd();
                $id=  filter_input(INPUT_POST,"id");
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION)){
                    session_start();
                }
		$valores=array("usuarios_id"=>$_SESSION["id"],
			       "eventos_tipos_id"=>3,
			       "fecha"=>$tiempo,
			       "evento_id"=>$id
				);
		$result=$bd->doInsert("eventos",$valores);
		return $result;
	}