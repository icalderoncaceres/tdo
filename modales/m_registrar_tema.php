<div class="modal fade bs-example-modal-lg modal-conf" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="reg-tema">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span id="usr-reg-title"
						class="marL15">Registrar un nuevo Tema</span>
				</h3>
			</div>
			<form id="form-reg-tema" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
<!--					<div id="editorTema" ></div>-->
						<input type="text" placeholder="Titulo máximo 60 caracteres" class="form-input" id="txt-titulo" name="txt-titulo"></input><br>
						<textarea class="form-textarea" placeholder="Detalle del tema" rows="4" id="txt-detalle" name="txt-detalle"></textarea>
					</section>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary2 btn-usr-act" id="btnAgregarTema" name="btnAgregarTema">Agregar tema</button>
				</div>
			</form>			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->