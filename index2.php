<?php

require_once 'init.php';



?>


<form method="POST">
	<?php echo Session::flash('success'); ?>
	
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

    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
    
    <div class="form-group">
        <button>
            <span>Submit</span>
        </button>
    </div>

</form>
