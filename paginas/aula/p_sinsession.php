<?php
include_once "clases/bd.php";
$bd=new bd();
$result=$bd->query("select r.usuarios_id,count(r.id) as tota,seudonimo from recursos as r,usuarios_accesos as a
                    where r.usuarios_id=a.usuarios_id group by r.usuarios_id order by tota desc limit 5");
$rndId=  rand(1, 25);
$pensamiento=$bd->doSingleSelect("pensamientos","id=$rndId");
$bd->doInsert("trafico",array("usuarios_id"=>-1,"pagina"=>5,"fecha"=>date("Y-m-d H:i:s",time())));
?>
<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenedor2 center-block">
    <br><br>
	<!--<img src="galeria/img/sinsession.png">-->
    <p class="t30">Inicia sesi&oacute;n para disfrutar de est&eacute; espacio, si no te has registrado
    adelante haslo es muy f&aacute;cil y gr&aacute;tis.</p>
    <br><br>
    <div class="col-xs-12 t28">
        <cite>"<?php echo $pensamiento["pensamiento"];?>"</cite>
        <cite>(<?php echo $pensamiento["autor"];?>)</cite>
    </div>
</section>