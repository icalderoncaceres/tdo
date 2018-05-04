<?php
include_once "clases/bd.php";
$bd=new bd();
$grupos=$bd->query("select a.id,a.nombre from grupos as a,usuarios_grupos as b where b.usuarios_id={$_SESSION["id"]} and 
					a.id=b.grupos_id");
?>
<div class="modal fade bs-example-modal-lg modal-conf" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="recomendar-evento">
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
				<h4 class="modal-title " >
					<!--<img src="galeria/img/logos/mascota.png" width="60" height="51">-->
                                        <span id="usr-reg-title"
						class="marL15">A que grupo deseas recomendar</span>
				</h4>
			</div>
			<form id="form-reg-aporte" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-group t20">
						Agrega un mensaje<br>
                                                <textarea class="form-textarea" id="txtmensaje-recomendar" name="txtmensaje-recomendar" rows="5" cols="90" maxlength="240"></textarea>
					</section>
				</div>
				<div id="recomendar-grupos" class="form-group recomendar-grupos t14">
					<input id="todos-grupos" name="todos-grupos" type="checkbox" checked> Todos mis grupos</input>
					<hr>
					<?php
						foreach ($grupos as $g => $valor):
							?>
								<input type="checkbox" class="mis-grupos" checked=true value="<?php echo $valor["id"];?>"> <?php echo $valor["nombre"];?></input>
								<br>
							<?php
						endforeach;
					?>
				</div>
                                <br>
				<div class="modal-footer">
					<button class="btn btn-primary2 btn-usr-act" id="btnRecomendar" name="btnRecomendar">Recomendar</button>
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