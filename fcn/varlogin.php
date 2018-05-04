<?php
/*codigo estandar para validar que se inicie session*/
/*REQUERIDO EN TODAS LAS PAGINAS RESTRINGIDAS*/
session_start();
if(!isset($_SESSION["id"])):
	header("Location: index.php");
endif;