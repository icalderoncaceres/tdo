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
					<li class="menu-monitoreo active" id="menu-inicio"><a class="marT10 point">
						Inicio
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-monitoreo" id="menu-consideraciones"><a class="marT10 point">
						Consideraciones
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-monitoreo" id="menu-configuracion"><a class="marT10 point">
						Configuraci&oacute;n
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-monitoreo" id="menu-contacto"><a class="marT10 point">
						Contacto
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="marT10 dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 						
							<!--<div class="borderS  point eti-blanco " style="display: flex; height: 40px; width: 40px; align-items: center;">-->
								<img src="<?php echo $_SESSION["fotoperfil"];?>" class="img img-responsive center-block" style="width:40px;height: 40px;background:white;"/>
								<?php if(strlen($_SESSION["seudonimo"])<=9){ echo strtoupper($_SESSION["seudonimo"]);}else{ echo substr(strtoupper($_SESSION["seudonimo"]),0,6) . "...";}?>
							<!--</div>-->
						</a>
						<ul class="dropdown-menu blanco" role="menu">
							<li><a href="salir.php">Salir</a></li>
						</ul>					
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>