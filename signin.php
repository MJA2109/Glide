<?php require("templates/head.php"); ?>
	<div class = 'wrapper'>
		<div class = 'signinform'>
			<div class = 'signupLogo'>
				<img src = '#' alt = 'Glide logo' />
			</div>
			<form name = 'signinform'>
				<input type = 'email' placeholder = 'E-Mail' />
				<input type = 'password' placeholder = 'Password' />
				<button id = 'signin'>Sign In</button>
			</form>
		</div>
		<div class = 'divBtnSignup'>
			<button><a href = 'index.php'>Sign Up</a></button>
		</div>
	</div>
<?php require("templates/footer.php"); ?>