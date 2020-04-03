<?php

require_once "init.php";

$user = new User();

if($user->isLoggedIn()){


    if(Input::exists()){
        
        if(Token::check(Input::get('token'))){
	
            $validation = new Validate();
            $validation->check($_POST, [
                "username" => ["required" => true, "min" => 5, "max" => 20],
                "status" => ["min" => 20, "max" => 255]
            ]);
            
            if($validation->success()){
                Redirect::to('profile.php');
               $success = true;
               $user->update([
				  "username" => Input::get('username'),
				  "status" => Input::get("status")
               ]);
          
            }
            else{
                $allError = $validation->printErrors();
            }
        }
        
    }

}
else{
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
              <a class="nav-link" href="#">Главная</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Управление пользователями</a>
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item">
              <li class="nav-item">
                <a href="profile.php" class="nav-link">Профиль</a>
              </li>
              <a href="#" class="nav-link">Выйти</a>
            </li>
          </ul>
        </div>
    </nav>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Профиль пользователя - <?php echo $user->data()->username;?></h1>
         
         
         <?php if($success): ?>
         <div class="alert alert-success">Профиль обновлен</div>
         <?php endif; ?>
         <?php if($allError): ?>
         <div class="alert alert-danger">
           <ul>
               <?php foreach($allError as $error): ?>
                    <li><?php echo $error?></li>
               <?php endforeach; ?>
           </ul>
         </div>
         <?php endif; ?>
         <ul>
           <li><a href="changepassword.php">Изменить пароль</a></li>
         </ul>
         <form action="" method="post" class="form">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" name="username" id="username" class="form-control" value="<?php echo $user->data()->username;?>">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" name="status" id="status" class="form-control" placeholder="Статус" >
           </div>
             <input type="hidden" name="token" value="<?php echo Token::generate();?>">
           <div class="form-group">
             <button class="btn btn-warning">Обновить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>