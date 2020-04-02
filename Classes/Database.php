<?php


class Database
{
	private static $instance = null;
	private $pdo, $error = false, $result, $query, $count;
	
	public function __construct()
	{
		
		try{
			$this->pdo = new PDO("mysql:host=".Config::get('mysql.host'). ";dbname=".Config::get('mysql.database')."", Config::get('mysql.username'), Config::get('mysql.password'));
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
	
	
	public function query($sql, $params){
	
		
		$this->error = false;
		$this->query = $this->pdo->prepare($sql);
		
		$i = 1;
		foreach ($params as $param){
			$this->query->bindValue($i, $param);
			$i++;
		}


		if(!$this->query->execute()){
			$this->error = true;
		}
		else{
			$this->result = $this->query->fetchAll(PDO::FETCH_OBJ);
			$this->count = $this->query->rowCount();
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
			$this->query($sql, $fields);
			return $this;
		}
		
		return false;
		
	}
	
	public function count(){
		return $this->count;
	}
	public function get($table, $fields = []){
		
		return $this->action('SELECT * ', $table, $fields);
		
	
	}
	
	public function delete($table, $fields = []){
		
		return $this->action('DELETE', $table, $fields);
		
	}
	
	
	public function insert($table, $fields = []){

		$value = '';
		foreach ($fields as $field){
			$value .= '?,';
		}
		$value = rtrim($value, ',');


		$keys = array_keys($fields);
		$keysString = implode('`,`', $keys);

		$sql = "INSERT INTO {$table} (`$keysString`) VALUES ({$value})";

		if(!$this->query($sql, $fields)->showErrors()){
			return true;
		}

	}
	
	
	public function update($table, $id, $fields){
		
		$set = '';
		foreach($fields as $field=>$field_value){
			$set .= "{$field} = ?,";
		}
		$set =rtrim($set, ',');

		
		$sql = "UPDATE {$table} set {$set} WHERE id = $id";
	
		if(!$this->query($sql,$fields)->showErrors()){
			return true;
		}
		return false;
		
		
	}
	
	public function first(){

		return $this->showResult()[0];
		
	}
	
	
	public function showErrors(){
		return $this->error;
	}
	
	public function showResult(){
		return $this->result;
	}
}