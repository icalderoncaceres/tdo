<div class="modal fade bs-example-modal-lg modal-conf" data-type="comprar-info"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-comprar">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Datos del vendedor</span>
				</h3>
			</div>
			
				<div class="modal-body">

                    <div class=" marL30 row">



                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="marco-foto-conf" style="width:150px; height:150px;"<a href="#" ><img src='<?php echo $foto->buscarFotoUsuario($usuario->id); ?>' width="100%" height="100%;" class="img img-responsive"  ></a></div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 text-left " style="margin-left:-5px;">
                        <br>
                            <span class="t18  vin-blue-apdp"><b><a href="perfil.php"><?php echo $usuario->a_seudonimo; ?></a></b></span> 
                            <br>
                            <span class="t16"><?php echo $usuario->n_nombre . " " . $usuario->n_apellido . $usuario->j_razon_social; ?> </span>
                            <br>
                            <span class="t14"><?php echo $usuario->u_telefono;?></span>
                            <br>
                            <span class="t14"><?php echo $usuario->a_email;?> </span>

                        </div>
                    </div>
				<div class="modal-footer">
					<button class="btn btn-primary2" data-dismiss="modal">Continuar</button>
				</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->