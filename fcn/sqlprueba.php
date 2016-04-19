<?php
include_once "../clases/bd.php";
include_once "../clases/usuarios.php";
include_once "../clases/fotos.php";
include_once "../clases/amigos.php";
include_once "../clases/publicaciones.php";
include_once "sqldatosprueba.php";

$bd = new bd ();
switch (filter_input ( INPUT_GET, "set" )) {
	case "clasificado":
		$bd->emptyTable ( "clasificados" );
		$class = new clasificados();
		foreach($clasificados as $clasificado){
			echo showResult($class->crearClasificado($clasificado["id"], $clasificado["nombre"], $clasificado["clasificados_id"]));
		}
		break;
	case "reset" : 
		$bd->emptyTable ( "usuarios_accesos" );
		$bd->emptyTable ( "usuarios_juridicos" );
		$bd->emptyTable ( "usuarios_naturales" );
		$bd->emptyTable ( "usuariosxstatus" );
		$bd->emptyTable ( "usuarios_amigos" );
		$bd->emptyTable ( "fotos_usuarios" );
		$bd->emptyTable ( "fotos" );
		$bd->emptyTable ( "usuarios" );
		$bd->emptyTable ( "clasificados" );
		echo "Clean!";
		break;
	case "usuario" :
		$bd->emptyTable ( "usuarios_accesos" );
		$bd->emptyTable ( "usuarios_juridicos" );
		$bd->emptyTable ( "usuarios_naturales" );
		$bd->emptyTable ( "usuariosxstatus" );		
		$bd->emptyTable ( "fotos_usuarios" );
		$bd->emptyTable ( "fotos" );
		$bd->emptyTable ( "usuarios" );
		$usuario = new usuario ();
		$foto = new fotos ();
		$i=0;
		foreach ( $naturales as $natural ) {
			echo $usuario->datosUsuario ( $natural ["direccion"], $natural ["telefono"], $natural ["descripcion"], rand ( 1, 24 ) );
			echo $usuario->datosNatural ( $natural ["identificacion"], $natural ["nombre"], $natural ["apellido"], $natural ["tipo"] );
			echo $usuario->datosAcceso ( strtolower ( $natural ["nombre"] . "_" . $natural ["apellido"] ), $natural ["email"], $natural ["nombre"] . $natural ["apellido"] );
			echo $usuario->datosStatus ();
			echo showResult ( $usuario->crearUsuario () );
			if(rand(0,1) == 0 and $i<=100){
				$i++;
				$ruta = $foto->crearRuta();
				echo $bd->doInsert("fotos",array("id" => $i, "ruta" => substr($ruta, strpos($ruta, "/") + 1)));
				$fotoid = $bd->lastInsertId();
				echo $bd->doInsert("fotos_usuarios", array("status" => "A", "usuarios_id" => $usuario->id, "fotos_id" => $fotoid));
				
			}
		}
		foreach ( $juridicos as $juridico ) {
			echo $usuario->datosUsuario ( $juridico ["direccion"], $juridico ["telefono"], $juridico ["descripcion"], rand ( 1, 24 ) );
			echo $usuario->datosJuridico ( $juridico ["rif"], $juridico ["razon_social"], $juridico ["tipo"], rand ( 1, 40 ) );
			echo $usuario->datosAcceso ( $juridico ["rif"], $juridico ["email"], $juridico ["rif"] );
			echo $usuario->datosStatus ();
			echo showResult ( $usuario->crearUsuario () );
			if(rand(0,1) == 0 and $i<=100){
				$i++;
				$ruta = $foto->crearRuta();
				$bd->doInsert("fotos",array("id" => $i, "ruta" => substr($ruta, strpos($ruta, "/") + 1)));
				$fotoid = $bd->lastInsertId();
				echo $bd->doInsert("fotos_usuarios", array("status" => "A", "usuarios_id" => $usuario->id, "fotos_id" => $fotoid));				
			}
		}		
		break;
	case "banco" :
		echo $bd->emptyTable ( "bancos" );
		foreach ( $bancos as $key => $value ) {
			echo showResult ( $bd->doInsert ( "bancos", array (
					"nombre" => $value,
					"siglas" => $key 
			) ) );
		}
		echo "OK Bancos!";
		break;
	case "pais" :
		$paises = array (
				"Venezuela" 
		);
		echo $bd->emptyTable ( "paises" );
		foreach ( $paises as $value ) {
			echo showResult ( $bd->doInsert ( "paises", array (
					"nombre" => $value 
			) ) );
		}
		echo "OK Paises!";
		break;
	case "categoria_juridico" :
		echo $bd->emptyTable ( "categorias_juridicos" );
		foreach ( $categorias_juridicos as $value ) {
			echo showResult ( $bd->doInsert ( "categorias_juridicos", array (
					"nombre" => $value 
			) ) );
		}
		echo "OK Categorias Juridicas!";
		break;
	case "estado" :
		echo $bd->emptyTable ( "estados" );
		foreach ( $estados as $value ) {
			echo showResult ( $bd->doInsert ( "estados", array (
					"nombre" => $value,
					"paises_id" => 1 
			) ) );
		}
		echo "OK Estados!";
		break;
	case "status_usuario" :
		echo $bd->emptyTable ( "status_usuarios" );
		foreach ( $status_usuarios as $value ) {
			echo showResult ( $bd->doInsert ( "status_usuarios", array (
					"nombre" => $value 
			) ) );
		}
		echo "OK Status Usuarios!";
		break;
	case "amigo":
		$amigo = new amigos();
		echo $bd->emptyTable("usuarios_amigos");
		foreach($bd->query("SELECT * FROM usuarios") as $row){
			foreach($bd->query("SELECT * FROM usuarios WHERE id != {$row["id"]}") as $row2){
				if(rand(0,30) == 30){
					$amigo->nuevoAmigo(date ( 'Y-m-d', time () ), $row["id"], $row2["id"]);
				}
			}			
		}
		echo "OK Amigos!";
		break;
	case "favorito":
		$amigo = new amigos();
		echo $bd->emptyTable("usuarios_favoritos");
		foreach($bd->query("SELECT * FROM usuarios") as $row){
			foreach($bd->query("SELECT * FROM usuarios WHERE id != {$row["id"]}") as $row2){
				if(rand(0,30) == 30){
					$amigo->nuevoFavorito(date ( 'Y-m-d', time () ), $row["id"], $row2["id"]);
				}
			}
		}
		echo "OK Favoritos!";
		break;		
	default :
		echo "GET OUT!";
}
function showResult($type) {
	if ($type >= 1) {
		echo "<span style='color:green'> GOD!</span><br>";
	} else {
		echo "<span style='color:red'> BAD!</span><br>";
	}
}
