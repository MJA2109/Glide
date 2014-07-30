<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
		echo "USERS";
		echo "Congatulations you're in " . $_SESSION["adminEmail"];
?>
		<table id = "usersTable">
			<thead>
				<tr>
					<th>User</th>
					<th>Email</th>
					<th>No. Of Claims</th>
					<th>Activation Code</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
				<tr>
					<td>David Sullivan</td>
					<td>daveSull@sony.com</td>
					<td>21</td>
					<td>gfdsg4534534</td>
				</tr>
			</tbody>
		</table>



<?php
		require("../templates/footer.php");
	}
?>