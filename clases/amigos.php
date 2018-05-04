<?php
include_once 'bd.php';
class amigos {
	// Amigos (f)
	protected $table = "usuarios_amigos";
	protected $table_fav = "usuarios_favoritos";
	private $fecha;
	private $usuarios_id;
	private $amigos_id;
	private $result;
	
	public function contarMeGustan($id){
		$bd = new bd();
		$sql = $bd->query("SELECT COUNT(*) total FROM {$this->table_fav} WHERE favoritos_id = $id GROUP BY favoritos_id");
		if($sql->rowCount()>0){
			$row = $sql->fetch();			
			return $row["total"];
		}else{
			return false;
		}		
	}
	public function yamegusta($useract,$userper){
		$bd = new bd();
		$sql = $bd->query("SELECT * FROM {$this->table_fav} WHERE usuarios_id = $userper AND favoritos_id = $useract");
		if($sql->rowCount()>0){			
			return true;
		}else{
			return false;
		}		
	}	
	public function buscarAmigos() {
		$bd = new bd ();
		$strSql="select usuarios.id as numero,CONCAT(usuarios.nombres,' ',usuarios.apellidos) as nombre,usuarios_accesos.seudonimo from usuarios,usuarios_accesos
		 where usuarios.id={$_SESSION["id"]} and usuarios.id = usuarios_accesos.usuarios_id AND usuarios.id in (select usuarios_id from usuarios_amigos where 
		usuarios_id = {$_SESSION["id"]} or amigos_id = {$_SESSION["id"]})";
		$result=$bd->query($strSql);
		if($result->rowcount()>0){
			return $result;
		}else{
			return false;
		}

	}
	public function nuevoAmigo($fecha, $usuarios_id, $amigos_id) {
		$bd = new bd ();
		$bd->doInsert ( $this->table, array (
				"fecha" => $fecha,
				"usuarios_id" => $usuarios_id,
				"amigos_id" => $amigos_id 
		) );
	}
	public function nuevoFavorito($fecha, $usuarios_id, $favoritos_id) {
		$bd = new bd ();
		$bd->doInsert ( $this->table_fav, array (
				"fecha" => $fecha,
				"usuarios_id" => $usuarios_id,
				"favoritos_id" => $favoritos_id
		) );
	}
	public function borrarAmigo($usuarios_id, $amigos_id){
		$bd = new bd();
		$sql = $bd->query("DELETE FROM usuarios_amigos WHERE usuarios_id = $usuarios_id AND amigos_id = $amigos_id");
		if($sql->rowCount()>0){
			return true;
		}else{
			return false;
		}
	}
	public function borrarFavorito($usuarios_id, $favoritos_id){
		$bd = new bd();
		$sql = $bd->query("DELETE FROM usuarios_favoritos WHERE usuarios_id = $usuarios_id AND favoritos_id = $favoritos_id");
		if($sql->rowCount()>0){
			return true;
		}else{
			return false;
		}
	}        
}