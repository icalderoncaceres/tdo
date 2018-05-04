<br>
<h2><center>Creaci&oacute;n de un nuevo grupo</center></h2>
<div class="row pad20">
    <form id="frm-new-grupo" name="frm-new-grupo" action="">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
            <select class="form-control form-select" id="cmbdescripcion" name="cmbdescripcion">
		<option value=1>Como describes a tu grupo</option>
		<option value=2>Un canal de comunicaci&oacute;n entre docente y estudiantes</option>
		<option value=3>Un canal de colaboraci&oacute;n entre compa&ntilde;eros</option>
		<option value=4>Un espacio de colaboraci&oacute;n entre representantes</option>
                <option value=5>Otra descripci&oacute;n</option>
            </select>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
            <input type="text" placeholder="Dale un nombre al grupo" class="form-control form-input" id="txtnombre" name="txtnombre">
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
            <label>Fecha limite<input type="date" min="<?php echo date("Y-m-d");?>" class="form-control form-input" id="txtFecha" name="txtFecha"></input></label>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
            <div class="text-left marL20">
		<table>
                    <tr>
			<td>
                            <div class="marR10 form-group" style="width: 20px; height: 20px; border: 0px; float: left;">
        			<input type="checkbox" id="chkSinLimite" name="chkSinLimite" class="form-input" value="0" style="width: 100%; height: 100%;margin-top:12px" data-marcado="0">
                            </div>
			</td>
			<td>
                            <div class="t18 marR10" style="margin-top:22px">
				Sin fecha limite
                            </div>
			</td>
                    </tr>
		</table>
            </div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
            <br>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><button class="btn3 btn-primary2" type="submit" id="btn-guardar" name="btn-guardar">Guardar</button></div>
    </form>
    
</div>