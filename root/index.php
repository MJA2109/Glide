<?php require("../templates/head.php"); ?>
	<div class = "signUpBody">
	 	<div class = 'wrapper'>
	 		<div class = 'indexLogo'>
	 			<div class = "strip"></div>
	 			<img src="../img/glideLogoTrans250.png" alt = 'glide logo'>
	 		</div>
	 		<div class = "signContent">
		 		<div class = 'signForm'>
			 		
			 		<form name = 'signUpForm' id = 'signUpForm' method = 'POST'>
			 			<div class = "form-group">
			 				<div class="input-group">
				 				<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
				 				<input type = 'text' name = 'companyName' placeholder = 'Company Name' class = "form-control"/>
			 				</div>
			 			</div>
			 			<div class = "form-group">
			 				<div class="input-group">
				 				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				 				<input type = 'email' name = 'adminEmail' placeholder = 'E-mail' class = "form-control"/>
				 			</div>
			 			</div>
			 			<div class = "form-group">
			 				<div class="input-group">
				 				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				 				<input type = 'password' name = 'adminPassword' placeholder = 'Password' class = "form-control"/>
				 			</div>
			 			</div>
			 			<div class = "form-group">
			 				<div class="input-group">
				 				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				 				<input type = 'password' name = 'adminRePassword' placeholder = 'Retype Password' class = "form-control"/>
				 			</div>
			 			</div>
			 			<input type = 'hidden' name = 'action' value = 'register' />
			 			
			 			<div class="form-group">
				 			<div class = "divBtnSign">
				 				<input type = 'submit' value = 'Sign Up' class = "btn btn-default"/>
				 			</div>
			 			</div>
			 		</form>

			 		<div class = "alternativeSign">
			 			<p>Already have an account ? <a href = 'signIn.php'>Sign In</a></p>
			 			<p>Are you a Project Manager ? <a href = 'pmSignIn.php'>Sign In</a></p>
			 		</div>

		 		</div>
	 		</div>
	 	</div>
 	</div>       
<?php require("../templates/footer.php"); ?>