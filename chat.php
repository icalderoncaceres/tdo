<?php
	include_once "clases/usuarios.php";
	include_once "clases/fotos.php";
	$usua=new usuario($_SESSION["id"]);
	$foto=new fotos();
	$conectados=$usua->amigosConectados();
?>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="contenedor2 sombra-div pad10 chat" >
   		<div style="background:#006CDB; color: #FFF; font-size: 18px; border-radius: 5px;" class="pad10 text-center sombra-div">Amigos</div>
   		<br>   			
   		<?php
			if($conectados):
				foreach($conectados as $c=>$valor):
					$nombre="{$valor["nombres"]} {$valor["apellidos"]}";
				?>
   					<div class="marL5 amigo-conectado" data-id="<?php echo $valor["usuarios_id"];?>">
                        <img src="<?php echo $foto->buscarFotoUsuario($valor["usuarios_id"]);?>" alt="..."  width="32px" height="32px" style="border-radius: 32px; border: 1px solid #ccc" class="sombra-div2">
                        <a data-toggle="modal" data-target="#info-conversacion">
                            <span class='blue-vin t12 marL10'><?php echo $nombre;?></span> 
                        </a>
	   				</div> 
   					<hr>
   				<?php
   				endforeach;
			endif;
		?>
   	</div>
</div>
<?php include "modales/m_conversacion.php";?>