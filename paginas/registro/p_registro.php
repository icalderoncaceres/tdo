<?php include_once 'clases/bd.php';?>
<?php include 'modales/m_cropper.php';?>
<form id="usr-reg-form" action="fcn/f_usuarios.php" method="post" class="form-inline" ng-model="form-registro">
	<section class="form-apdp" ng-app="registrarAp" ng-controller="RegistrarController">
		<div class="row">			
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
			<div class="col-xs-12 ">
				<span class="marL10">
					<i class="fa fa-male"></i> 
					Seudonimo
				</span>
			</div>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
				<input class=" form-input " id="seudonimo" name="seudonimo" placeholder=" Ingresa un nombre con el que te identificaras en el sitio..." />
			</div>
			<div class="hidden-xs col-sm-12""><br></div>
			<div class="col-xs-12 ">
				<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
			</div>			
			<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
				<input type="email" class="form-input noseleccionable" id="email" name="email" placeholder=" Ingresa tu correo electronico..." oncontextmenu="return false"/>
			</div>
			<div class="hidden-xs col-sm-12""><br></div>
			<div class="col-xs-12 ">
				<span class="marL10"><i class="fa fa-lock"></i> Contrase&ntilde;a</span>
			</div>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
				<input type="password" class="form-input noseleccionable" id="password" name="password" placeholder=" Ingresa tu contraseña..." oncontextmenu="return false"/>
			</div>
			<div class="hidden-xs col-sm-12"><br></div>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
				<input type="password" class="form-input noseleccionable" id="password_val" name="password_val" placeholder=" Repite tu contraseña..." oncontextmenu="return false"/>
			</div>
			<div class="hidden-xs col-sm-12"><br></div>
			<div class="col-xs-12">
				<input type="checkbox" ng-model="acepto"> Acepto los t&eacute;rminos de educacionenlinea.com.ve &nbsp;&nbsp;</input>
				<button id="usr-reg-submit" type="button" class="btn btn-primary2" data-type="p" ng-disabled="!acepto" ng-click="aceptar()">
					Guardar
				</button>				
			</div>			
        </div>
    </section>
</form>