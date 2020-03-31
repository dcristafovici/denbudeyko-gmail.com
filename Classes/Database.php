<?php


class Database
{
	private static $instance = null;
	private $pdo, $error = false, $result, $query;
	
	public function __construct()
	{
		
		try{
			$this->pdo = new PDO('mysql:host=localhost;dbname=simple', 'mysql', 'mysql');
		}
		catch (PDOException $e){
			echo "Подключение не удалось". $e->getMessage();
		}
		
	}
	
	public function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new Database();
		}
		return self::$instance;
	}
	
	
	public function query($sql){
		$this->error = false;
		
		$this->query = $this->pdo->prepare($sql);
		$this->query->execute();
		
		if(!$this->query->execute()){
			$this->error = true;
		}
		else{
			$this->result = $this->query->fetchAll(PDO::FETCH_OBJ);
		}
		return $this;
	}
	
	
	
	
	public function showErrors(){
		return $this->error;
	}
	
	public function showResult(){
		return $this->result;
	}
}