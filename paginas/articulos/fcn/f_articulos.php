<?php
	include_once "../../../clases/bd.php";
	include_once "../../../clases/articulos.php";
        $metodo=filter_input(INPUT_POST,"metodo");
	switch($metodo){
		case "ver":
			guardaVisita();
			break;
		case "calificar":
			calificar();
			break;
		case "recomendar":
			recomienda();
			break;
	}
	function guardaVisita(){
		$bd=new bd();
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION)){
			session_start();
		}
                $id=filter_input(INPUT_POST,"id");
		$valores=array("articulos_id"=>$id,
			       "usuarios_id"=>$_SESSION["id"],
			       "fecha"=>$tiempo
		);
		$result=$bd->doInsert("articulos_visitas",$valores);
		if($result){
			echo "Ok.";
		}else{
			echo "Error";
		}
	}
	function calificar(){
                $id=filter_input(INPUT_POST,"id");
                $calificacion=filter_input(INPUT_POST,"calificacion");
                $accion=filter_input(INPUT_POST,"accion");
		$articulo=new articulos($id);
		$result=$articulo->setCalificacion($calificacion,$accion);
                if($result){
                    echo "Ok";
                }else{
                    echo "Error";
                }
	}
	function recomienda(){
		$bd=new bd();
                $id=filter_input(INPUT_POST,"id");
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION)){
                    session_start();
                }
		$valores=array("usuarios_id"=>$_SESSION["id"],
			       "eventos_tipos_id"=>2,
			       "fecha"=>$tiempo,
			       "evento_id"=>$id
				);
		$result=$bd->doInsert("eventos",$valores);
		return $result;
	}