<!--
<script>
function iniciar(){
	var recognition;
	var recognizing = false;
	if (!('webkitSpeechRecognition' in window)) {
		alert("¡API no soportada!");
	} else {	
		elemento=document.getElementById("procesar");
		elemento.addEventListener("click",procesar);
		recognition = new webkitSpeechRecognition();
		recognition.lang = "es-VE";
		recognition.continuous = true;
		recognition.interimResults = true;
		recognition.onstart = function() {
			recognizing = true;
			console.log("empezando a escuchar");
		}
		recognition.onresult = function(event) {
			for (var i = event.resultIndex; i < event.results.length; i++) {
				if(event.results[i].isFinal)
				document.getElementById("texto").value += event.results[i][0].transcript;
			}
		}
		recognition.onerror = function(event) {
		}
		recognition.onend = function() {
			recognizing = false;
			document.getElementById("procesar").innerHTML = "Escuchar";
			console.log("terminó de escuchar, llegó a su fin");
		}
	}
	function procesar() {
		if (recognizing == false) {
			recognition.start();
			recognizing = true;
			document.getElementById("procesar").innerHTML = "Detener";
		} else {
			recognition.stop();
			recognizing = false;
			document.getElementById("procesar").innerHTML = "Escuchar";
		}
	}
}
</script>
-->
<?php
include "clases/bd.php";
$bd=new bd();
/*
$clave="contra";
$clave_encriptada=hash("sha256",$clave);
$valores=array("usuarios_id"=>14,
	       "password"=>$clave_encriptada,
	       "nombres"=>"Ivan Dario",
	       "apellidos"=>"Calderon Caceres",
	       "direccion"=>"Campo C",
	       "telefonos"=>"0416-1793965",
	       "email"=>"ivandario2010@gmail.com",
               "nivel"=>1,
	       "observaciones"=>"El fundador");
$result=$bd->doInsert("employer",$valores);
*/
?>
<body onload="iniciar()">
<button id="procesar" name="procesar">Procesar</button>
<input type="text" id="texto" name="texto"></input>
			<input type="text" id="voz-usuario" name="voz-usuario" x-webkit-speech speech error onwebkitspeechchange="procesar();" placeholder="Repeat"></input>
<?php
$result=$bd->doFullSelect("eng_1_3");
foreach($result as $r=>$valor){
	$nuevoTexto=utf8_encode($valor["texto"]);
	$nuevoTexto=substr($nuevoTexto,0,1)==" "?substr($nuevoTexto,1,strlen($nuevoTexto)-1):$nuevoTexto;
	$nuevoTexto=substr($nuevoTexto,strlen($nuevoTexto)-1,1)==" "?substr($nuevoTexto,0,strlen($nuevoTexto)-1):$nuevoTexto;
	$nuevoTexto=substr($nuevoTexto,strlen($nuevoTexto)-1,1)=="."?substr($nuevoTexto,0,strlen($nuevoTexto)-1):$nuevoTexto;
//	$nuevoTexto = preg_replace("/[\n|\r|\n\r]/i",".",$nuevoTexto);
	$id=$valor["id"];
	$valores=array("texto"=>$nuevoTexto);
	$res=$bd->doUpdate("eng_1_3",$valores,"id=$id");
	echo $res . " &nbsp;&nbsp;Id: &nbsp;&nbsp;" . $id . " &nbsp;&nbsp;Texto: &nbsp;&nbsp;" . $nuevoTexto . "<br>";
	echo "Id: &nbsp;&nbsp;" . $id . " &nbsp;&nbsp;Texto: &nbsp;&nbsp;" . $nuevoTexto . "<br>";	
}
echo $result;
 ?>

</body>
