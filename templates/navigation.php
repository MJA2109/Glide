<?php
echo "<div id = 'splash'><div id = 'splashMsg'><div id = 'splashSpin'><i class='fa fa-cog fa-spin fa-3x'></i></div><h3>Loading...</h3></div></div> 
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
					<li><a id = 'navCharts'>Charts</a></li>
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