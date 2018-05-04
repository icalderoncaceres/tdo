<?php
include_once '../clases/fotos.php';
include_once '../clases/usuarios.php';
include_once '../clases/bd.php';
$method=filter_input(INPUT_POST,"method");
switch ($method) {
	case "new" :
		newUser ();
		break;
	case "log" :
		logUser ();
		break;
	case "fot" :
		fotUser ();
		break;
	case "get" :
		getUser ();
		break;
	case "act-social" :
		actSocial ();
		break;
	case "act-email":
		actEmail();
		break;
	case "act-seudonimo":
		actSeudonimo();
		break;
	case "act-pass":
		actPass();
		break;
        case "act-nat":
                actNat();
                break;
	default :
		echo "error";
		break;
}
function getUser() {
	session_start();
	$usuario = new usuario ( $_SESSION ["id"] );
	$reflection = new ReflectionObject ( $usuario );
	$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
	foreach ( $properties as $property ) {
		$name = $property->getName ();
		$valores [$name] = $usuario->$name;
	}
	echo json_encode ( array (
			"result" => "OK",
			"campos" => $valores
	) );
}
function actPass(){
	session_start();
	$usuario = new usuario($_SESSION["id"]);
	$bd = new bd ();
	$password = filter_input(INPUT_POST, "password_act");
	$hash = hash ( "sha256", $password );
	$condicion = "usuarios_id = {$_SESSION["id"]} AND password = '$hash'";
	$result = $bd->doSingleSelect("usuarios_accesos",$condicion);
	if(!empty($result)){
		$newhashpass = hash ( "sha256", filter_input(INPUT_POST, "password") );
		$bd->doUpdate("usuarios_accesos", array("password" => $newhashpass), "usuarios_id = {$_SESSION["id"]}");
		echo json_encode ( array (
				"result" => "OK"
		) );
	}else{
		echo json_encode ( array (
				"result" => "error"
		) );
	}
}
function actEmail(){
	session_start();
	$usuario = new usuario($_SESSION["id"]);
	$bd = new bd ();
	$values = array (
			"email" => filter_input ( INPUT_POST, "email" )			
	);
	if($usuario->a_email == $values["email"]){
		echo json_encode ( array (
				"result" => "OK"
		) );		
	}else {
		if ($bd->valueExist ( "usuarios_accesos", $values['email'], "email" )) {
			echo json_encode ( array (
					"result" => "error",
					"fields" => array("email" => "Este correo electronico ya esta en uso")
			) );
		} else {
			$bd->doUpdate ( "usuarios_accesos", $values, "usuarios_id = {$_SESSION["id"]}" );
			echo json_encode ( array (
					"result" => "OK"
			) );
		}
	}
}
function actSeudonimo(){
	session_start();
	$usuario = new usuario($_SESSION["id"]);
	$bd = new bd ();
	$values = array (
			"seudonimo" => filter_input ( INPUT_POST, "seudonimo" )
	);
	if($usuario->a_seudonimo == $values["seudonimo"]){
		echo json_encode ( array (
				"result" => "OK"
		) );
	}else {
		if ($bd->valueExist ( "usuarios_accesos", $values['seudonimo'], "seudonimo" )) {
			echo json_encode ( array (
					"result" => "error",
					"fields" => array("seudonimo" => "Este seudonimo ya esta en uso")
			) );
		} else {
			$bd->doUpdate ( "usuarios_accesos", $values, "usuarios_id = {$_SESSION["id"]}" );
			echo json_encode ( array (
					"result" => "OK"
			) );
			$_SESSION["seudonimo"] = $values["seudonimo"];
		}
	}
}
function actSocial() {
	$bd = new bd ();
	$values = array (
			"descripcion" => filter_input ( INPUT_POST, "descripcion" ) ? NULL : filter_input ( INPUT_POST, "descripcion" ),
			"facebook" => filter_input ( INPUT_POST, "facebook" ) ? NULL : filter_input ( INPUT_POST, "facebook" ),
			"twitter" => filter_input ( INPUT_POST, "twitter" ) ? NULL : filter_input ( INPUT_POST, "twitter" ),
			"website" => filter_input ( INPUT_POST, "website" ) ? NULL : filter_input ( INPUT_POST, "website" )
	);
        /*        
	$values = array (
			"descripcion" =>filter_input(INPUT_POST,descripcion),
			"facebook" => $_POST["facebook"],
			"twitter" => $_POST["twitter"],
			"website" => $_POST["website"]
	);
         */
        if(!isset($_SESSION)){
            session_start();
        }
	if ($bd->doUpdate ( "usuarios", $values, "id = {$_SESSION["id"]}" )) {
		echo "OK";
	} else {
		echo "error";
	}
}
function fotUser() {
	$foto = new fotos ();
	session_start();
	if ($foto->updateFoto ( filter_input ( INPUT_POST, "ruta" ), filter_input ( INPUT_POST, "foto" ), $_SESSION["id"] )) {
		echo json_encode ( array (
				"result" => "OK" 
		) );
	} else {
		echo json_encode ( array (
				"result" => "error" 
		) );
	}
}
function logUser() {
	$usuario = new usuario ();
	$bd = new bd ();
	$login = filter_input ( INPUT_POST, "log_usuario" );
	$password = filter_input ( INPUT_POST, "log_password" );
	if ($bd->valueExist ( $usuario->a_table, $login, "seudonimo" )) {
		$id = $usuario->ingresoUsuario ( array (
				"seudonimo" => $login 
		), $password );
		if (empty ( $id )) {
			$fields ["log_password"] = "La contrase&ntilde;a es incorrecta";
		}
	} elseif ($bd->valueExist ( $usuario->a_table, $login, "email" )) {
		$id = $usuario->ingresoUsuario ( array (
				"email" => $login 
		), $password );
		if (empty ( $id )) {
			$fields ["log_password"] = "La contrase&ntilde;a es incorrecta";
		}
	} else {
		$fields ["log_usuario"] = "El usuario o el correo no estan registrados";
	}
	if (! empty ( $id )) {
		if($_POST["recordar"]=="SI"){
			setcookie("c_id",$_SESSION["id"],time()+864000,'/');
			setcookie("c_seudonimo",$_SESSION["seudonimo"],time()+864000,'/');
			setcookie("c_fotoperfil",$_SESSION["fotoperfil"],time()+864000,'/');
		}
		echo json_encode ( array (
			"result" => "OK" 
		) );
		exit ();
	}
	if (isset ( $fields )) {
		echo json_encode ( array (
				"result" => "error",
				"fields" => $fields 
		) );
		exit ();
	}
}
function newUser() {
	$usuario = new usuario ();
	$foto = new fotos ();
	$bd = new bd ();
	
	if (filter_input(INPUT_POST,"type")) {
		$seudonimo = filter_input ( INPUT_POST, "seudonimo" );
		if ($bd->valueExist ( $usuario->a_table, $seudonimo, "seudonimo" )) {
			$fields ["seudonimo"] = "El seudonimo no esta disponible";
		}
		$email = filter_input ( INPUT_POST, "email" );
		if ($bd->valueExist ( $usuario->a_table, $email, "email" )) {
			$fields ["email"] = "El email no esta disponible";
		}
		$password = filter_input ( INPUT_POST, "password" );
		$descripcion = filter_input ( INPUT_POST, "descripcion" );
		if ($descripcion == "") {
			$descripcion = NULL;
		}
		$nombres = filter_input ( INPUT_POST, "e_nombres" );
		$apellidos = filter_input ( INPUT_POST, "e_apellidos" );
		$regiones_id = filter_input ( INPUT_POST, "e_regiones_id" );
		$direccion = filter_input ( INPUT_POST, "e_direccion" );
		$genero = filter_input ( INPUT_POST, "e_genero" );
		$dianac = filter_input(INPUT_POST,"e_dia_nac");
        $mesnac = filter_input(INPUT_POST,"e_mes_nac");
        $agnonac = filter_input(INPUT_POST,"e_agno_nac");
		if (isset ( $fields )) {
			echo json_encode ( array (
					"result" => "error",
					"fields" => $fields 
			) );
			exit ();
		}
		$usuario->datosUsuario ( $nombres, $apellidos, $regiones_id, $direccion, $genero, $dianac, $mesnac,$agnonac);
		$usuario->datosAcceso ( $seudonimo, $email, $password );
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
		$bd->doInsert ( "usuarios",$valores);
        $nuevoId=$bd->lastInsertId();
		$hash = hash ( "sha256", $password );
		$bd->doInsert ( "usuariosxstatus",array("fecha"=>strtotime('now'),"status_usuarios_id"=>1,"usuarios_id"=>$nuevoId));
		$bd->doInsert ( "usuarios_accesos",array("usuarios_id"=>$nuevoId,"password"=>$hash,"email"=>$email,"seudonimo"=>$seudonimo));
//		$usuario->crearUsuario ($nuevoId);
//		$usuario->id=$nuevoId;
		$foto->crearFotoUsuario ( $nuevoId, filter_input(INPUT_POST,"foto"));
		$usuario->ingresoUsuario ( array (
				"seudonimo" => filter_input(INPUT_POST, "seudonimo" )),
				filter_input ( INPUT_POST, "password" ) );
		echo json_encode ( array (
				"result" => "ok" 
		) );
	}
}
function actNat() {
        session_start();
        $id=filter_input(INPUT_POST,"id");
        if(!$id){
                $usuario = new usuario($_SESSION["id"]);
                $actUsua=$_SESSION["id"];
        }else{
                $usuario = new usuario($id);
                $actUsua=$id;
        }
        $bd = new bd ();
        $values_usu = array(
                        "nombres" => filter_input ( INPUT_POST,"e_nombres"),
                        "apellidos" => filter_input ( INPUT_POST,"e_apellidos"),
                        "genero" => filter_input(INPUT_POST,"e_genero"),
                        "dia_nac" => filter_input(INPUT_POST,"e_dia_nac"),
                        "mes_nac" => filter_input(INPUT_POST,"e_mes_nac"),
                        "agno_nac" => filter_input(INPUT_POST,"e_agno_nac"),
                        "regiones_id" => filter_input(INPUT_POST,"e_regiones_id"),
                        "direccion" => filter_input ( INPUT_POST, "e_direccion" ),
        );
        $bd->doUpdate ( "usuarios", $values_usu, "id = $actUsua" );
        echo json_encode ( array (
                         "result" => "OK"
                         ) );
}