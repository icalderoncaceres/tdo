<?php
if (! isset ( $_SESSION )) {
	session_start ();
}
if (isset ( $_SESSION ["id"] )) {
	include ("menu-rigth-usr.php");
} else {
	include ("menu-rigth.php");
}
?>