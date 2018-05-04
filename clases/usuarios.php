<?php
include_once 'bd.php';
include_once 'fotos.php';
/**
 *
 */
class usuario {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	//Usuario (u)
	protected $u_table = "usuarios";
	private $id = 0;
	private $u_nombres;
	private $u_apellidos;
	private $u_regiones_id;
	private $u_direccion;
	private $u_genero;
	private $u_dia_nac;
    private $u_mes_nac;
    private $u_agno_nac;
	private $u_descripcion;
	private $u_website;
	private $u_facebook;
	private $u_twitter;
	// Acceso (a)
	protected $a_table = "usuarios_accesos";
	private $a_seudonimo;
	private $a_email;
	private $a_password;
	// Status (s)
	protected $s_table = "usuariosxstatus";
	protected $s_f_table = "status_usuarios";
	private $s_fecha;
	private $s_status_usuarios_id;
	// Ultimos Ingresos (i)
	protected $i_table = "ultimos_accesos";
	private $i_fecha;
	private $i_ip;
	private $i_datos_cliente;

	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function usuario($id = NULL) {
		if ($id != NULL) {
			// Hago consulta;
			$this->buscarUsuario ( $id );
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	public function buscarUsuario($id) {
		// hace consulta y setea valores
		$this->id = $id;
		if(!$this->getdatosUsuarios()){			
			$this->getdatosAcceso();
			$this->getdatosStatus();
		}else{
			return false;
		}
	}
	public function crearUsuario($nuevoId) {
		if (isset ( $this->a_seudonimo )) {
			$bd = new bd ();
//			$result = $bd->doInsert ( $this->u_table, $this->serializarDatos ( "u_" ) );
//			if ($result == true) {
				$result = 0;
				$this->id = $nuevoId;
				$result += $bd->doInsert ( $this->a_table, $this->serializarDatos ( "a_", $this->u_table ) );
				$result += $bd->doInsert ( $this->s_table, $this->serializarDatos ( "s_", array (
				$this->s_f_table,
				$this->u_table 
				) ) );
				if ($result >= 3) {
					return true;
				} else {
					return false;
				}
//			} else {
//				return false;
//			}
		} else {
			throw new Exception ( "Error Usuario 004: No se han definido datos de acceso" );
		}
	}
	public function ingresoUsuario($login, $password){
		$bd= new bd();
		$foto = new fotos();
		if(isset($login["seudonimo"])){
			$condicion = "seudonimo = '{$login["seudonimo"]}'";
		}else{
			$condicion = "email = '{$login["email"]}'";
		}
		$hash = hash ( "sha256", $password );
		$condicion = "$condicion AND password = '$hash'";
		$result = $bd->doSingleSelect($this->a_table,$condicion);
		if(!empty($result)){
			session_start();
			$_SESSION["id"] = $result["usuarios_id"];
			$_SESSION["seudonimo"] = $result["seudonimo"];
			$_SESSION["fotoperfil"] = $foto->buscarFotoUsuario($result["usuarios_id"]);
			return true;
		}else{
			return false;
		}
	}
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	private function serializarDatos($prefix = "u_", $foreign_table = false) {
		$reflection = new ReflectionObject ( $this );
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $property ) {
			$name = $property->getName ();
			if (substr ( $name, 0, 2 ) == $prefix || $name == "id") {
				if ($name == "id") {
					if ($foreign_table != false) {
						if (is_array ( $foreign_table )) {
							foreach ( $foreign_table as $f_table ) {
								$params ["{$f_table}_id"] = $this->$name;
							}
						} else {
							$params ["{$foreign_table}_id"] = $this->$name;
						}
					} else {
						$params ["id"] = $this->$name;
					}
				} else {
					$params [substr ( $name, strpos ( $name, "_" ) + 1 )] = $this->$name;
				}
			}
		}
		return $params;
	}
	private function nuevoUsuario() {
		foreach ( get_class_vars ( get_class ( $this ) ) as $name => $default ) {
			$this->$name = $default;
		}
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Getters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function getdatosUsuarios(){
		$bd = new bd();
		$result = $bd->doSingleSelect($this->u_table,"id = {$this->id}");
		if($result){
			$this->datosUsuario($result["nombres"], $result["apellidos"], $result["regiones_id"], $result["direccion"], $result["genero"], $result["dia_nac"],$result["mes_nac"],$result["agno_nac"], $result["descripcion"], $result["website"], $result["facebook"], $result["twitter"]);
			$this->id = $result["id"];
		}else {
			return false;
		}
	}
	public function getdatosAcceso(){
		$bd = new bd();
		$result = $bd->doSingleSelect($this->a_table,"usuarios_id = {$this->id}");
		if($result){
			$this->datosAcceso($result["seudonimo"], $result["email"], $result["password"]);
				
		}else{
			return false;
		}
	}
	public function getdatosStatus(){
		$bd = new bd();
		$result = $bd->doSingleSelect($this->s_table,"usuarios_id = {$this->id}");
		if($result){
			$this->datosStatus($result["fecha"],$result["status_usuarios_id"]);
		}else{
			return false;
		}
	}
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function datosUsuario($nombres, $apellidos, $regiones_id, $direccion, $genero, $dia_nac, $mes_nac, $agno_nac,$descripcion=NULL,$website=NULL, $facebook=NULL, $twitter = NULL) {
		$this->nuevoUsuario ();
		$this->u_nombres = $nombres;
		$this->u_apellidos = $apellidos;
		$this->u_regiones_id = $regiones_id;
		$this->u_direccion = $direccion;
		$this->u_genero = $genero;
		$this->u_dia_nac = $dia_nac;
        $this->u_mes_nac = $mes_nac;
        $this->u_agno_nac = $agno_nac;
		$this->u_descripcion = $descripcion;
		$this->u_website = $website;
		$this->u_facebook = $facebook;
		$this->u_twitter = $twitter;
	}
	public function datosAcceso($seudonimo, $email, $password) {
		$this->a_seudonimo = ucwords(strtolower($seudonimo));
		$this->a_email = $email;
		$this->a_password = hash ( "sha256", $password );
	}
	public function datosStatus($fecha = NULL, $status_usuarios_id = NULL) {
		if(!is_null($fecha)){
			$this->s_fecha = $fecha;
		}else{
			$this->s_fecha = date ( 'Y-m-d', time () );
		}
		if(!is_null($status_usuarios_id)){
			$this->s_status_usuarios_id = $status_usuarios_id;
		}else{
			$this->s_status_usuarios_id = 1;
		}
	}
	/*Se puede borrar*/
	public function __set($property, $value) {
		if (property_exists ( $this, $property )) {
			$bd = new bd ();
			$bd->doUpdate ( $this->table, array (
					$property => $value 
			) );
			$this->$property = $value;
		}
	}
	public function getRegion(){
		$bd=new bd();
		$condicion="id={$this->u_regiones_id}";
		$resultado=$bd->doSingleSelect("regiones",$condicion,"nombre");
		if(!empty($resultado)){
			return utf8_encode($resultado["nombre"]);
		}else{
			throw new Exception("No se encontro información de la región", 1);
			return false;
		}
	}
	public function getTiempo(){
		$bd=new bd();
		$condicion="usuarios_id={$this->id}";
		$resultado=$bd->doSingleSelect("usuariosxstatus",$condicion,"fecha");				
		if(!empty($resultado)){
			$segundos=strtotime('now') - strtotime($resultado["fecha"]);
			$dias=intval($segundos/60/60/24);
			if($dias<30){
				if($dias==1){
				    return $dias . " dia ";
				}else{
					return $dias . " dias ";
				}
			}else{
				$meses=round($dias / 30,0,PHP_ROUND_HALF_DOWN);
				if($meses<12){
					if($meses==1){
						return $meses . " mes ";
					}else{
						return $meses . " meses ";
					}
				}else{
					$agnos=round($meses / 12,0,PHP_ROUND_HALF_DOWN);
					if($agnos==1){
						return $agnos . " Año ";
					}else{
						return $agnos . " Años ";
					}
				}
			}
		}else{
			throw new Exception("No se encontro desde cuando este usuario comparte con nosotros", 1);
			return false;		
		}
		/*
		$bd=new bd();
		$condicion="id=$this->usuarios_id";
		$resultado=$bd->doSingleSelect("usuariosxstatus",$condicion,"fecha");
		if(!empty($resultado)){
						
			return "2 meses";
		}else{
			throw new Exception("No se encontro desde cuando publica este usuario", 1);
			return false;
		}
		 */		 
	}
    public function getGrupos($id=NULL){
        if(is_null($id))
            $id=$this->id;
        $bd=new bd();
        $result=$bd->query("select id from grupos where usuarios_id=$id or id in 
                          (select grupos_id from usuarios_grupos where usuarios_id=$id)");
        return $result;
    }        
	public function getNombre($formateado=0,$longitud=17){
		$nombre="{$this->u_nombres} {$this->u_apellidos}";
		if($formateado==0){
    			return "$nombre";
		}else{
			if(strlen($nombre)>$longitud){
				return substr($nombre,0,$longitud) . "...";
			}else{
				return $nombre;
			}
		}
 	}
	public function amigosConectados($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
//		$result=$bd->query("select usuarios_id,nombres,apellidos from usuarios_amigos,usuarios where usuarios_id=$id or amigos_id=$id");
		$result=$bd->query("select id as usuarios_id,nombres,apellidos from usuarios where id<>$id and (id in (select usuarios_id from usuarios_amigos where amigos_id=$id) or id in (select amigos_id from usuarios_amigos where usuarios_id=$id))");
		if($result){
			return $result;
		}else{
			return false;
		}
	}
    public function getPais(){
        $bd=new bd();
        $row=$bd->doSingleSelect("regiones","id=$this->u_regiones_id","paises_id");
        return $row["paises_id"];
    }
    public function getRecursos($id=NULL){
        if(is_null($id)){
            $id=$this->id;
        }
        $bd=new bd();
        $result=$bd->doFullSelect("recursos","usuarios_id=$id","id");
        return $result;
    }
	public function getStatusReservacion($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->doSingleSelect("reservaciones","usuarios_id=$id order by id desc limit 1");
		if($result){
			return $result["status"];
		}else{
			return -1;
		}
	}
	public function getLeccion($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		$bd=new bd();
		$result=$bd->query("select leccion from avances where reservaciones_id in (select id from reservaciones where usuarios_id=$id) and status=1");
		$result=$result->fetch();
		return $result["leccion"];
	}
	public function hasChildren($id=NULL){
		return true;
	}
}