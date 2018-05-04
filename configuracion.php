<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php");
?>
<body>
<?php
include ("temas/header.php");
?>
<div class="container">
	<div class="hidden-xs col-sm-12 col-md-2 col-lg-2">

	</div>
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<?php include("paginas/configuracion/p_confi_datos.php"); ?>
	</div>
	<div class="hidden-xs col-sm-12 col-md-2 col-lg-2">

	</div>    
</div>
<?php
include ("temas/footer.php");
include ("modales/m_edit_info_personal_n.php");
include ("modales/m_edit_info_seudonimo.php");
include ("modales/m_edit_info_correo.php");
include ("modales/m_edit_info_pass.php");
?>
<script type="text/javascript" src="js/configuracion.js"></script>
</body>
</html>