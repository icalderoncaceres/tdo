<?php
session_start();
if(!isset($_SESSION["id"])):
	header("Location: ../index.php");
endif;
include_once '../clases/bd.php';
$bd=new bd();
$result=$bd->doSingleSelect("employer","usuarios_id={$_SESSION["id"]}");
if(empty($result)):
    	header("Location: ../index.php");
endif;
include 'fcn/incluir-css-js.php';
?>
<script type="text/javascript" src="js/index.js"></script>
<!DOCTYPE html>
<html lang="es">
<body>
<?php
	include "temas/header.php";
?>
<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12" data-ng-app="apIndex">
	<?php
		include "paginas/index/p_seguridad.php";
	?>
</section>    
<?php include "temas/footer.php";?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>