<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
		echo "EXPENSES";
		echo "Congatulations you're in " . $_SESSION["adminEmail"];
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
			<tbody>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
				<tr>
					<td>Michael Anderson</td>
					<td>Hotel</td>
					<td>Clarion</td>
					<td>£180.56</td>
					<td>21/09/2014</td>
					<td>Processed</td>
					<td>Here</td>
					<td>Had to stay two nights.</td>
				</tr>
			</tbody>
		</table>


<?php
		require("../templates/footer.php");
	}
?>