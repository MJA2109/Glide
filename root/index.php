<?php require("../templates/head.php"); ?>
 	<div class = 'wrapper'>
 		
 		<div class = "signContent">

 			<div class = 'indexLogo'>
 				<img src="../img/glideLogoTrans250.png" alt = 'glide logo'>
 			</div>
	 		
 			<ul class="nav nav-tabs tabStyle">
 				<li class="active"><a data-toggle="tab" href="#signInTab" class = "btnTab">Sign In</a></li>
				<li><a data-toggle="tab" href="#signUpTab" class = "btnTab">Sign Up</a></li>
				<li><a data-toggle="tab" href="#pmSignInTab" class = "btnTab">Project Manager</a></li>
			</ul>

			<div class = "tab-content">
		 		<div class = 'signForm tab-pane fade' id = "signUpTab">
			 		
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

		 		</div>



		 		<div class = 'signForm tab-pane fade in active' id = "signInTab">
					<form name = 'signInForm' id = 'signInForm'  method = 'POST'>
						<div class = "form-group">
							<div class = "input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				 				<input type = 'email' name = 'adminEmail' placeholder = 'E-mail' class = "form-control"/>
				 			</div>
				 		</div>
				 		<div class = "form-group">
				 			<div class = "input-group">
				 				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				 				<input type = 'password' name = 'adminPassword' placeholder = 'Password' class = "form-control"/>
				 			</div>
				 		</div>

			 			<input type = 'hidden' name = 'action' value = 'signIn' class = "btn btn-default"/>
			 			
			 			<div class = "form-group">
				 			<div class = "divBtnSign">
				 				<input type = 'submit' value = 'Sign In' class = "btn btn-default"/>
				 			</div>
				 		</div>
				 		<div id = "errorNote"></div>
			 		</form>

				</div>


				
				<div class = 'signForm tab-pane fade' id = "pmSignInTab">
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
			 			<div id = "pmErrorNote"></div>
			 		</form>
			 	
				</div> 
			</div> <!-- tab content -->
		</div> <!-- sign content -->
 	</div> 
<?php require("../templates/footer.php"); ?>