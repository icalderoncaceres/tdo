<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-6 col-lg-8 form-group">
		<div class="col-xs-5">
			<select class="form-select" id="select-niveles-actividades">
				<option value="0">Select level </option>
				<option value="basic">Basic</option>
				<option value="intermediate">Intermediate</option>
				<option value="advance">Advance</option>
			</select>
		</div>
		<div class="col-xs-4">
			<select class="form-select" id="select-discos-actividades">
				<option value="0">Select disc </option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary" id="btn-go-actividades" name="btn-go-actividades">Go</button>
		</div>
	</div>
	<div class="hidden-xs col-sm-4 col-md-12 col-lg-12"></div>
	<div class="col-xs-12"><br></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="centro-ejercicios" name="centro-ejercicios">	
		<p class="t30 text-center">
			Select level and disc then do click in the button "Go" and start practice
		</p>
	</div>
	<div id="centro-aviso" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden text-justify">
		<?php include "../../vistas/aviso.html";?>
	</div>	
</div>