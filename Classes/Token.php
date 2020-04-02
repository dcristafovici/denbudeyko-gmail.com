<?php


class Token
{
	
	public function generate(){
		
		return Session::put(Config::get('session.token_name'), md5(uniqid()));
		
	}
	
	public function check($token){
	
		$tokenName = Config::get('session.token_name');
	
		if(Session::exists($tokenName) && $token == Session::get($tokenName)){
			return true;
		}
		return false;
		
	}
	
}