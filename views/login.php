<form class="form-horizontal" action="/user/doLogin" method="post">
	<div class="component" data-html="true">
		<img class="login-pic" src="/images/main-symbol.jpg" width="200px" height="200px">
		<div>
			<div class="center">
				<label class="control-label" for="username">Benutzername</label>
			</div>
		  <div class="center">
		  	<input id="username" name="username" type="text" class="form-control input-md center" value=<?= $username ?? ''?>>
		  </div>
		</div>
		<div>
			<div class="center">
				<label class="control-label" for="password">Passwort</label>
			</div>
		  <div class="center">
		  	<input id="password" name="password" type="password" class="form-control input-md center">
		  </div>
		</div>
	      <!-- <label class="col-md-2 control-label" for="textinput">&nbsp;</label> -->
		<div class="col center">
		  <input id="submit" name="submit" type="submit" class="btn btn-primary">
		</div>
		<a class="center" href="/User/Create">create an account</a>
	</div>
</form>

<?php
if(!isset($_SESSION['userID']) && isset($error)){
	echo "<script>alert('$error');</script>";
}
?>