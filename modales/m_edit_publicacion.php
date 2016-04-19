<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-publicacion">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span 
						class="marL15">Editar Publicación</span>
				</h3>
			</div>
			<form id="usr-act-form-social" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">
							
							<div class="alert alert-info " role="alert"
						style="width: 100%; margin: 0px; padding: 2px; ">
							<span class="marL5" style="font-size: 11px;"><i class="fa fa-info-circle marR5"></i> <b>Nota: </b> Si ya vendiste algun producto de esta publicacion, no podras cambiar el titulo.</span>
						</div>
							<div class="col-xs-12 marT10 ">
								 <span>Titulo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class=" form-input " id="" name=""
									value="titulo de la publicación" />
							</div>
							<div class="col-xs-12 ">
								 <span>Cantidad</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class=" form-input " id="" name=""
									value="55" />
							</div>
							<div class="col-xs-12 ">
								 <span>Precio (Bs)</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class=" form-input " id="" name=""
									value="5555" /> 
							</div>
							<div class="col-xs-12 text-center marT10">
								<br>
								<i class="fa fa-pencil"></i> <span><a href="ventas.php">Modificar mas detalles, Fotos,descripcion ...</a></span>
							</div>
						</div>
					</section>	
				</div>
				<div class="modal-footer">
				<button id="btn-social-act" type="button" class="btn btn-primary2">Actualizar</button>					
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->