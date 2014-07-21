<?php require("templates/head.php"); ?>
 	<div class = 'wrapper'>
 		<div class = 'indexLogo'>
 			<img src="#" alt = 'glide logo'>
 		</div>
 		<div class = 'divBtnSignin'>
 			<button><a href = 'signin.php'>Sign In</a></button>
 		</div>
 		<div class = 'info'>
 			<h3>this is the slogan</h3>
 			<div>
 				<p>this is some extra info</p>
 			</div>
 		</div>
 		<div class = 'signupForm'>
	 		<form name = 'signup'>
	 			<input type = 'text' name = 'companyName' placeholder = 'Company Name' />
	 			<input type = 'email' name = 'companyEmail' placeholder = 'E-mail' />
	 			<button>Sign-up</button>
	 			<p>Already have an account ? <a href = 'signin.php'>Sign In</a></p>
	 		</form>
 		</div>
 	</div>       
<?php require("templates/footer.php"); ?>