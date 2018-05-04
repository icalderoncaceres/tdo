<?php    
    include_once '../clases/bd.php';
    $bd=new bd();
    if(!isset($_SESSION))
        session_start();
    $pagina=filter_input(INPUT_POST,"pagina")?filter_input(INPUT_POST,"pagina"):1;
    $inicio=($pagina-1)*13;
    $id=filter_input(INPUT_POST,"id");
    $nombreamigo=filter_input(INPUT_POST,"amigo");
    $consulta="select * from mensajes where (usuarios_id={$_SESSION["id"]} or amigos_id={$_SESSION["id"]}) and (usuarios_id=$id or amigos_id=$id) order by fecha desc limit 13 OFFSET $inicio";
    $mensajes=$bd->query($consulta);
    $totalMensajes=$bd->query("select count(id) as tota from mensajes where (usuarios_id={$_SESSION["id"]} or amigos_id={$_SESSION["id"]}) and (usuarios_id=$id or amigos_id=$id)");
    $row=$totalMensajes->fetch();
    if($inicio>0):?>
        <a class="point" id="ver-mas-conversacion" name="ver-mas-conversacion" data-pagina="<?php echo ($pagina-1);?>" data-id="<?php echo $id;?>" data-amigo="<?php echo $nombreamigo;?>">Ver m&aacute;s recientes...</a><br>
    <?php
    endif;
    if(!empty($mensajes)):
        foreach($mensajes as $m=>$valor):
            if($valor["usuarios_id"]==$_SESSION["id"]):
            ?>
                <span class="t20 orange-apdp">Tu dijistes:</span> <span class="t16"><?php echo $valor["mensaje"];?></span>
            <?php
            else:
            ?>
                <span class="t20 orange-apdp"><?php echo $nombreamigo;?> dij&oacute;:</span> <span class="t16"><?php echo $valor["mensaje"];?></span>
            <?php
            endif;
            ?><br>
        <?php
        endforeach;
        if($row["tota"]>($inicio+13)):?>
            <a class="point" id="ver-mas-conversacion" name="ver-mas-conversacion" data-pagina="<?php echo ($pagina+1);?>" data-id="<?php echo $id;?>" data-amigo="<?php echo $nombreamigo;?>">Ver menos recientes...</a>
        <?php
        endif;
    endif;
?>