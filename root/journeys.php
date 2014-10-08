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
						<button type = "button" class = "btn btn-default">New Journey</button>
					</div>
					<div>
						<button type = "button" class = "btn btn-default">Delete Journey</button>
					</div>
				</div>
			</div>
		</div>

		<div id = "search">
			<form action = "POST" id = "searchJourneyForm">
				<div class = "searchInput">
					<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>
				</div>
				<div class = "searchInput">
					<input type = "text" name = "date" placeholder = "Date" class = "form-control"/>
				</div>
				<div class = "searchInput">
					<button type = "button" class = "btn btn-default" >Search</button>
				</div>	
			</form>
			<div id = "views">
			</div>
		</div>

		<div id = "mainView">
			<table id = "journeysTable">
				<thead>
					<tr>
						<th>User</th>
						<th>Origin</th>
						<th>Destination</th>
						<th>Distance</th>
						<th>Journey Time</th>
						<th>Date</th>
						<th>Comment</th>
					</tr>
				</thead>
				<tbody>
					<!-- journey data goes here -->
				</tbody>
			</table>
		</div>



<?php
		require("../templates/footer.php");
	}
?>