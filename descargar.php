<?php
	$root = "biblioteca/";
	$file = basename($_GET['ruta']);
	$path = $root.$file;
	$type = '';
	if (file_exists($path)) {
		 $size = filesize($path);
		 if (function_exists('mime_content_type')) {
			 $type = mime_content_type($path);
		 } else if (function_exists('finfo_file')) {
			 $info = finfo_open(FILEINFO_MIME);
			 $type = finfo_file($info, $path);
			 finfo_close($info);
		 }
		 if ($type == '') {
			 $type = "application/force-download";
		 }
		 // Definir headers
		 header("Content-Type: $type");
		 header("Content-Disposition: attachment; filename=$file");
		 header("Content-Transfer-Encoding: binary");
		 header("Content-Length: " . $size);
		 // Descargar archivo
		 readfile($path);
		 echo "ok.";
	} else {
		 echo("El archivo no existe.");
	}		
?>