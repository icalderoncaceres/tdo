<?php
/*Destruimos la sesion al llamar a esta pagina*/
session_start ();
if (isset ( $_SESSION ["id"] )):
	session_destroy ();
	header("Location: index.php");
else:
	header("Location: index.php");
endif;
if(isset($_COOKIE["c_id"])){
	setcookie("c_id","",-1000,'/');
	setcookie("c_seudonimo","",-1000,'/');
	setcookie("c_fotoperfil","",-1000,'/');
}