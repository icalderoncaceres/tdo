﻿<?php 
if (!headers_sent()) {
	header('Content-Type: text/html; charset=ISO-8859-15');
}
include_once "clases/articulos.php";
$articulo=new articulos();
$articulos=$articulo->listarArticulos();
if(!isset($_SESSION)){
	session_start();
}
$habilitado=!isset($_SESSION["id"])?"No":"Si";
?>
<div id="ajaxContainer" name="ajaxContainer" data-disponible="<?php echo $habilitado;?>">
	<center><H1>Artículos Educativos Que debes Leer</H1></center>
	<br>
	<?php
	if($articulos):
		foreach($articulos as $a=>$valor):
			$arti=new articulos($valor["id"]);
			$totaVisitas=$arti->getVisitas();
			$totaPositivos=$arti->getComentarios(1);
			$totaNegativos=$arti->getComentarios(-1);
			$totaComentarios=$totaPositivos + $totaNegativos;
			$calificacion=$articulo->getCalificacion();
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
			?>
			<div class="contenedor t16 pad20">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Titulo:<?php echo $arti->a_titulo;?></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Descripción:<?php echo $arti->a_descripcion;?></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Colaborador:<?php echo $arti->getUsuario();?> </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Fecha:<?php echo $arti->a_fecha;?></div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Visitas:<span id="totaVisitas<?php echo $arti->id;?>" name="totaVisitas<?php echo $totaVisitas;?>" data-total="<?php echo $totaVisitas;?>"><?php echo $totaVisitas;?></span></div>
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">Comentarios: <i class="fa fa-thumbs-up calificacion <?php echo $cal1;?>" style="cursor:pointer" data-id='<?php echo $articulo->id;?>' data-calificacion="1"></i> <?php echo $totaPositivos;?>
					<i class="fa fa-thumbs-down calificacion <?php echo $cal2;?>" style="cursor:pointer" data-id='<?php echo $articulo->id;?>' data-calificacion="-1"></i> <?php echo $totaNegativos;?> Total <?php echo $totaComentarios;?></div>
					<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"><a href="#" class="vistas" data-id="<?php echo $arti->id; ?>" data-metodo="ver" data-ruta="<?php echo $arti->a_ruta;?>">Ver</a></div>
					<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"><a href="#" data-toggle="modal" data-target="#recomendar-evento" class="recomendacion" data-id="<?php echo $valor["id"];?>">Recomendar</a></div>
				</div>
				<br>
			</div>
		<?php
		endforeach;
	endif;
	?>
</div>