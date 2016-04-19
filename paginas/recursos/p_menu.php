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
	<center><h2>RECURSOS EDUCATIVOS</h3></center>
	<hr>
	<article class="t18">
			<p>Un parrafo de cuatro lineas explicando el objetivo, la estructura, el fin que persigue y todo lo referente al modulo de recursos educativos,
			se debe redactar bien para que se entienda y genere interes</p>
	</article>
	<hr>
	<div class="contenedor pad20">
		<div class="col-sm-9 col-md-9 col-lg-9">Foros</div>
		<div class="col-sm-1 col-md-1 col-lg-1">Recursos</div>
		<div class="col-sm-1 col-md-1 col-lg-1">Visitas</div>
		<div class="col-sm-1 col-md-1 col-lg-1">Descargas</div>
		<div class="row pad10">
			<?php
			$bandera=true;
			foreach($areas as $area=>$valor):
				$fondo=$bandera?"fondo1":"fondo2";
				$bandera=!$bandera;
				$are=new areas($valor['id']);
				?>
				<div class="vinculos-areas <?php echo $fondo;?>" data-area="<?php echo $valor['id'];?>">
				<a href="#">
					<div class="col-sm-9 col-md-9 col-lg-9"><span><?php echo utf8_encode($valor["nombre"]);?></span></div>
					<div class="col-sm-1 col-md-1 col-log-1"><center><span><?php echo $are->countRecursos();?></center></span></div>
					<div class="col-sm-1 col-md-1 col-log-1"><center><span><?php echo $are->countVisitasRecursos();?></center></span></div>
					<div class="col-sm-1 col-md-1 col-log-1"><center><span><?php echo $are->countDescargas();?></center></span></div>
				</a></div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</div>