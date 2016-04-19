<?php
if(file_exists('clases/bd.php')){
	include_once 'clases/bd.php';
	include_once 'clases/fotos.php';
}else{
	include_once '../../clases/bd.php';
	include_once '../../clases/fotos.php';
}
$foto=new fotos();
$bd=new bd();
$result=$bd->query("select r.usuarios_id,count(r.id) as tota,seudonimo from recursos as r,usuarios_accesos as a
                    where r.usuarios_id=a.usuarios_id group by r.usuarios_id order by tota desc limit 5");
?>
<div class="row">
    <div class="col-xs-12">
        <br>
    </div>
    <div class="col-xs-12">
        <center><span class="t30">Colaboradores del mes</span></center>
        <br>
    </div>
    <?php
    var_dump(unserialize($_COOKIE["lista"]));
    foreach ($result as $r=>$valor):
        ?>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
            <a href="perfil.php?id=<?php echo $valor["usuarios_id"];?>">
             <img class="img-top" src="<?php echo $foto->buscarFotoUsuario($valor["usuarios_id"]);?>"/>
            </a>
            <br>
            <a class="vin-blue t18" href="perfil.php?id=<?php echo $valor["usuarios_id"];?>">
                <span><?php echo $valor["seudonimo"];?></span>
                <span>(<?php echo $valor["tota"];?>)</span>
            </a>
        </div>
    <?php
        endforeach;
    ?>
</div>