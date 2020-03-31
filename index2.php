<?php

require_once 'init.php';


Database::getInstance()->insert('users',[
	'username' => 'Moderator',
	'email' => 'moderator@mail.ru',
	'password' => 'modpassword',
	'status' => "I'm new moderator"
]);
