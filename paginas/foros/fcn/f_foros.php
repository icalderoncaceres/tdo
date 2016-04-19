<?php
include_once "../../../clases/temas.php";
include_once "../../../clases/areas.php";
include_once "../../../clases/aportes.php";
switch($_POST["metodo"]){
	case "guardarAporte":
		guardaAporte();
		break;
	case "guardarTema":
		guardaTema();
		break;
	case "cambiarPagina":
		cambiaPagina();
		break;
	case "cambiarPagina2":
		cambiaPagina2();
		break;
	case "calificar":
		califica();
		break;
	case "recomendar":
		recomienda();
		break;
}
function guardaAporte(){
	$tema=new temas($_POST["id"]);
	$result=$tema->agregarAporte($_POST["editor"]);
	echo "Ok.";
}
function guardaTema(){
	$area=new areas($_POST["id"]);
	$result=$area->agregarTema($_POST["editorTema"]);
	echo "Ok.";
}
function cambiaPagina(){
	$area=new areas($_POST["id"]);
	$inicio=($_POST["pagina"] - 1) * 25;
	$temas=$area->getTemas(25,$inicio);
	$bandera=true;
	$i=0;
	foreach($temas as $t=>$valor):
		$fondo=$bandera?"#eee":"#ccc";
		$letra=$bandera?"#ccc":"#eee";
		$bandera=!$bandera;
	?>
		<div class="temas" data-titulo="<?php echo $valor["titulo"];?>">
			<a style="cursor:pointer" class="vinculos-temas" data-tema="<?php echo $valor["id_t"]?>">
			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="background:<?php echo $fondo;?>";><span class="t16 vin-blue"><?php echo $valor["titulo"];?></span></div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="background:<?php echo $fondo;?>";><span class="t16 vin-blue"><?php echo $valor["totaVisitas"];?> Visitas</span></div>
			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="background:<?php echo $fondo;?>";><span class="t16 vin-blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "{$valor["nombres"]} {$valor["apellidos"]} {$valor["fecha"]}";?></span></div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="background:<?php echo $fondo;?>";><span class="t16 vin-blue"><?php echo $valor["totaRespuestas"];?> Aportes</span></div>
			</a>
		</div>
	<?php
	endforeach;	
}
function cambiaPagina2(){
	$tema=new temas($_POST["id"]);
	$inicio=($_POST["pagina"] - 1) * 25;
	$aportes=$tema->getAportes(25,$inicio);
	$bandera=true;
	$i=0;
	foreach($aportes as $a=>$valor):
	?>
		<div class="aportes" data-contenido="<?php echo $valor["contenido"];?>">
			<div>
				<div class="col-sm-12 col-md-12 col-lg-12" style="background:#ccc;"><span class="t16 vin-blue"><?php echo utf8_encode($valor["contenido"]);?></span></div>
			</div>
			<div>
				<div class="col-sm-12 col-md-12 col-lg-12" style="background:#ddd;"><span class="t16 vin-blue"><?php echo utf8_encode($valor["nombres"]) . " " . utf8_encode($valor["apellidos"]) ." / {$valor["fecha"]}";?></span></div>
			</div>
		</div>
	<?php
	endforeach;
}
function califica(){
	$aporte=new aportes($_POST["id"]);
	$result=$aporte->setCalificacion($_POST["calificacion"],$_POST["accion"]);
	return $result;	
}
function recomienda(){
	$bd=new bd();
	$tiempo = date("Y-m-d H:i:s",time());
	if(!isset($_SESSION))
	session_start();
	$valores=array("usuarios_id"=>$_SESSION["id"],
		       "eventos_tipos_id"=>1,
		       "fecha"=>$tiempo,
		       "evento_id"=>$_POST["id"]
			);
	$result=$bd->doInsert("eventos",$valores);
	return $result;
} 
?>