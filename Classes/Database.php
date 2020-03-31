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
	
	public function action($action, $table, $fields = []){
		
		$operators = ['<', '>', '=', '<=', '>='];
		$field = $fields[0];
		$operator = $fields[1];
		$value = $fields[2];
		
		if(in_array($operator, $operators)){
			$sql = "{$action} FROM {$table} WHERE {$field} {$operator} '${value}' ";
			$this->query($sql);
			return $this;
		}
		
		return false;
		
	}
	
	public function get($table, $fields = []){
		
		return $this->action('SELECT * ', $table, $fields);
		
	
	}
	
	public function delete($table, $fields = []){
		
		return $this->action('DELETE', $table, $fields);
		
	}
	
	
	
	public function showErrors(){
		return $this->error;
	}
	
	public function showResult(){
		return $this->result;
	}
}