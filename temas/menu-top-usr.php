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
			&nbsp;&nbsp;
			<img class="marT5 marB5 marL5" src="galeria/img/logos/logo-header.png" width="120px;" height="50px">
			&nbsp;&nbsp;
			<ul class="nav navbar-nav navbar-right t16 navegador">
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li class="menu" id="menuinicio"><a class="marT10" href="index.php">
					Inicio
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li class="menu" id="menuforos"><a class="marT10" href="foros.php" >
					Foros
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li class="menu" id="menurecursos"><a class="marT10" href="recursoseducativos.php">
					Recursos Educativos
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li class="menu" id="menuarticulos"><a class="marT10" href="articulos.php">
					Art&iacute;culos
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li class="menu" id="menuaulaonline"><a class="marT10" href="aulavirtual.php">
					Aula Virtual
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li class="menu" id="menuclases"><a class="marT10" href="clasesonline.php">
					Clases Online
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" style="cursor:pointer" data-toggle='modal' data-target='#contacto'>
					Contactenos
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
			</ul>
		</div>
			<ul class="nav navbar-nav navbar-right t16">
				<li class="marT10 hidden-xs hidden-sm">
					<div class="borderS  point eti-blanco "
						style="display: flex; height: 40px; width: 40px; align-items: center;">
						<a href="<?php echo $_SESSION["seudonimo"];?>" > <img id="fotoperfilm" src="<?php echo $_SESSION["fotoperfil"];?>" id=""
							class="img img-responsive center-block"
							style="max-height: 96%; cursor: pointer;background:white;">
						</a>
					</div>
				</li>
				<li>&nbsp;&nbsp;
				<li>
				<li class="dropdown"><a href="#" class="dropdown-toggle marT10"
					data-toggle="dropdown" role="button" aria-expanded="false"
					style=""> <?php echo strtoupper($_SESSION["seudonimo"]);?> </a>
					<ul class="dropdown-menu blanco" role="menu">
						<li><a href="<?php echo $_SESSION["seudonimo"];?>">Mi Perfil</a></li>
						<li><a href="salir.php">Salir</a></li>
					</ul></li>
				<li>
					<div class="vertical-line "
						style="height: 25px; margin-top: 15px;"></div>
				</li>
				<li><a href="#" data-toggle="" data-target="" class="marT10"><i
						class="fa fa-thumbs-up"></i> </a></li>
				<li><a href="#" data-toggle="" data-target="" class="marT10"><i
						class="fa fa-bell"></i> </a></li>
				<li><a href="#" data-toggle="" data-target="" class="marT10"><i
						class="fa fa-question-circle"></i> </a></li>
			</ul>
		</div>
	</div>
</nav>