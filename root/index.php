<?php require("../templates/head.php"); ?>
 	<div class = 'wrapper'>
 		<div class = 'indexLogo'>
 			<img src="#" alt = 'glide logo'>
 		</div>
 		<div class = 'divBtnSignin'>
 			<button><a href = 'signIn.php'>Sign In</a></button>
 		</div>
 		<div class = 'info'>
 			<h3>this is the slogan</h3>
 			<div>
 				<p>this is some extra info</p>
 			</div>
 		</div>
 		<div class = 'signUpForm'>
	 		<form name = 'signUpForm' id = 'signUpForm' action = "../api/GlideAPI.php" method = 'POST'>
	 			<input type = 'text' name = 'companyName' placeholder = 'Company Name'/>
	 			<input type = 'email' name = 'adminEmail' placeholder = 'E-mail' />
	 			<input type = 'password' name = 'adminPassword' placeholder = 'Password' />
	 			<input type = 'hidden' name = 'action' value = 'register' />
	 			<input type = 'submit' value = 'Sign Up'/>
	 			<p>Already have an account ? <a href = 'signIn.php'>Sign In</a></p>
	 		</form>
 		</div>
 	</div>       
<?php require("../templates/footer.php"); ?>