<?php
	require_once("../../clases/bd.php");
	$db = new bd();
	session_start();
	
	$uid = $_SESSION['id'];
	$pid = $db->quote($_POST['id']);
	
	$tabla="publicaciones";
	$fields=array(
		"publicar_twitter"  => 1,
		"publicar_facebook" => 1,
		"publicar_fanpage"  => 1,
		"publicar_grupo"    => 1
	);

	
	if($db->doUpdate($tabla, $fields, " id=$pid AND usuarios_id=$uid ")) $return=array("e"=>0);
	else $return=array("e"=>1);
	echo json_encode($return);
?>