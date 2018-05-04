<?php
include_once 'bd.php';
class fotos{
	protected $table = "fotos";
	protected $table_user = "fotos_usuarios";
	protected $table_pub = "fotosxpublicaciones";
	public $path = "../galeria/fotos";
	private $id;
	private $ruta;
	
// 	public function fotos($id = NULL, $tipo = "usr"){
// 		if ($id != NULL) {
// 			// Hago consulta;
// 			if($tipo = "usr"){
// 				$this->buscarFotoUsuario ( $id );
// 			}else{
// 				$this->buscarFotoPublicacion ( $id );
// 			}			
// 		}
// 	}
	public function buscarFotoUsuario($id){
		$bd = new bd();
		$table = "fotos, fotos_usuarios";
		$condicion = "usuarios_id = $id AND fotos_id = id";
		$result = $bd->doSingleSelect($table,$condicion);
		if(!empty($result)){
			return $result["ruta"].$result["id"].".png";
		}else{
			return "galeria/img/logos/silueta-bill.png";
		}
	}
	public function actualizarFotoPublicacion($id_publicacion, $dataurl,$id)
	{
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->id = $id;
			$this->ruta = $this->crearRuta();
			$this->subirFoto($dataurl);
		}
	}	
	public function crearFotoEvento()
	{
		$bd = new bd();
		$this->ruta = "galeria/imagenes/";
		$result = $bd->doInsert($this->table,array("ruta" => $this->ruta));
		if($result){
			$this->id = $bd->lastInsertId();
			return $this->id;
		}else{
			return false;
		}
	}        
	public function crearFotoUsuario($id_usuario, $dataurl){
		$bd = new bd();		
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->ruta = $this->crearRuta();
			$result = $bd->doInsert($this->table,array("ruta" => substr($this->ruta, strpos($this->ruta, "/") + 1)));
			if($result){
				$this->id = $bd->lastInsertId();
				$bd->doInsert($this->table_user, array("status" => "A", "usuarios_id" => $id_usuario, "fotos_id" => $this->id));
				$this->subirFoto($dataurl);
				return true;
			}else{
				return false;
			}	
			$this->updateSessionFoto($id_usuario);
		}
	}
	public function subirFoto($dataurl,$ruta = NULL){	
		//Obtener la dataurl de la imagen
		$data_url = str_replace(" ", "+", $dataurl);                
		$filteredData=substr($data_url, strpos($data_url, ",")+1);
		//Decodificar la dataurl
		$unencodedData=base64_decode($filteredData);
		//subir la imagen
		if(is_null($ruta)){
			$ruta = "{$this->ruta}{$this->id}.png";
		}else{
			$ruta = "../$ruta";
		}
		return file_put_contents($ruta, $unencodedData);
	}
	public function updateFoto($ruta,$dataurl,$id){
		if($ruta == "galeria/img/logos/silueta-bill.png")
		{
			return $this->crearFotoUsuario($id, $dataurl);
		}else{
			return $this->subirFoto($dataurl,$ruta);
		}
	}
	public function updateSessionFoto($id){
		session_start();
		$_SESSION["fotoperfil"] = $this->buscarFotoUsuario($id);	
	}
	public function crearRuta(){		
		$mes = date("m");
		$year = date("Y");
		$fullpath= "{$this->path}/{$year}/{$mes}/";
		if(!file_exists($fullpath)){
			mkdir($fullpath,0777,true);
		}
		return $fullpath;
	}
	public function crearFotoPort($id_usuario, $dataurl){
		$bd = new bd();		
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->ruta = $this->crearRuta();
			$result = $bd->doInsert($this->table,array("id" => 0, "ruta" => substr($this->ruta, strpos($this->ruta, "/") + 1)));
			if($result){
				$this->id = $bd->lastInsertId();
				$bd->doInsert($this->table_user, array("status" => "P", "usuarios_id" => $id_usuario, "fotos_id" => $this->id)); // fotos de portada se agregan con el estado P (portada activa)
				$this->subirFoto($dataurl);
				return true;
			}else{
				return false;
			}	
		}
	}
	public function updatePort($ruta,$dataurl,$id){
		if($ruta == "galeria/img/fondos/portada.png")
		{
			return $this->crearFotoPort($id, $dataurl);
		}else{
			return $this->subirFoto($dataurl,$ruta);
		}
	}
	public function buscarFotoPort($id){
		$bd = new bd();
		$table = "fotos , fotos_usuarios ";
		$condicion = "usuarios_id = $id AND fotos_id = id and status = 'P'";
		$result = $bd->doSingleSelect($table,$condicion);
		if(!empty($result)){
			return $result["ruta"].$result["id"].".png";
		}else{
			return "galeria/img/fondos/portada.png";
		}
	}        
}