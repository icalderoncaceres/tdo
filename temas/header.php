<header class="header">
<?php
if (! isset ( $_SESSION )) {
	session_start ();
}
if(isset($_COOKIE["c_id"])){
	$_SESSION["id"]=$_COOKIE["c_id"];
	$_SESSION["seudonimo"]=$_COOKIE["c_seudonimo"];
	$_SESSION["fotoperfil"]=$_COOKIE["c_fotoperfil"];
}
if (isset ( $_SESSION ["id"] )) {
	include ("menu-top-usr.php");
} else {
	include ("menu-top.php");
}
?>
</header>