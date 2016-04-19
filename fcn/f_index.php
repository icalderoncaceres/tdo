<?php
include_once "../clases/ventanachat.php";
include_once "../clases/bd.php";
include_once "../clases/usuarios.php";
switch($_POST["metodo"]){
	case "buscarRegiones":
                buscaRegiones();
		break;
	case "abrirChat":
		abrirChat();
		break;
        case "guardarMensaje":
                guardaMensaje();
                break;
}
function buscaRegiones(){
	$bd=new bd();
	$condicion="paises_id={$_POST["pais"]}";
	$result=$bd->doFullSelect("regiones",$condicion);
	$devolver="<select id='e_regiones_id' name='e_regiones_id'>";
	foreach($result as $r => $valor){
		$devolver.="<option value={$valor["id"]}>" . utf8_decode($valor["nombre"]) . "</option>";
	}
	$devolver.="</select>";
	echo $devolver;
}
function abrirChat(){
	if(!isset($_SESSION))
	session_start();
	$chat=new ventanachat($_SESSION["id"],$_POST["id"]);
}
function guardaMensaje(){
        $bd=new bd();
        if(!isset($_SESSION))
            session_start();
        $tiempo = date("Y-m-d H:i:s",time());
        $valores=array("usuarios_id"=>$_SESSION["id"],
                       "amigos_id"=>$_POST["amigo"],
                       "mensaje"=>$_POST["mensaje"],
                       "fecha"=>$tiempo,
                       );
        $result=$bd->doInsert("mensajes",$valores);
}
?>