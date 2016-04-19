<?php 
if (!headers_sent()) {
	header('Content-Type: text/html; charset=ISO-8859-15');
}

// Incluimos las clases a usar.
include_once '../../clases/usuarios.php';
include_once '../../clases/bd.php';
include_once '../../clases/fotos.php';
include_once '../../clases/amigos.php';
// validamos el session_start
if (! isset ( $_SESSION )) :
	session_start ();
endif;
// validamos que el id este seteado, caso contrario regresamos al usuario a otra pagina
if (isset ( $_GET ["u"] )) :
	$bd = new bd();
	$table = 'usuarios_accesos';
	$condicion = 'seudonimo="'.$_GET["u"].'"';
	$result = $bd->doSingleSelect($table,$condicion,'usuarios_id');
	$id = $result['usuarios_id'];
	$usuario = new usuario ( $id ); // instanciamos la clase usuario(perfil a ver)
	$estado_id = $usuario->u_estados_id; // obtengo el id del estado para luego mostrar
	$bd = new bd ();
endif;
$actual=0;
if(isset($_GET["u"])){
	
}
if (isset ( $_SESSION ["id"] )) :
	if($_SESSION["id"]==$_GET["u"]){
			$actual=1;
	}
	$usuarioActual = new usuario ( $_SESSION ["id"] );
	$estado_id = $usuarioActual->u_estados_id;
endif;
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>
	<div class="row mar-perfil-amigos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row"
				style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div>
						<h3 class="  titulo-perfil ">
							<i class="fa fa-users"></i> <?php if($actual==1) echo "Panas que te Siguen"; else echo "Seguidores de este Pana"; ?>
						</h3>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-right">
					<div class="navbar-form marR10 marL10" role="search">
						<div class="input-group input">
							<input name="q" id="q" type="text" class="form-control input-xs "
								placeholder="Buscar"> <span class="input-group-btn">
								<button id="amigoSearch" class="btn btn-default input-xs" style="width: 50px;" data-tipo="2">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
						<select class="form-control input" id="filter" name="filter" data-tipo="2">
							<option value="all">Todos</option>
							<option value="ven" disabled>Mas ventas</option>
							<option value="jur">Empresas</option>
							<option value="nat">Personas</option>
							<?php $row = $bd->doSingleSelect("estados","id = $estado_id")?>
							<option value="<?php echo $row["id"]?>"><?php echo $row["nombre"]?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<br>
		</div>
		<!--===== CONTENIDO AMIGOS =====-->
		<div id="ajaxAmigos">
		<?php include 'fcn/f_amigos2.php';?> 
		</div>
		<!--=== FIN CONTENIDO AMIGOS ===-->
	</div>
	<br> <br class="hidden-xs"> <br class="hidden-xs">
</div>
