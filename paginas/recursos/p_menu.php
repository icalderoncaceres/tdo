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
$areas=$bd->doFullSelect("areas","status=1");
if(!isset($_SESSION))
	session_start();
if(isset($_SESSION["id"])){
	$bd->doInsert("trafico",array("usuarios_id"=>$_SESSION["id"],"pagina"=>3,"fecha"=>date("Y-m-d H:i:s",time())));
}else{
	$bd->doInsert("trafico",array("usuarios_id"=>-1,"pagina"=>3,"fecha"=>date("Y-m-d H:i:s",time())));
}
?>
<div id="ajaxContainer" name="ajaxContainer">
	<center><h2>RECURSOS EDUCATIVOS</h3></center>
	<hr>
	<article class="t20 text-justify">
		<p>En esta secci&oacute;n cualquier persona puede expresar su creatividad compartiendo recursos educativos
                   que son disfrutados en forma gratuita por los miembros de nuestra comunidad, los mismos pueden ser
                   videotutoriales, canciones, juegos educativos, producciones escritas, actividades digitalizadas o de cualquier 
                   otro tipo, la informaci&oacute;n que aparece en dichos recursos ser&aacute; validada por nuestro equipo de expertos,
                   lo cual garantiza la confiabilidad de sus contenidos. Si deseas aportar al conocimiento tu recurso educativo por favor 
                   hacerlo llegar por el vinculo de <a href="uploader.php">contacto</a> que aparece en la barra superior, si deseas 
                   disfrutar de los recursos disponibles selecciona el &aacute;rea en la lista a continuaci&oacute;n.
                </p>
	</article>
	<hr>
	<div class="contenedor pad20">
		<div class="col-sm-9 col-md-9 col-lg-9">Área</div>
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