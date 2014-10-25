<?php require("../templates/head.php"); ?>
	<div class = 'wrapper'>
		<div class = 'signinform'>
			<div class = 'signupLogo'>
				<img src = '#' alt = 'Glide logo' />
			</div>
			<form name = 'signInForm' id = 'signInForm'  method = 'POST'>
	 			<input type = 'email' name = 'adminEmail' placeholder = 'E-mail' />
	 			<input type = 'password' name = 'adminPassword' placeholder = 'Password' />
	 			<input type = 'hidden' name = 'action' value = 'signIn' />
	 			<input type = 'submit' value = 'Sign In'/>
	 		</form>
		</div>
		<div class = 'divBtnSignUp'>
			<button><a href = 'index.php'>Sign Up</a></button>
		</div>
	</div>
<?php require("../templates/footer.php"); ?>