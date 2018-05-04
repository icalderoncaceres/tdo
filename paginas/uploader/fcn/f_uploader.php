<?php
include_once '../../../clases/bd.php';
$metodo=filter_input(INPUT_POST,"metodo");
if($metodo){
    $metodo();
}

function guardarMensaje(){
    $bd=new bd();
    if(!isset($_SESSION)){
        session_start();
    }
    $mensaje=filter_input(INPUT_POST,"mensaje");
    $tiempo=date("Y-m-d H:i:s",time());
    $result=$bd->doInsert("mensajes_contactos", array("mensaje"=>$mensaje,"usuarios_id"=>$_SESSION["id"],"fecha"=>$tiempo));
    if($result){
        echo json_encode(array("result"=>"ok"));
    }else{
        echo json_encode(array("result"=>"error"));
    }
}

function guardarRecurso(){
    $bd=new bd();
    if(!isset($_SESSION)){
        session_start();
    }
//    copy($_FILES["txt-file"]["tmp_name"],$_FILES["txt-file"]["name"]);
    $mensaje=filter_input(INPUT_POST,"txt-mensaje");
    $tiempo=date("Y-m-d H:i:s",time());
    $result=$bd->doInsert("mensajes_contactos", array("mensaje"=>$mensaje,"usuarios_id"=>$_SESSION["id"],"fecha"=>$tiempo));
    if($result>0){
        $nuevoID=$bd->lastInsertId();
        $valores=array("titulo"=>filter_input(INPUT_POST,"txt-titulo"),
                       "descripcion"=>filter_input(INPUT_POST,"descripcion"),
                       "scope"=>filter_input(INPUT_POST,"txt-scope"),
                       "areas_id"=>-1,
                       "tipos_id"=>-1,
                       "usuarios_id"=>$_SESSION["id"],
                       "ruta"=>filter_input(INPUT_POST,"filename")?filter_input(INPUT_POST,"filename"):NULL,
                       "fecha"=>$tiempo,
                       "status"=>0,
                       "formatos_id"=>filter_input(INPUT_POST,"cmb-formato"),
                       "vinculo"=>filter_input(INPUT_POST,"txt-vinculo")?filter_input(INPUT_POST,"txt-vinculo"):NULL,
                       "mensajes_contactos_id"=>$nuevoID
                      );
        $result+=$bd->doInsert("recursos",$valores);
        if($result>1){
            echo json_encode(array("result"=>"ok"));
        }else{
            echo json_encode(array("result"=>"error"));
        }
    }else{
        echo json_encode(array("result"=>"error"));
    }
}