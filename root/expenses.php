<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
		echo "EXPENSES";
		echo "Congatulations you're in " . $_SESSION["adminEmail"] . $_SESSION["adminId"];
?>
		<table id = "expensesTable">
			<thead>
				<tr>
					<th>User Name</th>
					<th>Expense</th>
					<th>Merchant</th>
					<th>Cost</th>
					<th>Date</th>
					<th>Status</th>
					<th>Receipt</th>
					<th>Comment</th>
				</tr>
			</thead>
			<tbody id = "expensesData">
				<!-- call data here -->
			</tbody>
		</table>


<?php
		require("../templates/footer.php");
	}
?>