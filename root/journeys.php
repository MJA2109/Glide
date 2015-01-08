<?php
	//sleep(3);
?>
<div id = "subHeader">
	<div id = "subHeaderFix">
		<div id = "subHeaderSec1">
			
		</div>
		<div id = "subHeaderSec2">
			<div>
				<div>
					<button id = "btnAddJourney" class = "btn btn-default btnAdd"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div>
					<button class = "btn btn-default btnDelete" disabled = "true"><span class="glyphicon glyphicon-trash"></span></button>
				</div>
				<div>
					<button id = "btnEditJourney" class = "btn btn-default btnEdit" disabled = "true"><span class="glyphicon glyphicon-refresh"></span></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id = "flexfix">
	<div id = "search">
		<form method = "POST" id = "searchJourneysForm">
			<input type = 'hidden' name = 'action' value = 'searchJourneys' />
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
				<input type = "text" name = "account" placeholder = "Account" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
				<input type = "text" name = "origin" placeholder = "Origin" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
				<input type = "text" name = "destination" placeholder = "Destination" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
				<select class = "form-control" name = "status">
					<option value = "" selected="selected" >Status</option>
					<option value = "processed">Processed</option>
					<option value = "unprocessed">Unprocessed</option>
				</select>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				<input type = "text" name = "date" placeholder = "Date" class = "form-control"/>
			</div>
			<div class = "searchInput">
				<input type = 'submit' value = 'Search' class = "btn btn-default" id = "btnSearchJourneys"/>
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
					<th>Origin Location</th>
					<th>Destination</th>
					<th>Distance</th>
					<th>Journey Time</th>
					<th>Date</th>
					<th>Status</th>
					<th>Account</th>
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
			<input type = "text" name = "account" placeholder = "Account" class = "form-control"/>	
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

<div id = "modalEditJourney" class = "modalStyle">
	<form id = "modalEditJourneyForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'editJourney' />
		<input id = "journeyId" type = "hidden" name = "journeyId" value = "" />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-refresh"></span>Edit Journey</h4>
		<div class = "modalInput">
			<input type = "text" name = "userName" class = "form-control" readonly="readonly"/>	
		</div>
		<div class = "modalInput">
			<select class = "form-control" name = "status">
				<option value = "" disabled="disabled">Status</option>
				<option value = "Processed">Processed</option>
				<option value = "Unprocessed">Unprocessed</option>
			</select>
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
			<input type = "text" name = "account" placeholder = "Account" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "comment" placeholder = "Comment" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = 'submit' value = 'Update' class = "btn btn-default" id = "btnSubmitEditJourney"/>
		</div>
		<div class = "clear"></div>
	</form>

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



