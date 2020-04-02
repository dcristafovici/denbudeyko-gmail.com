<?php

require_once 'init.php';

$user = new User();

if($user->isLoggedIn()){
	
	echo 'Hello '.$user->data()->username."<br>";
	echo "<a href='logout.php'>Logout</a>";
	
}
else{
	echo "<a href='register.php'>Register</a>";
	echo "<br>";
	echo "<a href='login.php'>Login</a>";
}