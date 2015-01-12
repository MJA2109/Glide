<?php require("../templates/head.php"); ?>
	<div class = "signUpBody">
		<div class = 'wrapper'>
			<div class = 'indexLogo'>
	 			<div class = "strip"></div>
	 			<img src="../img/glideLogoTrans250.png" alt = 'glide logo'>
	 		</div>

	 		<div class = "signContent">

				<div class = 'signForm'>
					<form name = 'pmSignInForm' id = 'pmSignInForm'  method = 'POST'>
						<div class = "form-group">
							<div class = "input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				 				<input type = 'email' name = 'email' placeholder = 'User E-mail' class = "form-control"/>
				 			</div>
				 		</div>

				 		<div class = "form-group">
				 			<div class = "input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				 				<input type = 'email' name = 'adminEmail' placeholder = 'Admin E-mail' class = "form-control"/>
				 			</div>
				 		</div>

				 		<div class = "form-group">
				 			<div class = "input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
				 				<input type = 'text' name = 'account' placeholder = 'Account Name' class = "form-control"/>
				 			</div>
				 		</div>

				 		<div class = "form-group">
				 			<div class = "input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				 				<input type = 'password' name = 'password' placeholder = 'Password' class = "form-control"/>
				 			</div>
				 		</div>

			 			<input type = 'hidden' name = 'action' value = 'pmSignIn' />
			 			<div class = "form-group">
				 			<div class = "divBtnSign">
				 				<input type = 'submit' value = 'Sign In' class = "btn btn-default"/>
				 			</div>
				 		</div>
			 			<div id = "errorNote"></div>
			 		</form>
			 		<div class = "alternativeSign">
			 			<p>Return to home page <a href = 'index.php'>Home</a></p>
			 		</div>
				</div>
			
			</div>
		</div>
	</div>
<?php require("../templates/footer.php"); ?>