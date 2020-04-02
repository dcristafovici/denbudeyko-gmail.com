<?php
session_start();

require_once "Classes/Database.php";
require_once "Classes/Config.php";
require_once "Classes/Input.php";
require_once "Classes/Validate.php";
require_once "Classes/Session.php";
require_once "Classes/Token.php";

$GLOBALS['config'] = [
	
	"mysql" => [
		"host" => "localhost",
		"database" => "simple",
		"username" => "mysql",
		"password" => "mysql",
	],
	"session"=>[
		"token_name" => "token"
	]
];
