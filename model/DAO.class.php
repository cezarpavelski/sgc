<?php 

require_once 'Conexao.class.php';

class DAO extends Conexao{

   

	public function insert($objeto,$tabela){

		$classe = new ReflectionClass(get_class($objeto));

		$metodos = $classe->getMethods();

		$campos = "NULL";

		foreach($metodos as $mt){

			$search=strstr($mt->getName(),"get");

			if($search){

				$campos .= ",'".call_user_func(array($objeto, $mt->getName()))."'";

			}

		}

		$sql = "INSERT INTO ".$tabela." VALUES(".$campos.")";

		$conn = $this->conecta();

		$conn->beginTransaction();

		try {

			$query= $conn->exec($sql);

			$conn->commit();

		}catch(PDOException $e){

			$db->rollback();

		}

		return $query;

	}  

	

	public function update($objeto,$id, $tabela){

		$classe = new ReflectionClass(get_class($objeto));

		$metodos = $classe->getMethods();

		$campos = $id;

		foreach($metodos as $mt){

			$search=strstr($mt->getName(),"get");

			if($search){

				$campos .= ",'".call_user_func(array($objeto, $mt->getName()))."'";

			}

		}

		$sql = "REPLACE INTO ".$tabela." VALUES(".$campos.")";

		$conn = $this->conecta();

		$conn->beginTransaction();

		try {

			$query= $conn->exec($sql);

			$conn->commit();

		}catch(PDOException $e){

			$db->rollback();

		}

		return $query;

	}

	

	public function delete($atributo,$valor, $tabela){

		$sql = "DELETE FROM ".$tabela." WHERE ".$atributo."='".$valor."'";

		$conn = $this->conecta();

		$conn->beginTransaction();

		try {

			$query= $conn->exec($sql);

			$conn->commit();

		}catch(PDOException $e){

			$db->rollback();

		}

		return $query;

	}

	

	public function selectAll($tabela){

		$sql="SELECT * FROM ".$tabela;

		$conn = $this->conecta();

		foreach ($conn->query($sql) as $campos){

			$a[] =$campos;

		}
		if($a){
			return $a;
		}else{
			return $a[]=null;
		}

	}

	

	public function selectUnique($atributo,$valor, $tabela){

		$sql="SELECT * FROM ".$tabela." WHERE ".$atributo."='".$valor."'";

		$conn = $this->conecta();

		foreach ($conn->query($sql) as $campos){

			$a[] = $campos;

		}

		if($a){
			return $a;
		}else{
			return $a[]=null;
		}

	}

	

	public function selectFree($sql){

		$conn = $this->conecta();
		$array = $conn->query($sql);
		if($array){
			foreach ($array as $campos){
	
				$a[] =$campos;
	
			}
		}
		if($a){
			return $a;
		}else{
			return $a[]=null;
		}

	}

}



?>