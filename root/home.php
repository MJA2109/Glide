<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
		echo "HOME";
		echo "Congatulations you're in " . $_SESSION["adminEmail"];
?>	
	<div class = "widget">
		<div><h3>New Users</h3></div>
		<div>
			New user info
		</div>
	</div>
	<div class = "widget">
		<div><h3>New Expenses</h3></div>
		<div>
			New expense data
		</div>
	</div>
	<div class = "widget">
		<div><h3>Awaiting Processing</h3></div>
		<div>
			Awaiting processing info
		</div>
	</div>
	<div class = "widget">
		<div><h3>Liabilities</h3></div>
		<div>
			Monies owed
		</div>
	</div>
	<div class = "widget">
		<div><h3>Notes</h3></div>
		<div></div>
	</div>
	<div class = "widget">
		<div><h3>Auxiliary</h3></div>
		<div>
			more data
		</div>
	</div>	
<?php
		require("../templates/footer.php");
	}
?>
