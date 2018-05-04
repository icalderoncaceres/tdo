<?php
include_once "../../../clases/bd.php";
$metodo=filter_input(INPUT_POST,"metodo");
if(!$metodo)
	return;
$metodo();
function reservar(){
	$bd=new bd();
	if(!isset($_SESSION))
		session_start();
	$id=$_SESSION["id"];
	$documento=filter_input(INPUT_POST,"txt-documento");
	$nombre=filter_input(INPUT_POST,"txt-nombre");
	$apellido=filter_input(INPUT_POST,"txt-apellido");
	$planes_id=filter_input(INPUT_POST,"select-plan");
	$pagos_id=filter_input(INPUT_POST,"select-forma");
	$bancos_id=filter_input(INPUT_POST,"select-banco");
	$referencia=filter_input(INPUT_POST,"txt-referencia");
	$observaciones=filter_input(INPUT_POST,"txt-observacion");
	$email=filter_input(INPUT_POST,"txt-email");
	$telefono=filter_input(INPUT_POST,"txt-telefono");
	$valores=array("usuarios_id"=>$id,
				   "documento"=>$documento,
				   "planes_id"=>$planes_id,
				   "pagos_id"=>$pagos_id,
				   "bancos_id"=>$bancos_id,
				   "referencia"=>$referencia,
				   "observaciones"=>$observaciones,
				   "fecha"=>date("Y-m-d H:i:s",time()),
				   "fecha_inicio"=>NULL,
				   "status"=>0,
				   "telefonos"=>$telefono
				   );
	$valoresUsuarios=array("nombres"=>$nombre,
						   "apellidos"=>$apellido,
						   "telefonos"=>$telefono
						   );
	$valoresAccesos=array("email"=>$email);
	$result=$bd->doInsert("reservaciones",$valores);
	$nuevoId=$bd->lastInsertId();
	$bd->doInsert("avances",array("reservaciones_id"=>$nuevoId,"fecha"=>date("Y-m-d H:i:s",time()),"leccion"=>0,"status"=>1));
	$result+=$bd->doUpdate("usuarios",$valoresUsuarios,"id=$id");
	$result+=$bd->doUpdate("usuarios_accesos",$valoresAccesos,"usuarios_id=$id");
	if($result>0){
		echo json_encode(array("result"=>"ok"));
	}else{
		echo json_encode(array("result"=>"error"));
	}
}

function getTitulos(){
	$bd=new bd();
	$disco=filter_input(INPUT_POST,"disco");
	$nivel=filter_input(INPUT_POST,"nivel");
	$tabla="eng_" . $nivel . "_" . $disco;
	$res=$bd->query("select * from $tabla order by posicion");
	$result=$res->fetchAll();
	echo json_encode(array("audios"=>$result));
}

function getVocabulario(){
	$bd=new bd();
	$lesson=filter_input(INPUT_POST,"lesson");
	if($lesson){
		$lesson=" and lesson=" . $lesson;
	}else{
		$lesson="";
	}	
	$res=$bd->doFullSelect("vocabulario","status=1 $lesson");
	$devolver="";
	$indice=0;
	foreach($res as $r=>$valor){
		$devolver= $devolver . "<li data-indice=" . $indice . "><a href='#' class='song-vocabulario' data-spanish='" . utf8_encode($valor["spanish"]) . "'>" . utf8_encode($valor["ingles"]) . "</a></li>";
		$indice++;
	}
	echo $devolver;
}

function getAudios(){
	$bd=new bd();
	$leccion=filter_input(INPUT_POST,"leccion");
	$tabla=filter_input(INPUT_POST,"tabla");

	$count=$bd->query("select count(id) as tota from $tabla where leccion=$leccion");
	$row=$count->fetch();
	$total=$row["tota"];
	
	$first=$bd->doSingleSelect("$tabla","leccion=$leccion order by posicion","posicion");
	
	$posiciones=array();
	for($i=0;$i<50;$i++){
		$posiciones[]=rand($first["posicion"],$first["posicion"] + $total);
	}
	$filtro=implode(",",$posiciones);	
	$res=$bd->query("select * from $tabla where leccion=$leccion and posicion in ($filtro) order by posicion limit 40");
	$result=$res->fetchAll();
	echo json_encode(array("audios"=>$result));
}

function uploads(){
	$bd=new bd();
	$titulo=filter_input(INPUT_POST,"titulo");
	$posicion=filter_input(INPUT_POST,"posicion");
	$tabla=filter_input(INPUT_POST,"tabla");
	$contenido=filter_input(INPUT_POST,"contenido");	
	$valores=array("archivo"=>$titulo,
				   "titulo"=>$titulo,
				   "texto"=>$contenido,
				   "posicion"=>$posicion
				  );
	$res=$bd->doInsert($tabla,$valores);
	echo $res;
}

function getPorcentaje(){
	$texto=filter_input(INPUT_POST,"texto");
	$audio=filter_input(INPUT_POST,"audio");
	$texto=strtolower($texto);
	$audio=strtolower($audio);
	$audio=str_replace(",","",$audio);
	$audio=str_replace(".","",$audio);
	$audio=str_replace("!","",$audio);
	similar_text($texto, $audio, $percent);
	echo json_encode(array("result"=>"ok","porcentaje"=>$percent));
}

function upLection(){
	$bd=new bd();
	if(!isset($_SESSION)){
		session_start();
	}
	$id=$_SESSION["id"];
	$leccion=intval(filter_input(INPUT_POST,"leccion")) + 1;
	$result=$bd->doSingleSelect("reservaciones","usuarios_id=$id order by id desc limit 1");
	if($result){		
		$bd->doUpdate("avances",array("status"=>0),"reservaciones_id={$result["id"]}");
		$bd->doInsert("avances",array("reservaciones_id"=>$result["id"],"fecha"=>date("Y-m-d H:i:s",time()),"leccion"=>$leccion,"status"=>1));
		echo json_encode(array("result"=>"ok"));
	}else{
		echo json_encode(array("result"=>"error"));
	}	
}

function updatePuntaje(){
	$bd=new bd();
	if(!isset($_SESSION)){
		session_start();
	}	
	$puntos=filter_input(INPUT_POST,"puntos");
	$flag=filter_input(INPUT_POST,"flag");
	if($flag==1){
		$result=$bd->doUpdate("puntajes",array("puntaje"=>$puntos,"fecha"=>date("Y-m-d H:i:s",time())),"usuarios_id={$_SESSION["id"]}");
	}else{
		$result=$bd->doInsert("puntajes",array("juegos_id"=>1,"usuarios_id"=>$_SESSION["id"],"fecha"=>date("Y-m-d H:i:s",time()),"puntaje"=>$puntos));
	}
	if($result){
		echo json_encode(array("result"=>"ok"));
	}else{
		echo json_encode(array("result"=>"error"));
	}
}