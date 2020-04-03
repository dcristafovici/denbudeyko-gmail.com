<?php require_once "init.php";
$user = new User();

if ($user->isLoggedIn()) {
	
	if (Input::exists()) {
		
		if (Token::check(Input::get('token'))) {
			
			$validation = new Validate();
			$validation->check($_POST, [
				"current_password" => ["required" => true, "min" => 4],
				"new_password" => ["required" => true, "min" => 4],
				"new_password_again" => ["required" => true, "min" => 4, "matches" => "new_password"]
			]);
			
			if ($validation->success()) {
				
				
				if (!password_verify(Input::get('current_password'), $user->data()->password)) {
					
					$allErrors[] = 'неправильный текущий пароль';
				} else {
					$user->update([
						"password" => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)
					]);
				}
				
			} else {
				$allErrors = $validation->printErrors();
			}
		}
		
	}
	
} else {
	echo "Вы не авторизовались" . "<br>";
	echo "<a href='login.php'>Авторизация</a>";
	die();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">User Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Главная</a>
            </li>
        </ul>

        <ul class="navbar-nav">
					<?php if(!$user->isLoggedIn()): ?>
              <li class="nav-item">
                  <a href="login.php" class="nav-link">Войти</a>
              </li>
              <li class="nav-item">
                  <a href="register.php" class="nav-link">Регистрация</a>
              </li>
					<?php else: ?>
              <li class="nav-item">
                  <a href="profile.php" class="nav-link">Профиль</a>
              </li>
              <li class="nav-item">
                  <a href="logout.php" class="nav-link">Выйти</a>
              </li>
					<?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Изменить пароль для пользователя <?php echo $user->data()->username; ?></h1>
					
	
					
					<?php if ($allErrors): ?>
              <div class="alert alert-danger">
                  <ul>
										<?php foreach ($allErrors as $error): ?>
                        <li><?php echo $error ?></li>
										<?php endforeach; ?>
                  </ul>
              </div>
					<?php endif; ?>
            <ul>
                <li><a href="profile.php">Изменить профиль</a></li>
            </ul>
            <form action="" method="post" class="form">
                <div class="form-group">
                    <label for="current_password">Текущий пароль</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="current_password">Новый пароль</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="current_password">Повторите новый пароль</label>
                    <input type="password" name="new_password_again" class="form-control">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <div class="form-group">
                    <button class="btn btn-warning">Изменить</button>
                </div>
            </form>


        </div>
    </div>
</div>
</body>
</html>