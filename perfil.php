<?php
if (!isset ( $_GET ["u"] )) {
	header ( "Location: index.php" );
}
// Incluimos las clases a usar.
include 'clases/usuarios.php';
include_once 'clases/fotos.php';
include 'clases/amigos.php';
$foto=new fotos();
if(!isset($_SESSION["id"])){
	session_start();
	$act_usu="";	
}else{
	$act_usu=$_SESSION["id"];
	$usua=new usuario($act_usu);
}	
if(isset($_GET["new"])){
	$_SESSION["fotoperfil"]=$foto->buscarFotoUsuario($_SESSION["id"]);
//	var_dump($_SESSION["fotoperfil"]);
}
?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="css/magnific-popup.css"/>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<link rel="stylesheet" href="js/cropit/cropit.css">
<body class="pad-body">
<?php include "temas/header.php";?>
<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php include "paginas/perfil/p_perfil_header.php"; ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
			id="ajaxContainer">			
			<?php
				if(!isset($_GET["t"])){
					if($_SESSION["seudonimo"]==$_GET["u"])
					//include "paginas/perfil/p_newsfeed.php";	
					//else
					include "paginas/perfil/p_perfil_listado.php";
				}else{
					include "paginas/perfil/p_perfil_amigos2.php";
				} 
			?>	
		</div>
	</div>
<?php include "temas/footer.php";?>
<?php include 'modales/m_cropper.php';?>
<?php include 'modales/m_info_social.php';?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
<script type="text/javascript" src="js/jquery.magnific-popup.js"></script>
<script type="text/javascript" src="js/perfil.js" async></script>
</html>
