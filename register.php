<?php
require_once "init.php";


if (Input::exists()) {
	
	if (Token::check(Input::get('token'))) {
		
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
		
		
		])) ;
		
		
		if ($validation->success()) {
		    $formValidate = true;
			Session::flash('success', 'Форма отправлена. Проверьте ваш е-майл');
			
			$password = password_hash(Input::get("password"), PASSWORD_DEFAULT);
			$user = new User();
			$user->create([
				"username" => Input::get('username'),
				"email" => Input::get('email'),
				"password" => $password
			
			]);
			
		} else {
			$allErrors = $validation->printErrors();
			Session::flash('error', 'У вас ошибки в полях. Пожалуйста исправьте');
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
    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
	<?php if (isset($allErrors)): ?>
        <div class="alert alert-info">
           <?php echo Session::flash('error')?>
        </div>
      <div class="alert alert-danger">
          <ul>
            <?php foreach ($allErrors as $error): ?>
                <li><?php echo $error ?></li>
            <?php endforeach; ?>
          </ul>
      </div>
	<?php endif; ?>
	
	
	<?php if ($formValidate): ?>
      <div class="alert alert-success">
          <?php echo Session::flash('success') ?>
      </div>
	<?php endif ?>


    <div class="form-group">
        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="text" placeholder="Имя" class="form-control" name="username" id="name"
               value="<?php echo Input::get('username'); ?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="password" id="password" placeholder="Пароль">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="password_again" name="password_again"
               placeholder="Повторите пароль">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
</form>
</body>
</html>
