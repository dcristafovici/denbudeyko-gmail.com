<?php

require_once 'init.php';


if (Input::exists()) {
	
	
	$validation = new Validate();
	
	if ($validation->check($_POST, [
		
		"username" => [
			"required" => true,
			"min" => 2,
			"max" => 20,
			"unique" => 'users'
		],
		"email" => [
			"required" => true,
			"min" => 2,
			"max" => 20,
			"unique" => "users",
			"email" => true
		],
		"password" => [
			"required" => true,
			"min" => 2,
			"max" => 20,
		],
		"password_again" => [
			"required" => true,
			"min" => 2,
			"max" => 20,
			"matches" => "password"
		],
		"status" => [
			"required" => true,
			"min" => 5,
			"max" => 100,
		]
	
	
	])) ;
	
	
	if ($validation->success()) {
		echo 'form send';
	} else {
		foreach ($validation->printErrors() as $error) {
			echo $error . "<br>";
		}
	}
	
}


?>


<form method="POST">

    <div class="form-group">
        <input type="text" name="username" placeholder="Username" value="<?php echo Input::get('username') ?>">
    </div>

    <div class="form-group">
        <input type="text" name="email" placeholder="E-mail">
    </div>

    <div class="form-group">
        <input type="text" name="password">
    </div>
    <div class="form-group">
        <input type="text" name="password_again">
    </div>

    <div class="form-group">
        <textarea name="status" placeholder="status"></textarea>
    </div>

    <div class="form-group">
        <button>
            <span>Submit</span>
        </button>
    </div>

</form>
