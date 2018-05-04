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
				<ul class="nav navbar-nav navbar-right t16 navegador">
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles active" id="menu-inicio"><a class="marT10 point">
						Home
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles" id="menu-escenas"><a class="marT10 point">
						Scens
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles" id="menu-audios"><a class="marT10 point">
						Audies
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles" id="menu-lessons"><a class="marT10 point">
						Lessons
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>					
					<li class="menu-ingles" id="menu-ejercicios"><a class="marT10 point">
						Exercies
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>					
					<li class="menu-ingles" id="menu-tutoriales"><a class="marT10 point">
						Video library
					</a></li>					
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles" id="menu-juegos2"><a class="marT10 point">
						Games
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles" id="menu-vocabulario"><a class="marT10 point">
						Vocabulary
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>					
					<li class="menu-ingles" id="menu-laboratorio"><a class="marT10 point">
						Laboratory
					</a></li>
					<div class="vertical-line " style="height: 25px; margin-top: 15px;"></div>
					<li class="menu-ingles" id="menu-test"><a class="marT10 point">
						Test of level
					</a></li>
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