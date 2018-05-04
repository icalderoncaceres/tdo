<div id="centro-aviso1" name="centro-aviso1" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">
	<div class="text-justify">
		<?php include "../../vistas/aviso.html";?>
	</div>
</div>
<div id="centro-nosoportado" name="nosoportado" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">
	<div class="text-justify center-block">
		<br>
		<h1>Por el momento tu navegador no soporta algunas de las funciones utilizadas en est&aacute; secci&oacute;n, por favor 
		    utiliza algunos de los siguientes navegadores</h1>
		<br>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img class="img-responsive" src="galeria/img/chrome.png"></img></div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img class="img-responsive" src="galeria/img/chrome.png"></img></div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img class="img-responsive" src="galeria/img/chrome.png"></img></div>
	</div>
</div>
<div id="centro-aviso2" name="centro-aviso2" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">
	<br><br>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
		<div class="col-xs-10 t30">
			<p id="nivel-actual" name="nivel-actual">
			</p>			
		</div>
		<div class="col-xs-2">
			<button class="btn btn-primary t20" id="btn-go-laboratorio" name="btn-go-laboratorio">Go</button>
		</div>
		<div class="col-xs-12 label label-success t20">Don't forget microphone</div>
	</div>
	<div class="col-xs-12 text-justify hidden t30" id="elementos" name="elementos">
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-12 col-md-3" id="listen" name="listen">
				<span>Listen! </span>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9"> 
				<audio id="audio-listen" name="audio-listen" src="" controls></audio>
			</div>
		</div>
		<div class="col-xs-12"><br></div>
		<div class="col-xs-12 hidden" id="repeat" name="repeat">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<!--				<input type="text" id="voz-usuario" name="voz-usuario" x-webkit-speech speech error onwebkitspeechchange="procesar();" placeholder="Repeat"></input>-->
				<button id="procesar" name="procesar">Start</button>
			</div>
		</div>
		<div class="col-xs-12"><br></div>
		<div class="col-xs-12 hidden" id="listen-yourself" name="listen-yourself">
			<div class="col-xs-12 col-sm-12 col-md-5">
				<span>You said: </span>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-7"> 
				<!--<audio src="medias/audios/basic/1/0040408.mp3" controls></audio>-->
				<span id="you-said" name="you-said"></span>
			</div>
			<div class="col-xs-12">
				<br>
				<span id="porcentaje" name="porcentaje" style="font-size:100px"></span>
				<div class="col-xs-12">
					<button class="btn btn-primary hidden" id="btn-again" name="btn-again">Again.</button>
					<button class="btn btn-primary hidden" id="btn-next" name="btn-next">Next</button>
				</div>
			</div>
		</div>
	</div>
</div>