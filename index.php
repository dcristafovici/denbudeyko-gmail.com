<?php

require_once 'init.php';


$users = Database::getInstance()->query("SELECT * FROM users");

if($users->showErrors()){
	echo 'you have error';
}

else{
	
	$allUsers = $users->showResult();
	foreach($allUsers as $user){
		echo $user->username.'<br>';
	}

}