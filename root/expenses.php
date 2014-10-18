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
					<button id = "btnAddExpense" class = "btn btn-default"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div>
					<button class = "btn btn-default btnDelete"><span class="glyphicon glyphicon-trash"></span></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id = "flexfix">
	<div id = "search">
		<form action = "POST" id = "searchExpensesForm">
			<div class = "searchInput">
				<label for = "userRadio">User</label>
				<input type = "radio" name = "searchFor" value = "user" id = "userRadio" checked="checked">
				<label for = "merchantRadio">Merchant</label>
				<input type = "radio" name = "searchFor" value = "merchant" id = "merchantRadio">
			</div>
			<div class = "searchInput">
				<input type = "text" name = "searchUserMerch" placeholder = "User/Merchant" class = "form-control"/>
			</div>
			<div class = "searchInput">
				<input type = "text" name = "searchDate" placeholder = "Date" class = "form-control"/>
			</div>
			<div class = "searchInput">
				<select class = "form-control" name = "status">
					<option value = "All Expenses">All Expenses</option>
					<option value = "Processed">Processed</option>
					<option value = "Unprocessed">Unprocessed</option>
				</select>
			</div>
			<div class = "searchInput">
				<select class = "form-control" name = "category">
					<option value = "allCategories">All Categories</option>
					<option value = "accommodation">Accommodation</option>
					<option value = "Food">Food</option>
					<option value = "Entertainment">Entertainment</option>
					<option value = "Phone">Phone</option>
					<option value = "Travel">Travel</option>
				</select>
			</div>
			<div class = "searchInput">
				<button class = "btn btn-default"><span class="glyphicon glyphicon-search"></span>Search</button>
			</div>
		</form>
		<div id = "views">
		</div>
	</div>

	<div id = "mainView">
		<table id = "expensesTable">
			<thead>
				<tr>
					<th>User Name</th>
					<th>Category</th>
					<th>Merchant</th>
					<th>Cost</th>
					<th>Receipt</th>
					<th>Date</th>
					<th>Status</th>
					<th>Comment</th>
				</tr>
			</thead>
			<tbody id = "expensesData">
				<!-- call data here -->
			</tbody>
		</table>
	</div>
</div>

<div id = "modalAddExpense" class = "modalStyle">
	<form id = "modalExpenseForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'addExpense' />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-envelope"></span>Add Expense</h4>
		<div class = "modalInput">
			<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "userId" placeholder = "User ID" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<select class = "form-control" name = "category">
				<option value = "allCategories">All Categories</option>
				<option value = "accommodation">Accommodation</option>
				<option value = "Food">Food</option>
				<option value = "Entertainment">Entertainment</option>
				<option value = "Phone">Phone</option>
				<option value = "Travel">Travel</option>
			</select>
		</div>
		<div class = "modalInput">
			<input type = "text" name = "merchant" placeholder = "Merchant" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "cost" placeholder = "Cost" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = "text" name = "comment" placeholder = "Comment" class = "form-control"/>	
		</div>
		<div class = "modalInput">
			<input type = 'submit' value = 'Submit' class = "btn btn-default" id = "btnSubmitExpense"/>
		</div>
		<div class = "clear"></div>
	</form>
</div>

<div id = "modalDeleteConfirmation" class = "comfirmationModal">
	<div>
		<p>Are you sure we want to delete the selected expenses ?</p>
	</div>
	<div>
		<button action = "deleteData" id = "deleteExpense" class = "btn btn-default"><span class="glyphicon glyphicon-remove"></span>Yes</button>
	</div>
</div>	

