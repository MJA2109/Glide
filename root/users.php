<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
?>
		
		<div id = "subHeader">
			<div id = "subHeaderSec1">
				<p>Search:</p>
			</div>
			<div id = "subHeaderSec2">
				<div>
					<div>
						<button class = "btn btn-default">New User</button>
					</div>
					<div>
						<button class = "btn btn-default">Delete User</button>
					</div>
				</div>
			</div>
		</div>

		<div id = "search">
			<form action = "POST" id = "searchUsersForm">
				<div class = "searchInput">
					<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>
				</div>
				<div class = "searchInput">
					<button class = "btn btn-default">Search</button>
				</div>
			</form>
		</div>

		<div id = "mainView">
			<table id = "usersTable">
				<thead>
					<tr>
						<th>User</th>
						<th>Email</th>
						<th>Sign-up Date</th>
						<th>No. of Claims</th>
					</tr>
				</thead>
				<tbody>
					<!-- users' data goes here -->
				</tbody>
			</table>
		</div>



<?php
		require("../templates/footer.php");
	}
?>