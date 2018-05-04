<?php
include_once 'clases/usuarios.php';
include_once 'clases/bd.php';
if (isset ( $_SESSION ["id"] )) :
	$foto = $_SESSION ["fotoperfil"];
	$usuario = new usuario ( $_SESSION ["id"] );
	$tipo = "N";
endif;
?>

<div class="contenedor">
<input type="file" class="hidden" id="input_foto">
	<a  href="perfil.php?id=<?php echo  $_SESSION ["id"];?>"><div
		style='overflow: hidden; height: 150px; width: 150px; margin-top: -30px;'
		class="pull-right borderS foto-resumen marco-foto-conf ">		
		 <img
		 id="foto-usuario"
			src="<?php echo $foto;?>" style='max-height: 100%;' class="foto-perfil">			
	</div></a>
	<h3 class=" marL20 marR20 negro text-center" style="padding: 10px;">
		<span class="marL10 ">Configuraci&oacute;n de datos</span>
	</h3>
	<br> <br> <i class="fa fa-user  borderS t26 marL30"
		style="width: 60px; text-align: center; padding: 10px;"></i><span
		class="marL10 t18 ">Informaci&oacute;n personal</span> <br> <br> <br>
	<div class="linea-resumen marL30 marR30"
		style="border-top: 1px solid #e5e5e5">
		<b class="t14">Nombre: </b> <?php echo $usuario->u_nombres;?> <span class="opacity">
		</span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Apellido: </b> <?php echo $usuario->u_apellidos;?> <span
			class="opacity"> </span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Direcci&oacute;n:</b> <?php echo $usuario->u_direccion;?><span
			class="opacity"></span>
	</div>
	
	<div class=" marL30 marR30 text-right" style="padding: 10px;">
		<button type="button" class="btn btn-primary2" id="info-usuario" data-type="<?php echo $tipo;?>">Modificar</button>
	</div>
	<br> <i class="fa fa-lock  borderS t26 marL30"
		style="width: 60px; text-align: center; padding: 10px;"></i><span
		class="marL10 t18 ">Informaci&oacute;n de acceso</span> <br> <br> <br>

	<div class="linea-resumen marL30 marR30"
		style="border-top: 1px solid #e5e5e5">
		<b class="t14">Seudonimo: </b><?php echo $usuario->a_seudonimo;?> <span
			class="opacity"></span> <span class="vin-blue pull-right marR10"><a href="#" data-toggle="modal" data-target="#info-seudonimo">Editar</a></span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Correo: </b><?php echo $usuario->a_email;?>  <span class="opacity">
		</span> <span class="vin-blue pull-right marR10"><a href="#" data-toggle="modal" data-target="#info-correo">Editar</a></span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Contraseña: </b> ******** <span class="opacity"> </span> <span class="vin-blue pull-right marR10"><a href="#" data-toggle="modal" data-target="#info-pass">Editar</a></span>
	</div>
	<br> <br> <br> <br>
</div>