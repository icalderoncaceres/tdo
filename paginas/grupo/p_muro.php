<?php
include_once 'clases/grupos.php';
include_once 'clases/eventos.php';
include_once 'clases/usuarios.php';
include_once 'clases/fotos.php';
include_once 'clases/aportes.php';
include_once 'clases/recursos.php';
include_once 'clases/articulos.php';
$grupo=new grupos($_GET["id"]);
$foto=new fotos();
$evento=new eventos();
$listaEventos=$evento->getEventosByGrupos($grupo->id);
$totalEventos=$evento->countEventosByGrupos($grupo->id);
$entradas=$grupo->getEntradas();
$miembros=$grupo->getMiembros();
$totalEntradas=$grupo->countEntradas();
if($_SESSION["id"]==$grupo->usuarios_id){
    $claseAdmin="data-toggle='modal' data-target='#edit-entrada' class='point'";
}else{
    $claseAdmin="";
}
?>
<div class="row" id="principal" data-id="<?php echo $grupo->id;?>">
	<!-- inicion del row principal  -->
	<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 maB10  " >
		<!-- inicio contenido  -->
		<div class=" contenedor">
			<!-- inicio contenido conte1-1 -->
			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   ">
				<!-- inicio titulo y p  -->
				<h2 class=" marL20 marR20 t20 negro" style="padding:10px;"><span class="marL10 titulo"><?php echo $grupo->nombre;?></span></h2>
				<center>
					<hr class='ancho95'>
				</center>
				<br>
				<ul class="nav nav-tabs marL30 marR30 t14 " >
					<li role="presentation" class="pesta active" id="pesta1">
						<a class="point" class="grisO">Actividades del grupo <span class="badge badge-publicar-antes" id="titulo1" name="titulo1"> <?php echo $totalEntradas; ?></span></a>
					</li>
					<li role="presentation" class="pesta" id="pesta2">
						<a class="point" class="grisO">Muro &nbsp;&nbsp;<span class="badge badge-publicar-antes" id="titulo2" name="titulo2"> <?php echo $totalEventos;?></span></a>
					</li>
					<li role="presentation" class="pesta" id="pesta3">
						<a class="point" class="grisO">Miembros &nbsp;&nbsp;<span class="badge badge-publicar-antes" id="titulo3" name="titulo3"> <?php echo $miembros->rowCount();?></span></a>
					</li>                                        
                                        <?php
                                        if($_SESSION["id"]==$grupo->usuarios_id):
                                        ?>
					<li role="presentation" class="pesta" id="pesta4">
						<a class="point" class="grisO">Administraci&oacute;n <span class="badge badge-publicar-antes" id="titulo4" name="titulo4"><?php echo $totalEntradas;?></span></a>
					</li>
                                        <?php endif;?>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10"></div>
			<div class='row  marB10 marT10 marL50 marR30'>
                            <div id="actividades">
                                <?php
                                if($totalEntradas>0):
                                    $cadena="";
                                    $indice=0;
