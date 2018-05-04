<?php include_once 'clases/bd.php';?>
<?php include 'modales/m_cropper.php';?>
<script>    
var demo=angular.module('registrarAp',[]).controller('RegistrarController',['$scope',function ($scope){
     $scope.dias=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];     
     $scope.meses=[{indice:0,mes:"mes"},
                   {indice:1,mes:"Ene."},
                   {indice:2,mes:"Feb."},
                   {indice:3,mes:"Mar."},
                   {indice:4,mes:"Abr."},
                   {indice:5,mes:"May."},
                   {indice:6,mes:"Jun."},
                   {indice:7,mes:"Jul."},
                   {indice:8,mes:"Ago."},
                   {indice:9,mes:"Sep."},
                   {indice:10,mes:"Oct."},
                   {indice:11,mes:"Nov."},
                   {indice:12,mes:"Dic."}];
     $scope.agnos=[];
     for(i=2016;i>1950;i--)
         $scope.agnos[2016-i]=i;
}]);
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="usr-reg" data-ng-app="registrarAp">
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
					<section class="form-apdp" style="display: none" data-title="Informaci�n Personal" data-step="1" data-type="e" id="personal">
                                            <div class="row">
						<div class="col-xs-12 ">
							<div class="marL10"><i class="fa fa-list-alt"></i>Informaci&oacute;n Personal</div>
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
						<div class="col-xs-4">
							<span class="marL10"><i class="fa fa-gender"></i> Genero</span>
						</div>
						<div class="col-xs-8">
							<span class="marL10"><i class="fa fa-phone"></i> Fecha de nacimiento</span>
						</div>
						<div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 input">
							<select class=" form-select " id="e_genero" name="e_genero">
								<option value="1">Seleccione</option>
								<option value="M">Masculino</option>
								<option value="F">Femenino</option>
                                                        </select>
						</div>
                                                <div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-8 input" data-ng-controller="RegistrarController">
                                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 form-group">
                                                            <select class="form-select" id="e_dia_nac">
                                                                <option value="0">dia</option>
                                                                <option data-ng-repeat="dia in dias" value="{{dia}}">{{dia}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 form-group">
                                                            <select class="form-select" id="e_mes_nac">
                                                                <option data-ng-repeat="mes in meses" value="{{mes.indice}}">{{mes.mes}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 form-group">
                                                            <select class="form-select" id="e_agno_nac">
                                                                <option value="0">año</option>
                                                                <option data-ng-repeat="agno in agnos" value="{{agno}}">{{agno}}</option>
                                                            </select>
                                                        </div>           
                                                </div>
                                                <div class="clearfix"></div>
                                                <!--
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
                                                -->
                                                <div class="col-xs-12">
                                                        <span class="marL10"><i class="fa fa-map-marker"></i>
                                                                Ubicaci&oacute;n...
                                                        </span>
                                                </div>
                                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
                                                        <select class=" form-select " id="e_pais" name="e_pais">
                                                                <option value="" disabled selected>Seleccione un Pa&iacute;s</option>
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
                                                                <option value="">Seleccione su regi&oacute;n</option>
                                                        </select>
                                                </div>
                                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
                                                        <textarea rows="4" cols="" placeholder="Direccion" id="e_direccion" name="e_direccion" class="form-textarea"></textarea>
                                                </div>
                                            </div>
                                        </section>	
                                        <section class="form-apdp" style="display: none" data-title="Informaci&oacute;n de acceso" data-step="2" >
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
							<span class="marL10"><i class="fa fa-lock"></i> Contrase�a</span>
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