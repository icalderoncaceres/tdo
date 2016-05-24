<?php include_once 'clases/bd.php';?>
<?php include 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="usr-reg">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " ><img src="galeria/img/logos/mascota.png" width="50" height="51"><span id="usr-reg-title" class="marL15">Inscribete</span></h3>
			</div>
			<form id="usr-reg-form" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<input type="hidden" id="type" name="type" value="p"/>
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" style="display: none" data-title="Información Personal" data-step="1" data-type="e" id="personal">
					<div class="row">
						<div class="col-xs-12 ">
							<div class="marL10"><i class="fa fa-list-alt"></i>Información Personal</div>
						</div>
						<div class="col-xs-12">
							<span class="marL10"><i class="fa fa-user"></i> Nombre y Apellido</span>
						</div>
						<div class=" form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input" >
							<input type="text" placeholder="Ingresa tu nombre..." name="e_nombres" class=" form-input " id="e_nombres">
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input" >
							<input type="text" placeholder="Ingresa tu apellido..." name="e_apellidos" class=" form-input " id="e_apellidos">
						</div>
						<div class="col-xs-6">
							<span class="marL10"><i class="fa fa-phone"></i> Genero</span>
						</div>
						<div class="col-xs-6">
							<span class="marL10"><i class="fa fa-phone"></i> Fecha de nacimiento</span>
						</div>
						<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6 input">
							<select class=" form-select " id="e_genero" name="e_genero">
								<option value="1">Seleccione</option>
								<option value="M">Masculino</option>
								<option value="F">Femenino</option>
                			</select>
						</div>
						<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6 input">
							<input type="date" " id="e_fechanac" name="e_fechanac"></input>
					</div>
					<div class="col-xs-4">
						<span class="marL10"><i class="fa fa-phone"></i> Telefono 1</span>
					</div>
					<div class="col-xs-4">
						<span class="marL10"><i class="fa fa-phone"></i> Telefono 2</span>
					</div>
					<div class="col-xs-4">
						<span class="marL10"><i class="fa fa-phone"></i> Telefono 3</span>
					</div>
					<div class=" form-group col-xs-4 col-sm-4 col-md-4 col-lg-4 input " >
						<input type="text" placeholder="Telefono 1" name="e_telefono1" class=" form-input" id="e_telefono1">
					</div>
					<div class=" form-group col-xs-4 col-sm-4 col-md-4 col-lg-4 input " >
						<input type="text" placeholder="Telefono 2" name="e_telefono2" class=" form-input" id="e_telefono2">
					</div>
					<div class=" form-group col-xs-4 col-sm-4 col-md-4 col-lg-4 input " >
						<input type="text" placeholder="Telefono 3" name="e_telefono3" class=" form-input" id="e_telefono3">
					</div>
					<div class="col-xs-12">
						<span class="marL10"><i class="fa fa-map-marker"></i>
							Ubicacion...
						</span>
					</div>
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
						<select class=" form-select " id="e_pais" name="e_pais">
							<option value="" disabled selected>Seleccione un País</option>
							<?php
							$bd = new bd();
							$paises=$bd->query("select * from paises order by nombre");
							foreach ($paises as $pais ) {			
				    			echo "<option value={$pais['id']}> {$pais['nombre']} </option>";
							}
							?>
						</select>
					</div>
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" id="regiones" name="regiones">
						<select class=" form-select " id="e_regiones_id" name="e_regiones_id" disabled>
							<option value="">Seleccione su región</option>
						</select>
					</div>
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
						<textarea rows="4" cols="" placeholder="Direccion" id="e_direccion" name="e_direccion" class="form-textarea"></textarea>
					</div>
				</div>
				</section>	
				<section class="form-apdp" style="display: none" data-title="Información de acceso" data-step="2" >
					<div class="row">
						<div class="col-xs-12 ">
							<span class="marL10"><i class="fa fa-male"></i> Seudonimo</span>
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
							<input class=" form-input " id="seudonimo" name="seudonimo" placeholder=" Ingresa un nombre con el que te identificaras en el sitio..." />
						</div>
						<div class="col-xs-12 ">
							<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
						</div>
						<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
							<input type="email" class="form-input noseleccionable" id="email" name="email" placeholder=" Ingresa tu correo electronico..." oncontextmenu="return false"/>
						</div>
						<div class="col-xs-12 ">
							<span class="marL10"><i class="fa fa-lock"></i> Contraseña</span>
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
							<input type="password" class="form-input noseleccionable" id="password" name="password" placeholder=" Ingresa tu contraseña..." oncontextmenu="return false"/>
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
							<input type="password" class="form-input noseleccionable" id="password_val" name="password_val" placeholder=" Repite tu contraseña..." oncontextmenu="return false"/>
						</div>
					</div>
				</section>
			</div>
			<div class="modal-footer">
				<button id="usr-reg-submit" type="button" class="btn btn-primary2" data-type="p">Continuar</button>					
			</div>
			</form>
		</div>
	</div>
</div>