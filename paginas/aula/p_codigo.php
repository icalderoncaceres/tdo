<?php
    include_once "../../clases/bd.php";
    $bd=new bd();
    if(!isset($_SESSION))
        session_start ();
    $result=$bd->doSingleSelect("codigos","usuarios_id={$_SESSION["id"]}","id,codigo");
    if($result){
        $clase1="hidden";
        $clase2="";
	$codigo=$result["codigo"];
    }else{
        $clase1="";
        $clase2="hidden";
	$codigo="";
    }
?>
<br><br><br>
<section class="col-xs-12 center-block text-center <?php echo $clase1;?>" id="generar" name="generar">
    <p class="lead text-justify">
        Presiona el boton "GENERAR" para crear el c&oacute;digo necesario, hay que redactar
    </p>
    <div class="col-xs-12">
	<br>
    </div>
    <button class="btn btn-primary2" id="btn-generar" name="btn-generar">Generar</button>
</section>
<div class="col-xs-12"><br><br></div>
<section class="col-xs-12 <?php echo $clase2;?>" id="codigo" name="codigo">
	<center><span class="text_encima" id="txt-codigo" name="txt-codigo"><?php echo $codigo;?></span><img src="galeria/img/fondopagina.jpg" width="40%" height="10%"></center>
	<br><br>
</section>