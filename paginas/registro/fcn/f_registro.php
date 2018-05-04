<?php
include_once "../../../clases/usuarios.php";
include_once "../../../clases/fotos.php";
include_once "../../../clases/bd.php";
$metodo=filter_input(INPUT_POST,"metodo");
if(!$metodo)
	return;
$metodo();

function registrar(){	
	$usuario=new usuario();
	$bd=new bd();
	$foto=new fotos();
	$seudonimo = filter_input (INPUT_POST, "seudonimo" );
	if ($bd->valueExist ( $usuario->a_table, $seudonimo, "seudonimo" )) {
		$fields ["seudonimo"] = "El seudonimo no esta disponible";
	}
	$email = filter_input(INPUT_POST, "email" );
	if ($bd->valueExist ($usuario->a_table, $email, "email" )) {
		$fields ["email"] = "El email no esta disponible";
	}
	$password = filter_input ( INPUT_POST, "password" );
	$descripcion = filter_input ( INPUT_POST, "descripcion" );
	if ($descripcion == "") {
		$descripcion = NULL;
	}
	$nombres = filter_input (INPUT_POST, "e_nombres" );
	$apellidos = filter_input (INPUT_POST, "e_apellidos" );
	$regiones_id = filter_input (INPUT_POST, "e_regiones_id" );
	$direccion = filter_input (INPUT_POST, "e_direccion" );
	$genero = filter_input (INPUT_POST, "e_genero" );
	$dianac = filter_input(INPUT_POST,"dia");
    $mesnac = filter_input(INPUT_POST,"mes");
    $agnonac = filter_input(INPUT_POST,"agno");
	if (isset ( $fields )) {
		echo json_encode ( array (
				"result" => "error",
				"fields" => $fields 
		) );
		exit();
	}
	$usuario->datosUsuario ($nombres, $apellidos, $regiones_id, $direccion, $genero, $dianac, $mesnac,$agnonac);
	$usuario->datosAcceso ($seudonimo, $email, $password );
	$usuario->datosStatus ();
	$valores=array(
		"nombres"=>$nombres,
		"apellidos"=>$apellidos,
		"regiones_id"=>$regiones_id,
		"direccion"=>$direccion,
		"genero"=>$genero,
		"dia_nac"=>$dianac,
        "mes_nac"=>$mesnac,
        "agno_nac"=>$agnonac
	);
	$bd->doInsert("usuarios",$valores);
    $nuevoId=$bd->lastInsertId();
	$hash = hash("sha256", $password);
	$bd->doInsert("usuariosxstatus",array("fecha"=>date("Y-m-d H:i:s",time()),"status_usuarios_id"=>1,"usuarios_id"=>$nuevoId));
	$bd->doInsert("usuarios_accesos",array("usuarios_id"=>$nuevoId,"password"=>$hash,"email"=>$email,"seudonimo"=>$seudonimo));
	$foto->crearFotoUsuario($nuevoId, filter_input(INPUT_POST,"foto"));
	$usuario->ingresoUsuario(array(
			"seudonimo" => filter_input ( INPUT_POST, "seudonimo" )
	), filter_input ( INPUT_POST, "password" ) );
	echo json_encode ( array (
			"result" => "ok" 
	) );	
}