//                                    $fondo="fondo1";
                                    foreach($entradas as $a=>$valor):
                                        $indice++;
                                        if($valor["activo"]==1):
                                        ?>
                                            <div class="t30">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="color: <?php echo $valor["color"];?>">
                                                    <u><span><?php echo $valor["titulo"];?></span></u>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 " style="color: <?php echo $valor["color"];?>">
                                                    <span><?php echo $valor["descripcion"];?></span>
                                                </div>                                                
                                                <?php if($_SESSION["id"]==$grupo->usuarios_id): ?>
                                                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 " style="color: <?php echo $valor["color"];?>">
                                                        <a class='edit-entrada' data-color='<?php echo $valor["color"];?>' data-imagen='<?php echo !is_null($valor["fotos_id"])?"galeria/imagenes/{$valor["fotos_id"]}.png":"";?>' data-id="<?php echo $valor["id"];?>">
                                                            <span class="t14 blue-vin point">Editar</span>
                                                        </a>
                                                    </div>                                                
                                                <?php endif;?>                                                
                                            </div>
                                            <div class="col-xs-12"><br></div>
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-left t16">
                                                <ul>
                                                <?php
                                                    $items=$grupo->getItems($valor["id"]);
                                                    if($items):
                                                        foreach($items as $i=>$valor2):                                                        
                                                        ?>
                                                            <li><a <?php 
									 if(is_null($valor2["archivo"])){
									 	if(!is_null($valor2["vinculo"])){ 
                                            echo "href='{$valor2["vinculo"]}' target='_blank'";
										}
									 }else{ 
										echo "href='uploads/items/{$valor2["archivo"]}' target='_blank'";
									 }
									  ?>><i class="<?php echo $valor2["icono"];?>"></i> <?php echo $valor2["titulo"];?></a>
                                                                <?php if($_SESSION["id"]==$grupo->usuarios_id): ?>
                                                                    <i class='fa fa-pencil point edit-entrada2' data-id="<?php echo $valor2["id"];?>"></i>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-lg-4 hidden-sm">
                                                <?php if(!is_null($valor["fotos_id"])):?>
                                                        <img src="<?php echo 'galeria/imagenes/' . $valor["fotos_id"]. '.png';?>"/>
                                                <?php endif;?>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>                                        
                                            <?php
                                        endif;
                                            $primero=$indice==1?"no":"";
                                            $ultimo=$indice==$totalEntradas?"no":"";
                                            $coloractivo=$valor["activo"]==1?"red":"";
                                            $cadena.="<div class='t16' id='item" . $indice . "'>
                                                       <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2' style='background-color:" . $valor["color"] . "'>"
                                                      . date("d/m/y",strtotime($valor["fecha"])) . "</div>
                                                      <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style='background-color:" . $valor["color"] . "'>"
                                                      . substr($valor["titulo"],0,40) . "</div>
                                                      <div class='col-xs-12 col-sm-12 col-md-5 col-lg-5' style='background-color:" . $valor["color"] . "'>" 
                                                      . substr($valor["descripcion"],0,40) . "</div>
                                                      <div class='col-xs-12 col-sm-12 col-md-1 col-lg-1'>";
                                                      $cadena.="<i class='fa fa-arrow-up point arriba' data-id='" . $valor["id"] . "' data-posicion='" . $valor["posicion"] . "' data-activo='" . $primero ."'></i>";
                                                      $cadena.=" <i class='fa fa-arrow-down point abajo' data-id='" . $valor["id"] . "' data-posicion='" . $valor["posicion"] . "' data-activo='" . $ultimo . "'></i>";
                                                      $cadena.=" <i class='fa fa-eye point activo " . $coloractivo . "' data-id='" . $valor["id"] . "'></i>";
                                                      $cadena.="</div>
                                                      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><br></div></div>";
                                    endforeach;
                                else:
                                    ?>
                                    <div id="noresultados" name="noresultados" class="container center-block col-xs-12 col-sm-12 col-md-12 col-lg-12">	                                        
                                        <br>
                                        <br>
                                        <div class='alert alert-warning2  text-center' role='alert'  >                                        	
                                            <span class="t16"><i class="fa fa-info-circle"></i> No se encontraron entradas.</span>
                                        </div>
                                        <br>  
                                    </div>                                        
                                    <?php
                                endif;
                                ?>
                            </div>
                            <div id="muro" class="hidden pad20">
                                <div class="hidden-xs col-sm-9 col-md-9 col-lg-11"></div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-1"><a id="actualizar" name="actualizar" class="point">Actualizar</a></div>
                                <div class="col-xs-12" id="nuevo-mensaje" name="nuevo-mensaje">
                                    <div>
                                        <textarea id="txt-muro" name="txt-muro" class="form-textarea" placeholder="¿Que estas pensando?" rows="3"></textarea>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1 t14" >
                                        <div class="subir-img-active foto" style="margin-left: 0px;" data-toggle="tooltip" title="Puedes subir una imágen">
                                            <img class="img-responsive"/>
                                            <i style="position: relative; top:-40px; left:110%;" class="fa fa-times red hidden"></i>
                                        </div>
                                    </div>                                            
                                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                        <a href="#" id="publicar" name="publicar">Publicar</a>
                                    </div>
                                </div>
                                <div class="col-xs-12"><hr></div>
                                <div class="col-xs-12" id="lista-eventos" name="lista-eventos">
                                     <?php
                                     if($listaEventos):
                                         foreach($listaEventos as $e=>$valor):
                                            echo "<div>";
                                            $evento=new eventos($valor["id"]);
                                            echo $evento->getTitulo();
                                            if($evento->eventos_tipos_id==1):
                                                if(!is_null($evento->fotos_id)):
                                            ?>         
                                                    <div class="col-xs-12"><br></div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <img class="imagenes-muro" src="galeria/imagenes/<?php echo $evento->fotos_id;?>.png" align="left" />
                                                        <span class="text-justify t30"><?php echo $evento->mensaje;?></span>
                                                    </div>
                                                    <div class="col-xs-12"><hr></div>
                                            <?php
                                                else:?>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <span class="text-justify t30"><?php echo $evento->mensaje;?></span>
                                                    </div>
                                                    <div class="col-xs-12"><hr></div>
                                                <?php    
                                                endif;
                                            elseif($evento->eventos_tipos_id==2):
                                                $aporte=new aportes($evento->evento_id);?>
                                                <div class="col-xs-12"><br></div>
                                                <div class='col-xs-12 t24'><?php echo $aporte->contenido;?></div>
                                                <div class="col-xs-12"><a href="perfil.php?id=<?php echo $aporte->usuarios_id;?>"><?php echo $aporte->getUsuario();?></a> 
                                                    <?php echo date("d/m/y H:i:s",strtotime($aporte->fecha));?>
                                                </div>
                                                <?php
                                            elseif($evento->eventos_tipos_id==3):
                                                $recurso=new recursos($evento->evento_id);?>
                                                <div class="col-xs-12"><br></div>
                                                <div class='hidden-xs col-sm-4 t24'><img src='galeria/img/<?php echo $recurso->r_tipos_id;?>.jpg'/></div>
                                                <div class='col-xs-12 col-sm-8 t18'>
                                                    <div class="col-xs-12"><strong><u>Titulo:</u></strong> <?php echo $recurso->r_titulo;?></div>
                                                    <div class="col-xs-12"><strong><u>Descripci&oacute;n:</u></strong> <?php echo $recurso->r_descripcion;?></div>
                                                    <div class="col-xs-12"><strong><u>Dirigido a:</u></strong> <?php echo $recurso->r_scope;?></div>
                                                    <div class="col-xs-12"><strong><u>Formato:</u></strong> <?php echo $recurso->getFormato();?></div>
                                                    <div class="col-xs-12"><strong><u>Fecha:</u></strong> <?php echo date("d/m/y H:i:s",strtotime($recurso->r_fecha));?></div>
                                                    <div class="col-xs-12"><strong><u>Colaborador:</u></strong> <?php echo $recurso->getUsuario();?></div>
                                                    <div class="col-xs-12"><br></div>
                                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><a href="<?php echo $recurso->getDestino();?>" target="_blank">Probar</a></div><div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><a href="<?php echo $recurso->getDestino();?>" target="_blank">Descargar</a></div>
                                                </div>;
                                                <?php
                                            elseif($evento->eventos_tipos_id==4):
                                                $arti=new articulos($evento->evento_id); ?>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <br><a href="<?php echo $arti->a_ruta;?>" target="_blank"><span class="text-justify t30"><?php echo $arti->a_titulo;?></span></a>
                                                </div>
                                                <div class="col-xs-12"><hr></div>
                                                <?php
                                            elseif($evento->eventos_tipos_id==5):?><br>
                                                $recurso=new recursos($evento->evento_id);?>
                                                <div class="col-xs-12"><br></div>
                                                <div class='hidden-xs col-sm-4 t24'><img src='galeria/img/<?php echo $recurso->r_tipos_id;?>.jpg'/></div>
                                                <div class='col-xs-12 col-sm-8 t18'>
                                                    <div class="col-xs-12"><strong><u>Titulo:</u></strong> <?php echo $recurso->r_titulo;?></div>
                                                    <div class="col-xs-12"><strong><u>Descripci&oacute;n:</u></strong> <?php echo $recurso->r_descripcion;?></div>
                                                    <div class="col-xs-12"><strong><u>Dirigido a:</u></strong> <?php echo $recurso->r_scope;?></div>
                                                    <div class="col-xs-12"><strong><u>Formato:</u></strong> <?php echo $recurso->getFormato();?></div>
                                                    <div class="col-xs-12"><strong><u>Fecha:</u></strong> <?php echo date("d/m/y H:i:s",strtotime($recurso->r_fecha));?></div>
                                                    <div class="col-xs-12"><br></div>
                                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><a href="<?php echo $recurso->getDestino();?>" target="_blank">Probar</a></div><div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><a href="<?php echo $recurso->getDestino();?>" target="_blank">Descargar</a></div>
                                                </div>;
                                                <?php
                                            endif;
                                            $hasCal=$evento->hasCalificacion();
                                            $totalCalificaciones=$evento->countCalificaciones();
                                            ?>
                                            <div class='col-xs-12'>
                                                <div data-id="<?php echo $evento->id;?>" data-nuevo="<?php echo $hasCal!=0?1:0;?>">
                                                    <i class='fa fa-thumbs-up point calificar-evento <?php if($hasCal==1) echo "red";?>'></i> <span class="badge"><?php echo $totalCalificaciones[0]; ?></span>
                                                    <i class='fa fa-thumbs-down point calificar-evento <?php if($hasCal==-1) echo "red";?>'></i> <span class="badge"><?php echo $totalCalificaciones[1]; ?></span>
                                                </div><br>
                                                <div class='form-group'>
                                                    <textarea class='form-textarea' rows='1' placeholder='Comentario'></textarea>
                                                    <div class="pull-right t8"><a class="publicar-comentario point" data-id="<?php echo $evento->id;?>">Publicar</a></div>
                                                </div>                                                
                                            </div>
                                            <div class='col-xs-12'><hr></div>
                                            <?php
                                            if($evento->mensaje!="" && !is_null($evento->mensaje) && $evento->eventos_tipos_id>1 ):?>
                                                <div class="col-xs-12"><?php echo $evento->mensaje;?></div>
                                                <?php
                                            endif;
                                            $totalComentarios=$evento->countComentarios();
                                            echo "<div id='comentarios-$evento->id' class='col-xs-12 pad5' data-total='" . $totalComentarios . "'>";
                                            echo $evento->getComentarios() . "</div>";
                                            if($totalComentarios>13): ?>
                                                <div class="pad10"><a href="#" class="ver-mas-comentarios" data-pagina="2">Ver m&aacute;s comentarios...</a></div>
                                            <?php endif;?>
                                            <div class='col-xs-12' style='background:#ccc;'><br></div>
                                            </div> <!--El div que cubre todo el evento-->
                                            <?php
                                        endforeach;
                                     endif;
                                     ?>
                                </div><?php
                                if($totalEventos>20):?>
                                    <div class="pull-right"><a href="#" id="ver-mas-eventos" name="ver-mas-eventos" data-pagina="2" data-total="<?php echo $totalEventos;?>">Ver m&aacute;s...</a></div>
                                <?php
                                endif;?>
                            </div>
                            <div id="miembros" class="hidden">
                                <?php
                                    if($miembros):
                                        foreach($miembros as $m=>$valor):                            
                                            $usua=new usuario($valor["usuarios_id"]);
                                            $miTitulo=$usua->getNombre();
                                        ?>
                                            <div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
					  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
						    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='<?php echo $usua->id;?>'>
						</div>
                                            </div>											
                                            <div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
						<p class='marL10 marT5'>
                                                <span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?> </b></a></span>
                                                <!--<span class=""><img style="margin-top: -5px;" src="galeria/img/iconos_cat/verificado.png" height="18px" width="auto" /></span>-->
                                                <br>
                                                <span class='t14 grisO '><?php echo $miTitulo;?></span>
						<br>
						<span class=' grisO '> 		
                                                    <span class="t12"><?php echo utf8_decode($usua->getRegion());?></span>
                                                    <br>
                                                    <i class='fa fa-thumbs-o-up opacity '></i>
                                                    <span class='t11 point h-under marL5'>4 Seguidores</span>
						</span>
						<br>
                                                <span class='t12 orange-apdp'> <?php echo $usua->getTiempo();?> Compartiendo con nosotros</span>
                                                <br>			    
                    			        </p>
					    </div>
                                            <br>
					    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
                                                <div class='marR20'>
                                                    <span class='vin-blue t16'><a href='perfil.php?id=<?php echo $usua->id;?>' style='text-decoration:underline;'>Ver Perfil</a></span >
                                                </div>
                                            </div>
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div>
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </div>
                            <div id="entradas" class="hidden">
                                <div class="col-xs-12">
                                    <span class="t18">C&oacute;digo de afiliaci&oacute;n: <?php echo $grupo->getCodigo();?></span><hr>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 ">
                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><i class="fa fa-arrow-up"></i> Subir </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><i class="fa fa-arrow-down"></i> Bajar </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><i class="fa fa-eye red"></i> Activa </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><i class="fa fa-eye"></i> Inactiva</div>
                                </div>                                
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ">
                                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#add-entrada">Agregar</button>
                                </div>
                                <?php
                                if($_SESSION["id"]==$grupo->usuarios_id):
                                ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10 " style="background: #F2F2F2;">
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Fecha</div>
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">Titulo</div>
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">Descripci&oacute;n</div>
                                    </div>
                                    <div id="lista-entradas" name="lista-entradas">
                                         <?php
                                         if($totalEntradas>0):
                                             echo $cadena;
                                         endif;
                                         ?>
                                    </div>
                                    <hr>
                                <?php endif;?>
                            </div>                                    
                        </div>
                        <!-- fin contenido conte1-1 -->
                </div >
	<!-- fin de contenido -->
        </div>
</div>