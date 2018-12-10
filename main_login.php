<div id='header'>
	<h3>&nbsp Log in to your account</h3>
</div>

<div id='content'>
	<h4>Please enter your data below:
		<br>
		If you don't have an account, simply register <a href='index.php?page=registration'>here</a>
	</h4>
	<form id='login' action='login.php' method='post' accept-charset='UTF-8'>
		<fieldset>
			<legend>Login</legend>
			<br>
			<label for='id'>IVAO VID:</label>
			<br>
			<input type='text' name='id' id='id' maxlength="50" />
			<br>
			<label for='password'>Password: <span style='color:red'>(NOT your IVAO passwords!!!)</span></label>
			<br>
			<input type='password' name='password' id='password' maxlength="50" />
			<br><br>
			<input class='submit' type='submit' name='submit' value='Login!' />
		</fieldset>
	</form>
</div>