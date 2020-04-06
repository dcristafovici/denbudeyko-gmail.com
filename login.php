<?php

require_once "init.php";

$user = new User();
if($user->isLoggedIn()){
    echo 'Вы уже авторизовались';
    echo "<br>";
    echo "<a href='index.php'>На главную</a>";
    die();
}

if (Input::exists()) {
	
	if (Token::check(Input::get('token'))) {
		
		$validation = new Validate();
		
		$validation->check($_POST, [
			
			"email" => ["email" => true, "required" => true],
			"password" => ["required" => true]
		
		]);
		
		if ($validation->success()) {
			$user = new User();
			$login = $user->login(Input::get('email'), Input::get("password"));
			if($login){
			    Redirect::to('index.php');
            }
		} else {
			$allErrors = $validation->printErrors();
			
		}
	}
	
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" method="post">
    <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Авторизация </h1>

	<?php if (isset($allErrors)): ?>
	
		<div class="alert alert-danger">
			<ul>
				<?php foreach ($allErrors as $error): ?>
					<li><?php echo $error ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	
	

	
	
	<div class="form-group">
		<input type="text" class="form-control" name="email" placeholder="E-mail">
	</div>
	
	<div class="form-group">
		<input type="text" class="form-control" name="password">
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate() ?>">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
</form>
</body>
</html>
