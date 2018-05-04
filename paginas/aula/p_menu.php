<?php
include_once "clases/bd.php";
$bd=new bd();
if(!isset($_SESSION))
	session_start();
$bd->doInsert("trafico",array("usuarios_id"=>$_SESSION["id"],"pagina"=>5,"fecha"=>date("Y-m-d H:i:s",time())));
?>
<h2><center>Men&uacute; principal</center></h2>
<hr>
<ul class="nav nav-pills nav-stacked">
	<li class="active"><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_principal.php">Inicio</a></li>
	<li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_grupos.php">Mis grupos</a></li>
	<li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_new_grupos.php">Crear grupo</a></li>
	<li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_add_grupo.php">Agregarme a un grupo</a></li>
	<li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_codigo.php">Codigo para padres</a></li>
	<li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_padres.php">Vincular a mi representado</a></li>
	<li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_acompa.php">Acompa&ntilde;amiento a mi representado</a></li>
        <li><a class="menu-aula" href="#" data-vinculo="paginas/aula/p_ayuda.php">Ayuda</a></li>
</ul>
<hr>
<img src="galeria/img/logos/logo_sc_grande.jpg" width="64px" height="64px"></img>