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
$rndId=  rand(1, 25);
$pensamiento=$bd->doSingleSelect("pensamientos","id=$rndId");
if(isset($_SESSION["id"])){
	$bd->doInsert("trafico",array("usuarios_id"=>$_SESSION["id"],"pagina"=>1,"fecha"=>date("Y-m-d H:i:s",time())));
}else{
	$bd->doInsert("trafico",array("usuarios_id"=>-1,"pagina"=>1,"fecha"=>date("Y-m-d H:i:s",time())));
}
?>
<div class="row">
    <div class="col-xs-12">
        <br>
    </div>
    <div class="col-xs-12">
        <center><span class="t30">Colaboradores del mes</span></center>
        <br>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php
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
    <div class="col-xs-12">
        <hr>
        <br>
    </div>
    <div class="col-xs-12 t28">
        <cite>"<?php echo $pensamiento["pensamiento"];?>"</cite>
        <cite>(<?php echo $pensamiento["autor"];?>)</cite>
    </div>
</div>