<?php
if(file_exists('../../clases/usuarios.php')){
	include_once '../../clases/usuarios.php';
	include_once '../../clases/publicaciones.php';
	$vienedeAjax=true;
}else{
	$vienedeAjax=false;
	include_once "clases/publicaciones.php";
}
if (! isset ( $_SESSION )) {
	session_start ();
}
$bd = new bd();
	$table = 'usuarios_accesos';
	$condicion = 'seudonimo="'.$_GET["u"].'"';
	$result = $bd->doSingleSelect($table,$condicion,'usuarios_id');
	$id = $result['usuarios_id'];
$usua=new usuario($id);
$alerts = $usua -> getAllNotificaciones();
$pagina=1;
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>
	<div class="row mar-perfil-amigos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row" style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div>
						<h3 class="  titulo-perfil ">
							<i class="fa fa-newspaper-o"></i> Ultimas Noticias
						</h3>
					</div>
				</div>
			</div>
		</div>
		<?php
			$hijos=$usua->getPublicaciones(1);
   		$ac=0;
		if(!empty($hijos)){
			$publicaciones=$hijos;
		?>
		<script type="text/javascript">$("#categorias").css("display","none");</script>
			<?php
		}else{
			$publicaciones=array();
		}
		?> 
		<div id="noresultados" name="noresultados" class="container center-block col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">	
		<br>
		<br>
		<div class='alert alert-warning2  text-center' role='alert'  >                                        	
              	<span class="t16  "><i class="fa fa-info-circle"></i> No tienes ninguna noticia, deberias conseguir m&aacutes panas.</span>
         </div>
         <br>  
        </div>
		<div class="row " id="publicaciones" name="publicaciones">
									<?php
									$ac=0;
									foreach($alerts as $key => $valor) {
										$fecha = $val["fecha"];
										$tipo = $val["tipo"];
										$id_pana = $val["pana"];
										$id_pub = $val["pub"];
										$id_pre = $val["pregunta"];
										$pub = new publicaciones($id_pub);
										$segundos = strtotime('now')-strtotime($fecha);
										$tiempo = $pub -> getTiempo($segundos);
										if($tipo==1){//Pregunta
											$foto = $pub -> getFotoPrincipal();
											$title= $pub -> tituloFormateado();
											$id   = 1;
											$tema = "Te Preguntaron";
											$link = "pre_pub";
										}
										if($tipo==2){//Repuesta
											$foto = $pub -> getFotoPrincipal();
											$title= $pub -> tituloFormateado();
											$id   = 2;
											$tema = "Te Respondieron";
											$link = "res_pub";
										}
										if($tipo==3){//Panas
											$foto = $usr -> buscarFotoUsuario($id_pana);
											$title= $usr -> getPana($id_pana);
											$id   = $title;
											$tema = "Ahora es tu pana";	
											$link = "perfil";
										}
										if($tipo==4){//Publicacion
											$foto = $pub -> getFotoPrincipal();
											$title= $pub -> tituloFormateado();
											$tema = "Tu Pana ha publicado";
											$id   = $id_pub;
											$link = "publicaciones1";
										}
										$cadena="
										<div class='general ".$link."' id='general' name='general' data-titulo='" . $tema . "'>
											<div class=' col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20'></div>
											<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
								    		<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >							 
									    	<img src='" . $foto. "' class='img img-responsive center-block img-apdp imagen ".$link."'  >						
											</div>
											</div>
											<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
										<p class='t16 marL10 marT5'>
										    <span class=' t15'><a class='negro' href='publicacion-" . $publi->id . "' class='grisO'><b>" . $publi->titulo . "</b></a></span>
											<br>
											<span class=' vin-blue t14'><a style='cursor:pointer;' class=''><b>" . $usua->a_seudonimo . "</b></a></span>
											<br>
											<span class='t14 grisO '>" . $usua->getNombre() . "</span>
											<br>
											<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i>" . $publi->getTiempoPublicacion() . "</span>
											<br>
											<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'> " . $publi->getVisitas() . " Visitas</span><i class='fa fa-thumbs-up negro marL15 opacity'>
											</i><span class=' point h-under marL5'>" . $publi->getFavoritos() .  " Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'>15 Veces compartido</span> </span>
								      </p>
								    </div>
								    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
								    	<br>
								    	<div class='marR20'>
								    		<span class='red t20'><b>". $publi->getMonto() . "</b></span >
											<br>
											<span class=' t12'>" . $estado . "</span>
											<br>
											<span class='vin-blue t16'><a href='publicacion-" . $valor["id"] . "' style='text-decoration:underline;'>Ver Mas</a></span >
										</div>
									</div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><hr class='marR10'><br></div></div> <!-- inicio del registro de la publicacion-->";									
									echo $cadena;
								}
								$ac=$usua->getCantidadPub(1);
								$totalPaginas=floor($ac/25);
								$restantes=$ac-($totalPaginas*25);
								if($restantes>0){
									$totalPaginas++;
								}
								echo"</div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' id='paginas' name='paginas' data-metodo='buscarPublicaciones' data-id='" . $usua->id . "'> <center><nav><ul class='pagination'>";
								$contador=0;
								if($pagina<=10){
									$inicio=1;
								}else{
									$inicio=floor($pagina/10);
									if($pagina % 10!=0){
										$inicio=($inicio*10)+1;
									}else{
										$inicio=($inicio*10)-9;
									}									
								}
								 								 
								for($i=$inicio;$i<=$totalPaginas;$i++){
									$contador++;
									if($i==1){
										echo "<li class='active' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}else{
										echo "<li class='' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}
									if($contador==10){
										break;
									}
								}
								echo "</li></ul></nav></center></div></div></div></div></div></div>";
								?>
									<!-- fin de la fila de la publicacion  -->						
		</div>
		
	</div>