<?php require("../templates/head.php"); ?>
	<div class = 'wrapper'>
		<div class = 'signinform'>
			<div class = 'signupLogo'>
				<img src = '#' alt = 'Glide logo' />
			</div>
			<form name = 'pmSignInForm' id = 'pmSignInForm'  method = 'POST'>
	 			<input type = 'email' name = 'email' placeholder = 'E-mail' />
	 			<input type = 'email' name = 'adminEmail' placeholder = 'Admin Email' />
	 			<input type = 'text' name = 'account' placeholder = 'Account Name' />
	 			<input type = 'password' name = 'password' placeholder = 'Password' />
	 			<input type = 'hidden' name = 'action' value = 'pmSignIn' />
	 			<input type = 'submit' value = 'Sign In'/>
	 		</form>
		</div>
		<div class = 'divBtnSignUp'>
			<button><a href = 'index.php'>Back</a></button>
		</div>
	</div>
<?php require("../templates/footer.php"); ?>