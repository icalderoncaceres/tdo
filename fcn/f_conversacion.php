<?php    
    include_once '../clases/bd.php';
    $bd=new bd();
    if(!isset($_SESSION))
        session_start();
    $consulta="select * from mensajes where (usuarios_id={$_SESSION["id"]} or amigos_id={$_SESSION["id"]}) and (usuarios_id={$_POST["id"]} or amigos_id={$_POST["id"]}) order by fecha desc limit 20";
    $mensajes=$bd->query($consulta);
    if(!empty($mensajes)):
        foreach($mensajes as $m=>$valor):
            if($valor["usuarios_id"]==$_SESSION["id"]):
            ?>
                <span>Tu dijistes</span>
            <?php
            else:
            ?>
                <span><?php echo $_POST["amigo"];?> dij&oacute;</span>
            <?php
            endif;
        ?>
           <div>
                <p><?php echo $valor["mensaje"];?></p>
           </div>
        <?php
        endforeach;
    endif;
?>