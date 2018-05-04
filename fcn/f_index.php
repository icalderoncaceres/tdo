<?php
include_once "../clases/ventanachat.php";
include_once "../clases/bd.php";
include_once "../clases/usuarios.php";
include_once "../clases/eventos.php";
$metodo=filter_input(INPUT_POST,"metodo");
switch($metodo){
	case "buscarRegiones":
                buscaRegiones();
		break;
	case "abrirChat":
		abrirChat();
		break;
        case "guardarMensaje":
                guardaMensaje();
                break;
        case "recomendar":
                recomienda();
}
function buscaRegiones(){
	$bd=new bd();
        $pais=  filter_input(INPUT_POST,"pais");
	$condicion="paises_id=$pais";
	$result=$bd->doFullSelect("regiones",$condicion);
	$devolver="<select class='form-select' id='e_regiones_id' name='e_regiones_id'>";
	foreach($result as $valor ){
		$devolver.="<option value={$valor["id"]}>" . utf8_encode($valor["nombre"]) . "</option>";
	}
	$devolver.="</select>";
	echo $devolver;
}
function abrirChat(){
        $id=filter_input(INPUT_POST,"id");
	if(!isset($_SESSION)){
            session_start();
        }
	$chat=new ventanachat($_SESSION["id"],$id);
}
function guardaMensaje(){
        $bd=new bd();
        $amigo=  filter_input(INPUT_POST,"amigo");
        $mensaje=  filter_input(INPUT_POST,"mensaje");
        if(!isset($_SESSION)){
            session_start();
        }
        $tiempo = date("Y-m-d H:i:s",time());
        $valores=array("usuarios_id"=>$_SESSION["id"],
                       "amigos_id"=>$amigo,
                       "mensaje"=>$mensaje,
                       "fecha"=>$tiempo,
                       );
        $bd->doInsert("mensajes",$valores);
}
function recomienda(){
    $evento=new eventos();
    $mensaje=filter_input(INPUT_POST,"mensaje");
    $tipo=filter_input(INPUT_POST,"tipo");
    $evento_id=filter_input(INPUT_POST,"evento");
    $grupos=filter_input(INPUT_POST,"grupos");
    if(!isset($_SESSION)){
        session_start();
    }
    $valores=array("mensaje"=>$mensaje,
                   "usuarios_id"=>$_SESSION["id"],
                   "eventos_tipos_id"=>$tipo,
                   "fecha"=>date("Y-m-d H:i:s",time()),
                   "evento_id"=>$evento_id,
                   "grupos"=>$grupos,
                   "status"=>1
                   );
    $result=$evento->nuevoEvento($valores);
    echo $result;
}
?>