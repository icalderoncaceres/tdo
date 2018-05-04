<?php
$metodo=filter_input(INPUT_POST,"metodo");
if(!$metodo){
    echo "Vacio";
    return;
}
include_once '../../clases/bd.php';
$metodo();
function ingresar(){
    $bd=new bd();
    if(!isset($_SESSION)){
        session_start();
    }
    $id=$_SESSION["id"];
    $password=filter_input(INPUT_POST,"password");
    $hash = hash ( "sha256", $password );
    $result=$bd->doSingleSelect("employer","usuarios_id=$id and password='$hash'");
    if(!$result){
        echo json_encode(array("result"=>"0"));
    }else{
        echo json_encode(array("result"=>"1"));
        $_SESSION["employer_id"]=$result["id"];
    }
}