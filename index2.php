<?php

require_once 'init.php';


$user = Database::getInstance()->get('users', ['username','=', 'Moderator'])->first();

var_dump($user->username);