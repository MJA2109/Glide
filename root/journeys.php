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
					<button id = "btnAddJourney" class = "btn btn-default"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div>
					<button class = "btn btn-default btnDelete" disabled = "true"><span class="glyphicon glyphicon-trash"></span></button>
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
				<button type = "button" class = "btn btn-default"><span class="glyphicon glyphicon-search"></span>Search</button>
			</div>	
		</form>
		<div id = "views">
		</div>
	</div>

	<div id = "mainView">
		<table id = "journeysTable">
			<thead>
				<tr>
					<th>User Name</th>
					<th>Origin</th>
					<th>Destination</th>
					<th>Distance</th>
					<th>Journey Time</th>
					<th>Date</th>
					<th>Status</th>
					<th>Comment</th>
				</tr>
			</thead>
			<tbody>
				<!-- journey data goes here -->
			</tbody>
		</table>
	</div>
</div>

<div id = "modalAddJourney" class = "modalStyle">
	<form id = "modalJourneyForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'addJourney' />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-road"></span>Add Journey</h4>
		<div class = "modalInput">
			<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "userId" placeholder = "User ID" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "origin" placeholder = "Origin" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "destination" placeholder = "Destination" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "distance" placeholder = "Distance" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "journeyTime" placeholder = "Journey Time" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "date" placeholder = "Date" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "comment" placeholder = "Comment" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = 'submit' value = 'Submit' class = "btn btn-default" id = "btnSubmitJourney"/>
		</div>
		<div class = "clear"></div>
	</form>
</div>

<div id = "modalDeleteConfirmation" class = "comfirmationModal">
	<div>
		<h4><span class="glyphicon glyphicon-trash"></span>Delete Journey</h4>
	</div>
	<div>
		<p>Are you sure you want to delete the selected journey ?</p>
	</div>
	<div>
		<button action = "deleteData" id = "deleteJourney" class = "btn btn-default"><span class="glyphicon glyphicon-ok"></span>Yes</button>
	</div>
</div>



