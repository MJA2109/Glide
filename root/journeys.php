<?php
	sleep(3);
?>
<div id = "subHeader">
	<div id = "subHeaderFix">
		<div id = "subHeaderSec1">
			
		</div>
		<div id = "subHeaderSec2">
			<div>
				<div>
					<button class = "btn btn-default"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div>
					<button class = "btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id = "flexfix">
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
</div>



