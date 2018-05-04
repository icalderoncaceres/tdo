<?php
if(file_exists('../../clases/usuarios.php')){
	include_once '../../clases/usuarios.php';
	include_once '../../clases/recursos.php';
	$vienedeAjax=true;
}else{
	$vienedeAjax=false;
}
if (!isset ( $_SESSION )) {
	session_start ();
}
$bd = new bd();
$id=$_GET['id'];
$usua=new usuario($id);
$recursos=$usua->getRecursos();
$pagina=1;
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>
	<div class="row mar-perfil-amigos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row"
				style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div>
						<h3 class="titulo-perfil ">
							<i class="fa fa-tags"></i> Recursos educativos
						</h3>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-right">					
					<div class="navbar-form marR10 marL10" role="search">
						<i class="fa fa-list t24 marR10 grisC hidden"></i>
						<i class="fa fa-th-large t24 marR10 grisC hidden"></i>
						<div class="input-group" style="">
                        				<span class="input-group-btn">
                                                            <button class="btn-header btn-default-header" style="border: #ccc 1px solid; border-right:transparent;">
                                                                <span class="glyphicon glyphicon-search"></span>
                                                            </button>
                                                        </span> <input style="margin-left: -10px; border: #ccc 1px solid; border-left:1px solid #FFF; width: 180px; type="text" class="form-control-header " placeholder="Buscar" id="txtBusqueda" name="txtBusqueda">
                				</div>
						<select class="form-control input" id="filter" name="filter">
							<option >Mas Recientes</option>
							<option >Menos Recientes</option>
							<option >Mayor Precio</option>
							<option >Menor Precio</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div id="noresultados" name="noresultados" class="container center-block col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">	
                    <br>
                    <br>
                    <div class='alert alert-warning2  text-center' role='alert'  >                                        	
                        <span class="t16  "><i class="fa fa-info-circle"></i> No se encontraron publicaciones favoritas.</span>
                    </div>
                    <br>  
                </div>
		<div class="row " id="publicaciones" name="recursos">
                    <?php
                        if(!empty($recursos)):
                            $ac=0;
                            foreach($recursos as $key => $valor):
                                $ac++;
                                $recurso=new recursos($valor["id"]);
                                $estado=$vienedeAjax?utf8_encode($usua->getRegion()):$usua->getRegion();
                                ?>
                                    <div class='general' id='general<?php echo $valor["id"];?>' data-titulo='<?php echo $recurso->r_titulo;?>'>
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20'></div>
                                        <div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
                                            <div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'>
                                                 <img src='galeria/img/<?php echo $recurso->r_tipos_id;?>.jpg' class='img img-responsive center-block img-apdp imagen' data-id='<?php echo $valor["id"];?>'>
                                            </div>
                                        </div>
                                        <div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
                                            <p class='t16 marL10 marT5'>
                                                <span class=' t15'><a class='negro' href='#' class='grisO'><b><?php echo $recurso->titulo;?></b></a></span><br>
                                                <span class=' vin-blue t14'><b><?php echo $usua->a_seudonimo;?></b></span><br>
                                                <span class='t14 grisO '><?php echo $usua->getNombre();?></span><br>
                                                <span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i> <?php echo date("d/m/y",strtotime($recurso->r_fecha));?></span><br>
                                                <span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span>
                                                    <span class='marL5'> <?php echo $recurso->countVisitas();?> Visitas</span><i class='fa fa-thumbs-up negro marL15 opacity'></i>
                                                    <span class=' point h-under marL5'><?php echo $recurso->countDescargas();?>  Descargas</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'><br>
                                            <div class='marR20'>
                                                <?php
                                                if(isset($_SESSION["id"])):?>
                                                    <span class='vin-blue t16'><a href='<?php echo $recurso->r_ruta;?>' style='text-decoration:underline;' target="_blank">Probar</a></span ><br><br>
                                                    <span class='vin-blue t16'><a href='<?php echo $recurso->r_ruta;?>' style='text-decoration:underline;' target="_blank">Descargar</a></span >
                                                <?php
                                                endif;?>
                                            </div>
                                        </div>
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div>
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><hr class='marR10'><br></div>
                                    </div> <!-- inicio del registro de la publicacion-->";
                                    <?php
                            endforeach;
                        else:?>
                            <div class="alert alert-success t30">
                                <br class="hidden-sm"><br class="hidden-sm">
                                <p>A&uacute;n no contamos con recursos aportados por est&eacute; usuario.</p><br>
                            </div>
                        <?php endif;?>
		</div>
	</div>
</div>