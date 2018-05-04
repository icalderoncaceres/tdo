<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="edit-entrada">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " ><img src="galeria/img/logos/mascota.png" width="60" height="51"><span id="usr-reg-title" class="marL15">Editar la entrada</span></h3>
			</div>
			<form class="form-inline" id="frm-entrada">
				<div class="modal-body marL20 marR20" data-ng-controller="GrupoController">
					<div class="row">
						<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 t18" >
							<input type="text" placeholder="Titulo" name="e_titulo" class="form-input" id="e_titulo">
						</div>
                                                <br><br>
        					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 t18" >
                                                    <textarea rows="3" cols="" placeholder="Descripción" id="e_descripcion" name="e_descripcion" class="form-textarea" maxlength="240"></textarea>
                        			</div>
                                                <div class="col-xs-12"><br></div>
        					<div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2 t14" >
                                                    <span>Color </span><input id="e_color" type="color"></input>
                        			</div>                                                
        					<div class="form-group col-xs-12 col-sm-12 col-md-10 col-lg-10 t14" >
                                                    <div class="subir-img-active foto" style="margin-left: 0px;" data-toggle="tooltip" title="Puedes subir una imágen">
                                                        <img class="img-responsive"/>
            						<i style="position: relative; top:-40px; left:110%;" class="fa fa-times red hidden"></i>
                                                    </div>
                        			</div>                                            
                                                <div class="col-xs-12"><hr></div>
                                	</div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-edit-entrada" type="button" class="btn btn-primary2">Guardar</button>
                                </div>
			</form>
		</div>
	</div>
</div>