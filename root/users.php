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
					<button id = "btnAddUser" class = "btn btn-default btnAdd"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div>
					<button class = "btn btn-default btnDelete" disabled = "true"><span class="glyphicon glyphicon-trash"></span></button>
				</div>
				<div>
					<button id = "btnEditUser" class = "btn btn-default btnEdit" disabled = "true"><span class="glyphicon glyphicon-refresh"></span></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id = "flexfix">
	<div id = "search">
		<form method = "POST" id = "searchUsersForm">
			<input type = 'hidden' name = 'action' value = 'searchUsers' />
			<div class = "searchInput input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>
			</div>
			<div class = "searchInput">
				<input type = 'submit' value = 'Search' class = "btn btn-default" id = "btnSearchUsers"/>
			</div>
		</form>
	</div>

	<div id = "mainView">
		<table id = "usersTable">
			<thead>
				<tr>
					<th>User ID</th>
					<th>User Name</th>
					<th>Mobile</th>
					<th>E-mail</th>
					<th>User Type</th>
				</tr>
			</thead>
			<tbody>
				<!-- users' data goes here -->
			</tbody>
		</table>
	</div>
</div>

<div id = "modalAddUser" class = "modalStyle">
	<form id = "modalUserForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'addUser' />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-user"></span>Add User</h4>
		

		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userName" placeholder = "User Name" class = "form-control"/>	
			</div>
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input type = "text" name = "userEmail" placeholder = "Email" class = "form-control"/>
			</div>	
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
				<input type = "text" name = "userMobile" placeholder = "User Mobile" class = "form-control"/>	
			</div>
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
				<input type = "text" name = "retypeMobile" placeholder = "Confirm Mobile" class = "form-control"/>	
			</div>
		</div>

		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
				<select class = "form-control" name = "userType">
					<option value = "">Select User Type</option>
					<option value = "Project Manager">Project Manager</option>
					<option value = "Standard User">Standard User</option>
				</select>
			</div>
		</div>

		<div class = "modalInput">
			<input type = 'submit' value = 'Submit' class = "btn btn-default" id = "btnSubmitUser"/>
		</div>
		<div class = "clear"></div>
	</form>
</div>


<div id = "modalEditUser" class = "modalStyle">
	<form id = "modalEditUserForm" method = "POST" class = "modalForm">
		<input type = 'hidden' name = 'action' value = 'editUser' />
		<input id = "userId" type = "hidden" name = "userId" value = "" />
		<div class = "modalCloseIm"></div>
		<h4><span class="glyphicon glyphicon-user"></span>Edit User</h4>
		

		<div class = "form-group">
			<div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type = "text" name = "userName" placeholder = "User Name" class = "form-control" readonly="readonly"/>
			</div>	
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input type = "text" name = "userEmail" placeholder = "Email" class = "form-control" readonly="readonly"/>
			</div>	
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
				<input type = "text" name = "userMobile" placeholder = "Mobile" class = "form-control" readonly="readonly"/>
			</div>	
		</div>


		<div class = "form-group">
			 <div class="input-group">	
		 		<span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
				<select class = "form-control" name = "userType">
					<option value = "" disabled>User Type</option>
					<option value = "Project Manager">Project Manager</option>
					<option value = "Standard User">Standard User</option>
				</select>
			</div>
		</div>

		<div class = "modalInput">
			<input type = 'submit' value = 'Submit' class = "btn btn-default" id = "btnSubmitEditUser"/>
		</div>
		<div class = "clear"></div>
	</form>
</div>


<div id = "modalDeleteConfirmation" class = "comfirmationModal">
	<div>
		<h4><span class="glyphicon glyphicon-trash"></span>Delete User</h4>
	</div>
	<div>
		<p>Are you sure you want to delete the selected Users ?</p>
	</div>
	<div>
		<p>Warning : All records will be deleted !!</p>
	</div>
	<div>
		<button action = "deleteData" id = "deleteUser" class = "btn btn-default"><span class="glyphicon glyphicon-ok"></span>Yes</button>
	</div>
</div>


