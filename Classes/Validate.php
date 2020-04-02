<?php


class Validate
{
	
	private $db, $errors, $succces;
	
	
	public function __construct()
	{
		$this->db = Database::getInstance();
	}
	
	public function check($post, $fields)
	{
		
		foreach ($fields as $field => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = $post[$field];
				
				
				if ($rule_value == 'required' && empty($value)) {
					$this->addError("{$field} объязателен для заполнения");
				} else if (!empty($value)) {
					
					switch ($rule) {
						
						case "min":
							if (strlen($value) < $rule_value) {
								$this->addError("{$field} имеет меньше символов чем допустимо");
							}
							break;
							
						case "max":
							if(strlen($value) > $rule_value){
								$this->addError("{$field} имеет больше символов чем допустимо");
							}
							break;
							
						
						case 'matches':
							if($value != $post[$rule_value]){
								var_dump($post[$rule_value]);
								$this->addError("{$field} не совпадает с {$rule_value}");
							}
							break;
							
						
							
						
						case "email":
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
								$this->addError("{$field} имеет не правильный формат");
							}
							break;
							
						case 'unique':
							$check = $this->db->get($rule_value, [$field , "=", $value]);
							if($check->count()){
								$this->addError("{$value} занято. Придумайте что-то другое");
							}
							break;
					}
				}
				
				
			}
		}
		
		if(empty($this->errors)){
			$this->succces = true;
		}
		return $this;
		
		
	}
	
	public function addError($error)
	{
		$this->errors[] = $error;
	}
	
	public function printErrors()
	{
		return $this->errors;
	}
	
	public function success(){
		return $this->succces;
	}
}