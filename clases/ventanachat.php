<?php
	class ventanachat{
		private $usuarios_id;
		private $amigos_id;
		public function ventanachat($id1,$id2){
		    $this->usuarios_id=$id1;
		    $this->amigos_id=$id2;
		    echo '<html>
			<head><title>Titulo</title>
			</head>
			<body>
			<section class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
				<aside><h4>' . $this->getUsuario() . ' </h4></aside>
				<nav role="navigation">
					<ul class="nav navbar-nav navbar-center t8 navegador">
						<li><a class="marT8" style="cursor:pointer;">Minimizar
</a></li>
						<li><a class="marT8" style="cursor:pointer;">
Cerrar</a></li>
					</ul>
				</nav>
				<textarea rows="12" cols="32">Mensajes</textarea>
				<br>
				<textarea rows="2" cols="32" placeholder="Escriba aqui su mensaje"></textarea> 
			</section>
			</body>
			</html>
			';
		}
		private function getUsuario(){
			$bd=new bd();
			$result=$bd->doSingleSelect("usuarios","id=$this->amigos_id");
			return $result["nombres"] . " " . $result["apellidos"];
		}
	}
?>