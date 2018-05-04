<?php
	include_once "clases/usuarios.php";
	$usua=new usuario($_SESSION["id"]);
	$status_reservacion=$usua->getStatusReservacion();
?>
<br><br>
<div class="row">
	<div class="container pad20">
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-justify">
			<div class="col-xs-12">
				<?php if($status_reservacion==0 || $status_reservacion==1):
						if($status_reservacion==0):?>
							<div class="jumbotron">
								<span class="text-justify t30">
									Estamos verificando tu contrataci&oacute;n del servicio, tardara solo unas horas, mientras tanto puedes probar nuestra versi&oacute;n gratuita.
								</span><br><br><br>
								<div class="text-center"><a href="englishzone" target="_blank" class="btn btn-primary" role="button">Entrar al sistema</a></div>
							</div>
						<?php 
						else: ?>
							<div class="jumbotron">
								<span class="text-justify t30">Eres miembro activo de nuestro sistema, puedes disfrutar de todos los recursos. Recuerda que no existen formulas m&aacute;gicas para el aprendizaje,
										es necesario la constancia y el esfuerzo para lograr el &eacute;xito, por tanto, dedicar la mayor cantidad de tiempo y concentraci&oacute;n en el uso de los recursos es fundamental para lograr los objetivos planteados.
								</span> <br><br><br>
								<div class="text-center"><a href="englishzone" target="_blank" class="btn btn-primary" role="button">Entrar al sistema</a></div>
							</div>
						<?php 
						endif;?>
				<?php else:?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 jumbotron">
							<span class="text-justify t30">
								En nuestro sistema encontraras una gran colecci&oacute;n de audios, videos, juegos, actividades, canciones
								y muchos m&aacute;s recursos organizados y sistematizados que te guiaran en el aprendizaje del idioma mas hablado
								del mundo de forma pr&aacute;ctica y divertida.
							﻿</span><br><br><br>
							<div class="text-center"><a href="englishzone" target="_blank" class="btn btn-primary" role="button"> Prueba Grat&iacute;s </a></div>
						</div>				
				<?php endif;?>
			</div>
		</div>
		<div class="col-xs-12"><br></div>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-center">
			<div class="col-xs-12">
				<?php if($status_reservacion==0 || $status_reservacion==1):?>
					<a href="englishzone" target="_blank"><button id="btn-ingresar" name="btn-ingresar" class="btn btn-primary" href="englishzone.php" target="_blank">Entrar al sistema</button></a>
				<?php else:?>
					<a href="englishzone" target="_blank"><button class="btn btn-primary">Prueba grat&iacute;s</button></a>
				<?php endif;?>
			</div>
		</div>		
		<div class="col-xs-12"><br></div>
		<?php
		if($status_reservacion==-1 || $status_reservacion==2 || $status_reservacion==3):?>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"  name="planes" id="planes">
			<center><h1><u>Planes &nbsp;y &nbsp;contacto</u></h1></center>
			<div class="col-xs-12 col-sm-6">
				<table class="table">
					<caption>Planes</caption>
					<thead>
						<tr>
							<td>Planes</td>
							<td>Inversi&oacute;n</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Mensual</td>
							<td>7,00 dolares.</td>
						</tr>
						<tr>
							<td>Trimestral</td>
							<td>17,00 dolares.</td>
						</tr>
						<tr>
							<td>Semestral</td>
							<td>28,00 dolares.</td>
						</tr>
						<tr>
							<td>Anual</td>
							<td>45,00 dolares.</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-xs-12 col-sm-6">
				<br><br>
				<div class="col-xs-3">
					<img class="img-responsive" src="galeria/img/telefono.jpg"></img>
				</div>
				<div class="col-xs-9">
					<div class="col-xs-12"><span class="t18">0058 276 6518167</span></div>
					<div class="col-xs-12"><span class="t18">0058 414 7229007</span></div>
					<div class="col-xs-12"><span class="t18">0058 416 179-3965</span></div>
				</div><div class="col-xs-12"><br><br></div>
				<div class="col-xs-3">
					<img class="img-responsive" src="galeria/img/email.jpg"></img>
				</div>
				<div class="col-xs-9">
					<div class="col-xs-12"><a href="mailto:admin@sistemacalderon.com.ve"><span class="t18">admin@sistemacalderon.com.ve</span></a></div>
					<div class="col-xs-12"><a href="mailto:ivandario2010@gmail.com"><span class="t18">ivandario2010@gmail.com</span></a></div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-justify t16"  name="instrucciones" id="instrucciones">
			<div class="col-xs-12">
				<center><h1><u>¿Como adquirir el servicio?</u></h1></center><br>
				<p class="t20">
					A&uacute;n no contamos con cuentas bancarias en Chile, sin embargo, puedes contratar el servicio transfiriendo
					el monto correspondiente a la cuenta bancaria destinada en Colombia
				</p>				
				<p>
					<h3><u>Paso 1:</u></h3>
					Selecciona el plan que que mas te agrade
				</p>
				<p>
					<h3><u>Paso 2:</u></h3>
					Deposita o transfiere el monto correspondiente a la siguientes cuentas bancarias <br><br>
					<ul>
						<li>
							<u><b>Banco caja social: </b></u> cuenta de ahorros 24040117786 a nombre de Cruz Belia C&aacute;ceres, 
							c&eacute;dula 28.075.317, email cacerescruzbelia@gmail.com
						</li><br>
					</ul>
				</p>
				<p>
					<h3><u>Paso 3:</u></h3><br>
					Cu&aacute;ndo calcules que el dinero sea efectivo reportarlo por medio del formulario de
					<a href="#pago">Registro de pagos</a>
				</p>
				<p>
					<h3><u>Paso 4:</u></h3><br>
					24 horas h&aacute;biles despues de registrar el pago recibiras un correo electr&oacute;nico por medio del cual
					podras activar tu cuenta, una vez hecho esto podras inciar tu proceso de aprendizaje, recuerda que lo m&aacute;s importante
					para aprender es la constancia
				</p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-center t16" name="pago" id="pago">
			<div class="col-xs-12">
				<center><h1><u>Registro de pago</u></h1></center><br><br>
				<div class="form-group">
					<form id="frm-reservacion" name="frm-reservacion">
						<div class="form-group">
							<input id="txt-documento" name="txt-documento" class="form-input" type="text" placeholder="Documento de identidad"></input>
						</div>
						<div class="form-group">
							<input id="txt-nombre" name="txt-nombre" class="form-input" type="text" placeholder="Nombres" value="<?php echo $usua->u_nombres;?>"></input>
						</div>
						<div class="form-group">
							<input id="txt-apellido" name="txt-apellido" class="form-input" type="text" placeholder="Apellidos" value="<?php echo $usua->u_apellidos;?>"></input>
						</div>
						<div class="form-group">
							<input id="txt-email" name="txt-email" class="form-input" type="email" placeholder="Correo electronico" value="<?php echo $usua->a_email;?>"></input>
						</div>
						<div class="form-group">
							<input id="txt-telefono" name="txt-telefono" class="form-input" type="text" placeholder="Telefonos"></input>
						</div>
						<div class="form-group">
							<select id="select-plan" name="select-plan" class="form-select" type="text" placeholder="Plan seleccionado">
								<option value="0">Plan seleccionado</option>
								<option value="1">Mensual</option>
								<option value="2">Trimestral</option>
								<option value="3">Semestral</option>
								<option value="4">Anual</option>
							</select>
						</div>
						<div class="form-group">
							<select id="select-forma" name="select-forma" class="form-select" type="text" placeholder="Forma de pago">
								<option  value="0">Forma de pago</option>
								<option  value="1">D&eacute;posito</option>
								<option  value="2">Transferencia</option>
							</select>
						</div>
						<div class="form-group">
							<select id="select-banco" name="select-banco" class="form-select" type="text" placeholder="Banco">
								<option  value="0">Seleccione el banco</option>
								<option  value="1">Caja social</option>
							</select>
						</div>
						<div class="form-group">
							<input id="txt-referencia" name="txt-referencia" class="form-input" type="text" placeholder="Referencia"></input>
						</div>
						<div class="form-group">
							<textarea id="txt-observacion" name="txt-observacion" class="form-textarea" placeholder="Observaciones"></textarea>
						</div>
						<div class="form-group">
                            <button id="registrar-pago" type="button" class="btn btn-primary2">Guardar</button><br><br>
							<span class="t14">
								Nota: si no desea iniciar el programa de forma inmediata, por favor indique en las observaciones
								la fecha en la que desea iniciar
							</span>							
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--<div class="hidden-xs hidden-sm col-md-6 col-lg-8 text-right">-->
		<div class="hidden-xs hidden-sm col-md-1 col-lg-1 text-right">
		</div>
		<div class="hidden-xs hidden-sm col-md-5 col-lg-7 text-right">
			<br><br><br><br><br>
			<img class="img-responsive" src="galeria/img/logos/logo-ingles.jpg"></img>
		</div>
		<?php endif;?>		
	</div>
</div>