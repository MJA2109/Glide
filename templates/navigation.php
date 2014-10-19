<?php
echo "
	<div id = 'strip'></div>
	<div id = 'navHeader'>
		<div id = 'navHeaderFix'>
			<div id = 'logo'>
				<img src = '../img/logo.png' />
			</div>
			<nav>
				<ul>
					<li><a id = 'navHome'>Home</a></li>
					<li><a id = 'navExpenses'>Expenses</a></li>
					<li><a id = 'navJourneys'>Journeys</a></li>
					<li><a id = 'navUsers'>Users</a></li>
				</ul>
		  	</nav>
		</div>
		<div id = 'emailDiv'>
			<div>
				<span class='glyphicon glyphicon-user'></span>{$_SESSION['adminEmail']}
			</div>
		</div>
		<div id = 'signOutDiv'>
			<button id = 'btnSignOut' class = 'btn btn-default'>Sign Out</button>
		</div>
	 </div>";
?>