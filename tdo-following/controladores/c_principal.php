<?php
$metodo=filter_input(INPUT_POST,"metodo");
if(!$metodo){
    echo "Vacio";
    return;
}
include_once '../../clases/bd.php';
$metodo();
function getValores($pagina=1,$campos="*"){
    $bd=new bd();
    $pagina=filter_input(INPUT_POST,"pagina")?filter_input(INPUT_POST,"pagina"):$pagina;
    $inicio=($pagina-1)*50;
    $tabla=filter_input(INPUT_POST,"tabla");
    $condicion=filter_input(INPUT_POST,"condicion")?" where " . filter_input(INPUT_POST,"condicion"):"";
    $campos=filter_input(INPUT_POST,"campos")?filter_input(INPUT_POST,"campos"):$campos;
    $result=$bd->query("select $campos from $tabla $condicion order by fecha desc limit 50 OFFSET $inicio");
    $devolver=array();
    foreach($result as $r){
        $devolver[]=$r;
    }
    echo json_encode(array("records"=>$devolver));
}
function changeStatus(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");
    $status=filter_input(INPUT_POST,"status");
    $tabla=  filter_input(INPUT_POST,"tabla");
    $result=$bd->query("update $tabla set status=$status where id=$id");
    echo json_encode(array("result"=>$result));
}
function addArticulo(){
    $bd=new bd();
    $valores=array("titulo"=>filter_input(INPUT_POST,"titulo"),
                   "descripcion"=>filter_input(INPUT_POST,"descripcion"),
                   "ruta"=>filter_input(INPUT_POST,"ruta"),
                   "status"=>1
                   );
    $result=$bd->doInsert("articulos",$valores);
    if($result){
        $ultimoId=$bd->lastInsertId();
        echo json_encode(array("result"=>"ok","id"=>$ultimoId));
    }else{
        echo json_encode(array("result"=>"error"));
    }
}
function getEmployer(){
    $bd=new bd();
    if(!isset($_SESSION))
        session_start();
    $id=$_SESSION["id"];
    $result=$bd->doSingleSelect("employer","usuarios_id=$id","id,nombres,apellidos,telefonos,direccion,email,observaciones,usuarios_id");
    $result["password"]="";
    $result["password2"]="";
    echo json_encode(array("employer"=>$result));
}
function updateEmployer(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");
    if(!$id){
        echo json_encode(array("result"=>"desconocido"));
    }else{        
        $valores=array("nombres"=>filter_input(INPUT_POST,"n"),
                       "apellidos"=>filter_input(INPUT_POST,"a"),
                       "direccion"=>filter_input(INPUT_POST,"d"),
                       "telefonos"=>filter_input(INPUT_POST,"t"),
                       "email"=>filter_input(INPUT_POST,"e"),            
                       "password"=>hash("sha256",filter_input(INPUT_POST,"p")),
                       "observaciones"=>filter_input(INPUT_POST,"o"),
                       );
        $result=$bd->doUpdate("employer",$valores,"id=$id");
        if($result){
            echo json_encode(array("result"=>"ok"));
        }else{
            echo json_encode(array("result"=>"error"));
        }
    }
}
function setRecurso(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");
    if(!isset($_SESSION))
        session_start();
    $usuarios_id=$_SESSION["id"];
    $result=$bd->doUpdate("recursos", array("employer_id"=>$usuarios_id), "id=$id");
    if($result){
        echo json_encode(array("result"=>"ok"));
    }else{
        echo json_encode(array("result"=>"error"));
    }
}
function unsetRecurso(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");
    $result=$bd->doUpdate("recursos",array("employer_id"=>null,"status"=>0),"id=$id");
    if($result){
        echo json_encode(array("result"=>"ok"));
    }else{
        echo json_encode(array("result"=>"error"));
    }
}
function checkRecurso(){
    $bd=new bd();
    $areas_id=filter_input(INPUT_POST,"areas_id");
    $tipos_id=filter_input(INPUT_POST,"tipos_id");
    $titulo=filter_input(INPUT_POST,"titulo");
    $descripcion=filter_input(INPUT_POST,"descripcion");
    $id=filter_input(INPUT_POST,"id");	
    $ruta=filter_input(INPUT_POST,"ruta");	
    $vinculo=filter_input(INPUT_POST,"vinculo");		
    $valores=array("status"=>1,"areas_id"=>$areas_id,"tipos_id"=>$tipos_id,"titulo"=>$titulo,"descripcion"=>$descripcion,"ruta"=>$ruta,"vinculo"=>$vinculo);
    $result=$bd->doUpdate("recursos",$valores,"id=$id");
    if($result==1){
		echo "ok";
    }else{
		echo "error";
    }
}