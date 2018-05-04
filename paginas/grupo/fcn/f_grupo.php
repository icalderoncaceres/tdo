<?php
include_once "../../../clases/bd.php";
include_once "../../../clases/fotos.php";
include_once "../../../clases/eventos.php";
include_once "../../../clases/aportes.php";
include_once "../../../clases/recursos.php";
include_once "../../../clases/articulos.php";
$mymetodo= filter_input(INPUT_POST,"metodo");
$mymetodo();
function guardarEntrada(){
    $bd=new bd();
    $imagen=filter_input(INPUT_POST,"imagen");
    $id=filter_input(INPUT_POST,"id");
    $titulo=filter_input(INPUT_POST,"e_titulo");
    $descripcion=filter_input(INPUT_POST,"e_descripcion");
    $color=filter_input(INPUT_POST,"e_color");
    $capitulos=filter_input(INPUT_POST,"capitulos");
    if($imagen){
        $foto=new fotos();        
        $nuevaImagen=$foto->crearFotoEvento();
	$data_url = str_replace(" ", "+", $imagen);
	$filteredData=substr($data_url, strpos($data_url, ",")+1);
	$unencodedData=base64_decode($filteredData);
        $ruta = "../../../galeria/imagenes/{$nuevaImagen}.png";
	file_put_contents($ruta, $unencodedData);        
    }else{
        $nuevaImagen=null;
    }
    $result=$bd->query("select count(id) as tota from entradas_grupos where grupos_id=$id");
    $row=$result->fetch();
    $posicion=$row["tota"] + 1;
    $valores=array("grupos_id"=>$id,
                   "titulo"=>$titulo,
                   "descripcion"=>$descripcion,
                   "fecha"=>date("Y-m-d H:i:s",time()),
                   "color"=>$color,
                   "fotos_id"=>$nuevaImagen,
                   "posicion"=>$posicion
                  );
    $res=$bd->doInsert("entradas_grupos",$valores);    
    $nuevoId=$bd->lastInsertId();
    $ids=array();
    $resultado=1;
    if($capitulos!=""){
        $resultado=2;
        $capitulos=explode("F,.,.I",$capitulos);
        $indice=0;
        foreach($capitulos as $c){
            $indice++;
            $item=explode("I,.,.F",$c);
            $valores=array("entradas_id"=>$nuevoId,
                           "grupos_id"=>$id,
                           "titulo"=>$item[0],
                           "icono"=>$item[1],
                           "posicion"=>$item[2],
                           "vinculo"=>$item[3]!="Sin Vinculo"?$item[3]:NULL
                          );
            $res.=$bd->doInsert("entradas_capitulos",$valores);
            if($item[4]==1){
                $ids[]=$bd->lastInsertId();
            }
        }
    }    
    echo json_encode(array("result"=>$resultado,"ids"=>$ids));
}
function cambiarPosicion(){
    $bd=new bd();
    $direccion=  filter_input(INPUT_POST,"direccion");
    $posicion=  filter_input(INPUT_POST,"posicion");
    $id_grupo=  filter_input(INPUT_POST,"id_grupo");
    $id=  filter_input(INPUT_POST,"id");
    if($direccion=="arriba"){
        $posicion=$posicion - 1;
        $result=$bd->doUpdate("entradas_grupos", array("posicion"=>$posicion+1), "grupos_id=$id_grupo and posicion=$posicion");
    }else{
        $posicion=$posicion + 1;
        $result=$bd->doUpdate("entradas_grupos", array("posicion"=>$posicion-1), "grupos_id=$id_grupo and posicion=$posicion");
    }
    $result.=$bd->doUpdate("entradas_grupos", array("posicion"=>$posicion), "id=$id");
    echo $result;
}
function publicar(){
    $bd=new bd();
    if(!isset($_SESSION))
        session_start();
    $imagen=filter_input(INPUT_POST,"imagen");
    $grupos_id=filter_input(INPUT_POST,"grupos_id");
    $id=$_SESSION["id"];
    $mensaje=filter_input(INPUT_POST,"mensaje");
    if($imagen){
        $foto=new fotos();
        $nuevaImagen=$foto->crearFotoEvento();
	$data_url = str_replace(" ", "+", $imagen);
	$filteredData=substr($data_url, strpos($data_url, ",")+1);
	$unencodedData=base64_decode($filteredData);
        $ruta = "../../../galeria/imagenes/{$nuevaImagen}.png";
	file_put_contents($ruta, $unencodedData);
    }else{
        $nuevaImagen=null;
    }    
    if(!$grupos_id){
        $misgrupos=$bd->doFullSelect("usuarios_grupos","usuarios_id=$id","grupos_id");
        $grupo="";
        if(!empty($misgrupos)){
            foreach($misgrupos as $mg){
                $grupo.="I" . $mg["grupos_id"] . "F";
            }
        }
    }else{
        $grupo="I" . $grupos_id . "F";
    }
    $valores=array("mensaje"=>$mensaje,
                   "usuarios_id"=>$id,
                   "eventos_tipos_id"=>1,
                   "fecha"=>date("Y-m-d H:i:s",time()),
                   "evento_id"=>NULL,
                   "grupos"=>$grupo,
                   "fotos_id"=>$nuevaImagen,
                   "status"=>1
                  );
    $result=$bd->doInsert("eventos", $valores);
    if($result){
        $nuevoId=$bd->lastInsertId();
        $evento=new eventos($nuevoId);
        $devolver=array("result"=>"ok","titulo"=>$evento->getTitulo());
        echo json_encode($devolver);
    }else{
        echo json_encode(array("result"=>"error"));
    }
}
function publicarComentario(){
    $bd=new bd();
    if(!isset($_SESSION))
        session_start();
    $eventos_id=  filter_input(INPUT_POST, "eventos_id");
    $mensaje=  filter_input(INPUT_POST, "mensaje");
    $valores=array("eventos_id"=>$eventos_id,
                   "usuarios_id"=>$_SESSION["id"],
                   "fecha"=>date("Y-m-d H:i:s",time()),
                   "comentario"=>$mensaje
                   );
    $result=$bd->doInsert("eventos_comentarios", $valores);
    if($result){
        $devolver=array("result"=>"ok","id"=>$_SESSION["id"],"foto"=>$_SESSION["fotoperfil"],"nombre"=>$_SESSION["seudonimo"]);
        echo json_encode($devolver);
    }else{
        echo json_encode(array("result"=>"error"));
    }
}
function cambiarStatus(){
    $bd=new bd();
    $operacion=  filter_input(INPUT_POST,"operacion");
    $status=$operacion==1?0:1;
    $id=filter_input(INPUT_POST,"id");
    $result=$bd->doUpdate("entradas_grupos", array("activo"=>$status), "id=$id");
    echo $result;
}
function editentrada(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");    
    $titulo=filter_input(INPUT_POST,"titulo");
    $descripcion=filter_input(INPUT_POST,"descripcion");
    $color=filter_input(INPUT_POST,"color");
    $valores=array("titulo"=>$titulo,
                   "descripcion"=>$descripcion,
                   "color"=>$color
                  );
    $result=$bd->doUpdate("entradas_grupos",$valores,"id=$id");
    echo $result;
}
function editentrada2(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");
    $titulo=filter_input(INPUT_POST,"titulo");
    $vinculo=filter_input(INPUT_POST,"vinculo");
    $valores=array("titulo"=>$titulo,
                   "vinculo"=>$vinculo
                  );
    $result=$bd->doUpdate("entradas_capitulos", $valores, "id=$id");
    echo $result;
}
function vermaseventos(){
    $pagina=  filter_input(INPUT_POST,"pagina");
    $id=  filter_input(INPUT_POST,"id");
    $inicio=($pagina-1)*20;
    $evento=new eventos();
    if(isset($id)){ //Viene del muro del grupo
        $result=$evento->getEventosByGrupos($id,$inicio);
    }else{ //Viene del muro del usuario
        if(!isset($_SESSION))
            session_start();
        $result=$evento->getEventosByUsuarios($_SESSION["id"],$inicio);
    }
    foreach($result as $e=>$valor):
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
        endif;?>
        <div class='col-xs-12'>
            <i class='fa fa-thumbs-up'></i> <i class='fa fa-thumbs-down'></i><br>
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
            echo $evento->getComentarios();?>
            <div class='col-xs-12' style='background:#ccc;'><br></div>
        </div> <!--El div que cubre todo el evento-->
    <?php
    endforeach;
}
function vermascomentarios(){
    $id=filter_input(INPUT_POST,"id");
    $pagina=filter_input(INPUT_POST,"pagina");
    $inicio=($pagina-1)*13;
    $evento=new eventos($id);
    $result=$evento->getComentarios($inicio);
    echo $result;
}
function calificarevento(){
    $bd=new bd();
    $id=filter_input(INPUT_POST,"id");
    if(!isset($_SESSION))
        session_start();
    $usuario=$_SESSION["id"];
    $calificacion=filter_input(INPUT_POST,"calificacion");
    $accion=filter_input(INPUT_POST,"accion");
    $nuevo=filter_input(INPUT_POST,"nuevo");
    if($accion==="poner"){
        if($nuevo==1){
            $result=$bd->doUpdate("eventos_calificaciones",array("calificacion"=>$calificacion),"eventos_id=$id and usuarios_id=$usuario");
        }else{
            $valores=array("eventos_id"=>$id,
                           "usuarios_id"=>$usuario,
                           "fecha"=>date("Y-m-d H:i:s",time()),
                           "calificacion"=>$calificacion
                           );
            $result=$bd->doInsert("eventos_calificaciones",$valores,"eventos_id=$id and usuarios_id=$usuario");
        }
    }else{
        $result=$bd->query("delete from eventos_calificaciones where eventos_id=$id and usuarios_id=$usuario");
    }
}