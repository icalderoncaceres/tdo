<?php
include_once 'clases/grupos.php';
include_once 'clases/eventos.php';
$grupo=new grupos($_GET["id"]);
$evento=new eventos();
$listaEventos=$evento->getEventosByGrupos($grupo->id);
?>
<div class="row">
    <h1>Actividades del grupo: <?php echo $grupo->nombre;?></h1>
    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php
            foreach ($listaEventos as $l=>$valor):
                ?>
                <div><?php echo $valor["mensaje"]?></div>
                <div><?php echo $valor["fecha"]?></div>
                <?php
            endforeach;
        ?>
    </section>
</div>