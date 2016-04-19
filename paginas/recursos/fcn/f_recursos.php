<?php
	include_once "../../../clases/bd.php";
	include_once "../../../clases/recursos.php";
	switch($_POST["metodo"]){
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
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION)){
			session_start();
		}
		$valores=array("recursos_id"=>$_POST["id"],
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
		$recurso=new recursos($_POST["id"]);
		$result=$recurso->setCalificacion($_POST["calificacion"],$_POST["accion"]);
		echo "Ok";
	}
	function recomienda(){
		$bd=new bd();
		$tiempo = date("Y-m-d H:i:s",time());
		if(!isset($_SESSION))
		session_start();
		$valores=array("usuarios_id"=>$_SESSION["id"],
			       "eventos_tipos_id"=>3,
			       "fecha"=>$tiempo,
			       "evento_id"=>$_POST["id"]
				);
		$result=$bd->doInsert("eventos",$valores);
		return $result;
	} 
?>