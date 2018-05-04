<?php
session_start();
if(!isset($_SESSION["id"])):
	header("Location: index.php");
endif;
include_once 'clases/usuarios.php';
include_once 'clases/bd.php';
$usua=new usuario($_SESSION["id"]);
$status=$usua->getStatusReservacion();
$leccion=$status!=-1?$usua->getLeccion():3;
$bd=new bd();
include "fcn/incluir-css-js.php";
$bd->doInsert("trafico",array("usuarios_id"=>$_SESSION["id"],"pagina"=>7,"fecha"=>date("Y-m-d H:i:s",time())));
?>
<!DOCTYPE html>
<html lang="es">
<body class="pad-body" style="margin-top:2px;">
<?php
	include "temas/ingles-header.php";
?>
<section class="col-xs-12 col-sm-8 col-md-8 col-lg-9 center-block" style="padding-left:15%;" id="center" name="center" data-status="<?php echo $status;?>" data-leccion="<?php echo $leccion;?>">
	<?php
		include "paginas/zonaingles/p_menu-inicio.php"
	?>
</section>
<section class="col-xs-12 col-sm-4 col-md-4 col-lg-3" id="api-traslate" style="padding-left:1%">
	<br><br><br>
	<div class="col-xs-12">
		<textarea id="txt-traslate" name="txt-traslate" class="form-textarea" placeholder="put o select text for traslate" rows="3"></textarea>
	</div>
	<div class="col-xs-offset-10">
		<button class="btn btn-primary" id="btn-go-traslate" name="btn-go-traslate">Go</button>
	</div>
	<div class="col-xs-12 text-justify" id="google-texto" name="google-texto">
		<div class="jumbotron hidden" id="traslate-aviso" name="traslate-aviso">
		   <div class="container">
			  <h3>Puedes acceder al traducctor adquiriendo nuestro servicio, f&aacute;cil, barato, entretenido y desde la comodidad de tu casa</h3>
			  <p class="text-center"><a class="btn btn-primary btn-lg" role="button" href="zonaingles.php#planes">
				 ¿Como adquirir el servicio?</a>
			  </p>
		   </div>
		</div> 	
		<div class="jumbotron hidden" id="traslate-aviso2" name="traslate-aviso2">
		   <div class="container">
			  <h3>En est&eacute; momento estamos realizando una actualizaci&oacute;n necesaria de est&aacute; plataforma para ofrecerte un gr&aacute;n servicio que nos tardara
				 un par de d&iacute;as pedimos disculpas</h3>
		   </div>
		</div> 		
	</div>
</section>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script src="js/zonaingles.js"></script>
</body>
</html>