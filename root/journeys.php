<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
		echo "Journeys page";
		echo "Congatulations you're in " . $_SESSION["adminEmail"];
?>
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



<?php
		require("../templates/footer.php");
	}
?>