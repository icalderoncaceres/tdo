<?php
	include "../../../clases/bd.php";
	include "../../../clases/grupos.php";
	include "../../../clases/representantes.php";        
        $metodo= filter_input(INPUT_POST,"metodo");
	switch($metodo){
		case "guardarGrupo":
		    guardaGrupo();
		    break;
                case "buscarGrupo":
                    buscaGrupo();
                    break;
                case "agregarGrupo":
                    agregaGrupo();
                    break;
                case "generarCodigo":
                    generaCodigo();
                    break;
		case "vincularRep":
		    vinculaRep();
		    break;
	}
	function guardaGrupo(){
		$grupo=new grupos();
		$tiempo = date("Y-m-d H:i:s",time());
                $marcado=filter_input(INPUT_POST,"marcado");
                $fecha=filter_input(INPUT_POST,"txtFecha");
                $nombre=filter_input(INPUT_POST,"txtnombre");
                $descripcion=filter_input(INPUT_POST,"cmbdescripcion");
                if($marcado==0){
                    $fechaFin=$fecha;
                }else{
                    $fechaFin=NULL;
                }
                if(!isset($_SESSION)){
                    session_start ();
                }
		$valores=array("nombre"=>$nombre,
			       "fecha"=>$tiempo,
			       "fecha_fin"=>$fechaFin,
			       "relaciones_id"=>$descripcion,
                               "usuarios_id"=>$_SESSION["id"]
			       );                
		return $result=$grupo->nuevoGrupo($valores);
	}
        function buscaGrupo(){
            $grupo=new grupos();
            $codigo=filter_input(INPUT_POST,"txtCodigo");
            $result=$grupo->getGrupo($codigo);
            echo json_encode($result);
        }
        function agregaGrupo(){
            $id=  filter_input(INPUT_POST,"id");
            $grupo=new grupos($id);
            $grupo->addUsuario();
        }
        function generaCodigo(){
            $bd=new bd();
            if(!isset($_SESSION)){
                session_start();
            }
            $result=$bd->query("select id,codigo from codigos where grupos_id is null and usuarios_id is null limit 1");
            $row=$result->fetch();
            $bd->doUpdate("codigos",array("usuarios_id"=>$_SESSION["id"]),"id={$row["id"]}");
	    if($result){
		echo $row["codigo"];
	    }else{
		echo "error";
	    }
        }
	function vinculaRep(){
	    $rep=new representantes();
            $codigo=  filter_input(INPUT_POST, "codigo");
            $result=$rep->nuevoRepresentante($codigo);
            echo $result;
	}
?>