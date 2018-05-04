<?php
include_once "../../../clases/bd.php";
$bd=new bd();
$disco=filter_input(INPUT_GET,"disco");
$nivel=filter_input(INPUT_GET,"nivel");
$parte=filter_input(INPUT_GET,"parte");
switch($nivel){
	case "basic":
		$tabla="eng_1_$disco";
		break;
	case "intermediate":
		$tabla="eng_2_$disco";
		break;
	case "advance":
		$tabla="eng_3_$disco";
		break;
}
$count=$bd->query("select count(id) as tota from $tabla");
$row=$count->fetch();
$total=$row["tota"];
switch($parte){
	case 1:
		$inicio=1;
		$final=round($total / 3);
		break;
	case 2:
		$inicio=round($total / 3);
		$final=round($total / 3 * 2);
		break;
	case 3:
		$inicio=round($total / 3 * 2);
		$final=$total;
		break;
}
$posiciones=array();
for($i=0;$i<60;$i++){
	$posiciones[]=rand($inicio,$final);
}
$filtro=implode(",",$posiciones);
$result=$bd->query("select * from $tabla where posicion in ($filtro) and activo=1 order by posicion");
?>
<center><h1>Arrange the words and write every sentence</h1></center>
<div class='col-xs-12'><br></div>
<?php
foreach($result as $r=>$valor):
	if(strpos($valor["texto"]," ") && strlen($valor["texto"])<55):
		$ruta=$valor["texto"];
		$palabras=explode(" ",$ruta);
		//Desordenar el array palabras
		shuffle($palabras);
		$ruta=implode("-",$palabras);
?>
		<div class="col-xs-12 respuesta-audio" data-texto="<?php echo $valor["texto"];?>">
			<div class="col-xs-12 resultado hidden text-center">
				<span>
					<i class="fa fa-times red"></i> Wrong! &nbsp;
					<i class="fa fa-user" data-toggle="tooltip" title="<?php echo $valor["texto"];?>"></i>help
				</span>
				<span>
					<i class="fa fa-thumbs-up green"></i> Good 
				</span>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><p class="t18"><?php echo $ruta;?></p></div>
			<div class="col-xs-12 hidden-sm hidden-md hidden-lg"><br></div>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><input type="text" class="form-input" placeholder="What the audio say? ¿Qué dice el audio?"></text></div>		
			<div class="col-xs-12"><br></div>
		</div>
<?php 
	endif;
endforeach;
?>
<div class="col-xs-12"><br></div>
<div id="calificacion" name="calificacion" class="t20 text-center"></div>