<?php
if (! headers_sent ()) {
	header ( 'Content-Type: text/html; charset=ISO-8859-1' );
}
// Incluimos las clases a usar.
if (file_exists ( '../../../clases/usuarios.php' )) {
	include_once '../../../clases/usuarios.php';
	include_once '../../../clases/fotos.php';
	include_once '../../../clases/amigos.php';
}

// validamos el session_start
if (! isset ( $_SESSION )) {
	session_start ();
}
// validamos que el id este seteado, caso contrario regresamos al usuario a otra pagina
if (isset ( $_GET ["u"] )) :
	$bd = new bd();
	$table = 'usuarios_accesos';
	$condicion = 'seudonimo="'.$_GET["u"].'"';
	$result = $bd->doSingleSelect($table,$condicion,'usuarios_id');
	$id = $result['usuarios_id'];
	$usuario = new usuario ( $id ); // instanciamos la clase usuario(perfil a ver)
	$amigos = new amigos ();
	$foto = new fotos ();
	$bd = new bd ();
	
	endif;
if (isset ( $_SESSION ["id"] )) {
	$usuarioActual = new usuario ( $_SESSION ["id"] );
}
$resultamigos = $amigos->buscarAmigos2 ( $id, filter_input ( INPUT_GET, "filter" ), filter_input ( INPUT_GET, "q" ) );
if (! empty ( $resultamigos )) :
	foreach ( $resultamigos as $row ) :
		?>
<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
	<div class="contenedor sombra-div" style="margin: 10px;">
		<div class="marco-foto-amigos center-block marT20" style="width: 50%">
			<a class="vin-blue" href="<?php echo $row["seudonimo"];?>"><img
				src="<?php echo $foto->buscarFotoUsuario($row["numero"])?>"
				alt="..." style="width: 100%"
				class=" img img-responsive foto-perfil"></a>
		</div>
		<div class="text-center marT20 marB20">
			<a class="vin-blue" href="<?php echo $row["seudonimo"];?>"><span
				class="seudonimo"><?php echo $row["seudonimo"];?></span></a> <br> <span
				class="nom-ape"><?php echo $row["nombre"]?></span> <br> <br>
			<div class="btn-group">
				<button type="button" class="btn btn-primary2">Amigos</button>
				<button type="button" class="btn btn-primary2 dropdown-toggle"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu">
					<li><a class="vin-blue"
						href="<?php echo $row["seudonimo"];?>">Ver Perfil</a></li>
					<li class="hidden"><a href="#">Dejar de ser amigos</a></li>
					<li class="hidden"><a href="#">Bloquear</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>
<?php else:?>
<div class="alert alert-warning2 text-center marT100" role="alert" ><i class="fa fa-info-circle"></i> No Tienes Amigos Por Ahora</div>
<?php endif;?>