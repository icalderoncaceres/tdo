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
	include "paginas/index/p_index.php";
	?>
</section>
<section class="col-xs-12 col-sm-12 col-md-4 col-lg-2" id="derecha" name="derecha">
	<?php
		include "fcn/f_chat.php";
	?>
</section>
<!--
<section class="col-xs-12 center-block text-center hidden" id="youtube-section" name="youtube-section">
	<div class="col-xs-12 col-sm-3">Cultura</div>
	<div class="col-xs-12 col-sm-3">Deportes</div>
	<div class="col-xs-12 col-sm-3">Educaci&oacute;n</div>
	<div class="col-xs-12 col-sm-3">Tecnolog&iacute;a</div>
</section>
-->
<section class="col-xs-12">
	<?php
		if(isset($_SESSION["id"])){
			if(strtoupper($_SESSION["seudonimo"])=="ICALDERON")
				include "paginas/index/p_redes.php";
		}
	?>
</section>
<?php include "temas/footer.php";?>
</div>
<?php	
	include "modales/m_registrar.php";
?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>