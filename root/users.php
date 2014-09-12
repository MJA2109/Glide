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
					<th>Sign-up Date</th>
					<th>No. of Claims</th>
				</tr>
			</thead>
			<tbody>
				<!-- users' data goes here -->
			</tbody>
		</table>



<?php
		require("../templates/footer.php");
	}
?>