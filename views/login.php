<?php require_once('HeaderForEverything.php'); ?>
</head>
<body>
	<div>

<form class="form-horizontal" action="/user/doLogin" method="post">
	<div class="component" data-html="true">
		<img class="login-pic" src="/images/main-symbol.jpg" alt="forhonor-symbol" width="200" height="200">
		<div>
			<div class="center">
				<label class="control-label" for="username">Username</label>
			</div>
		  <div class="center">
		  	<input id="username" name="username" placeholder="username" type="text" maxLength='30' class="form-control input-md center" value="<?= $username ?? ''?>">
		  </div>
		</div>
		<div>
			<div class="center">
				<label class="control-label" for="password">Password</label>
			</div>
		  <div class="center">
		  	<input id="password" name="password" placeholder="password" type="password" class="form-control input-md center">
		  </div>
		</div>
	      <!-- <label class="col-md-2 control-label" for="textinput">&nbsp;</label> -->
		<div class="col center">
		  <input id="submit" name="submit" value="sign in" type="submit" class="btn btn-primary">
		</div>
		<a class="center" href="/User/Create">create an account</a>
	</div>
</form>

<?php
if(!isset($_SESSION['userID']) && !empty($error)){
	echo "<script>alert(\"". htmlspecialchars($error) ."\");</script>";
}
?>