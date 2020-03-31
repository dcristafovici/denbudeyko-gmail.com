<?php

require_once "Classes/Database.php";
require_once "Classes/Config.php";


$GLOBALS['config'] = [
	
	"mysql" => [
		"host" => "localhost",
		"database" => "simple",
		"username" => "mysql",
		"password" => "mysql",
	],
	"tested"=>[
		"fortested" => [
			"last_tested" => "this_is_last_tested"
		]
	]

];
