<?php 

class Sql extends PDO {

	private $conn;

	//Método construtor para que, quando a classe for instanciada, a conexão seja feita automaticamente
	public function __construct(){//método construtor

		//Faz a conexão 
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");

	}

	//Função para associar os parâmetros (bind) ao comando prepare
	private function setParams($statement, $parameters = array()){

		foreach ($parameters as $key => $value) {
			
			$this->setParam($key, $value);

		}

	}

	//Método para fazer o bind de um parâmetro apenas
	private function setParam($statement, $key, $value){

		$statement->bindParam($key, $value);

	}

	/* Função para executar os comandos SQL 
  	($rawQuery: comando SQL; $params: dados que serão recebidos e armazenados em um array */
	public function run($rawQuery, $params = array()){

		//Statement que prepara o comando
		$stmt = $this->conn->prepare($rawQuery);

		//Associa os parâmetros ao comando prepare
		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;

	}


	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->run($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

}

 ?>