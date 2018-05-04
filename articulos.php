<?php
include "fcn/incluir-css-js.php";
?>
<!DOCTYPE html>
<html lang="es">
<body class="pad-body">
<?php
	include "temas/header.php";
?>
<div style="margin-top: -25px;margin-bottom:10px;"><?php include 'paginas/index/apdp-principal.php'; ?></div>
<div id="grupo" name="grupo">
<section class="col-xs-12 col-sm-12 col-md-8 col-lg-10 center-block" style="padding-left:15%;padding-rigth:10%;" id="centro" name="centro">
	<?php
	include "paginas/articulos/p_listado.php";
	?>
</section>
<section class="col-xs-12 col-sm-12 col-md-4 col-lg-2" id="derecha" name="derecha">
	<?php
            include "fcn/f_chat.php";
	?>
</section>
</div>
<?php	
	include "modales/m_registrar.php";
	if(isset($_SESSION["id"]))
        include "modales/m_recomendar.php";
?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>

<script src="js/articulos.js"></script>
</body>
</html>