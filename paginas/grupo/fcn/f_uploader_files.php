<?php
include_once "../../../clases/bd.php";
$bd=new bd();
$c=0;
while(true){
    $id=filter_input(INPUT_GET,"ids" . $c);
    if(!$id){
        $t=$c;
        break;
    }
//    if($_FILES["file" . $c]["name"]!="filename.txt"){
        $archivo=explode(".", $_FILES["file" . $c]["name"]);
        $extension=end($archivo);
        $destino="../../../uploads/items/" . $id . "." . $extension;
        copy($_FILES["file" . $c]["tmp_name"],$destino);
        $bd->doUpdate("entradas_capitulos", array("archivo"=>$id . "." . $extension),"id=$id");
//    }     
    $c++;
}
var_dump($_FILES);