<?php if(!isset($_SESSION)){
    session_start();
}
?>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation ">
	<div class="container">
		<div class="navbar-header ">
			<button type="button" class=" navbar-toggle collapsed"
				data-toggle="collapse" data-target="#menuP">
				<span class="sr-only">Mostrar / Ocultar</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>			
			<div class="collapse navbar-collapse" id="menuP">
				<img class="marT5 marB5 marL5 hidden-sm hidden-xs" src="galeria/img/logos/logo-header.png" width="120px;" height="50px">
				<ul class="nav navbar-nav navbar-right t16 navegador">
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menuinicio"><a class="marT10" href="index">
						Inicio
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menuforos"><a class="marT10" href="foros" >
						Foros
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menurecursos"><a class="marT10" href="recursoseducativos">
						Recursos
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menuarticulos"><a class="marT10" href="articulos">
						Art&iacute;culos
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menuaulaonline"><a class="marT10" href="aulavirtual">
						Espacio Virtual
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menuingles"><a class="marT10" href="zonaingles">
						Zona ingles
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu" id="menucontactenos"><a class="marT10" href="uploader">
						Contactenos
					</a></li>
<!--					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>-->
					<li class="marT10 hidden-xs hidden-sm">
						<div class="borderS  point eti-blanco " style="display: flex; height: 40px; width: 40px; align-items: center;">
							<a href="perfil.php?id=<?php echo $_SESSION["id"];?>">
								<img id="fotoperfilm" src="<?php echo $_SESSION["fotoperfil"];?>" id="" class="img img-responsive center-block" style="max-height: 96%; cursor: pointer;background:white;">
							</a>
						</div>
					</li>
					<li class="dropdown marT10">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 
							<?php if(strlen($_SESSION["seudonimo"])<=9){ echo strtoupper($_SESSION["seudonimo"]);}else{ echo substr(strtoupper($_SESSION["seudonimo"]),0,6) . "...";}?> 
						</a>
						<ul class="dropdown-menu blanco" role="menu">
							<li><a href="perfil.php?id=<?php echo $_SESSION["id"];?>">Mi Perfil</a></li>
                            <li><a href="configuracion.php">Configuraci&oacute;n</a></li>
							<li><a href="salir.php">Salir</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>		
	</div>
</nav>