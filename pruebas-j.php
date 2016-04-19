<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<!-- include adicional (editor) debe ir antes del body -->
<link rel="stylesheet" href="js/htmledit/ui/trumbowyg.css">
<script type="text/javascript" src="js/htmledit/trumbowyg.min.js"></script>
<script type="text/javascript" src="js/htmledit/langs/es.min.js"></script>
<body>
<?php include "temas/header.php";?>
<div class="container">	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 conte1">
		<?php include "paginas/publicar/p_header.php";?>
		<div id="ajaxContainer">
			<?php include "paginas/publicar/p_publicar3.php"; ?>
		</div>	
		<div id="ajaxContainer2"></div>	
	</div>
</div>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script type="text/javascript" src="js/publicaciones.js"></script>
</body>
</html>

