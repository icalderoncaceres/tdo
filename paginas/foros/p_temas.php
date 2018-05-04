<?php
include_once "../../clases/temas.php";
include_once "../../clases/areas.php";
$area=new areas($_POST["area"]);	
$temas=$area->getTemas();
$total=$area->countTemas();
$totalPaginas=ceil($total/25);
if(!isset($_SESSION)){
	session_start();
}
$habilitado=isset($_SESSION["id"])?$habilitado="":"disabled";
?>
<h3>FORO <?php echo utf8_encode($area->nombre);?></h3>
<div class="row">
	<div class="col-sm-6 col-md-6 col-lg-6">
		<span>
			<input type="text" id="txtBusquedaTema" name="txtBusquedaTema"><button class="btn btn-primary" id="btnBuscarTema" name="btnBuscarTema">Buscar</button>
		</span><span id="filtradoporTema" name="filtradoporTema"></span>
	</div>
	<div class="pull-right">
		<span>
			<button class="btn btn-primary" id="btnNuevoTema" name="btnNuevoTema" data-toggle="modal" data-target="#reg-tema" data-id="<?php echo $area->id;?>" <?php echo $habilitado;?>>
			Nuevo Tema</button><button class="btn btn-primary cmdVolver" data-pagina="paginas/foros/p_menu.php">Volver</button>
		</span>
	</div>
	<div class="col-sm-6 col-md-6 col-lg-6">
		<span>
			Mostrando del 1 al 30 de 50 registros
		</span>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<label>Filtrar por:</label>
		<select>
			<option>todos los mensajes</option>
			<option>los mensajes de hoy</option>
			<option>los mensajes desde ayer</option>
			<option>los mensajes desde hace una semana</option>
			<option>los mensajes desde hace un mes</option>
		</select>
	</div>
</div>
<div class="pad20">
	<div class="row">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
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
					<li id="siguiente"><a href='#' aria-label='Next'><i class='fa fa-angle-right'></i> </a></li>
				</ul></nav></center>	
			</div>
	</div>
	<div class="contenedor pad20">
		<div class="row pad10" id="filas" name="filas" data-id="<?php echo $area->id;?>" data-totalpaginas="<?php echo $totalPaginas;?>" data-actualpagina='1'>
			<?php
			if($temas):
				$bandera=true;
				$i=0;
				foreach($temas as $t=>$valor):
					$fondo=$bandera?"fondo1":"fondo2";
					$bandera=!$bandera;
				?>
					<div class="temas vinculos-temas <?php echo $fondo;?>" data-titulo="<?php echo $valor["titulo"];?>" data-tema="<?php echo $valor["id_t"]?>">
						<a style="cursor:pointer" >
						<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><span><?php echo utf8_encode($valor["titulo"]);?></span></div>
						<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><span><?php echo substr(utf8_encode($valor["detalle"]),0,100);?></span></div>
						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span><?php echo $valor["totaVisitas"];?> Visitas</span></div>
                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="perfil.php?id=<?php echo $valor["id"];?>" target="_blank"><?php echo "{$valor["nombres"]} {$valor["apellidos"]}"?></a> <?php echo date("d/m/y H:i:s",strtotime($valor["fecha"]));?></span></div>
						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span><?php echo $valor["totaRespuestas"];?> Aportes</span></div>
						</a>
					</div>
				<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
	<br><br><br><br><br><br>
</div>