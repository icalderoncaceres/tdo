﻿<?php 
if (!headers_sent()) {
	header('Content-Type: text/html; charset=ISO-8859-15');
}
include_once "../../clases/areas.php";
include_once "../../clases/recursos.php";
$area=new areas($_POST["area"]);
$recursos=$area->getRecursos($_POST["filtro"]);
if(!isset($_SESSION)){
	session_start();
}
$habilitado=!isset($_SESSION["id"])?$habilitado="No":$habilitado="Si";
?>
<div id="filas" name="filas" data-disponible="<?php echo $habilitado;?>">
	<center><h1>Recursos del &aacute;rea: <?php echo utf8_encode($area->nombre);?></h1></center>
	<?php
	if($recursos):
		foreach($recursos as $r=>$valor):
			$recurso=new recursos($valor["id_r"]);
			if(isset($_SESSION["id"])){
				$calificacion=$recurso->getCalificacion();
				if($calificacion==-1){
					$cal1="";
					$cal2="red";
				}elseif($calificacion==1){
					$cal1="red";
					$cal2="";
				}else{
					$cal1="";
					$cal2="";
				}
			}else{
				$cal1="";
				$cal2="";
			}
			?>
			<section class="contenedor t16" style="padding-right:2%;padding-left:2%">
				<div class="row pad10">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Titulo:<?php echo utf8_encode($valor["titulo"]);?></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Descripción:<?php echo utf8_encode($valor["des_r"]);?></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Colaborador:<?php echo " {$valor["nombres"]} {$valor["apellidos"]}";?> </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Fecha:<?php echo $valor["fecha"];?></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Visitas:<span id="totaVisitas<?php echo $valor["id_r"];?>" name="totaVisitas<?php echo $valor["id_r"];?>" data-total="<?php echo $valor["totaVisitas"];?>"><?php echo $valor["totaVisitas"];?></span></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Formato:<span><?php echo $recurso->getFormato();?></span></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Descargas:<span id="totaDescargas<?php echo $valor["id_r"];?>" name="totaDescargas<?php echo $valor["id_r"];?>" data-total="<?php echo $valor["totaDescargas"];?>"><?php echo $valor["totaDescargas"];?></div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">Comentarios: 
					<i class="fa fa-thumbs-up calificacion <?php echo $cal1;?>" style="cursor:pointer" data-id='<?php echo $valor["id_r"];?>' data-calificacion="1"></i> <span id="positivos<?php echo $valor["id_r"];?>"><?php echo $valor["totaPositivos"];?></span>
  				        <i class="fa fa-thumbs-down calificacion <?php echo $cal2;?>" style="cursor:pointer" data-id='<?php echo $valor["id_r"];?>' data-calificacion="-1"></i>
					<span id="negativos<?php echo $valor["id_r"];?>"><?php echo $valor["totaNegativos"];?></span> Total <span id="total<?php echo $valor["id_r"];?>"><?php echo $valor["totaPositivos"] + $valor["totaNegativos"];?></span></div>
					<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"><a href="ejecutar.php?ruta=<?php echo $valor["id_r"];?>" target="_blank" class="vistasdescargas" data-id="<?php echo $valor["id_r"]; ?>" data-metodo="ver" data-ruta="<?php echo $valor["ruta"];?>">Probar</a></div>
					<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"><a href="#" class="vistasdescargas" data-id="<?php echo $valor["id_r"]; ?>" data-metodo="descargar" data-ruta="<?php echo $valor["ruta"];?>">Descargar</a></div>
					<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"><a href="#" data-toggle="modal" data-target="#recomendar-recurso" class="recomendacion" data-id="<?php echo $valor["id_r"];?>">Recomendar</a></div>
				</div>
				<br>
			</section>
		<?php
		endforeach;
	endif;
	?>
</div>