<form data-toggle="validator" class="form-horizontal" action="/user/Register" method="post">
	<div class="component" data-html="true">
		<div class="form-group">
		  <label class="col-md-2 control-label" for="textinput">Benutzername</label>
		  <div class="col-md-4">
		  	<input id="username" name="username" type="text" class="form-control input-md" maxlength='30' placeholder='Benutzername' required>
		  </div>
		</div>
		<!-- <div class="form-group">
		  <label class="col-md-2 control-label" for="textinput">Passwort</label>
		  <div class="col-md-4">
		  	<input id="password" name="password" type="password" class="form-control input-md">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-2 control-label" for="textinput">Passwort bestätigen</label>
		  <div class="col-md-4">
		  	<input id="passwordConfirm" name="passwordConfirm" type="password" class="form-control input-md">
		  </div>
		</div> -->

		<div class="form-group">
			<label class="col-md-2 control-label" for="textinput">Passwort</label>
    	<div class="col-md-4">
        <input name='password' type="password" data-minlength="6" class="form-control" id="inputPassword" placeholder="Passwort" required>
        <div class="help-block">Minimum of 6 characters</div>
				<input type="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" placeholder="Password bestätigen" required>
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
