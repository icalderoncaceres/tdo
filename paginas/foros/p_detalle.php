<?php
include_once "../../clases/temas.php";
include_once "../../clases/aportes.php";
$tema=new temas($_POST["tema"]);
$aportes=$tema->getAportes();
$total=$tema->countAportes();
$totalPaginas=ceil($total/25);
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION["id"])){	
	$habilitado="";
	$disponible="Si";
}else{
	$habilitado="disabled";
	$disponible="No";
}
?>
<div>
	<h1><?php echo $tema->getRuta();?></h6>
	<br>
	<div class="row">
		<div class="col-sm-9 col-md-9 col-lg-9">
			&nbsp;<input type="text" class=form-group" id="txtBusqueda" name="txtBusqueda"><button class="btn btn-primary" id="btnBuscar" name="btnBuscar">Buscar</button>
			</span><span id="filtradopor" name="filtradopor"></span>
		</div>
		<div class="col-sm-3 col-md-3-col-lg-3">
			<button id="btnNuevo" name="btnNuevo" class="btn btn-primary" data-toggle="modal" data-target="#reg-aporte" data-id="<?php echo $tema->id;?>" <?php echo $habilitado;?>>
			Nuevo Aporte</button> &nbsp;<button class="btn btn-primary cmdVolver" data-pagina="paginas/foros/p_menu.php">Volver</button>
		</div>
	</div>
	<div class="row">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 '>
				<center><nav><ul class='pagination'>
					<li class="hidden" id="anterior"><a href='#' aria-label='Previous'><i class='fa fa-angle-left'></i></a></li>
					<?php
						$activo="active";
						for($i=1;$i<=$totalPaginas;$i++):
							?>
							<li class='<?php echo $activo;?>'><a href='#' class='botonPagina' data-pagina="<?php echo $i;?>"><?php echo $i; ?></a></li>
							<?php
							$activo="";
						endfor;
					?>
					<li id="siguiente" class="<?php if($totalPaginas==1) echo "hidden";?>"><a href='#' aria-label='Next'><i class='fa fa-angle-right'></i> </a></li>
				</ul></nav></center>	
			</div>
	</div>
	<div class="contenedor pad20">
		<div class="row pad10" id="filas" name="filas" data-id="<?php echo $tema->id;?>" data-totalpaginas="<?php echo $totalPaginas;?>" data-actualpagina='1' data-disponible="<?php echo $disponible;?>">
		<?php
		if($aportes):
			foreach($aportes as $a=>$valor):
				$aporte=new aportes($valor["id_a"]);
				$totalCal=$aporte->contarCalificaciones();
				if(isset($_SESSION["id"])){
					$calificacion=$aporte->getCalificacion();
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
				<section class="aportes pad5" data-contenido="<?php echo $valor["contenido"];?>">
					<div>
						<div class="col-sm-12 col-md-12 col-lg-12 fondo1"><span><?php echo utf8_encode($valor["contenido"]);?></span></div>
					</div>
					<div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 fondo2"><span><a href="perfil.php?id=<?php echo $valor["id"];?>" target="_blank"><?php echo utf8_encode($valor["nombres"]) . " " . utf8_encode($valor["apellidos"]);?></a> <?php echo date("d/m/y H:i:s",strtotime($valor["fecha"]));?></span></div>
					</div>
					<footer class="pull-right">
						<div id="calificaciones<?php echo $valor["id_a"]; ?>">
							<i class="fa fa-thumbs-up calificacion <?php echo $cal1;?>" data-id="<?php echo $valor["id_a"];?>" data-disponible="<?php echo $disponible;?>" data-calificacion="1"></i> <?php echo $totalCal["good"];?>&nbsp;&nbsp;
							<i class="fa fa-thumbs-down calificacion <?php echo $cal2;?>" data-id="<?php echo $valor["id_a"];?>" data-calificacion="-1"></i> <?php echo $totalCal["bad"];?>
							&nbsp;&nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#recomendar-evento" class="recomendacion"  data-id="<?php echo $valor["id_a"];?>">Recomendar</a>
						</div>						
					</footer>
					<div class="col-xs-12"><hr></div>
				</section>
				<?php
			endforeach;
		endif;
		?>
	</div>
</div>