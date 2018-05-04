<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 form-group">
		<select class="form-select" id="select-niveles">
			<option>Select level </option>
			<option value="0" data-disco="1" data-nivel="basic">Basic 1</option>
			<option value="1" data-disco="2" data-nivel="basic">Basic 2</option>
			<option value="2" data-disco="3" data-nivel="basic">Basic 3</option>
			<option value="3" data-disco="4" data-nivel="basic">Basic 4</option>
			<option value="4" data-disco="1" data-nivel="intermediate">Intermediate 1</option>
			<option value="5" data-disco="2" data-nivel="intermediate">Intermediate 2</option>
			<option value="6" data-disco="3" data-nivel="intermediate">Intermediate 3</option>
			<option value="7" data-disco="4" data-nivel="intermediate">Intermediate 4</option>
			<option value="8" data-disco="1" data-nivel="advance">Advance 1</option>
			<option value="9" data-disco="2" data-nivel="advance">Advance 2</option>
			<option value="10" data-disco="3" data-nivel="advance">Advance 3</option>
			<option value="11" data-disco="4" data-nivel="advance">Advance 4</option>
		</select>
	</div>
	<div class="hidden-xs col-sm-4 col-md-6 col-lg-8"></div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-8" id="reproductor">
		<div class="col-xs-12 col-sm-4 lista-audios">
			<div id="loading-ajax" name="loading-ajax" class="hidden center-block"><img src="galeria/img/loading.gif" /> Cargando...</div>
			<ul id="lista-audios">
				
			</ul>
			<audio src="" controls style="display:none;" id="audio"></audio>
		</div>
		<div id="centro-audios" class="col-xs-12 col-sm-8 hidden">
			<div id="textos"></div> <br>			
		</div>
		<div id="centro-aviso" class="col-xs-12 col-sm-8 hidden text-justify pad20">
			<?php include "../../vistas/aviso.html";?>
		</div>
	</div>
	<div id="barra" class="col-xs-12 center-block hidden">
		<div id="progreso"></div>
	</div>
	<div class="col-xs-12"><br></div>
	<div class="hidden-xs col-sm-3"></div>
	<div class="col-xs-12 col-sm-6 hidden" id="botones">
		<button type="button" class="btn btn-primary" id="prev" name="prev">Prev</button>
		<button type="button" class="btn btn-primary" id="iniciar">Play</button>				
		<button type="button" class="btn btn-primary" id="next" name="next">Next</button>
	</div>
	<div class="hidden-xs col-sm-3"></div>
</div>