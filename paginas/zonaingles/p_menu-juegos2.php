<?php
if(!isset($_SESSION))
	session_start();
include_once "../../clases/bd.php";
$bd=new bd();
$record=$bd->query("select seudonimo,puntaje as tota from puntajes,usuarios_accesos where juegos_id=1 and usuarios_accesos.usuarios_id = puntajes.usuarios_id order by tota desc limit 1");
$row=$record->fetch();
$record=$row["tota"];
$recorduser=strtoupper($row["seudonimo"]);
$myrecord=$bd->doSingleSelect("puntajes","usuarios_id={$_SESSION["id"]}","puntaje");
$myrecord=$myrecord["puntaje"];
?>
<div class="col-xs-12 jumbotron text-justify pad20 t26 hidden">
	En este momento estamos actualizando el catalogo de juegos para brindarte cada vez mejores herramientas para
	el aprendizaje de la lengua m&aacute;s hablada del mundo, dicha actualizaci&oacute;n tardar&aacute; unos d&iacute;as,
	mientras tanto puedes aprender divirti&eacute;ndote dirigiendo el personaje por la pista de obst&aacute;culos, ¿est&aacute;s dispuest@
	a romper el record?, recuerda que lo conduces con la voz y solo reconoce comandos en ingles.
</div>
<div class="col-xs-12"><br></div>
<div class="col-xs-12">
	<div class="col-xs-12" id="pizarra" name="pizarra" style="border:solid 2px;width:100%;height:45px;">
		<div id="vidas" name="vidas" class="col-xs-3 t30 text-left">
			<canvas id="canvas-vidas" name="canvas-vidas" style="width:100%;height:60px;">
				Tu navegador no soporta Canvas
			</canvas>
		</div>
		<div id="palabra-buscar" name="palabra-buscar" class="col-xs-6 t30 text-center"></div>
		<input type="hidden" id="palabra-oculta" name="palabra-oculta"></input>
		<div id="marcador" name="marcador" class="col-xs-3 t24 text-right"></div>
	</div>
	<canvas id="micanvas" name="micanvas" style="width:100%;height:400px;">
		Tu navegador no soporta Canvas
	</canvas>	
	<div class="col-xs-12">
		<br>
		<span class="t24 orange-apdp">
			Record: <?php  echo $recorduser . " " . "<span class='t20 badge red'>" . $record . " Ptos. </span>";?> (SUPERALO)
			Personal: <span id="record-personal" name="record-personal" class="red"><?php  echo $myrecord;?></span> Ptos.
		</span>
		<button class="btn btn-primary" id="btn-start" name="btn-start">Start</button>		
	</div>
	<ul id="vocablos" name="vocables" class="hidden"></ul>
</div>
<audio src="medias/sonidos/no.mp3" class="hidden" id="audio-no" name="audio-no"></audio>
<audio src="medias/sonidos/yes.mp3" class="hidden" id="audio-yes" name="audio-yes"></audio>
<div class="col-xs-12"><br><br><br></div>