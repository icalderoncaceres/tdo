<?php
    session_start();
    $archivo=explode(".", $_FILES["file"]["name"]);
    $extension=end($archivo);
    $destino="../../../uploads/" . $_SESSION["id"] . "DOS" . time() . "." . $extension;
    $copiado=copy($_FILES["file"]["tmp_name"],$destino);
	$destino="uploads/" . $_SESSION["id"] . "DOS" . time() . "." . $extension;
    if($copiado){
        echo json_encode(array("result"=>"ok","name"=>$destino));
    }else{
        echo json_encode(array("result"=>"error"));
    }