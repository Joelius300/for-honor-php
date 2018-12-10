<form data-toggle="validator" class="form-horizontal" action="/user/Register" method="post">
	<div class="component" data-html="true">
		<img class="login-pic" src="/images/main-symbol.jpg" width="200px" height="200px">
		<div>
			<div class="center">
				<label class="control-label" for="textinput">Benutzername</label>
			</div>
		  <div class="center">
		  	<input id="username" name="username" type="text" class="form-control input-md center" maxlength='30' placeholder='Benutzername' required>
		  </div>
		</div>

		<div>
			<div class="center">
				<label class="control-label" for="textinput">Passwort</label>
			</div>
    	<div class="center">
        <input name='password' type="password" data-minlength="6" class="form-control center" id="inputPassword" placeholder="Passwort" required>
        <div class="help-block">Minimum of 6 characters</div>
				<input type="password" class="form-control center" id="inputPasswordConfirm" data-match="#inputPassword" placeholder="Password bestätigen" required>
      </div>
    </div>

		<div>
	      <label class="control-label" for="textinput">&nbsp;</label>
		  <div class="center">
		    <input id="submit" name="submit" type="submit" class="btn btn-primary">
			</div>
			<a class="center" href="/User/login">login</a>
		</div>
	</div>
</form>

<?php
require_once "../controller/UserController.php";
if(!isset($_SESSION['userID']) && isset(UserController::$ERROR)){
	$error = UserController::$ERROR;
	echo "<script>alert('$error');</script>";
}
?>
