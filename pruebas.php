<?php
include "clases/publicaciones.php";
include "fcn/incluir-css-js.php";
//include "clases/bd.php";
/*
$publicacion=new publicaciones(24);
$bd=new bd();
$resultado=$bd->doFullSelect("clasificados");
foreach ($resultado as $r => $valor) {
	$cadena="I" . $valor["id"] . "F";
	if(!is_null($valor["clasificados_id"])){
		$condicion="id={$valor['clasificados_id']}";
		$resultado2=$bd->doSingleSelect("clasificados",$condicion);
		while(!is_null($resultado2["clasificados_id"])){
			$cadena ="I" . $resultado2["id"] . "F" . $cadena;
			$resultado2=$bd->doSingleSelect("clasificados","id={$resultado2["clasificados_id"]}");
		}
		$cadena="I" . $resultado2["id"] . "F" . $cadena;
	}
//	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $valor["id"]  . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $cadena . "<br>";
    echo "update clasificados set ruta='$cadena' where id={$valor["id"]};<br>";	
}
//var_dump($publicacion->getPreguntasPublicacion());
//var_dump($publicacion->listarPublicaciones(array(" usuarios_id="=>203,"clasificados_id="=>2)));

//var_dump($publicacion->listarPublicaciones());
 * */
	$bd=new bd();
	$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1) order by id desc limit 5 OFFSET 5";
	$result=$bd->query($consulta);
	if(!empty($result)){
	    $devolver = array();
		foreach($result as $r){
			$devolver[] = array(
			"id" => utf8_encode($r['id']),
			"titulo" => utf8_encode($r['titulo']));
		}
		echo json_encode($devolver);
	}else{
		echo json_encode(array("resultado"=>"Error"));
	}
?>

<!DOCTYPE html>
<html lang="es">
	
<body>
<!--<input type="text" id="currency" /> 
	-->
</body>
<!--	
<script type="text/javascript">
	// jQuery noConflict wrapper & document load
(function($){ 
	$(function(){
		// Define your currency field(s)
		var currency_input = $('#currency');
		// Check the document for currency field(s)
		if ( currency_input.length > 0 ){
			// Format the currency field when a user clicks or tabs outside of the input
			currency_input.blur(function(){
				$(this).formatCurrency();
			});
		}
	});
})(jQuery);
-->
</script>
</html>

