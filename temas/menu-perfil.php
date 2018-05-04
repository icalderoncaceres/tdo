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
				<li><a href="index.php" class="marT10" style="cursor:pointer">
					Inicio
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" href="foros.php">
					Foros
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" href="recursoseducativos.php">
					Recursos Educativos
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" href="articulos.php">
					Art&iacute;culos
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" href="aulavirtual.php">
					Aula Virtual
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" href="clasesonline.php">
					Clases Online
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
				<li><a class="marT10" style="cursor:pointer" data-toggle='modal' data-target='#contacto'>
					Contactenos
				</a></li>
				<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>                                
			</ul>
		</div>
	</div>
</nav>