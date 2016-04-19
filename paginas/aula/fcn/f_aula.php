<?php
	include "../../../clases/bd.php";
	include "../../../clases/grupos.php";
	include "../../../clases/representantes.php";        
	switch($_POST["metodo"]){
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
                if($_POST["marcado"]==0){
                    $fechaFin=$_POST["txtFecha"];
                }else{
                    $fechaFin=NULL;
                }
                if(!isset($_SESSION))
                    session_start ();
		$valores=array("nombre"=>$_POST["txtnombre"],
			       "fecha"=>$tiempo,
			       "fecha_fin"=>$fechaFin,
			       "relaciones_id"=>$_POST["cmbdescripcion"],
                               "usuarios_id"=>$_SESSION["id"]
			       );                
		return $result=$grupo->nuevoGrupo($valores);
	}
        function buscaGrupo(){
            $grupo=new grupos();
            $result=$grupo->getGrupo($_POST["txtCodigo"]);
            echo json_encode($result);
        }
        function agregaGrupo(){
            $grupo=new grupos($_POST["id"]);
            $result=$grupo->addUsuario();
        }
        function generaCodigo(){
            $bd=new bd();
            if(!isset($_SESSION))
                session_start();
            $result=$bd->query("select id,codigo from codigos where grupos_id is null and usuarios_id is null limit 1");
            $row=$result->fetch();
            $result=$bd->doUpdate("codigos",array("usuarios_id"=>$_SESSION["id"]),"id={$row["id"]}");
	    if($result){
		echo $row["codigo"];
	    }else{
		echo "error";
	    }
        }
	function vinculaRep(){
	    $rep=new representantes();
            $result=$rep->nuevoRepresentante($_POST["codigo"]);
            echo $result;
	}
?>