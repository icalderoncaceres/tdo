<br>
<h2><center>Creaci&oacute;n de un nuevo grupo</center></h2>
<div class="row pad20">
    <form id="frm-new-grupo" name="frm-new-grupo" action="">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
            <select class="form-control" id="cmbdescripcion" name="cmbdescripcion">
		<option value=1>Como describes a tu grupo</option>
		<option value=2>Soy un docente que desea crear un canal de comunicaci&oacute;n con sus estudiantes</option>
		<option value=3>Soy un estudiante que desea crear un canal de colaboraci&oacute;n con sus compa&ntilde;eros</option>
		<option value=4>Soy un representante que desea crear un espacio de colaboraci&oacute;n con otros representantes</option>
            </select>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
            <input type="text" placeholder="Dale un nombre al grupo" class="form-control" id="txtnombre" name="txtnombre">
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
            <label>Fecha limite<input type="date" min="<?php echo date("Y-m-d");?>" class="form-control" id="txtFecha" name="txtFecha"></input></label>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
            <div class="text-left marL20">
		<table>
                    <tr>
			<td>
                            <div class="marR10" style="width: 20px; height: 20px; border: 0px; float: left;">
        			<input type="checkbox" id="chkSinLimite" name="chkSinLimite" value="0" style="width: 100%; height: 100%;margin-top:12px" data-marcado="0">
                            </div>
			</td>
			<td>
                            <div class="t12 marR10" style="margin-top:22px">
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