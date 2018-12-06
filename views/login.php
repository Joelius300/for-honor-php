<form class="form-horizontal" action="/user/login" method="post">
	<div class="component" data-html="true">
		<div class="form-group">
		  <label class="col-md-2 control-label" for="textinput">Benutzername</label>
		  <div class="col-md-4">
		  	<input id="username" name="username" type="text" class="form-control input-md" value=<?= $username ?? ''?>>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-2 control-label" for="textinput">Passwort</label>
		  <div class="col-md-4">
		  	<input id="password" name="password" type="password" class="form-control input-md">
		  </div>
		</div>
		<div class="form-group">
	      <label class="col-md-2 control-label" for="textinput">&nbsp;</label>
		  <div class="col-md-4">
		    <input id="submit" name="submit" type="submit" class="btn btn-primary">
		  </div>
		</div>
	</div>
</form>
