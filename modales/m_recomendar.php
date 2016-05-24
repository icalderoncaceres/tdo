<?php
include_once "clases/bd.php";
$bd=new bd();
$grupos=$bd->query("select a.nombre from grupos as a,usuarios_grupos as b where b.usuarios_id={$_SESSION["id"]} and 
					a.id=b.grupos_id");
?>
<div class="modal fade bs-example-modal-lg modal-conf" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="recomendar-recurso">
	<?php
	if($grupos->rowCount()>0):
		?>
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span id="usr-reg-title"
						class="marL15">A que grupo deseas recomendar est&eacute; recurso</span>
				</h3>
			</div>
			<form id="form-reg-aporte" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						Agrega un mensaje<textarea></textarea>
					</section>
				</div>
				<div id="grupos">
					<input type="checkbox" checked>Todos mis grupos</input>
					<hr>
					<?php
						foreach ($grupos as $g => $valor):
							?>
								<input type="checkbox" checked><?php echo $valor["nombre"];?></input>
								<br>
							<?php
						endforeach;
					?>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary2 btn-usr-act" id="btnAgregar" name="btnAgregar">Recomendar</button>
				</div>
			</form>			
		</div>
		<!-- /.modal-content -->
	</div>
	<?php
	else:
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h3 class="modal-title " >
				<img src="galeria/img/logos/mascota.png" width="50" height="51"><span id="usr-reg-title"
					class="marL15">Agregate a un grupo, adelante es gratis</span>
			</h3>
		</div>
		<div class="alert alert-warning"><h1>No tiene grupos asociados para recomendar</h1></div>
	<?php
	endif;
	?>
	<!-- /.modal-dialog -->
</div>