<?php

/*

 * DRIVERS

 * POSTGRES = pgsql:host=http://ns3.grupouds.com.br port=5432 dbname=projetos user=postgres password=KL92@81

 * MYSQL = mysql:dbname=grupouds_tickets;host=localhost

 * MSSQL = mssql:host=$hostname;dbname=$dbname

 * FIREBIRD/INTERBASE = firebird:dbname=localhost:C:\\path\\to\\database\\MyDatabase.FDB

 *

 */

class Conexao

  {



  	private $username;

  	private $password;

  	private $driver;

  	private $conn;



    	//======================M�TODO CONSTRUTOR============================================

  	public function __construct($driver="mysql:host=localhost;dbname=versati", $username="root",$password=""){

  		$this->username=$username;

  		$this->password=$password;

  		$this->driver=$driver;

  		$this->conecta();

  	}



  	public function Conexao(){

  		$this->conecta();

  	}

  	//======================M�TODO PARA CONECTAR NO BANCO DE DADOS======================

  	public function conecta()

  	{

	  	try {

	  		if($this->username!=null){

		   		$this->conn = new PDO($this->driver, $this->username, $this->password);

	  		}else{

	  			echo $this->driver;

		    	$this->conn = new PDO($this->driver);

	  		}

		} catch (PDOException $e) {

		    echo 'Conex�o n�o aceita: ' . $e->getMessage();

		}

	return $this->conn;

  	}



}



?>
