<?php
	include_once "../../../clases/bd.php";
	include_once "../../../clases/articulos.php";
	switch($_POST["metodo"]){
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
		$valores=array("articulos_id"=>$_POST["id"],
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
		$articulo=new articulos($_POST["id"]);
		$result=$articulo->setCalificacion($_POST["calificacion"],$_POST["accion"]);
		echo "Ok";
	}
	function recomienda(){
		$bd=new bd();
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION))
		session_start();
		$valores=array("usuarios_id"=>$_SESSION["id"],
			       "eventos_tipos_id"=>2,
			       "fecha"=>$tiempo,
			       "evento_id"=>$_POST["id"]
				);
		$result=$bd->doInsert("eventos",$valores);
		return $result;
	} 
?>