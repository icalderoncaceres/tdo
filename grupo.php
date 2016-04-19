<?php
include "fcn/varlogin.php";
include "fcn/incluir-css-js.php";
?>
<!DOCTYPE html>
<html lang="es">
<body>
<?php
	include "temas/header.php";
?>
<div>
	<section class="col-xs-12 col-sm-12 col-md-8 col-lg-10 center-block" style="padding-left:15%;padding-rigth:10%;" id="centro" name="centro">
		<?php
		include "paginas/grupo/p_muro.php";
		?>
	</section>
	<section class="col-xs-12 col-sm-12 col-md-4 col-lg-2" id="derecha" name="derecha">
		<?php
	            include "fcn/f_chat.php";
		?>
	</section>
	<?php include "temas/footer.php";?>
</div>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script src="js/grupo.js"></script>
</body>
</html>