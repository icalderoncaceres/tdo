<?php
    if(!isset($_SESSION))
		session_start();
    if(file_exists('clases/eventos.php')){
        include_once 'clases/eventos.php';
        include_once 'clases/usuarios.php';
        include_once 'clases/fotos.php';
        include_once 'clases/aportes.php';
        include_once 'clases/recursos.php';
        include_once 'clases/articulos.php';
    }else{
        include_once '../../clases/eventos.php';
        include_once '../../clases/usuarios.php';
        include_once '../../clases/fotos.php';
        include_once '../../clases/aportes.php';
        include_once '../../clases/recursos.php';
        include_once '../../clases/articulos.php';        
    }
    $foto=new fotos();
    $evento=new eventos();
    $listaEventos=$evento->getEventosByUsuarios($_SESSION["id"]);
    $totalEventos=$evento->countEventosByUsuarios($_SESSION["id"]);	
?>
<article>
	<h2><center>Bienvenido <?php echo $_SESSION["seudonimo"];?></center></h2>
</article>
<div id="muro" class="pad20">
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
            &nbsp;&nbsp;&nbsp;<a href="#" id="publicar" name="publicar">Publicar</a>
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