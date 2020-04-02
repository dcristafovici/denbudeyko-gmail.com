<?php

require_once 'init.php';

echo Session::get('users');
if(Input::exists()){
    
    if(Token::check(Input::get('token'))){
        
        $validation = new Validate();
        
        $validation->check($_POST, [
           
           "email" => ["email" => true, "required" => true],
            "password" => ["required" => true]
           
        ]);
        
        if($validation->success()){
            $user = new User();
            $user->login(Input::get('email'), Input::get("password"));
        }
        
        else{
            foreach($validation->printErrors() as $error){
                echo $error."<br>";
            }
        }
    }

}

?>


<form method="POST">
	
   

    <div class="form-group">
        <input type="text" name="email" placeholder="E-mail">
    </div>

    <div class="form-group">
        <input type="text" name="password">
    </div>
  

    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    
    <div class="form-group">
        <button>
            <span>Submit</span>
        </button>
    </div>

</form>
