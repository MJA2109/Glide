<?php require("../templates/head.php"); ?>
	<div class = 'wrapper'>
		<div class = 'signinform'>
			<div class = 'signupLogo'>
				<img src = '#' alt = 'Glide logo' />
			</div>
			<form name = 'signInForm' id = 'signInForm' action = "../api/GlideAPI.php" method = 'POST'>
	 			<input type = 'email' name = 'companyEmail' placeholder = 'E-mail' />
	 			<input type = 'password' name = 'passoword' placeholder = 'Password' />
	 			<input type = 'hidden' name = 'action' value = 'signIn' />
	 			<input type = 'submit' value = 'Sign In'/>
	 		</form>
		</div>
		<div class = 'divBtnSignUp'>
			<button><a href = 'index.php'>Sign Up</a></button>
		</div>
	</div>
<?php require("../templates/footer.php"); ?>