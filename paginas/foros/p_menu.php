<?php 
if (!headers_sent()) {
	header('Content-Type: text/html; charset=ISO-8859-15');
}
?>
<?php
if(file_exists("clases/bd.php")){
	include_once "clases/bd.php";
	include_once "clases/areas.php";
}else{
	include_once "../../clases/bd.php";
	include_once "../../clases/areas.php";
}
$bd=new bd();
$areas=$bd->doFullSelect("areas");
?>
<div id="ajaxContainer" name="ajaxContainer">
	<article class="t18 ">
		<hr>
		Hemos creado una serie de foros, con la finalidad de que todos los factores que intervienen en el &aacute;mbito educativo, asi como todos los miembros de la sociedad
		compartan informaci&oacute;n y experiencias que contribuyan a mejorar el proceso de ense&ntilde;anza aprendizaje.
		El buen uso de este espacio, el cumplimiento de las normas
		establecidas as&iacute; como el respeto a las opiniones de los dem&aacute;s foristas es necesario para el logro de los objetivos planteados.
		Mas cosas faltaaaaaa
		<hr>
	</article>
	<h3>FOROS</h3>
	<div class="contenedor pad20">
		<div class="row pad10">
			<div class="col-sm-10 col-md-10 col-lg-10">Foros</div>
			<div class="col-sm-1 col-md-1 col-lg-1">Temas</div>
			<div class="col-sm-1 col-md-1 col-lg-1">Aportes</div>
			<?php
			$bandera=true;
			foreach($areas as $area=>$valor):
				$fondo=$bandera?"fondo1":"fondo2";
				$bandera=!$bandera;
				$are=new areas($valor['id']);
				?>
				<div class="vinculos-areas <?php echo $fondo;?>" data-area="<?php echo $valor['id'];?>"><a href="#">
					<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10"><span><?php echo utf8_encode($valor["nombre"]);?></span></div>
					<div class="col-xs-12 col-sm-12 col-md-1 col-log-1"><center><span><?php echo $are->countTemas();?></center></span></div>
					<div class="col-xs-12 col-sm-12 col-md-1 col-log-1"><center><span><?php echo $are->countAportes();?></span></center></div>
				</a></div>
			<?php
			endforeach;
			?>
		</div><!--Cierre del div row-->
	</div>
</div>