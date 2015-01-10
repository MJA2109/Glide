<?php require("../templates/head.php"); ?>
	<div class = "signUpBody">
		<div class = 'wrapper'>
			<div class = 'indexLogo'>
	 			<div class = "strip"></div>
	 			<img src="../img/glideLogoTrans250.png" alt = 'glide logo'>
	 		</div>
	 		
	 		<div class = "signContent">
				
				<div class = 'signForm'>
					<form name = 'signInForm' id = 'signInForm'  method = 'POST'>
						<div class = "input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
			 				<input type = 'email' name = 'adminEmail' placeholder = 'E-mail' class = "form-control"/>
			 			</div>
			 			<div class = "input-group">
			 				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			 				<input type = 'password' name = 'adminPassword' placeholder = 'Password' class = "form-control"/>
			 			</div>

			 			<input type = 'hidden' name = 'action' value = 'signIn' class = "btn btn-default"/>
			 			

			 			<div class = "divBtnSign">
			 				<input type = 'submit' value = 'Sign In' class = "btn btn-default"/>
			 			</div>
			 		</form>

			 		<div class = "alternativeSign">
			 			<p>Don't have an account ? <a href = 'index.php'>Sign Up</a></p>
			 		</div>

				</div>

			</div>
		</div>
	</div>
<?php require("../templates/footer.php"); ?>