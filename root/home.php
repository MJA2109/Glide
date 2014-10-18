<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
?>	
	<div id = "ajaxContent">
	
	</div>
<?php
		require("../templates/footer.php");
	}
?>
