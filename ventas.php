
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<!-- include adicional (editor) debe ir antes del body -->
<body>
<?php include "temas/header.php";?>
<div class="container">	
	<div class="row">
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
		<?php include "temas/menu-left-usr.php";?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ">
		<div class="marL20"><?php include "paginas/venta/p_edit_publicaciones.php";?></div>
	</div>
	</div>
</div>
<?php include "modales/m_edit_publicacion.php";?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>
