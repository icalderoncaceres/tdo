<?php
include_once "clases/bd.php";
include "fcn/incluir-css-js.html ";
$bd=new bd();
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
		if(!isset($_SESSION))
			session_start();
		if(!isset($_SESSION["id"])){
			include "paginas/zonaingles/p_sinsession.php";
			$bd->doInsert("trafico",array("usuarios_id"=>-1,"pagina"=>8,"fecha"=>date("Y-m-d H:i:s",time())));
		}else{
			$bd=new bd();
			$result=$bd->query("select paises_id from regiones where id in (select regiones_id from usuarios where id={$_SESSION["id"]})");
			$result=$result->fetch();
			$pais=$result["paises_id"];
			$pagina="paginas/zonaingles/p_inicio_" . $pais . ".php";
			include $pagina;
			$bd->doInsert("trafico",array("usuarios_id"=>$_SESSION["id"],"pagina"=>6,"fecha"=>date("Y-m-d H:i:s",time())));
		}
	?>
</section>
<section class="col-xs-12 col-sm-12 col-md-4 col-lg-2" id="derecha" name="derecha">
	<?php
        include "fcn/f_chat.php";
	?>
</section>
</div>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script src="js/zonaingles.js"></script>
</body>
</html>