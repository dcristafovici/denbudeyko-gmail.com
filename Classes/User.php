<?php


class User
{
	private $db, $data;
	
	public function __construct()
	{
		$this->db = Database::getInstance();
	}
	
	public function create($fields){
		
		$this->db->insert('users', $fields);
		
	}
	
	public function login($email, $password){
		
		if($email){
		
			$user = $this->find($email);
			if ($user) {
				
				if (password_verify($password, $this->data->password)) {
					Session::put('users', $this->data->id);
					return true;
					
				}
			}

			return false;
		
		}
		
	}
	
	public function find($email){
		$this->data = $this->db->get('users', ['email', '=', $email])->first();
		if($this->data){
			return true;
		}
		return false;
	
	}
	
	public function data()
	{
		return $this->data;
	}
	
	
}