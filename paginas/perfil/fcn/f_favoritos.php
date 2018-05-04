<?php
include_once "../../../clases/amigos.php";
include_once "../../../clases/bd.php";
session_start();
$amigos = new amigos();
$bd = new bd();
$id = $_GET["id"];
if(filter_input(INPUT_GET, "action") == "like"){
	$amigos->nuevoFavorito(date("Y-m-d",time()), $_SESSION["id"], $id);
	$amigos->nuevoAmigo(date("Y-m-d",time()), $_SESSION["id"], $id);
//	$amigos->setNotificacion(3,$id,$_GET["pana"]);
	echo json_encode(array("result" => "OK"));
} else {
	$amigos->borrarFavorito($_SESSION["id"], $id);
	$amigos->borrarAmigo($_SESSION["id"], $id);
	echo json_encode(array("result" => "OK"));
}
?>