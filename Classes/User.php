<?php


class User
{
	private $db, $data, $session_name, $isLoggedIn;
	
	public function __construct($user = null)
	{
		$this->db = Database::getInstance();
		$this->session_name = Config::get('session.user_session');
		
		if(!$user){
			
			$user = $this->find(Session::get($this->session_name));
			if($user){
				
				$this->isLoggedIn = true;
				
			}
		}
		else{
			$this->find($user);
		}
		
		
	}
	
	public function create($fields){
		
		$this->db->insert('users', $fields);
		
	}
	
	public function login($email, $password){
		
		if($email){
		
			$user = $this->find($email);
			if ($user) {
				
				if (password_verify($password, $this->data->password)) {
					Session::put($this->session_name, $this->data->id);
					return true;
					
				}
			}

			return false;
		
		}
		
	}
	
	public function find($value){
		if(is_numeric($value)){
			$this->data = $this->db->get('users', ['id', '=', $value])->first();
		}
		else{
			$this->data = $this->db->get('users', ['email', '=', $value])->first();
		}
		if($this->data){
			return true;
		}
		return false;
	
	}
	
	public function data()
	{
		return $this->data;
	}
	
	public function isLoggedIn(){
		return $this->isLoggedIn;
	}
	
	public function logOut(){
		return Session::delete($this->session_name);
	}
	
	public function update($fields, $id = null){
		
		if(!$id && $this->isLoggedIn){
			$id = $this->data()->id;
		}
		
		$this->db->update('users',$id, $fields);
		
		
	}
	
}