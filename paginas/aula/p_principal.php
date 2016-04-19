<?php
	if(!isset($_SESSION))
	session_start();
?>
<article>
	<h2><center>Bienvenido <?php echo $_SESSION["seudonimo"];?></center></h2>
	<hr>
	<div>
		<textarea placeholder="Comparte una experiencia con tus amigos" cols="80" rows="3"></textarea>
	</div>
</article>
