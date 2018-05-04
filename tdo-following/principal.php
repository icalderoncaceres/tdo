<?php
session_start();
if(!isset($_SESSION["id"])):
	header("Location: ../index.php");
endif;
if(!isset($_SESSION["employer_id"])):
	header("Location: index.php");
endif;
include 'fcn/incluir-css-js.php';
?>
<script type="text/javascript" src="js/principal.js"></script>
<!DOCTYPE html>
<html lang="es">
<body data-ng-app="apPrincipal">
<?php
	include "temas/header.php";
?>
<div class="hidden-xs hidden-sm col-md-1 col-lg-1"></div>
<aside class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
    <?php
        include "temas/menu-left.html";
    ?>
</aside>    
<section class="col-xs-12 col-sm-10 col-md-9 col-lg-9" data-ng-view="">
    
</section>
<?php include "modales/m_verificar_recurso.php"; ?>
<div id="load-ajax" class="modal-backdrop fade in cargador" style="visibility:hidden"></div>
</body>
</html>