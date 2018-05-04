<?php
include_once "../../clases/bd.php";
include_once "../../clases/usuarios.php";
include_once "../../clases/grupos.php";
if(!isset($_SESSION))
    session_start ();
$usua=new usuario($_SESSION["id"]);
$grupos=$usua->getGrupos();
?>
<div class="row">
	<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 maB10  " >
		<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   ">
		    <center><h2 class=" marL20 marR20 negro"><span class="marL10">Mis grupos</span></h2></center>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
	<div class="pad10">
	    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5"><span class="t20">Nombre del grupo</span></div>
	    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"><span class="t20">Administrador</span></div>
	    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2"><span class="t20">Relaci&oacute;n</span></div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-1"><p><i class="fa fa-users"></i></p></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
	    <?php
	    $fondo="";
	    foreach ($grupos as $g => $valor):
		$grupo=new grupos($valor["id"]);
		$fondo=$fondo=="fondo1"?"fondo2":"fondo1";
        	?>
                    <a href="grupo.php?id=<?php echo $grupo->id;?>">
		    <div class="<?php echo $fondo;?> vinculos-temas">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5"><span><?php echo $grupo->nombre;?></span></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"><span><?php echo $grupo->getAdmin();?></span></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2"><span><?php echo $grupo->getRelacion();?></span></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-1"><span class="text-right"><?php echo $grupo->countMiembros();?></span></div>
		    </div>
                    </a>
		    <?php
	    endforeach;
	    ?>
	</div>
</div>
