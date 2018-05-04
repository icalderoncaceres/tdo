<?php
include_once "../../../clases/temas.php";
include_once "../../../clases/areas.php";
include_once "../../../clases/aportes.php";
$metodo=filter_input(INPUT_POST,"metodo");
switch($metodo){
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
    $id=  filter_input(INPUT_POST,"id");
    $aporte=filter_input(INPUT_POST,"txt-aporte");
	$tema=new temas($id);
	$result=$tema->agregarAporte($aporte);
    if($result){
        echo "Ok.";
    }else{
        echo "Error";
    }
}
function guardaTema(){
    $id=filter_input(INPUT_POST,"id");
    $titulo=filter_input(INPUT_POST,"txt-titulo");
	$detalle=filter_input(INPUT_POST,"txt-detalle");
	$area=new areas($id);
	$result=$area->agregarTema($titulo,$detalle);
    if($result){
        echo "Ok.";
    }else{
        echo "Error";
    }
}
function cambiaPagina(){
        $id=  filter_input(INPUT_POST,"id");
        $pagina=  filter_input(INPUT_POST,"pagina");
	$area=new areas($id);
	$inicio=($pagina - 1) * 25;
	$temas=$area->getTemas(25,$inicio);
	$bandera=true;
	foreach($temas as $valor):
        	$fondo=$bandera?"fondo1":"fondo2";
		$bandera=!$bandera;
		?>
                <div class="temas vinculos-temas <?php echo $fondo;?>" data-titulo="<?php echo $valor["titulo"];?>" data-tema="<?php echo $valor["id_t"]?>">
			<a style="cursor:pointer" >
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><span><?php echo utf8_encode($valor["titulo"]);?></span></div>
                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span><?php echo $valor["totaVisitas"];?> Visitas</span></div>
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="perfil.php?id=<?php echo $valor["id"];?>"><?php echo "{$valor["nombres"]} {$valor["apellidos"]}"?></a> <?php echo date("d/m/y H:i:s",strtotime($valor["fecha"]));?></span></div>
                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span><?php echo $valor["totaRespuestas"];?> Aportes</span></div>
			</a>
		</div>
		<?php
	endforeach;
}
function cambiaPagina2(){
        $id=  filter_input(INPUT_POST,"id");
        $pagina=  filter_input(INPUT_POST,"pagina");    
	$tema=new temas($id);
	$inicio=($pagina - 1) * 25;
	$aportes=$tema->getAportes(25,$inicio);
	foreach($aportes as $valor):
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
        $id=  filter_input(INPUT_POST,"id");
        $calificacion=filter_input(INPUT_POST,"calificacion");
        $accion=filter_input(INPUT_POST,"accion");
	$aporte=new aportes($id);
	$result=$aporte->setCalificacion($calificacion,$accion);
	return $result;	
}
function recomienda(){
        $id=  filter_input(INPUT_POST,"id");
	$bd=new bd();
	$tiempo = date("Y-m-d H:i:s",time());
	if(!isset($_SESSION)){
            session_start();
        }
	$valores=array("usuarios_id"=>$_SESSION["id"],
		       "eventos_tipos_id"=>1,
		       "fecha"=>$tiempo,
		       "evento_id"=>$id
			);
	$result=$bd->doInsert("eventos",$valores);
	return $result;
}