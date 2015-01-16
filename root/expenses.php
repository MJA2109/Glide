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
					<button id = "btnAddExpense" class = "btn btn-default btnAdd"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div>
					<button class = "btn btn-default btnDelete" disabled = "true"><span class="glyphicon glyphicon-trash"></span></button>
				</div>
				<div>
					<button id = "btnEditExpense" class = "btn btn-default btnEdit" disabled = "true"><span class="glyphicon glyphicon-refresh"></span></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id = "flexfix">
	<div id = "search">
		<form method = "POST" id = "searchExpensesForm" >
			<input type = 'hidden' name = 'action' value = 'searchExpenses' />
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "searchUser" placeholder = "User name" class = "form-control"/>
			</div>
			<div class = "searchInput input-group accountSearch">
				<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
				<input type = "text" name = "account" placeholder = "Account" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-shopping-cart"></i></span>
				<input type = "text" name = "searchMerch" placeholder = "Merchant" class = "form-control"/>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
				<select class = "form-control" name = "status">
					<option value = "">Status</option>
					<option value = "processed">Processed</option>
					<option value = "unprocessed">Unprocessed</option>
				</select>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
				<select class = "form-control" name = "category">
					<option value = "">All Categories</option>
					<option value = "accommodation">Accommodation</option>
					<option value = "food">Food</option>
					<option value = "entertainment">Entertainment</option>
					<option value = "phone">Phone</option>
					<option value = "travel">Travel</option>
				</select>
			</div>
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				<input type = "text" name = "searchDate" placeholder = "Date" class = "form-control searchDatePicker"/>
			</div>
			<div class = "searchInput">
				<input type = 'submit' value = 'Search' class = "btn btn-default" id = "btnSearchExpenses"/>
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
					<th>Date / Time</th>
					<th>Status</th>
					<th>Account</th>
					<th>Comment</th>
				</tr>
			</thead>
			<tbody id = "expensesData">
				<!-- call data here -->
			</tbody>
		</table>
	</div>
</div>

<div class = "modalReceiptImage modalImageStyle">
	<img src="" alt = "Receipt Image" />
</div>	

<div id = "modalAddExpense" class = "modalStyle">
	<form id = "modalExpenseForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'addExpense' />
        <input type = "hidden" name = "receiptId" value = "" />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-plus"></span>Add Expense</h4>

		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>	
			</div>
		</div>

		<div class = "form-group">
			 <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userId" placeholder = "User ID" class = "form-control"/>	
			</div>
		</div>

		<div class = "form-group">
			 <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
					<select class = "form-control" name = "category">
						<option value = "">Select Category</option>
						<option value = "accommodation">Accommodation</option>
						<option value = "Food">Food</option>
						<option value = "Entertainment">Entertainment</option>
						<option value = "Phone">Phone</option>
						<option value = "Travel">Travel</option>
					</select>
			</div>
		</div>

		<div class = "form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-shopping-cart"></i></span>
				<input type = "text" name = "merchant" placeholder = "Merchant" class = "form-control"/>	
			</div>
		</div>

		<div class = "form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
				<input type = "text" name = "cost" placeholder = "Cost" class = "form-control"/>	
			</div>
		</div>
		
		<div class = "form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
				<input type = "text" name = "account" placeholder = "Account" class = "form-control"/>	
			</div>
		</div>

		<div class = "form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
				<input type = "text" name = "comment" placeholder = "Comment" class = "form-control"/>	
			</div>
		</div>

		<div class = "modalInput">
			<input type = 'submit' value = 'Submit' class = "btn btn-default" id = "btnSubmitExpense"/>
		</div>

		<div class = "clear"></div>

	</form>
</div>

<div id = "modalEditExpense" class = "modalStyle">
	<form id = "modalEditExpenseForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'editExpense' />
		<input id = "expenseId" type = "hidden" name = "expenseId" value = "" />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-refresh"></span>Edit Expense</h4>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userName" placeholder = "User Name" class = "form-control" readonly="readonly"/>	
			</div>
		</div>
		


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
				<select class = "form-control" name = "status">
					<option value = "" disabled="disabled">Status</option>
					<option value = "Processed">Processed</option>
					<option value = "Unprocessed">Unprocessed</option>
				</select>
			</div>
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
				<select class = "form-control" name = "category">
					<option value = "" disabled="disabled">Select Categories</option>
					<option value = "Accommodation">Accommodation</option>
					<option value = "Food">Food</option>
					<option value = "Entertainment">Entertainment</option>
					<option value = "Phone">Phone</option>
					<option value = "Travel">Travel</option>
				</select>
			</div>
		</div>



		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-shopping-cart"></i></span>
				<input type = "text" name = "merchant" placeholder = "Merchant" class = "form-control" readonly="readonly"/>	
			</div>
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
				<input type = "text" name = "cost" placeholder = "Cost" class = "form-control"/>
			</div>	
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
				<input type = "text" name = "account" placeholder = "Account" class = "form-control"/>
			</div>	
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
				<input type = "text" name = "comment" placeholder = "Comment" class = "form-control"/>
			</div>	
		</div>


		<div class = "modalInput">
			<input type = 'submit' value = 'Update' class = "btn btn-default" id = "btnSubmitEditExpense"/>
		</div>
		<div class = "clear"></div>
	</form>
</div>

<div id = "modalDeleteConfirmation" class = "comfirmationModal">
	<div>
		<h4><span class="glyphicon glyphicon-trash"></span>Delete Expense</h4>
	</div>
	<div>
		<p>Are you sure you want to delete the selected expense ?</p>
	</div>
	<div>
		<button action = "deleteData" id = "deleteExpense" class = "btn btn-default"><span class="glyphicon glyphicon-ok"></span>Yes</button>
	</div>
</div>


